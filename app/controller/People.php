<?php
/**
 * People Controller
 */
class People extends Controller
{
    /**
     * Process
     */
    public function process()
    {    

		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");
        $Settings       = $this->getVariable("Settings");

 
        if (isset($Route->params->self)) {
            $Listing        = $this->db->from('peoples')->where('self',$Route->params->self,'=')->first();
            if(isset($Listing['data'])) {
                $Data           = json_decode($Listing['data'], true);
            }
            if(empty($Listing['id'])) {
                header('location:'.APP.'/404');
            }

            // Query 
            $TotalRecord        = $this->db->from(null,'
                SELECT 
                COUNT(posts_people.people_id) as total 
                FROM `posts_people` 
                WHERE posts_people.people_id = '.$Listing['id'])
                ->total();  
            $LimitPage          = $this->db->pagination($TotalRecord, PAGE_LIMIT, PAGE_PARAM); 
       
            
            $Posts = $this->db->from(null,'
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
                `posts_people`  
                LEFT JOIN posts ON posts_people.post_id = posts.id
                LEFT JOIN posts_genre ON posts.id = posts_genre.post_id
                LEFT JOIN genres ON genres.id = posts_genre.genre_id
                WHERE posts_people.people_id = '.$Listing['id'].' 
                GROUP BY posts.id
                ORDER BY posts.id DESC
                LIMIT '.$LimitPage['start'].','.$LimitPage['limit'])
            ->all(); 
            $Pagination         = $this->db->showPagination(people($Listing['id'],$Listing['self']).(isset($SearchPage) ? $SearchPage.'&' : '?').'page=[page]');
        }

        $new    = array($Listing['name']);
        $old    = array('[name]');

        $Config['title']        = trim(str_replace($old, $new, trim(get($Settings,'data.people_title','seo'))));
        $Config['description']  = trim(str_replace($old, $new, trim(get($Settings,'data.people_description','seo'))));
        $Config['id']           = $Listing['id'];
        $Config['type']         = 'people';

        $this->setVariable("Config", $Config);   
        $this->setVariable('Listing', $Listing);  
        $this->setVariable('Posts', $Posts);  
        $this->setVariable('Pagination', $Pagination);  
        $this->setVariable('Data',isset($Data) ? $Data : null); 

        $this->view("people", "app");
    }

}