<?php
/**
 * Api Controller
 */
class Api extends Controller
{
    /**
     * Process
     */
    public function process()
    {
        $AuthUser   = $this->getVariable("AuthUser");
        $Route      = $this->getVariable("Route");
        $this->{$Route->params->api}();
    }
    public function getMovie($value='') 
    {
        $Settings      = $this->getVariable("Settings");
        
        // Guzzle Get
        $Client         = new \GuzzleHttp\Client();
        $Response       = $Client->request(
                'GET', 
                'https://api.themoviedb.org/3/movie/'.$_POST['id'].'?api_key='.get($Settings,'data.tmdb_api','api').'&language='.get($Settings,'data.tmdb_language','api')
        );
        $Listing        = json_decode($Response->getBody() , true);

        $VideoResponse  = $Client->request(
                'GET', 
                'https://api.themoviedb.org/3/movie/'.$_POST['id'].'/videos?api_key='.get($Settings,'data.tmdb_api','api')
        );
        $Videos          = json_decode($VideoResponse->getBody() , true);
        $Trailer = null; 
        foreach ($Videos['results'] as $Video) { 
            if($Video['type'] == 'Trailer') {
                $Trailer = 'https://www.youtube.com/embed/'.$Video['key'];
            } 
        }
 

        $Credits        = $Client->request(
            'GET', 
            'https://api.themoviedb.org/3/movie/'.$_POST['id'].'/credits?api_key='.get($Settings,'data.tmdb_api','api').'&language='.get($Settings,'data.tmdb_language','api')
        );
        $Credits        = json_decode($Credits->getBody() , true);

        $Keywords        = $Client->request(
            'GET', 
            'https://api.themoviedb.org/3/movie/'.$_POST['id'].'/keywords?api_key='.get($Settings,'data.tmdb_api','api').'&language='.get($Settings,'data.tmdb_language','api')
        );
        $Keywords        = json_decode($Keywords->getBody() , true);

        $Tags = null; 
        foreach ($Keywords['keywords'] as $Keyword) { 
            $Tags .= $Keyword['name'].','; 
        }
        if(isset($Tags)) {
            $Tags = rtrim($Tags,',');
        }

        $People = array();
        if(get($Settings,'data.tmdb_people','api') == 1) {
            $icrew = 1;
            foreach ($Credits['crew'] as $Crew) {
                if($Crew['department'] == 'Directing' AND $icrew == 1) {
                    $People[] = array(
                        'id'                => $Crew['id'],
                        'api'               => true,
                        'name'              => $Crew['name'],
                        'department'        => $this->translate('Director'),
                        'image'             => isset($Crew['profile_path']) ? 'https://image.tmdb.org/t/p/w235_and_h235_face'.$Crew['profile_path'] : '',
                    );
                    $icrew++;
                }
            }
            $icast = 1;
            foreach ($Credits['cast'] as $Cast) {
                if($icast <= get($Settings,'data.tmdb_people_limit','api')) {
                    $People[] = array(
                        'id'                => $Cast['id'],
                        'api'               => true,
                        'name'              => $Cast['name'],
                        'department'        => $this->translate('Actor'),
                        'image'             => isset($Cast['profile_path']) ? 'https://image.tmdb.org/t/p/w235_and_h235_face'.$Cast['profile_path'] : '',
                    );
                    $icast++;
                }
            }
        }
        $Parse = array(
            'id'                => $Listing['id'], 
            'imdb_id'           => $Listing['imdb_id'], 
            'title'             => $Listing['title'], 
            'original_title'    => $Listing['original_title'], 
            'image'             => isset($Listing['poster_path']) ? 'https://image.tmdb.org/t/p/original'.$Listing['poster_path'] : null,
            'cover'             => isset($Listing['backdrop_path']) ? 'https://image.tmdb.org/t/p/original'.$Listing['backdrop_path'] : null,
            'genres'            => $Listing['genres'], 
            'overview'          => $Listing['overview'], 
            'vote_average'      => $Listing['vote_average'], 
            'country'           => isset($Listing['production_countries'][0]['iso_3166_1']) ? mb_strtoupper($Listing['production_countries'][0]['iso_3166_1'],"UTF-8") : null, 
            'runtime'           => $Listing['runtime'], 
            'release_date'      => date("Y-m-d", strtotime($Listing['release_date'])), 
            'trailer'           => isset($Trailer) ? $Trailer : '', 
            'people'            => $People, 
            'tags'              => $Tags, 
        );
        echo json_encode($Parse);
    }

