<?php
/**
 * Ajax Controller
 */  
class Ajax extends Controller
{
    /**
     * Process
     */
    public function process()
    {
        $AuthUser   = $this->getVariable("AuthUser");
        $Route      = $this->getVariable("Route");
        $this->{$Route->params->ajax}();
    }
    public function placeholder() {
        header('Content-type: image/svg+xml');

        // Dimensions
        $getsize    = isset($_GET['size']) ? $_GET['size'] : '200x200';
        $sizer      = explode('x', $getsize);

        echo '<svg width="'.$sizer[0].'" height="'.$sizer[1].'" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 0H200V200H0V0Z" fill="#1A1A1E"/></svg>';
    }
    public function reaction() {  
        $AuthUser   = $this->getVariable("AuthUser");
        if($AuthUser['id']) {
            $Vote = $this->db->from('posts_like')->where('user_id',$AuthUser['id'])->where('post_id',$_POST['id'])->first();
            if(Input::cleaner($_POST['type']) == '-up' || Input::cleaner($_POST['type']) == '-down') {
                $this->db->delete('posts_like')->where('id',$Vote['id'],'=')->done(); 
            } elseif($Vote['id']) {
                $dataarray          = array(
                    "reaction"          => Input::cleaner($_POST['type'])
                );   
                $this->db->update('posts_like')->where('id',$Vote['id'])->set($dataarray);  
            } elseif(!$Vote['id']) {
                $dataarray          = array(
                    "user_id"       => $AuthUser['id'],
                    "post_id"       => Input::cleaner($_POST['id']),
                    "reaction"      => Input::cleaner($_POST['type'])
                );   
                $this->db->insert('posts_like')->set($dataarray);  
            }
        }
        return true; 
    }

