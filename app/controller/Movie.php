<?php
/**
 * Movie Controller
 */
class Movie extends Controller
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

            $More = $this->db->from(null,'
                SELECT 
                posts.id, 
                posts.type, 
                posts.title, 
                posts.title_sub, 
                posts.self, 
                posts.view, 
                posts.cover, 
                posts.image, 
                posts.release_date, 
                posts.created, 
                genres.name, 
                genres.self as genre_self
                from posts 
                LEFT JOIN posts_genre ON posts_genre.post_id = posts.id  
                LEFT JOIN genres ON genres.id = posts_genre.genre_id  
                WHERE posts.type = "'.$Listing['type'].'" AND posts.id NOT IN ('.$Listing['id'].')
                ORDER BY posts.id DESC'
            )->first();
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
            
            // Videos 
            $Videos = $this->db->from(
                null,
                '
                SELECT 
                posts_video.id,  
                posts_video.post_id, 
                posts_video.source, 
                posts_video.sortable, 
                posts_video.embed, 
                options.id as service_id,
                options.name as service_name
                FROM `posts_video` 
                LEFT JOIN options ON posts_video.service_id = options.id AND options.type = "service" AND posts_video.service_id IS NOT NULL
                WHERE posts_video.post_id = ' . $Listing['id'] . ' AND posts_video.source != "download"
                ORDER BY posts_video.sortable ASC'
            )->all();
            
            if(isset($AuthUser['id'])) {
                $Vote = $this->db->from('posts_like')->where('user_id',$AuthUser['id'])->where('post_id',$Listing['id'])->first();
            }

            $sessionItem = 'video:'.$Listing['id'];
            if(empty($_SESSION[$sessionItem])) {
                $_SESSION[$sessionItem] = $sessionItem;  
                $this->db->update('posts')->where('id',$Listing['id'])->set(array('view' => $Listing['view']+1));
            } 

            // Downloads 
            $Downloads = $this->db->from(
                null,
                '
                SELECT 
                posts_video.id,  
                posts_video.post_id, 
                posts_video.source, 
                posts_video.sortable, 
                posts_video.embed, 
                options.id as service_id,
                options.name as service_name
                FROM `posts_video` 
                LEFT JOIN options ON posts_video.service_id = options.id AND options.type = "service" AND posts_video.service_id IS NOT NULL
                WHERE posts_video.post_id = ' . $Listing['id'] . ' AND posts_video.source = "download"
                ORDER BY posts_video.sortable ASC'
            )->all();
            
            // Subtitles 
            $Subtitles = $this->db->from(null,'
                SELECT
                    posts_subtitle.id,
                    posts_subtitle.link,
                    countries.icon,
                    countries.language,
                    countries.name
                FROM
                `posts_subtitle` 
                LEFT JOIN countries ON countries.id = posts_subtitle.language_id
                WHERE posts_subtitle.post_id = '.$Listing['id'])
            ->all(); 

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
                        WHERE posts.status = "1" AND posts_genre.genre_id IN ('.rtrim($RecommendsGenre,',').') AND posts.id NOT IN ('.$Listing['id'].') AND posts.type = "movie"
                        GROUP BY posts.id
                        ORDER BY posts.id DESC
                        LIMIT 0,'.(int)get($Settings,'data.column','customize'))
                        ->all();

            $Multimedia = $this->db->from('posts_media')->where('post_id', $Listing['id'])->all(); 
        }
        
        if(empty($Listing['id'])) {
            header('location:'.APP.'/404');
        }

        

        $new    = array($Listing['title']);
        $old    = array('[title]');

        $Config['title']        = trim(str_replace($old, $new, trim(get($Settings,'data.movie_title','seo'))));
        $Config['description']  = trim(str_replace($old, $new, trim(get($Settings,'data.movie_description','seo'))));

        $Config['url']          = post($Listing['id'],$Listing['self'],$Listing['type']);
        $Config['id']           = $Listing['id'];
        $Config['type']         = 'post';

        $Config['edit']         = APP.'/admin/movie/'.$Listing['id'];

        $this->setVariable("Config", $Config);  
        $this->setVariable("Listing", $Listing);  
        $this->setVariable("Data", $Data);  
        $this->setVariable("Genres", $Genres);  
        $this->setVariable("Videos", $Videos);  
        $this->setVariable("Peoples", $Peoples);  
        $this->setVariable("Multimedia", $Multimedia);  
        $this->setVariable("Subtitles", $Subtitles);  
        $this->setVariable("Downloads", $Downloads);  
        $this->setVariable("More", $More);  
        $this->setVariable('Recommends',isset($Recommends) ? $Recommends : null); 
        $this->setVariable('Vote',isset($Vote) ? $Vote : null); 

        if(isset($_POST['_ACTION']) AND Input::cleaner($_POST['_ACTION']) == 'report' AND isset($AuthUser['id'])) {
            $this->report();
        } 

        if(isset($Route->params->tab) AND $Route->params->tab == 'comments' AND (isset($Data['comment']) AND $Data['comment'] == 1)) {
            header('location:'.APP.'/404');
        }

        if(empty($_GET['ajax'])) {
            $this->view("movie", "app");
        } else {
            require PATH . '/theme/view/common/post.'.$Route->params->tab.'.php';
        }
    }

    /**
     * report
     */
    public function report() { 
        $AuthUser       = $this->getVariable("AuthUser");    
        $Listing        = $this->getVariable("Listing");     
        if (empty($Notify)) { 
            $dataarray          = array(
                "user_id"       => $AuthUser['id'],
                "type"          => 'movie',
                "report"        => Input::cleaner($_POST['report']),
                "report_id"     => $Listing['id'],
                "body"          => Input::cleaner($_POST['body']),
                "status"        => 2,
                "created"       => date('Y-m-d H:i:s')
            );   
            $this->db->insert('reports')->set($dataarray);  

            $Notify['type']     = 'success';
            $Notify['text']     = $this->translate('Action completed successfully'); 
            $this->notify($Notify);
            header('location:'.post($Listing['id'],$Listing['self'],$Listing['type']));
        } else {
            $this->notify($Notify);
        }
    }
}