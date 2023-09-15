<?php
/**
 * Series Controller
 */
class Series extends Controller
{
    /**
     * Process
     */
    public function process()
    {    

		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");
        $Settings       = $this->getVariable("Settings");


        require PATH . '/config/array.config.php';
        
        // Filter


        $Filter         = null;
        $SearchPage     = null; 
        $Where          = null;   
        $CategoryWhere  = null;
           
        if(isset($_POST['_ACTION']) AND $_POST['_ACTION'] == 'filter') { 
            foreach ($_POST as $key => $value) {
                if(isset($key) AND ($key != '_TOKEN' && $key != '_ACTION')) {

                    if($key == 'genre') {
                        $Filter .= '&'.$key.'='.implode(',',$value);
                    } else {
                        if(($key == 'released' AND $value != '1960;2022') OR $key =='imdb' AND $value != '5;10') {
                            $Filter .= '&'.$key.'='.$value;
                        } elseif($key != 'released' AND $key != 'imdb') {
                            $Filter .= '&'.$key.'='.$value;
                        }
                    }
                }
            }
            if(isset($Filter)) {
                header("location: ".APP.'/'.App::translate('series').'?'.ltrim($Filter,'&'));
            } else {
                header("location: ".APP.'/'.App::translate('series'));
            }
        }

        $Filter = array ('sorting', 'genre', 'imdb', 'released');
        $i= 0;
        foreach($Filter as $key) {
            if (isset($_GET[$key])) {
                if ($i == 0) {
                    $SearchPage .= '?'.$key.'='.$_GET[$key];
                } else {
                    $SearchPage .= '&'.$key.'='.$_GET[$key];
                }
                $i++;
            }
        }

        $Where          = "WHERE posts.status = 1 AND posts.type ='serie' AND ";


        if(isset($Route->params->category) AND $Route->params->category AND $Route->params->category != 'all') { 
            $SelectCategory = $this->db->from(null,'
                SELECT 
                genres.id,
                genres.name,
                genres.self 
                FROM `genres` 
                WHERE genres.self = "'. $Route->params->category .'"')
                ->first();
                $Where          .= ' WHERE posts_genre.genre_id = '.$SelectCategory['id'].' AND'; 
                $CategoryWhere  = ' WHERE genre_id = '.$SelectCategory['id'].' '; 

        }
        if(isset($_GET['genre'])) {
            $Where  .= ' posts_genre.genre_id IN ('.$_GET['genre'].') AND'; 
            $CategoryWhere  = ' WHERE posts_genre.genre_id IN ('.$_GET['genre'].') '; 
        }
        if(isset($_GET['released'])) {
            $YearExplode = explode(';',Input::cleaner($_GET['released']));
            $Where .= ' YEAR(posts.release_date) BETWEEN '.$YearExplode[0].' AND '.$YearExplode[1].' AND ';
        }

        if(isset($_GET['imdb'])) {
            $ImdbExplode = explode(';',Input::cleaner($_GET['imdb']));
            $Where .= ' posts.vote_average BETWEEN '.$ImdbExplode[0].' AND '.$ImdbExplode[1].' AND ';
        }
        if(isset($_GET['sorting']) AND in_array($_GET['sorting'], $SortArray)) {
            if($_GET['sorting'] == 'popular') {
            }
        }
        // Orderby
        if(isset($_GET['sorting']) AND $_GET['sorting'] == $this->translate('popular')) {
            $Selected['sorting'] = $this->translate('Most popular');
            $OrderBy = 'ORDER BY posts.view DESC';
        } elseif(isset($_GET['sorting']) AND $_GET['sorting'] == $this->translate('released')) {
            $Selected['sorting'] = $this->translate('Released');
            $OrderBy = 'ORDER BY posts.release_date DESC';
        } elseif(isset($_GET['sorting']) AND $_GET['sorting'] == $this->translate('imdb')) {
            $Selected['sorting'] = $this->translate('Imdb rating');
            $OrderBy = 'ORDER BY posts.vote_average DESC';
        } else {
            $Selected['sorting'] = $this->translate('Newest');
            $OrderBy = 'ORDER BY posts.id DESC';
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
                  '.$CategoryWhere.'
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
                  '.$CategoryWhere.' 
                  GROUP BY posts_genre.post_id
                  ORDER BY posts_genre.genre_id DESC
                ) posts_genre ON posts.id = posts_genre.post_id
            LEFT JOIN genres ON genres.id = posts_genre.genre_id
            '.$Where.' 
            '.$OrderBy.'
            LIMIT '.$LimitPage['start'].','.$LimitPage['limit'])
        ->all(); 
        $Pagination         = $this->db->showPagination(APP.'/'.App::translate('series').(isset($SearchPage) ? $SearchPage.'&' : '?').'page=[page]');


        $Genres = $this->db->from('genres')->all();


        $new    = array(isset($Selected['sorting']) ? $Selected['sorting'].' ' : null);
        $old    = array('[sort]','[imdb]','[genre]','[released]');

        $Config['title']        = trim(str_replace($old, $new, trim(get($Settings,'data.series_title','seo'))));
        $Config['description']  = trim(str_replace($old, $new, trim(get($Settings,'data.series_description','seo'))));
        $Config['page']         = $this->translate('TV Shows');
        $Config['link']         = APP.'/'.App::translate('series').(isset($SearchPage) ? $SearchPage : null);
        $Config['url']          = APP.'/'.App::translate('movies').(isset($SearchPage) ? $SearchPage : null);


        $this->setVariable("Config", $Config);  
        $this->setVariable("Listings", $Listings);
        $this->setVariable("TotalRecord", $TotalRecord);
        $this->setVariable("Pagination", $Pagination);
        $this->setVariable("Genres", $Genres);

        if(empty($_GET['ajax'])) {
            $this->view("series", "app");
        } else {
            require PATH . '/theme/view/common/listing.php';
        }
    }
}