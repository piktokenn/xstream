<?php
/**
 * Serie Controller
 */
class Serie extends Controller
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
            $Listing = $this->db->from(null,'
                SELECT 
                posts.id, 
                posts.type, 
                posts.title, 
                posts.title_sub, 
                posts.self, 
                posts.overview, 
                posts.keywords, 
                posts.view, 
                posts.trailer, 
                posts.image, 
                posts.private, 
                posts.release_date, 
                posts.runtime, 
                posts.cover, 
                posts.upcoming, 
                posts.platform, 
                posts.created,
                posts.vote_average, 
                posts.data,
                countries.name as country_name,
                platforms.name as platform_name,
                platforms.image as platform_image,
                platforms.self as platform_self,
                (SELECT 
                COUNT(comments.post_id) 
                FROM comments 
                WHERE comments.parent_id = 0 AND comments.type = "movie" AND post_id = posts.id) AS comments, 
                (SELECT 
                COUNT(posts_like.post_id) 
                FROM posts_like 
                WHERE posts_like.reaction = "up" AND post_id = posts.id) AS likes, 
                (SELECT 
                COUNT(posts_like.post_id) 
                FROM posts_like 
                WHERE posts_like.reaction = "down" AND post_id = posts.id) AS dislikes
                FROM `posts`  
                LEFT JOIN countries ON countries.id = posts.country AND posts.country IS NOT NULL
                LEFT JOIN platforms ON platforms.id = posts.platform AND posts.platform IS NOT NULL
                WHERE posts.self = "'. $Route->params->self .'" AND posts.status = 1')
                ->first(); 
            $Data       = json_decode($Listing['data'], true);

            if(empty($Listing['id'])) {
                header('location:'.APP.'/404');
            }
            
            // Genres 
            $Genres = $this->db->from(
                null,
                '
                SELECT 
                genres.id, 
                genres.name, 
                genres.self
                FROM `posts_genre` 
                LEFT JOIN genres ON posts_genre.genre_id = genres.id     
                WHERE posts_genre.post_id = "' . $Listing['id'] . '"
                ORDER BY genres.name ASC'
            )->all(); 

            // Peoples 
            $Peoples = $this->db->from(null,'
                SELECT
                    peoples.id,
                    peoples.image,
                    peoples.department,
                    peoples.name,
                    peoples.self
                FROM
                `posts_people` 
                LEFT JOIN peoples ON peoples.id = posts_people.people_id
                WHERE posts_people.post_id = '.$Listing['id'])
            ->all(); 
            $RecommendsGenre = null;
            foreach ($Genres as $Genre) {
                $RecommendsGenre .= '"'.$Genre['id'].'",';
            } 
            $Recommends = $this->db->from(null,'
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
                        genres.name
                        FROM `posts` 
                        LEFT JOIN posts_genre ON posts_genre.post_id = posts.id  
                        LEFT JOIN genres ON genres.id = posts_genre.genre_id  
                        WHERE posts.status = "1" AND posts_genre.genre_id IN ('.rtrim($RecommendsGenre,',').') AND posts.id NOT IN ('.$Listing['id'].') AND posts.type = "serie"
                        GROUP BY posts.id
                        ORDER BY posts.id DESC
                        LIMIT 0,'.(int)get($Settings,'data.column','customize'))
                        ->all();

            $Multimedia = $this->db->from('posts_media')->where('post_id', $Listing['id'])->all(); 
        }

        $new    = array($Listing['title']);
        $old    = array('[title]');

        $Config['title']        = trim(str_replace($old, $new, trim(get($Settings,'data.serie_title','seo'))));
        $Config['description']  = trim(str_replace($old, $new, trim(get($Settings,'data.serie_description','seo'))));
        $Config['url']          = post($Listing['id'],$Listing['self'],$Listing['type']);
        $Config['id']           = $Listing['id'];
        $Config['type']         = 'post';
        $Config['edit']         = APP.'/admin/serie/'.$Listing['id'];
        $Config['add']          = APP.'/admin/episode?tv='.$Listing['id'];

        $this->setVariable("Config", $Config);   
        $this->setVariable('Listing', $Listing);  
        $this->setVariable('Data', $Data); 
        $this->setVariable("Genres", $Genres);  
        $this->setVariable("Peoples", $Peoples);  
        $this->setVariable("Recommends", $Recommends);  
        $this->setVariable("Multimedia", $Multimedia);  

        if(empty($_GET['ajax'])) {
            $this->view("serie", "app");
        } else {
            require PATH . '/theme/view/common/post.'.$Route->params->tab.'.php';
        }
    }

}