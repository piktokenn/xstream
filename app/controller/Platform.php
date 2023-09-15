<?php
/**
 * Platform Controller
 */
class Platform extends Controller
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
            $Listing        = $this->db->from('platforms')->where('self',$Route->params->self,'=')->first();
    
            if(empty($Listing['id'])) {
                header('location:'.APP.'/404');
            }

            // Query 
            $TotalRecord        = $this->db->from(null,'
                SELECT 
                COUNT(posts.id) as total 
                FROM `posts` 
                WHERE posts.platform = '.$Listing['id'])
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
                `posts`   
                LEFT JOIN posts_genre ON posts.id = posts_genre.post_id
                LEFT JOIN genres ON genres.id = posts_genre.genre_id
                WHERE posts.platform = '.$Listing['id'].'  
                GROUP BY posts.id
                ORDER BY posts.id DESC
                LIMIT '.$LimitPage['start'].','.$LimitPage['limit'])
            ->all(); 
            $Pagination         = $this->db->showPagination(platform($Listing['id'],$Listing['self']).(isset($SearchPage) ? $SearchPage.'&' : '?').'page=[page]');
        }

        $new    = array($Listing['name']);
        $old    = array('[name]');

        $Config['title']        = trim(str_replace($old, $new, trim(get($Settings,'data.platform_title','seo'))));
        $Config['description']  = trim(str_replace($old, $new, trim(get($Settings,'data.platform_description','seo'))));
        $Config['id']           = $Listing['id'];
        $Config['type']         = 'platform';

        $this->setVariable("Config", $Config);   
        $this->setVariable('Listing', $Listing);  
        $this->setVariable('Posts', $Posts);  
        $this->setVariable('Pagination', $Pagination);  
        $this->setVariable('Data',isset($Data) ? $Data : null); 

        $this->view("platform", "app");
    }

}