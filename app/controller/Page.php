<?php
/**
 * Page Controller
 */
class Page extends Controller
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
            $Listing        = $this->db->from('pages')->where('self',$Route->params->self,'=')->first();
            if(empty($Listing['id'])) {
                header('location:'.APP.'/404');
            }
        }

        $Config['title']        = get($Settings,'data.title','seo');
        $Config['description']  = get($Settings,'data.description','seo');
        $Config['id']           = $Listing['id'];
        $Config['type']         = 'people';

        $this->setVariable("Config", $Config);   
        $this->setVariable('Listing', $Listing);  

        $this->view("page", "app");
    }

}