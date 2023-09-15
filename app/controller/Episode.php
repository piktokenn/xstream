<?php
/**
 * Episode Controller
 */
class Episode extends Controller
{
    /**
     * Process
     */
    public function process()
    {    

        $AuthUser       = $this->getVariable("AuthUser");
        $Route          = $this->getVariable("Route");
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
                posts_episode.id as episode_id,
                posts_season.id as season_id,
                posts_episode.view as view,
                posts_season.name as season_name,
                posts_episode.id as episode_id,
                posts_episode.title as episode_title,
                posts_episode.title as episode_title,
                posts_episode.title_number,
                posts_episode.overview as episode_overview,
                posts_episode.view as episode_view,
                posts_episode.trailer, 
                (SELECT 
                COUNT(comments.post_id) 
                FROM comments 
                WHERE comments.parent_id = 0 AND comments.type = "episode" AND post_id = posts_episode.id) AS comments, 
                (SELECT 
                COUNT(posts_like.post_id) 
                FROM posts_like 
                WHERE posts_like.reaction = "up" AND post_id = posts.id) AS likes, 
                (SELECT 
                COUNT(posts_like.post_id) 
                FROM posts_like 
                WHERE posts_like.reaction = "down" AND post_id = posts.id) AS dislikes
                FROM `posts`  
                LEFT JOIN posts_season ON posts.id = posts_season.post_id AND posts_season.post_id IS NOT NULL
                LEFT JOIN posts_episode ON posts_season.id = posts_episode.season_id AND posts_episode.post_id IS NOT NULL
                LEFT JOIN countries ON countries.id = posts.country AND posts.country IS NOT NULL
                LEFT JOIN platforms ON platforms.id = posts.platform AND posts.platform IS NOT NULL
                WHERE posts.self = "'. $Route->params->self .'" AND posts_episode.title_number = "'.$Route->params->episode.'" AND posts_season.name = "'.$Route->params->season.'" AND posts.status = 1')
                ->first(); 
            $Data       = json_decode($Listing['data'], true);

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
                WHERE posts_video.post_id = ' . $Listing['id'] . ' AND posts_video.episode_id = '.$Listing['episode_id'].' AND posts_video.source != "download"
                ORDER BY posts_video.sortable ASC'
            )->all();
            
            if(isset($AuthUser['id'])) {
                $Vote = $this->db->from('posts_like')->where('user_id',$AuthUser['id'])->where('post_id',$Listing['id'])->first();
            }


            $sessionItem = 'episode:'.$Listing['id'];
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

            $Next = $this->db->from(null,'
                SELECT 
                posts.self,
                posts_season.name as season_name,
                posts_episode.title_number
                FROM `posts` 
                LEFT JOIN posts_season ON posts.id = posts_season.post_id AND posts_season.post_id IS NOT NULL
                LEFT JOIN posts_episode ON posts_season.id = posts_episode.season_id AND posts_episode.post_id IS NOT NULL
                WHERE posts_episode.post_id = '. $Listing['id'] .' AND posts_episode.title_number = (select min(title_number) from posts_episode where title_number > "'.$Listing['title_number'].'" ORDER BY cast(posts_episode.title_number as unsigned) ASC) 
                ORDER BY cast(posts_episode.title_number as unsigned) ASC')
                ->first();
            $Prev = $this->db->from(null,'
                SELECT 
                posts.self,
                posts_season.name as season_name,
                posts_episode.title_number
                FROM `posts` 
                LEFT JOIN posts_season ON posts.id = posts_season.post_id AND posts_season.post_id IS NOT NULL
                LEFT JOIN posts_episode ON posts_season.id = posts_episode.season_id AND posts_episode.post_id IS NOT NULL 
                WHERE posts.id = '. $Listing['id'] .' AND posts_episode.title_number = (select max(title_number) from posts_episode where title_number < "'.$Listing['title_number'].'" ORDER BY cast(posts_episode.title_number as unsigned) ASC) 
                ORDER BY cast(posts_episode.title_number as unsigned) ASC')
                ->first();
        }
        
        if(empty($Listing['id'])) {
            header('location:'.APP.'/404');
        }

        

        $new    = array($Listing['title'],$Listing['season_name'],$Listing['title_number']);
        $old    = array('[title]','[season]','[episode]');

        $Config['title']        = trim(str_replace($old, $new, trim(get($Settings,'data.episode_title','seo'))));
        $Config['description']  = trim(str_replace($old, $new, trim(get($Settings,'data.episode_description','seo'))));
        $Config['url']          = episode($Listing['id'],$Listing['self'],$Listing['season_name'],$Listing['title_number']);
        $Config['id']           = $Listing['episode_id'];
        $Config['type']         = 'episode';

        $Config['edit']         = APP.'/admin/episode/'.$Listing['episode_id'];
        $Config['add']          = APP.'/admin/episode?tv='.$Listing['id'];

        $this->setVariable("Config", $Config);  
        $this->setVariable("Listing", $Listing);  
        $this->setVariable("Data", $Data);  
        $this->setVariable("Genres", $Genres);  
        $this->setVariable("Videos", $Videos);  
        $this->setVariable("Peoples", $Peoples);  
        $this->setVariable("Multimedia", $Multimedia);  
        $this->setVariable("Subtitles", $Subtitles);  
        $this->setVariable("Downloads", $Downloads);  
        $this->setVariable("Prev", $Prev);  
        $this->setVariable("Next", $Next);  
        $this->setVariable('Recommends',isset($Recommends) ? $Recommends : null); 
        $this->setVariable('Vote',isset($Vote) ? $Vote : null); 

        if(isset($_POST['_ACTION']) AND Input::cleaner($_POST['_ACTION']) == 'report' AND isset($AuthUser['id'])) {
            $this->report();
        } 

        if(isset($Route->params->tab) AND $Route->params->tab == 'comments' AND (isset($Data['comment']) AND $Data['comment'] == 1)) {
            header('location:'.APP.'/404');
        }

        if(empty($_GET['ajax'])) {
            $this->view("episode", "app");
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
                "type"          => 'episode',
                "report"        => Input::cleaner($_POST['report']),
                "report_id"     => $Listing['episode_id'],
                "body"          => Input::cleaner($_POST['body']),
                "status"        => 2,
                "created"       => date('Y-m-d H:i:s')
            );   
            $this->db->insert('reports')->set($dataarray);  

            $Notify['type']     = 'success';
            $Notify['text']     = $this->translate('Action completed successfully'); 
            $this->notify($Notify);
            header('location:'.episode($Listing['id'],$Listing['self'],$Listing['season_name'],$Listing['title_number']));
        } else {
            $this->notify($Notify);
        }
    }
}