    public function getSerie($value='') 
    {
        $Settings      = $this->getVariable("Settings");
        
        // Guzzle Get
        $Client         = new \GuzzleHttp\Client();
        $Response       = $Client->request(
                'GET', 
                'https://api.themoviedb.org/3/tv/'.$_POST['id'].'?api_key='.get($Settings,'data.tmdb_api','api').'&language='.get($Settings,'data.tmdb_language','api')
        );
        $Listing        = json_decode($Response->getBody() , true);

        $VideoResponse  = $Client->request(
                'GET', 
                'https://api.themoviedb.org/3/tv/'.$_POST['id'].'/videos?api_key='.get($Settings,'data.tmdb_api','api').'&language='.get($Settings,'data.tmdb_language','api')
        );
        $Videos          = json_decode($VideoResponse->getBody() , true);
        $Trailer = null;
        
        foreach ($Videos['results'] as $Video) { 
            if($Video['type'] == 'Trailer') {
                $Trailer = 'https://www.youtube.com/embed/'.$Video['key'];
            } 
        }

        $Credits        = $Client->request(
            'GET', 
            'https://api.themoviedb.org/3/tv/'.$_POST['id'].'/credits?api_key='.get($Settings,'data.tmdb_api','api').'&language='.get($Settings,'data.tmdb_language','api')
        );
        $Credits        = json_decode($Credits->getBody() , true);

        $Keywords        = $Client->request(
            'GET', 
            'https://api.themoviedb.org/3/tv/'.$_POST['id'].'/keywords?api_key='.get($Settings,'data.tmdb_api','api').'&language='.get($Settings,'data.tmdb_language','api')
        );
        $Keywords        = json_decode($Keywords->getBody() , true);

        $Tags = null; 
        foreach ($Keywords['results'] as $Keyword) { 
            $Tags .= $Keyword['name'].','; 
        }
        if(isset($Tags)) {
            $Tags = rtrim($Tags,',');
        }


        $People = array();

        if(get($Settings,'data.tmdb_people','api') == 1) {
            $icrew = 1;
            foreach ($Credits['crew'] as $Crew) {
                if($Crew['department'] == 'Directing' AND $icrew == 1) {
                    $People[] = array(
                        'id'                => $Crew['id'],
                        'api'               => true,
                        'name'              => $Crew['name'],
                        'department'        => $this->translate('Director'),
                        'image'             => isset($Crew['profile_path']) ? 'https://image.tmdb.org/t/p/w235_and_h235_face'.$Crew['profile_path'] : '',
                    );
                    $icrew++;
                }
            }
            $icast = 1;
            foreach ($Credits['cast'] as $Cast) {
                if($icast <= get($Settings,'data.tmdb_people_limit','api')) {
                    $People[] = array(
                        'id'                => $Cast['id'],
                        'api'               => true,
                        'name'              => $Cast['name'],
                        'department'        => $this->translate('Actor'),
                        'image'             => isset($Cast['profile_path']) ? 'https://image.tmdb.org/t/p/w235_and_h235_face'.$Cast['profile_path'] : '',
                    );
                    $icast++;
                }
            }
        }
        foreach ($Listing['seasons'] as $Season) {
            if(isset($Season['season_number']) AND $Season['season_number'] > 0) {
                $Seasons[] = array(
                    'name'              => $Season['season_number']
                );
            }
        }
        $Parse = array(
            'id'                => $Listing['id'], 
            'imdb_id'           => null, 
            'title'             => $Listing['name'], 
            'original_title'    => $Listing['original_name'], 
            'image'             => isset($Listing['poster_path']) ? 'https://image.tmdb.org/t/p/original'.$Listing['poster_path'] : '',
            'cover'             => isset($Listing['backdrop_path']) ? 'https://image.tmdb.org/t/p/original'.$Listing['backdrop_path'] : '',
            'genres'            => $Listing['genres'], 
            'overview'          => $Listing['overview'], 
            'vote_average'      => $Listing['vote_average'], 
            'country'           => isset($Listing['production_countries'][0]['name']) ? mb_strtoupper($Listing['production_countries'][0]['name'],"UTF-8") : null, 
            'runtime'           => null, 
            'release_date'      => date("Y-m-d", strtotime($Listing['first_air_date'])), 
            'trailer'           => isset($Trailer) ? $Trailer : '', 
            'season'            => $Seasons, 
            'people'            => $People, 
            'tags'              => $Tags, 
        );
        echo json_encode($Parse);
    }

