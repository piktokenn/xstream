<?php
/**
 * Profile Controller
 */
class Profile extends Controller
{
    /**
     * Process
     */
    public function process()
    {    

		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");
        $Settings       = $this->getVariable("Settings");

 
        if (isset($Route->params->username)) {
            $Listing        = $this->db->from('users')->where('username',$Route->params->username,'=')->first();
            if(empty($Listing['id'])) {
                header('location:'.APP.'/404');
            }
        }
        if(isset($Route->params->tab) AND $Route->params->tab == 'collection') {

            $Where = 'WHERE collections.user_id = '.$AuthUser['id']; 

            // Query 
            $TotalRecord        = $this->db->from(null,'
                SELECT 
                COUNT(collections.id) as total 
                FROM `collections` 
                LEFT JOIN collections_post ON collections.id = collections_post.post_id
                '.$Where)
                ->total();  
            $LimitPage          = $this->db->pagination($TotalRecord, PAGE_LIMIT, PAGE_PARAM); 
       
            
            $Posts = $this->db->from(null,'
                SELECT
                    collections.*,   
                    collections_post.post_id,
                    (SELECT 
                    COUNT(collections_post.id) 
                    FROM collections_post 
                    WHERE collection_id = collections.id) AS total
                FROM
                `collections`  
                LEFT JOIN collections_post ON collections.id = collections_post.post_id
                '.$Where.' 
                ORDER BY collections.id DESC
                LIMIT '.$LimitPage['start'].','.$LimitPage['limit'])
            ->all(); 
            $Pagination         = $this->db->showPagination(user($Listing['id'],$Listing['username']).'/collection?page=[page]');
            $this->setVariable('Posts',isset($Posts) ? $Posts : null); 
            $this->setVariable('Pagination',isset($Pagination) ? $Pagination : null); 
        } elseif(isset($Route->params->tab) AND $Route->params->tab == 'like') {

            $Where = 'WHERE posts.status = 1 AND posts_like.user_id = '.$AuthUser['id']; 

            // Query 
            $TotalRecord        = $this->db->from(null,'
                SELECT 
                COUNT(posts.id) as total 
                FROM `posts_like` 
                LEFT JOIN posts ON posts.id = posts_like.post_id
                '.$Where)
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
                `posts_like`  
                LEFT JOIN posts ON posts.id = posts_like.post_id
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
                ORDER BY posts_like.id DESC
                LIMIT '.$LimitPage['start'].','.$LimitPage['limit'])
            ->all(); 
            $Pagination         = $this->db->showPagination(user($Listing['id'],$Listing['username']).'/like?page=[page]');
            $this->setVariable('Posts',isset($Posts) ? $Posts : null); 
            $this->setVariable('Pagination',isset($Pagination) ? $Pagination : null); 
        } elseif(isset($Route->params->tab) AND $Route->params->tab == 'history') {


            $Where = 'WHERE posts.status = 1 AND posts_log.user_id = '.$AuthUser['id']; 

            // Query 
            $TotalRecord        = $this->db->from(null,'
                SELECT 
                COUNT(posts.id) as total 
                FROM `posts_log` 
                LEFT JOIN posts ON posts.id = posts_log.post_id
                '.$Where.'
                GROUP BY posts_log.post_id')
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
                `posts_log`  
                LEFT JOIN posts ON posts.id = posts_log.post_id
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
                GROUP BY posts_log.post_id
                ORDER BY posts_log.id DESC
                LIMIT '.$LimitPage['start'].','.$LimitPage['limit'])
            ->all(); 
            $Pagination         = $this->db->showPagination(user($Listing['id'],$Listing['username']).'/history?page=[page]');
            $this->setVariable('Posts',isset($Posts) ? $Posts : null); 
            $this->setVariable('Pagination',isset($Pagination) ? $Pagination : null); 
        } else {

            $Historys = $this->db->from(null,'
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
                `posts_log`  
                LEFT JOIN posts ON posts.id = posts_log.post_id
                LEFT JOIN (
                      SELECT
                        post_id, 
                        genre_id 
                      FROM `posts_genre`   
                      GROUP BY posts_genre.post_id
                      ORDER BY posts_genre.genre_id DESC
                    ) posts_genre ON posts.id = posts_genre.post_id
                LEFT JOIN genres ON genres.id = posts_genre.genre_id
                WHERE posts_log.user_id = '.$Listing['id'].'
                GROUP BY posts_log.post_id
                ORDER BY posts_log.id DESC
                LIMIT 0,6')
            ->all(); 

            $Likes = $this->db->from(null,'
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
                `posts_like`  
                LEFT JOIN posts ON posts.id = posts_like.post_id
                LEFT JOIN (
                      SELECT
                        post_id, 
                        genre_id 
                      FROM `posts_genre`   
                      GROUP BY posts_genre.post_id
                      ORDER BY posts_genre.genre_id DESC
                    ) posts_genre ON posts.id = posts_genre.post_id
                LEFT JOIN genres ON genres.id = posts_genre.genre_id
                WHERE posts_like.user_id = '.$Listing['id'].'
                ORDER BY posts_like.id DESC
                LIMIT 0,6')
            ->all(); 

            $Collections = $this->db->from(null,'
                SELECT
                collections.*,   
                collections_post.post_id,
                (SELECT 
                COUNT(collections_post.id) 
                FROM collections_post 
                WHERE collection_id = collections.id) AS total
                FROM `collections`  
                LEFT JOIN collections_post ON collections.id = collections_post.post_id
                WHERE collections.user_id = '.$Listing['id'].'
                GROUP BY collections.id
                ORDER BY collections.id DESC
                LIMIT 0,6')
            ->all(); 

        }

        $new    = array($Listing['username']);
        $old    = array('[username]');

        $Config['title']        = trim(str_replace($old, $new, trim(get($Settings,'data.profile_title','seo'))));
        $Config['description']  = trim(str_replace($old, $new, trim(get($Settings,'data.profile_description','seo'))));
        $Config['url']          = user($Listing['id'],$Listing['username']);
        $Config['type']         = 'profile';

        $this->setVariable("Config", $Config);   
        $this->setVariable('Listing', $Listing);  

        $this->setVariable('Likes',isset($Likes) ? $Likes : null); 
        $this->setVariable('Historys',isset($Historys) ? $Historys : null); 
        $this->setVariable('Collections',isset($Collections) ? $Collections : null); 

        $this->view("profile", "app");
    }

}