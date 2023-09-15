<?php
/**
 * Request Controller
 */
class Request extends Controller
{
    /**
     * Process
     */
    public function process()
    {    

		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");
        $isValid        = $this->getVariable("isValid");
        $Settings       = $this->getVariable("Settings");

        $Config['title']        = $this->translate('Request').' – '.get($Settings,'data.title','seo');
        $Config['description']  = get($Settings,'data.description','seo');
        $Config['cache']        = 'true';

        if (isset($_POST['_ACTION']) AND Input::cleaner($_POST['_ACTION']) == "search" AND $isValid == 1 AND Input::cleaner($_POST['q'])) {
            // Guzzle Get
            $Client         = new \GuzzleHttp\Client();
            $Response       = $Client->request(
                    'GET', 
                    'https://api.themoviedb.org/3/search/multi?api_key='.get($Settings,'data.tmdb_api','api').'&language='.get($Settings,'data.tmdb_language','api').'&page=1&query='.Input::cleaner($_POST['q'])
            );
            $Listings        = json_decode($Response->getBody() , true);
            $this->setVariable("Listings", $Listings);  
        } elseif(isset($_POST['_ACTION']) AND Input::cleaner($_POST['_ACTION']) == "search" AND empty($isValid)) {
            header('location:'.APP.'/'.$this->translate('request'));
        }

        $this->setVariable("Config", $Config);   

        $this->view("request", "app");
    }
}