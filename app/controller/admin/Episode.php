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

		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");
 
        // Config
        $Config['btn']  = 'episode';
        $Config['nav']  = 'series';

        if (isset($Route->params->id)) {
            $Listing    = $this->db->from('posts_episode')->where('id',$Route->params->id,'=')->first();

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
                WHERE posts_video.post_id = ' . $Listing['post_id'] . ' AND posts_video.episode_id = ' . $Listing['id'] . '
                ORDER BY posts_video.sortable ASC'
            )->all(); 
            
            // Subtitles 
            $Subtitles = $this->db->from(
                null,
                '
                SELECT 
                posts_subtitle.id,  
                posts_subtitle.post_id, 
                posts_subtitle.language_id, 
                posts_subtitle.sortable, 
                posts_subtitle.link, 
                countries.name
                FROM `posts_subtitle` 
                LEFT JOIN countries ON posts_subtitle.language_id = countries.id AND posts_subtitle.language_id IS NOT NULL
                WHERE posts_subtitle.post_id = ' . $Listing['post_id'] . ' AND posts_subtitle.episode_id = ' . $Listing['id'] . '
                ORDER BY posts_subtitle.sortable ASC'
            )->all();
        }

        $Series    = $this->db->from('posts')->where('type','serie')->orderby('title','ASC')->all();
        $TabNav = array(
            'episode'       =>  $this->translate('General'),
            'video'         =>  $this->translate('Video'),
            'subtitle'      =>  $this->translate('Subtitle')
        ); 

        $Countries  = $this->db->from('countries')->orderby('name','ASC')->all();
        $Services   = $this->db->from('options')->where('type','service')->all();

        $this->setVariable('Services',isset($Services) ? $Services : null); 
        $this->setVariable('Countries',isset($Countries) ? $Countries : null); 
        $this->setVariable('Listing',isset($Listing) ? $Listing : null); 
        $this->setVariable('TabNav',isset($TabNav) ? $TabNav : null); 
        $this->setVariable('Videos',isset($Videos) ? $Videos : null); 
        $this->setVariable('Subtitles',isset($Subtitles) ? $Subtitles : null); 
        $this->setVariable('Config', $Config);  
        $this->setVariable('Series', $Series);  

        if(Input::cleaner((isset($_POST['_ACTION']) ? $_POST['_ACTION'] : null)) == 'save' AND empty($Listing['id'])) {
            $this->save();
        } elseif(Input::cleaner((isset($_POST['_ACTION']) ? $_POST['_ACTION'] : null)) == 'save' AND isset($Listing['id'])) {
            $this->update();
        }

        $this->view("episode", "admin");
    }

    public function save() { 
        if (empty($Notify)) {  
  
            if(isset($_POST['self'])) {
                $self = Input::seo($_POST['self']);
            } else {
                $self = Input::seo($_POST['title']);
            }

            foreach ($_POST['data'] as $key => $value) {
                if ($value) {
                    $Json['data'][$key] = $value;
                }
            }

            $dataarray          = array(
                "post_id"           => Input::cleaner($_POST['post_id']),
                "season_id"         => Input::cleaner($_POST['season_id']),
                "title"             => Input::cleaner($_POST['title']),
                "title_number"      => Input::cleaner($_POST['title_number']),
                "self"              => $self,
                "image"             => empty($image) ? null : $image,
                "overview"          => Input::cleaner($_POST['overview']),
                "release_date"      => Input::cleaner($_POST['release_date']),
                "runtime"           => Input::cleaner($_POST['runtime']),
                "trailer"           => Input::cleaner($_POST['trailer']),
                "view"              => Input::cleaner($_POST['view'],'0'),
                "private"           => Input::cleaner($_POST['private'],'2'),
                "featured"          => (int)Input::cleaner($_POST['featured'],'2'),
                "upcoming"          => (int)Input::cleaner($_POST['upcoming'],'2'),
                "status"            => (int)Input::cleaner($_POST['status'],'2'),
                'data'              => json_encode($Json['data'], JSON_UNESCAPED_UNICODE),
                "created"           => date('Y-m-d H:i:s')
            );   
            $this->db->insert('posts_episode')->set($dataarray); 
            $post_id     = $this->db->lastId(); 

            // Videos    
            foreach ($_POST['video'] as $Video) { 
                $dataarray = array(
                    "post_id"       => $_POST['post_id'],
                    "episode_id"    => $post_id,
                    "service_id"    => (int)Input::cleaner($Video['service']),
                    "embed"         => Input::cleaner($Video['embed']),
                    "source"        => Input::cleaner($Video['source']),
                    "sortable"      => (int)Input::cleaner($Video['sortable']),
                );
                $this->db->insert('posts_video')->set($dataarray);
            }

            // Subtitles    
            foreach ($_POST['subtitle'] as $Subtitle) { 
                $dataarray = array(
                    "post_id"       => $_POST['post_id'],
                    "episode_id"    => $post_id,
                    "language_id"   => (int)Input::cleaner($Subtitle['language_id']),
                    "link"          => Input::cleaner($Subtitle['link']),
                    "sortable"      => (int)Input::cleaner($Subtitle['sortable']),
                );
                $this->db->insert('posts_subtitle')->set($dataarray);
            }
            $Notify['type']     = 'success';
            $Notify['text']     = $this->translate('Action completed successfully'); 
            $this->notify($Notify);
            header("location: ".APP.'/admin/episodes');
        }else{ 
            $this->notify($Notify);
        }
        return $this;
    }

    public function update() {
        $Listing        = $this->getVariable("Listing");       
        if (empty($Notify)) {
            if(isset($_POST['self'])) {
                $self = Input::seo($_POST['self']);
            } else {
                $self = Input::seo($_POST['title']);
            }

            foreach ($_POST['data'] as $key => $value) {
                if ($value) {
                    $Json['data'][$key] = $value;
                }
            }

            $dataarray          = array(
                "post_id"           => Input::cleaner($_POST['post_id']),
                "season_id"         => Input::cleaner($_POST['season_id']),
                "title"             => Input::cleaner($_POST['title']),
                "title_number"      => Input::cleaner($_POST['title_number']),
                "self"              => $self,
                "image"             => empty($image) ? null : $image,
                "overview"          => Input::cleaner($_POST['overview']),
                "release_date"      => Input::cleaner($_POST['release_date']),
                "runtime"           => Input::cleaner($_POST['runtime']),
                "trailer"           => Input::cleaner($_POST['trailer']),
                "view"              => Input::cleaner($_POST['view'],'0'),
                "private"           => Input::cleaner($_POST['private'],'2'),
                "featured"          => (int)Input::cleaner($_POST['featured'],'2'),
                "upcoming"          => (int)Input::cleaner($_POST['upcoming'],'2'),
                "status"            => (int)Input::cleaner($_POST['status'],'2'),
                'data'              => json_encode($Json['data'], JSON_UNESCAPED_UNICODE)
            );   
            $this->db->update('posts_episode')->where('id',$Listing['id'])->set($dataarray);


            // Videos
            foreach ($_POST['video'] as $Video) {
                if (isset($Video['id']) AND isset($Video['embed'])) {
                    $dataarray = array(
                        "post_id"       => $Listing['post_id'],
                        "episode_id"    => $Listing['id'],
                        "service_id"    => (int)Input::cleaner($Video['service']),
                        "embed"         => Input::cleaner($Video['embed']),
                        "source"        => Input::cleaner($Video['source']),
                        "sortable"      => (int)Input::cleaner($Video['sortable']),
                    );
                    $this->db->update('posts_video')->where('id', Input::cleaner($Video['id']))->set($dataarray);
                } elseif (empty($Video['id']) AND isset($Video['embed'])) {
                    $dataarray = array(
                        "post_id"       => $Listing['post_id'],
                        "episode_id"    => $Listing['id'],
                        "service_id"    => (int)Input::cleaner($Video['service']),
                        "embed"         => Input::cleaner($Video['embed']),
                        "source"        => Input::cleaner($Video['source']),
                        "sortable"      => (int)Input::cleaner($Video['sortable']),
                    );
                    $this->db->insert('posts_video')->set($dataarray);
                }
            }

            // Subtitles    
            foreach ($_POST['subtitle'] as $Subtitle) { 
                if (isset($Subtitle['id']) AND isset($Subtitle['link'])) {
                    $dataarray = array(
                        "post_id"       => $Listing['post_id'],
                        "episode_id"    => $Listing['id'],
                        "language_id"   => (int)Input::cleaner($Subtitle['language_id']),
                        "link"          => Input::cleaner($Subtitle['link']),
                        "sortable"      => (int)Input::cleaner($Subtitle['sortable']),
                    );
                    $this->db->update('posts_subtitle')->where('id', Input::cleaner($Subtitle['id']))->set($dataarray);
                } elseif (empty($Subtitle['id']) AND isset($Subtitle['link'])) {
                    $dataarray = array(
                        "post_id"       => $Listing['post_id'],
                        "episode_id"    => $Listing['id'],
                        "language_id"   => (int)Input::cleaner($Subtitle['language_id']),
                        "link"          => Input::cleaner($Subtitle['link']),
                        "sortable"      => (int)Input::cleaner($Subtitle['sortable']),
                    );
                    $this->db->insert('posts_subtitle')->set($dataarray);
                }
            }
            $Notify['type']     = 'success';
            $Notify['text']     = $this->translate('Action completed successfully'); 
            $this->notify($Notify);
            header("location: ".APP.'/admin/episodes');
        }else{ 
            $this->notify($Notify);
        } 
        return $this;
    }
}