    public function embed() {
        $AuthUser   = $this->getVariable("AuthUser");
        if(isset($_POST['id'])) {
            $Player = $this->db->from(
                    null,
                    '
                    SELECT 
                    posts.view,
                    posts_video.id,  
                    posts_video.source,  
                    posts_video.post_id, 
                    posts_video.episode_id, 
                    posts_video.sortable, 
                    posts_video.embed, 
                    posts.cover, 
                    posts.image
                    FROM `posts_video` 
                    LEFT JOIN posts ON posts_video.post_id = posts.id 
                    LEFT JOIN posts_episode ON posts_video.episode_id = posts_episode.id AND posts_video.episode_id IS NOT NULL 
                    WHERE posts_video.id = '.Input::cleaner($_POST['id']))
            ->first();
            if(isset($Player['id'])) {

                if($Player['source'] == 'youtube') {
                    $html = '<video id="player" class="video-js vjs-default-skin" controls data-setup=\'{ "techOrder": ["youtube"], "sources": [{ "type": "video/youtube", "src": "https://www.youtube.com/watch?v='.$Player['embed'].'"}], "youtube": { "customVars": { "wmode": "transparent" } } }\'></video>';
                } elseif($Player['source'] == 'mp4') {
                    $html = '<video id="player" class="video-js vjs-default-skin" data-setup="{}" controls preload="auto" poster="'.UPLOAD.'/'.POST_FOLDER.'/player-'.$Player['cover'].'"><source src="'.$Player['embed'].'" type="video/mp4"></video>';
                } elseif($Player['source'] == 'hls') {
                    $html = '<video id="player" class="video-js vjs-default-skin" data-setup="{}" controls preload="auto" poster="'.UPLOAD.'/'.POST_FOLDER.'/player-'.$Player['cover'].'"><source src="'.$Player['embed'].'" type="application/x-mpegURL"></video>';
                } else {
                    $html = '<iframe class="embed-responsive-item lazyload" data-src="'.$Player['embed'].'" allowfullscreen></iframe>';
                }
                if(isset($AuthUser['id'])) {
                    $Check = $this->db->from(null,'
                        SELECT *
                        from posts_log 
                        WHERE posts_log.post_id = '.$Player['post_id'].' AND posts_log.user_id = '.$AuthUser['id']
                        .(isset($Player['episode_id']) ? ' AND posts_log.episode_id = '.$Player['episode_id'] : null)
                    )->first();
                    if(empty($Check['id'])) {
                        $this->db->insert('posts_log')->set(array(
                            'post_id'       => $Player['post_id'],
                            'episode_id'    => isset($Player['episode_id']) ? $Player['episode_id'] : null,
                            'user_id'       => isset($AuthUser['id']) ? $AuthUser['id'] : NULL,
                            'created'       => date('Y-m-d')
                        ));

                        $this->db->update('users')->where('id',$AuthUser['id'])->set(array('xp' => $AuthUser['xp']+10));
                    }
                }
            }
            echo $html;
        }
    }

    public function earnxp() {
        $AuthUser   = $this->getVariable("AuthUser");
        $Settings   = $this->getVariable("Settings");

        $sessionGame = $AuthUser['id'].':'.Input::cleaner($_POST['game_id']);
        if(empty($_SESSION[$sessionGame]) AND isset($AuthUser['id'])) {
            $_SESSION[$sessionGame] = $sessionGame;  
            $this->db->update('users')->where('id',$AuthUser['id'])->set(array('xp' => $AuthUser['xp']+get($Settings,'data.play_xp','customize')));
        }
    }

    public function collections() {
        $AuthUser       = $this->getVariable("AuthUser"); 
        if(isset($AuthUser['id'])) {
            $Listings = $this->db->from(null,'
                SELECT *
                FROM `collections`   
                WHERE collections.user_id = "'.$AuthUser['id'].'"
                ORDER BY name ASC')
                ->all();

            $Collection = $this->db->from('collections_post')->where('post_id',Input::cleaner($_POST['post_id']))->where('user_id',$AuthUser['id'])->first();

            foreach ($Listings as $Listing) {
                $result[] = [
                    'id'            => $Listing['id'],
                    'name'          => $Listing['name'],
                    'selected'      => (isset($Collection['collection_id']) AND $Listing['id'] == $Collection['collection_id'] ? true : null)
                ];  
            }
        }
        echo json_encode(array(
            "data"   => $result
        ));
    }

    public function collection() {
        $AuthUser   = $this->getVariable("AuthUser");
        if(empty($AuthUser['id'])) {
            $status     = 'danger';
            $text       = $this->translate('You must sign in');
        } elseif(isset($_POST['name'])) { 
            $dataarray          = array(
                "user_id"       => Input::cleaner($AuthUser['id']),
                "name"          => Input::cleaner($_POST['name']),
                "self"          => Input::seo($_POST['name']),
                "color"         => '#'.getRandomColor(),
                "privacy"       => isset($_POST['privacy']) ? (int)Input::cleaner($_POST['privacy'],1) : 0,
                'created'       => date('Y-m-d H:i:s')
            );   
            $this->db->insert('collections')->set($dataarray);  
         
            $result = [
                'id'            => $this->db->lastId(),
                'name'          => Input::cleaner($_POST['name']),
                'selected'      => false
            ];  
            $status     = 'success';
            $text       = $this->translate('Action completed successfully');
        }
        echo json_encode(array(
            "status"    => $status,
            "text"      => $text,
            "data"      => $result
        ));

    }

    public function savecollection() {
        $AuthUser   = $this->getVariable("AuthUser");
        if(empty($AuthUser['id'])) {
            $status     = 'danger';
            $text       = $this->translate('You must sign in');
        } elseif(isset($_POST['collection_id']) AND isset($_POST['post_id'])) {

            $Total     = $this->db->from(null,'SELECT count(collections_post.id) as total FROM `collections_post` WHERE collections_post.user_id = '.$AuthUser['id'].' AND collections_post.collection_id = '.$_POST['collection_id'])->total();  
            if($Total <= 100) {
                $Collection = $this->db->from('collections_post')->where('post_id',Input::cleaner($_POST['post_id']))->where('user_id',Input::cleaner($AuthUser['id']))->first();
                if(isset($Collection['id'])) {
                    $dataarray          = array(
                        "collection_id"     => Input::cleaner($_POST['collection_id'])
                    );   
                    $this->db->update('collections_post')->where('id',$Collection['id'])->where('user_id',$AuthUser['id'])->set($dataarray);  
                } elseif(empty($Collection['id'])) {
                    $dataarray          = array(
                        "collection_id" => Input::cleaner($_POST['collection_id']),
                        "post_id"       => Input::cleaner($_POST['post_id']),
                        "user_id"       => Input::cleaner($AuthUser['id'])
                    );   
                    $this->db->insert('collections_post')->set($dataarray);  
                }
                $status     = 'success';
                $text       = $this->translate('Saved bookmark');
            } else {

            $status     = 'success';
            $text       = $this->translate('Maximum post');
            }
        }
        echo json_encode(array(
            "status"    => $status,
            "text"      => $text
        ));

    }


    public function request() {  
        $AuthUser   = $this->getVariable("AuthUser");
        $Settings   = $this->getVariable("Settings");
        if(isset($AuthUser['id'])) {
            $TotalRecord        = $this->db->from(null,'
            SELECT 
            count(requests.id) as total 
            FROM `requests` 
            WHERE requests.user_id = '.$AuthUser['id']. ' AND DATE(created) = CURDATE()')
            ->total(); 
            if($TotalRecord < 3) {
                $Vote = $this->db->from('requests')->where('user_id',$AuthUser['id'])->where('tmdb_id',$_POST['tmdb_id'])->first();
                if(empty($Vote['tmdb_id']) AND isset($_POST['tmdb_id'])) {

                    // Guzzle Get
                    $Client         = new \GuzzleHttp\Client();
                    $Response       = $Client->request(
                            'GET', 
                            'https://api.themoviedb.org/3/'.$_POST['media_type'].'/'.$_POST['tmdb_id'].'?api_key='.get($Settings,'data.tmdb_api','api').'&language='.get($Settings,'data.tmdb_language','api')
                    );
                    $Listing        = json_decode($Response->getBody() , true);

                    if(isset($Listing['id'])) {
                        $dataarray          = array(
                            "user_id"       => $AuthUser['id'],
                            "tmdb_id"       => Input::cleaner($Listing['id']),
                            "media_type"    => Input::cleaner($_POST['media_type']),
                            "name"          => ($_POST['media_type'] == 'movie' ? $Listing['original_title'] : $Listing['original_name']),
                            "image"         => $Listing['poster_path'],
                            "media_type"    => Input::cleaner($_POST['media_type']),
                            "created" => date('Y-m-d')
                        );   
                        $this->db->insert('requests')->set($dataarray);  
                        $status     = 'success';
                        $text       = $this->translate('Ready');
                    }
                }
            } else {
                $status     = 'danger';
                $text       = $this->translate('Maximum of 3 requests per day');
            }
        }  else {

                $status     = 'danger';
                $text       = $this->translate('Maximum of 3 requests per day');
        }
        echo json_encode(array(
            "status"    => $status,
            "text"      => $text
        )); 
    }

    public function viewed() {  
        $AuthUser   = $this->getVariable("AuthUser");
        if(isset($AuthUser['id'])) {
            $Check = $this->db->from('posts_log')->where('user_id',$AuthUser['id'])->where('episode_id',$_POST['episode_id'])->first();
            if(isset($Check['episode_id'])) {
                $this->db->delete('posts_log')->where('episode_id',$Check['episode_id'],'=')->where('user_id',$AuthUser['id'])->done(); 
            } elseif(empty($Check['episode_id'])) {
                $dataarray          = array(
                    "user_id"       => $AuthUser['id'],
                    "post_id"       => Input::cleaner($_POST['post_id']),
                    "episode_id"    => Input::cleaner($_POST['episode_id'])
                );   
                $this->db->insert('posts_log')->set($dataarray);  
            }
        }
        return true; 
    }

}