<?php
/**
 * Tmdb Controller
 */
class Tmdb extends Controller
{
    /**
     * Process
     */
    public function process()
    {    

		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");
 
        // Config
        $Config['nav']      = 'tools';
        $Config['page']     = $this->translate('Tmdb');

        if(isset($_POST['_ACTION'])) {
            foreach ($_POST as $key => $value) {
                if(!empty($value) AND isset($key) AND ($key != '_TOKEN' && $key != '_ACTION')) {
                    $Filter[$key] = $value;
                }
            }
            if(count($Filter) > 1) {
                header("location: ".APP.'/admin/tmdb?filter='.json_encode($Filter));
            } else {
                header("location: ".APP.'/admin/tmdb');
            }
        }
        if(isset($_GET['filter'])) {
            $Filter     = json_decode($_GET['filter'], true); 
            $this->setVariable('Filter',isset($Filter) ? $Filter : null); 
        }
        $this->setVariable("Config", $Config);  

        if(isset($Filter['type'])) {
            $this->listings();
        }

        $this->view("tmdb", "admin");
    }

    public function listings() {
        $Filter     = $this->getVariable("Filter");
        $Settings   = $this->getVariable("Settings");

        $ApiFilter      = null;
        $this->page     = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

        if ($this->page) $ApiFilter .= '&page=' . $this->page;
    
        $Client         = new \GuzzleHttp\Client();
        if(isset($Filter['q'])) {

            $Response   = $Client->request('GET', 'https://api.themoviedb.org/3/search/' . Input::cleaner($Filter['type']) . '?query=' . Input::cleaner($Filter['q']) . $ApiFilter . '&api_key=' . get($Settings,'data.tmdb_api','api') . '&language='.get($Settings,'data.tmdb_language','api'));
        } else {
            $Response   = $Client->request('GET', 'https://api.themoviedb.org/3/discover/'.$Filter['type'].'?sort_by='.Input::cleaner($Filter['sort']). '&api_key='.get($Settings,'data.tmdb_api','api').$ApiFilter.'&language='.get($Settings,'data.tmdb_language','api'));
        }
        $Results = json_decode($Response->getBody() , true); 
        foreach ($Results['results'] as $Result) {
            if (isset($Filter['type']) AND Input::cleaner($Filter['type']) == 'movie') {
     
                if(isset($Result['poster_path'])) {
                    $Listings[] = [
                        'id'        => trim($Result['id']),
                        'type'      => 'movie',
                        'link'      => 'https://tmdb.org/movie/' . $Result['id'],
                        'title'     => $Result['title'],
                        'original_title'    => $Result['original_title'], 
                        'image'     => 'https://image.tmdb.org/t/p/w780/' . $Result['poster_path']
                    ];
                }
            } elseif (Input::cleaner($Filter['type']) == 'tv') {
                if(isset($Result['poster_path'])) {
                    $Listings[] = [
                        'id'        => trim($Result['id']),
                        'type'      => 'tv',
                        'link'      => 'https://tmdb.org/tv/' . $Result['id'],
                        'title'     => $Result['name'],
                        'original_title'    => $Result['original_name'], 
                        'image'     => 'https://image.tmdb.org/t/p/w780/' . $Result['poster_path']
                    ];
                }
            }
        }

        $this->paginationLimit  = 20;
        $this->totalRecord      = $Results['total_results'];
        $this->pageCount        = ceil($this->totalRecord / $this->paginationLimit);

        $Pagination         = $this->showPagination(APP.'/admin/tmdb?filter='.json_encode($Filter).'&page=[page]');
        $this->setVariable("Listings",$Listings);   
        $this->setVariable("Pagination",$Pagination);

    }


    public function showPagination($url=null, $class = 'active',$small=null) {
        $this->html = null;
        if ($this->totalRecord > PAGE_LIMIT) {
            if($small) {
                $this->html .= '<ul class="pagination pagination-spaced mb-3">';
            }else{
                $this->html .= '<ul class="pagination pagination-spaced mb-3">';
            }
            for ($i = $this->page - 2; $i < $this->page + 2 + 1; $i ++) {
                if ($i > 0 && $i <= $this->pageCount) {
                    $this->html .= '<li class="page-item ';
                    $this->html .= ($i == $this->page ? 'active' : null);
                    $this->html .= '"><a class="page-link border-0" href=\'' . str_replace('[page]', $i, $url) . '\' rel="nofollow">' . $i . '</a>';
                }
            }
            $this->html .= '</ul>';
            return $this->html;
        }
    }

}