    public function getNetwork($value='') 
    {
        
        $Settings      = $this->getVariable("Settings");
        // Guzzle Get
        $Client         = new \GuzzleHttp\Client();
        $Response       = $Client->request(
                'GET', 
                'https://api.themoviedb.org/3/network/'.$_POST['id'].'?api_key='.get($Settings,'data.tmdb_api','api').'&language='.get($Settings,'data.tmdb_language','api')
        );
        $Listing        = json_decode($Response->getBody() , true);

        $Parse = array(
            'id'                => $Listing['id'], 
            'name'              => $Listing['name'], 
            'homepage'          => $Listing['homepage'], 
            'image'             => isset($Listing['logo_path']) ? 'https://image.tmdb.org/t/p/w500_filter(negate,000,666)'.$Listing['logo_path'] : '',
            'country'           => $Listing['origin_country']
        );
        echo json_encode($Parse);
    }

    public function getPeople() 
    {
        $Settings      = $this->getVariable("Settings");
        
        // Guzzle Get
        $Client         = new \GuzzleHttp\Client();
        $Response       = $Client->request(
                'GET', 
                'https://api.themoviedb.org/3/person/'.$_POST['id'].'?api_key='.get($Settings,'data.tmdb_api','api').'&language='.get($Settings,'data.tmdb_language','api')
        );
        $Listing        = json_decode($Response->getBody() , true);

        $Parse = array(
            'id'                => $Listing['id'],
            'name'              => $Listing['name'],
            'birthday'          => $Listing['birthday'],
            'imdb_id'           => $Listing['imdb_id'],
            'biography'         => $Listing['biography'],
            'gender'            => $Listing['gender'],
            'department'        => $Listing['known_for_department'] == 'Directing' ? $this->translate('Director') : $this->translate('Actor'),
            'image'             => isset($Listing['profile_path']) ? 'https://image.tmdb.org/t/p/w235_and_h235_face'.$Listing['profile_path'] : '',
        );
        echo json_encode($Parse);
    }


    public function sample() {
        $Settings      = $this->getVariable("Settings");
        /*
        // Guzzle Get
        $Client         = new \GuzzleHttp\Client();
        $Response       = $Client->request(
                'GET', 
                'https://api.themoviedb.org/3/genre/movie/list?api_key='.get($Settings,'data.tmdb_api','api').'&language='.get($Settings,'data.tmdb_language','api')
        );
        $Listings        = json_decode($Response->getBody() , true);
        foreach($Listings['genres'] as $Listing) {
            $CheckGenre = $this->db->from('genres')->where('name', $Listing['name'])->first();
            if(empty($CheckGenre['id'])) {
                $dataarray          = array(
                    "name"              => Input::cleaner($Listing['name']),
                    "self"              => Input::seo($Listing['name']),
                    "footer"            => 1,
                    "featured"          => 1
                );   
                $this->db->insert('genres')->set($dataarray); 
            }
        }
        */

        $Posts = $this->db->from('posts')->where('type','serie')->all();
        foreach ($Posts as $Post) {

            $Seasons = $this->db->from('posts_season')->where('post_id',$Post['id'])->all();
            foreach($Seasons as $Season) {
                for ($i=1; $i <=8; $i++) { 
                        // code...
                    $dataarray          = array(
                        "post_id"           => Input::cleaner($Post['id']),
                        "season_id"         => Input::cleaner($Season['id']),
                        "title"             => 'Sample heading #'.$i,
                        "title_number"      => $i,
                        "release_date"      => '2022-'.rand(1,12).'-'.rand(1,30),
                        "runtime"           => rand(60,140),
                        "trailer"           => 'https://www.youtube.com/embed/aqz-KE-bpKQ',
                        "view"              => rand(1000,40000),
                        "status"            => 1,
                        "created"           => date('Y-m-d H:i:s')
                    );   
                    $this->db->insert('posts_episode')->set($dataarray); 
                    $post_id     = $this->db->lastId(); 
                    for ($ii=0; $ii <2; $ii++) { 
                        $dataarray = array(
                            "post_id"       => $Post['id'],
                            "episode_id"    => $post_id,
                            "embed"         => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4',
                            "source"        => 'mp4',
                            "sortable"      => $ii,
                        );
                        $this->db->insert('posts_video')->set($dataarray);
                    }
                }
            }
        }
    }

}