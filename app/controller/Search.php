<?php
/**
 * Search Controller
 */
class Search extends Controller
{
    /**
     * Process
     */
    public function process()
    {    

		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");
        $Settings       = $this->getVariable("Settings");
        $isValid        = $this->getVariable("isValid");


        if(isset($_POST['_ACTION']) AND Input::cleaner($_POST['_ACTION']) == 'search') {
            if(empty(Input::cleaner($_POST['q'])) || Input::cleaner(mb_strlen($_POST['q'])) < 3 || Input::cleaner(mb_strlen($_POST['q'])) > 40) {
                $Notify['type']     = 'danger';
                $Notify['text']     = 'Your search query must be between 3 and 40 characters long'; 
                $this->notify($Notify);
                header('location:'.APP);
            } else {
                header("location: ".APP.'/search/'.tagger($_POST['q']));
            }
        }
        $Where          = "WHERE posts.status = 1 AND ";
        if(isset($Route->params->q)) {  
            $Where          .= ' posts.title LIKE  "%'.Input::cleaner(tagger($Route->params->q,true)).'%" OR posts.title_sub LIKE "%'.Input::cleaner(tagger($Route->params->q,true)).'%" AND '; 
        }
        
        $Where = rtrim($Where,' AND '); 
        // Query 
        $TotalRecord        = $this->db->from(null,'
            SELECT 
            COUNT(posts.id) as total 
            FROM `posts` 
            LEFT JOIN (
                  SELECT
                    post_id, 
                    genre_id 
                  FROM `posts_genre`   
                  GROUP BY posts_genre.post_id
                  ORDER BY posts_genre.genre_id DESC
                ) posts_genre ON posts.id = posts_genre.post_id
            '.$Where)
            ->total();  
        $LimitPage          = $this->db->pagination($TotalRecord, PAGE_LIMIT, PAGE_PARAM); 
   
        
        $Listings = $this->db->from(null,'
            SELECT
                posts.id, 
                posts.title,  
                posts.title_sub,  
                posts.self, 
                posts.image, 
                posts.type,
                posts.upcoming,
                posts.release_date,
                posts.vote_average, 
                genres.name as name,
                genres.self as genre_self
            FROM
            `posts`  
            LEFT JOIN (
                  SELECT
                    post_id, 
                    genre_id 
                  FROM `posts_genre`   
                  GROUP BY posts_genre.post_id
                  ORDER BY posts_genre.genre_id DESC
                ) posts_genre ON posts.id = posts_genre.post_id
            LEFT JOIN genres ON genres.id = posts_genre.genre_id
            '.$Where.' 
            ORDER BY posts.id DESC
            LIMIT '.$LimitPage['start'].','.$LimitPage['limit'])
        ->all(); 
        $Pagination         = $this->db->showPagination(APP.'/'.App::translate('explore').(isset($SearchPage) ? $SearchPage.'&' : '?').'page=[page]');

        $new    = array(isset($Route->params->q) ? $Route->params->q : null);
        $old    = array('[keyword]');

        $Config['title']        = trim(str_replace($old, $new, trim(get($Settings,'data.search_title','seo'))));
        $Config['description']  = trim(str_replace($old, $new, trim(get($Settings,'data.search_description','seo'))));
     
        $this->setVariable("Config", $Config);   
        $this->setVariable("Listings", $Listings);   
        $this->setVariable("Pagination", $Pagination);   

        $this->view("search", "app");
    }
}