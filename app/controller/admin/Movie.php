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


        // Config
        $Config['btn']      = 'movie';
        $Config['nav']      = 'movies';
        $Config['page']     = $this->translate('Movies');
        $Config['api']      = 'getMovie';

        if (isset($Route->params->id)) {
            $Listing    = $this->db->from('posts')->where('id',$Route->params->id,'=')->first();
            $Data       = json_decode($Listing['data'], true);

            // Peoples
            $Peoples = $this->db->from(
                null,
                '
                SELECT 
                posts_people.id as people_id,
                peoples.id,
                peoples.name,  
                peoples.self,  
                peoples.department,  
                peoples.tmdb_id,  
                peoples.image
                FROM `posts_people` 
                LEFT JOIN peoples ON posts_people.people_id = peoples.id     
                WHERE posts_people.post_id = ' . $Listing['id']
            )->all();


            // Genres
            $PostGenres = $this->db->from('posts_genre')->where('post_id', $Listing['id'])->all();
            foreach ($PostGenres as $Genre) {
                $SelectGenres[] = $Genre['genre_id'];
            }

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
                WHERE posts_video.post_id = ' . $Listing['id'] . '
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
                WHERE posts_subtitle.post_id = ' . $Listing['id'] . '
                ORDER BY posts_subtitle.sortable ASC'
            )->all();

            $Multimedia = $this->db->from('posts_media')->where('post_id', $Listing['id'])->all();
            if(empty($Listing['id'])) {
                header('location:'.APP.'/admin/movies');
            }
        }
        $Genres         = $this->db->from('genres')->orderby('name','ASC')->all();
        $Countries      = $this->db->from('countries')->orderby('name','ASC')->all();
        $Services       = $this->db->from('options')->where('type','service')->all();
        $Platforms      = $this->db->from('platforms')->orderby('name','ASC')->all();

        $TabNav = array(
            'general'       =>  $this->translate('General'),
            'video'         =>  $this->translate('Video'),
            'cast'          =>  $this->translate('Cast'),
            'subtitle'      =>  $this->translate('Subtitle'),
            'multimedia'    =>  $this->translate('Multimedia')
        ); 

        $this->setVariable('Genres',isset($Genres) ? $Genres : null); 
        $this->setVariable('Peoples',isset($Peoples) ? $Peoples : null); 
        $this->setVariable('Countries',isset($Countries) ? $Countries : null); 
        $this->setVariable('Multimedia',isset($Multimedia) ? $Multimedia : null); 
        $this->setVariable('Subtitles',isset($Subtitles) ? $Subtitles : null); 
        $this->setVariable('Listing',isset($Listing) ? $Listing : null); 
        $this->setVariable('Services',isset($Services) ? $Services : null); 
        $this->setVariable('Platforms',isset($Platforms) ? $Platforms : null); 
        $this->setVariable('SelectGenres',isset($SelectGenres) ? $SelectGenres : null); 
        $this->setVariable('Seasons',isset($Seasons) ? $Seasons : null); 
        $this->setVariable('Videos',isset($Videos) ? $Videos : null); 
        $this->setVariable('Data',isset($Data) ? $Data : null); 
        $this->setVariable('TabNav',isset($TabNav) ? $TabNav : null); 
        $this->setVariable('Config', $Config);  

        if(Input::cleaner((isset($_POST['_ACTION']) ? $_POST['_ACTION'] : null)) == 'save' AND empty($Listing['id'])) {
            $this->save();
        } elseif(Input::cleaner((isset($_POST['_ACTION']) ? $_POST['_ACTION'] : null)) == 'save' AND isset($Listing['id'])) {
            $this->update();
        }

        $this->view("post", "admin");
    }

    public function save() { 
        if (empty($Notify)) {  
  
            if(!empty($_POST['image_url'])) {
                $path_image = UPLOADPATH . '/temp/' . randomcode() . '.jpg';
                downloader($_POST['image_url'], $path_image); 

                unlink(UPLOADPATH . '/'.POST_FOLDER.'/'.$Listing['image']);
                unlink(UPLOADPATH . '/'.POST_FOLDER.'/thumb-'.$Listing['image']);
                unlink(UPLOADPATH . '/'.POST_FOLDER.'/'.str_replace('png', 'webp', $Listing['image']));
                unlink(UPLOADPATH . '/'.POST_FOLDER.'/thumb-'.str_replace('png', 'webp', $Listing['image']));

                $ImageName  = randomcode();
                $image      = uploader($path_image,$ImageName,UPLOADPATH.'/'.POST_FOLDER.'/',POST_X.','.POST_Y,'png');
                uploader($path_image,$ImageName,UPLOADPATH.'/'.POST_FOLDER.'/',POST_X.','.POST_Y,'webp');
                uploader($path_image,'thumb-'.$ImageName,UPLOADPATH.'/'.POST_FOLDER.'/',POST_THUMB_X.','.POST_THUMB_Y,'png');
                uploader($path_image,'thumb-'.$ImageName,UPLOADPATH.'/'.POST_FOLDER.'/',POST_THUMB_X.','.POST_THUMB_Y,'webp');

                unlink($path_image);
                
            }
            if(!empty($_FILES['image']) AND $_FILES['image']['error'] == 0) {

                unlink(UPLOADPATH . '/'.POST_FOLDER.'/'.$Listing['image']);
                unlink(UPLOADPATH . '/'.POST_FOLDER.'/thumb-'.$Listing['image']);
                unlink(UPLOADPATH . '/'.POST_FOLDER.'/'.str_replace('png', 'webp', $Listing['image']));
                unlink(UPLOADPATH . '/'.POST_FOLDER.'/thumb-'.str_replace('png', 'webp', $Listing['image']));

                $ImageName  = randomcode();
                $image      = uploader($_FILES['image'],$ImageName,UPLOADPATH.'/'.POST_FOLDER.'/',POST_X.','.POST_Y,'png');
                uploader($_FILES['image'],$ImageName,UPLOADPATH.'/'.POST_FOLDER.'/',POST_X.','.POST_Y,'webp');
                uploader($_FILES['image'],'thumb-'.$ImageName,UPLOADPATH.'/'.POST_FOLDER.'/',POST_THUMB_X.','.POST_THUMB_Y,'png');
                uploader($_FILES['image'],'thumb-'.$ImageName,UPLOADPATH.'/'.POST_FOLDER.'/',POST_THUMB_X.','.POST_THUMB_Y,'webp');

                unlink($path_image);
            }
            if(!empty($_POST['cover_url'])) {

                $path_cover = UPLOADPATH . '/temp/' . randomcode() . '.jpg';
                downloader($_POST['cover_url'], $path_cover);
                unlink(UPLOADPATH . '/'.POST_FOLDER.'/'.$Listing['cover']);
                unlink(UPLOADPATH . '/'.POST_FOLDER.'/thumb-'.$Listing['cover']);
                unlink(UPLOADPATH . '/'.POST_FOLDER.'/'.str_replace('png', 'webp', $Listing['cover']));
                unlink(UPLOADPATH . '/'.POST_FOLDER.'/thumb-'.str_replace('png', 'webp', $Listing['cover']));

                $CoverName  = randomcode();
                $cover      = uploader($path_cover,$CoverName,UPLOADPATH.'/'.POST_FOLDER.'/',POST_COVER_X.','.POST_COVER_Y,'png');
                uploader($path_cover,$CoverName,UPLOADPATH.'/'.POST_FOLDER.'/',POST_COVER_X.','.POST_COVER_Y,'webp');
                uploader($path_cover,'thumb-'.$CoverName,UPLOADPATH.'/'.POST_FOLDER.'/',POST_COVER_THUMB_X.','.POST_COVER_THUMB_Y,'png');
                uploader($path_cover,'thumb-'.$CoverName,UPLOADPATH.'/'.POST_FOLDER.'/',POST_COVER_THUMB_X.','.POST_COVER_THUMB_Y,'webp');
                uploader($path_cover,'player-'.$CoverName,UPLOADPATH.'/'.POST_FOLDER.'/',POST_PLAYER_X.','.POST_PLAYER_Y,'png');
                uploader($path_cover,'player-'.$CoverName,UPLOADPATH.'/'.POST_FOLDER.'/',POST_PLAYER_X.','.POST_PLAYER_Y,'webp');

                unlink($path_cover);
            }
            
            if(isset($_FILES['cover']) AND $_FILES['cover']['error'] == 0) {

                unlink(UPLOADPATH . '/'.POST_FOLDER.'/'.$Listing['cover']);
                unlink(UPLOADPATH . '/'.POST_FOLDER.'/thumb-'.$Listing['cover']);
                unlink(UPLOADPATH . '/'.POST_FOLDER.'/'.str_replace('png', 'webp', $Listing['cover']));
                unlink(UPLOADPATH . '/'.POST_FOLDER.'/thumb-'.str_replace('png', 'webp', $Listing['cover']));

                $CoverName  = randomcode();
                $cover      = uploader($_FILES['cover'],$CoverName,UPLOADPATH.'/'.POST_FOLDER.'/',POST_COVER_X.','.POST_COVER_Y,'png');
                uploader($_FILES['cover'],$CoverName,UPLOADPATH.'/'.POST_FOLDER.'/',POST_COVER_X.','.POST_COVER_Y,'webp');
                uploader($_FILES['cover'],'thumb-'.$CoverName,UPLOADPATH.'/'.POST_FOLDER.'/',POST_COVER_THUMB_X.','.POST_COVER_THUMB_Y,'png');
                uploader($_FILES['cover'],'thumb-'.$CoverName,UPLOADPATH.'/'.POST_FOLDER.'/',POST_COVER_THUMB_X.','.POST_COVER_THUMB_Y,'webp');
                uploader($_FILES['cover'],'player-'.$CoverName,UPLOADPATH.'/'.POST_FOLDER.'/',POST_PLAYER_X.','.POST_PLAYER_Y,'png');
                uploader($_FILES['cover'],'player-'.$CoverName,UPLOADPATH.'/'.POST_FOLDER.'/',POST_PLAYER_X.','.POST_PLAYER_Y,'webp');

                unlink($path_cover);
            }
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
                "type"              => 'movie',
                "title"             => Input::cleaner($_POST['title']),
                "self"              => $self,
                "title_sub"         => Input::cleaner($_POST['title_sub']),
                "image"             => empty($image) ? null : $image,
                "cover"             => empty($cover) ? null : $cover,
                "overview"          => Input::cleaner($_POST['overview']),
                "collection"        => Input::cleaner($_POST['collection']),
                "release_date"      => Input::cleaner($_POST['release_date']),
                "runtime"           => Input::cleaner($_POST['runtime']),
                "vote_average"      => Input::cleaner($_POST['vote_average']),
                "country"           => Input::cleaner($_POST['country']),
                "trailer"           => Input::cleaner($_POST['trailer']),
                "imdb_id"           => Input::cleaner($_POST['imdb_id']),
                "tmdb_id"           => Input::cleaner($_POST['tmdb_id']),
                "view"              => Input::cleaner($_POST['view'],'0'),
                "private"           => Input::cleaner($_POST['private'],'2'),
                "platform"          => Input::cleaner($_POST['platform']),
                "featured"          => (int)Input::cleaner($_POST['featured'],'2'),
                "upcoming"          => (int)Input::cleaner($_POST['upcoming'],'2'),
                "slider"            => (int)Input::cleaner($_POST['slider'],'2'),
                "status"            => (int)Input::cleaner($_POST['status'],'2'),
                "keywords"          => Input::cleaner($_POST['keywords']),
                'data'              => json_encode($Json['data'], JSON_UNESCAPED_UNICODE),
                "updated"           => date('Y-m-d H:i:s'),
                "created"           => date('Y-m-d H:i:s')
            );   
            $this->db->insert('posts')->set($dataarray); 
            $post_id     = $this->db->lastId(); 

            // Genres
            if (count($_POST['genres']) >= '1') {
                for ($i = 0; $i < count($_POST['genres']); $i++) {
                    if (Input::cleaner($_POST['genres'][$i])) {
                        $dataarray = array(
                            "genre_id"  => Input::cleaner($_POST['genres'][$i]),
                            "post_id"   => $post_id
                        );
                        $this->db->insert('posts_genre')->set($dataarray);
                    }
                }
            }


            // Videos    
            foreach ($_POST['video'] as $Video) { 
                $dataarray = array(
                    "post_id"       => $post_id,
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
                    "post_id"       => $post_id,
                    "language_id"   => (int)Input::cleaner($Subtitle['language_id']),
                    "link"          => Input::cleaner($Subtitle['link']),
                    "sortable"      => (int)Input::cleaner($Subtitle['sortable']),
                );
                $this->db->insert('posts_subtitle')->set($dataarray);
            }

            // Multimedia    
            foreach ($_POST['multimedia'] as $Multimedia) { 
                $dataarray = array(
                    "post_id"       => $post_id,
                    "image"         => Input::cleaner($Multimedia['name'])
                );
                $this->db->insert('posts_media')->set($dataarray);
            }


            // Peoples
            if (isset($_POST['peoples']) AND count($_POST['peoples']) >= '1') {  

                foreach ($_POST['peoples'] as $People) { 
                    if(isset($People['tmdb_id'])) {
                        $CheckPeople = $this->db->from('peoples')->where('tmdb_id', $People['tmdb_id'])->first();
                        if (empty($CheckPeople['id']) AND $People['tmdb_id'] != $CheckPeople['tmdb_id']) {
                            // Guzzle Get
                            $Client         = new \GuzzleHttp\Client();
                            $Response       = $Client->request(
                                'GET', 
                                'https://api.themoviedb.org/3/person/'.$People['tmdb_id'].'?api_key=5ea02218764ccc1f0764e079169f8573&language=tr'
                            );
                            $Cast        = json_decode($Response->getBody() , true);

                            $path_avatar    = UPLOADPATH . '/temp/' . randomcode() . '.jpg';
                            downloader('https://image.tmdb.org/t/p/w300_and_h300_face/'.$Cast['profile_path'], $path_avatar);
         
                            $AvatarName     = randomcode();
                            $avatar         = uploader($path_avatar,$AvatarName,UPLOADPATH.'/'.PEOPLE_FOLDER.'/',PEOPLE_X.','.PEOPLE_Y,'png');
                            uploader($path_avatar,$AvatarName,UPLOADPATH.'/'.PEOPLE_FOLDER.'/',PEOPLE_X.','.PEOPLE_Y,'webp');
               
                            unlink($path_avatar);
                            $dataarray          = array(
                                "name"              => Input::cleaner($Cast['name']),
                                "self"              => Input::seo($Cast['name']),
                                "biography"         => Input::cleaner($Cast['biography']),
                                "department"        => $People['department'],
                                "birthday"          => Input::cleaner($Cast['birthday']),
                                "gender"            => Input::cleaner($Cast['gender']),
                                "image"             => isset($avatar) ? $avatar : null,
                                "tmdb_id"           => $Cast['id'],
                                "imdb_id"           => $Cast['imdb_id'],
                                "featured"          => 0,
                                "created"           => date('Y-m-d H:i:s')
                            );   
                            $this->db->insert('peoples')->set($dataarray); 
                            $people_id = $this->db->lastId();
                        } elseif(isset($CheckPeople['id'])) {
                            $people_id = $CheckPeople['id'];
                        }

                        $dataarray = array(
                            "people_id"     => $people_id,
                            "post_id"       => $post_id
                        );
                        $this->db->insert('posts_people')->set($dataarray);

                    } elseif(isset($People['people_id'])) {
                    
                        $dataarray = array(
                            "people_id"     => $People['people_id'],
                            "post_id"       => $post_id
                        );
                        $this->db->insert('posts_people')->set($dataarray);

                    }
                }
            } 

            $Notify['type']     = 'success';
            $Notify['text']     = 'Action completed successfully'; 
            $this->notify($Notify);
            header("location: ".APP.'/admin/movies');
        }else{ 
            $this->notify($Notify);
        }
        return $this;
    }

    public function update() {
        $Listing            = $this->getVariable("Listing");       
        $SelectGenres       = $this->getVariable("SelectGenres");       
        $SelectPeoples      = $this->getVariable("SelectPeoples");       
        if (empty($Notify)) {
            
            if(!empty($_POST['image_url'])) {
                $path_image = UPLOADPATH . '/temp/' . randomcode() . '.jpg';
                downloader($_POST['image_url'], $path_image); 

                unlink(UPLOADPATH . '/'.POST_FOLDER.'/'.$Listing['image']);
                unlink(UPLOADPATH . '/'.POST_FOLDER.'/thumb-'.$Listing['image']);
                unlink(UPLOADPATH . '/'.POST_FOLDER.'/'.str_replace('png', 'webp', $Listing['image']));
                unlink(UPLOADPATH . '/'.POST_FOLDER.'/thumb-'.str_replace('png', 'webp', $Listing['image']));

                $ImageName  = randomcode();
                $image      = uploader($path_image,$ImageName,UPLOADPATH.'/'.POST_FOLDER.'/',POST_X.','.POST_Y,'png');
                uploader($path_image,$ImageName,UPLOADPATH.'/'.POST_FOLDER.'/',POST_X.','.POST_Y,'webp');
                uploader($path_image,'thumb-'.$ImageName,UPLOADPATH.'/'.POST_FOLDER.'/',POST_THUMB_X.','.POST_THUMB_Y,'png');
                uploader($path_image,'thumb-'.$ImageName,UPLOADPATH.'/'.POST_FOLDER.'/',POST_THUMB_X.','.POST_THUMB_Y,'webp');

                unlink($path_image);
                
            }
            if(!empty($_FILES['image']) AND $_FILES['image']['error'] == 0) {

                unlink(UPLOADPATH . '/'.POST_FOLDER.'/'.$Listing['image']);
                unlink(UPLOADPATH . '/'.POST_FOLDER.'/thumb-'.$Listing['image']);
                unlink(UPLOADPATH . '/'.POST_FOLDER.'/'.str_replace('png', 'webp', $Listing['image']));
                unlink(UPLOADPATH . '/'.POST_FOLDER.'/thumb-'.str_replace('png', 'webp', $Listing['image']));

                $ImageName  = randomcode();
                $image      = uploader($_FILES['image'],$ImageName,UPLOADPATH.'/'.POST_FOLDER.'/',POST_X.','.POST_Y,'png');
                uploader($_FILES['image'],$ImageName,UPLOADPATH.'/'.POST_FOLDER.'/',POST_X.','.POST_Y,'webp');
                uploader($_FILES['image'],'thumb-'.$ImageName,UPLOADPATH.'/'.POST_FOLDER.'/',POST_THUMB_X.','.POST_THUMB_Y,'png');
                uploader($_FILES['image'],'thumb-'.$ImageName,UPLOADPATH.'/'.POST_FOLDER.'/',POST_THUMB_X.','.POST_THUMB_Y,'webp');

                unlink($path_image);
            }
            if(!empty($_POST['cover_url'])) {

                $path_cover = UPLOADPATH . '/temp/' . randomcode() . '.jpg';
                downloader($_POST['cover_url'], $path_cover);
                unlink(UPLOADPATH . '/'.POST_FOLDER.'/'.$Listing['cover']);
                unlink(UPLOADPATH . '/'.POST_FOLDER.'/thumb-'.$Listing['cover']);
                unlink(UPLOADPATH . '/'.POST_FOLDER.'/'.str_replace('png', 'webp', $Listing['cover']));
                unlink(UPLOADPATH . '/'.POST_FOLDER.'/thumb-'.str_replace('png', 'webp', $Listing['cover']));

                $CoverName  = randomcode();
                $cover      = uploader($path_cover,$CoverName,UPLOADPATH.'/'.POST_FOLDER.'/',POST_COVER_X.','.POST_COVER_Y,'png');
                uploader($path_cover,$CoverName,UPLOADPATH.'/'.POST_FOLDER.'/',POST_COVER_X.','.POST_COVER_Y,'webp');
                uploader($path_cover,'thumb-'.$CoverName,UPLOADPATH.'/'.POST_FOLDER.'/',POST_COVER_THUMB_X.','.POST_COVER_THUMB_Y,'png');
                uploader($path_cover,'thumb-'.$CoverName,UPLOADPATH.'/'.POST_FOLDER.'/',POST_COVER_THUMB_X.','.POST_COVER_THUMB_Y,'webp');
                uploader($path_cover,'player-'.$CoverName,UPLOADPATH.'/'.POST_FOLDER.'/',POST_PLAYER_X.','.POST_PLAYER_Y,'png');
                uploader($path_cover,'player-'.$CoverName,UPLOADPATH.'/'.POST_FOLDER.'/',POST_PLAYER_X.','.POST_PLAYER_Y,'webp');

                unlink($path_cover);
            }
            
            if(isset($_FILES['cover']) AND $_FILES['cover']['error'] == 0) {

                unlink(UPLOADPATH . '/'.POST_FOLDER.'/'.$Listing['cover']);
                unlink(UPLOADPATH . '/'.POST_FOLDER.'/thumb-'.$Listing['cover']);
                unlink(UPLOADPATH . '/'.POST_FOLDER.'/'.str_replace('png', 'webp', $Listing['cover']));
                unlink(UPLOADPATH . '/'.POST_FOLDER.'/thumb-'.str_replace('png', 'webp', $Listing['cover']));

                $CoverName  = randomcode();
                $cover      = uploader($_FILES['cover'],$CoverName,UPLOADPATH.'/'.POST_FOLDER.'/',POST_COVER_X.','.POST_COVER_Y,'png');
                uploader($_FILES['cover'],$CoverName,UPLOADPATH.'/'.POST_FOLDER.'/',POST_COVER_X.','.POST_COVER_Y,'webp');
                uploader($_FILES['cover'],'thumb-'.$CoverName,UPLOADPATH.'/'.POST_FOLDER.'/',POST_COVER_THUMB_X.','.POST_COVER_THUMB_Y,'png');
                uploader($_FILES['cover'],'thumb-'.$CoverName,UPLOADPATH.'/'.POST_FOLDER.'/',POST_COVER_THUMB_X.','.POST_COVER_THUMB_Y,'webp');
                uploader($_FILES['cover'],'player-'.$CoverName,UPLOADPATH.'/'.POST_FOLDER.'/',POST_PLAYER_X.','.POST_PLAYER_Y,'png');
                uploader($_FILES['cover'],'player-'.$CoverName,UPLOADPATH.'/'.POST_FOLDER.'/',POST_PLAYER_X.','.POST_PLAYER_Y,'webp');

                unlink($path_cover);
            }
            
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
                "type"              => 'movie',
                "title"             => Input::cleaner($_POST['title']),
                "self"              => $self,
                "title_sub"         => Input::cleaner($_POST['title_sub']),
                "image"             => empty($image) ? $Listing['image'] : $image,
                "cover"             => empty($cover) ? $Listing['cover'] : $cover,
                "overview"          => Input::cleaner($_POST['overview']),
                "collection"        => Input::cleaner($_POST['collection']),
                "release_date"      => Input::cleaner($_POST['release_date']),
                "runtime"           => Input::cleaner($_POST['runtime']),
                "vote_average"      => Input::cleaner($_POST['vote_average']),
                "country"           => Input::cleaner($_POST['country']),
                "trailer"           => Input::cleaner($_POST['trailer']),
                "imdb_id"           => Input::cleaner($_POST['imdb_id']),
                "tmdb_id"           => Input::cleaner($_POST['tmdb_id']),
                "view"              => Input::cleaner($_POST['view'],'0'),
                "private"           => Input::cleaner($_POST['private'],'2'),
                "platform"          => Input::cleaner($_POST['platform']),
                "featured"          => (int)Input::cleaner($_POST['featured'],'2'),
                "upcoming"          => (int)Input::cleaner($_POST['upcoming'],'2'),
                "slider"            => (int)Input::cleaner($_POST['slider'],'2'),
                "status"            => (int)Input::cleaner($_POST['status'],'2'),
                "keywords"          => Input::cleaner($_POST['keywords']),
                'data'              => json_encode($Json['data'], JSON_UNESCAPED_UNICODE),
                "updated"           => date('Y-m-d H:i:s')
            );   
            $this->db->update('posts')->where('id',$Listing['id'])->set($dataarray);

            // Genres
            if (count($_POST['genres']) >= '1') { 
                foreach ($SelectGenres as $Key => $Value) {  
                    if (!in_array($Value, $_POST['genres'])) {  
                        $this->db->delete('posts_genre')->where('genre_id', $Value, '=')->where('post_id',$Listing['id'],'=')->done();
                    }
                }
                for ($i = 0; $i < count($_POST['genres']); $i++) {
                    if (!in_array($_POST['genres'][$i], $SelectGenres)) {
                        $dataarray = array(
                            "genre_id"      => Input::cleaner($_POST['genres'][$i]),
                            "post_id"       => $Listing['id']
                        );
                        $this->db->insert('posts_genre')->set($dataarray);
                    }
                }
            } 

            // Videos
            foreach ($_POST['video'] as $Video) {
                if (isset($Video['id']) AND isset($Video['embed'])) {
                    $dataarray = array(
                        "post_id"       => $Listing['id'],
                        "service_id"    => (int)Input::cleaner($Video['service']),
                        "embed"         => Input::cleaner($Video['embed']),
                        "source"        => Input::cleaner($Video['source']),
                        "sortable"      => (int)Input::cleaner($Video['sortable']),
                    );
                    $this->db->update('posts_video')->where('id', Input::cleaner($Video['id']))->set($dataarray);
                } elseif (empty($Video['id']) AND isset($Video['embed'])) {
                    $dataarray = array(
                        "post_id"       => $Listing['id'],
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
                        "post_id"       => $Listing['id'],
                        "language_id"   => (int)Input::cleaner($Subtitle['language_id']),
                        "link"          => Input::cleaner($Subtitle['link']),
                        "sortable"      => (int)Input::cleaner($Subtitle['sortable']),
                    );
                    $this->db->update('posts_subtitle')->where('id', Input::cleaner($Subtitle['id']))->set($dataarray);
                } elseif (empty($Subtitle['id']) AND isset($Subtitle['link'])) {
                    $dataarray = array(
                        "post_id"       => $Listing['id'],
                        "language_id"   => (int)Input::cleaner($Subtitle['language_id']),
                        "link"          => Input::cleaner($Subtitle['link']),
                        "sortable"      => (int)Input::cleaner($Subtitle['sortable']),
                    );
                    $this->db->insert('posts_subtitle')->set($dataarray);
                }
            }

            // Multimedia    
            foreach ($_POST['multimedia'] as $Multimedia) { 
                $dataarray = array(
                    "post_id"       => $Listing['id'],
                    "image"         => Input::cleaner($Multimedia['name'])
                );
                $this->db->insert('posts_media')->set($dataarray);
            }

            // Peoples
            if (isset($_POST['peoples']) AND count($_POST['peoples']) >= '1') {  

                foreach ($_POST['peoples'] as $People) { 
                    if(isset($People['tmdb_id'])) {
                        $CheckPeople = $this->db->from('peoples')->where('tmdb_id', $People['tmdb_id'])->first();
                        if (empty($CheckPeople['id']) AND $People['tmdb_id'] != $CheckPeople['tmdb_id']) {
                            // Guzzle Get
                            $Client         = new \GuzzleHttp\Client();
                            $Response       = $Client->request(
                                'GET', 
                                'https://api.themoviedb.org/3/person/'.$People['tmdb_id'].'?api_key=5ea02218764ccc1f0764e079169f8573&language=tr'
                            );
                            $Cast        = json_decode($Response->getBody() , true);

                            $path_avatar    = UPLOADPATH . '/temp/' . randomcode() . '.jpg';
                            downloader('https://image.tmdb.org/t/p/w300_and_h300_face/'.$Cast['profile_path'], $path_avatar);
         
                            $AvatarName     = randomcode();
                            $avatar         = uploader($path_avatar,$AvatarName,UPLOADPATH.'/'.PEOPLE_FOLDER.'/',PEOPLE_X.','.PEOPLE_Y,'png');
                            uploader($path_avatar,$AvatarName,UPLOADPATH.'/'.PEOPLE_FOLDER.'/',PEOPLE_X.','.PEOPLE_Y,'webp');
               
                            unlink($path_avatar);
                            $dataarray          = array(
                                "name"              => Input::cleaner($Cast['name']),
                                "self"              => Input::seo($Cast['name']),
                                "biography"         => Input::cleaner($Cast['biography']),
                                "department"        => $People['department'],
                                "birthday"          => Input::cleaner($Cast['birthday']),
                                "gender"            => Input::cleaner($Cast['gender']),
                                "image"             => isset($avatar) ? $avatar : null,
                                "tmdb_id"           => $Cast['id'],
                                "imdb_id"           => $Cast['imdb_id'],
                                "featured"          => 0,
                                "created"           => date('Y-m-d H:i:s')
                            );   
                            $this->db->insert('peoples')->set($dataarray); 
                            $people_id = $this->db->lastId();
                        } elseif(isset($CheckPeople['id'])) {
                            $people_id = $CheckPeople['id'];
                        }

                        $PostPeople = $this->db->from('posts_people')->where('people_id', $people_id)->where('post_id',$Listing['id'])->first();
                        if(empty($PostPeople['id'])) {
                            $dataarray = array(
                                "people_id"     => $people_id,
                                "post_id"       => $Listing['id']
                            );
                            $this->db->insert('posts_people')->set($dataarray);
                        }
                    } elseif(isset($People['id'])) {

                        $dataarray = array(
                            "people_id"     => $People['id'],
                            "post_id"       => $Listing['id']
                        );
                        $this->db->update('posts_people')->where('id', Input::cleaner($People['id']))->set($dataarray);

                    } elseif(isset($People['people_id'])) {
                    
                        $dataarray = array(
                            "people_id"     => $People['people_id'],
                            "post_id"       => $Listing['id']
                        );
                        $this->db->insert('posts_people')->set($dataarray);

                    }
                }
            } 


            $Notify['type']     = 'success';
            $Notify['text']     = 'Action completed successfully'; 
            $this->notify($Notify);
            header("location: ".APP.'/admin/movie/'.$Listing['id']);
        }else{ 
            $this->notify($Notify);
        } 
        return $this;
    }
}