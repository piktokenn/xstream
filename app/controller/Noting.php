<?php
/**
 * Noting Controller
 */
class Noting extends Controller
{
    /**
     * Process
     */
    public function process()
    {    
		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");
        $Settings       = $this->getVariable("Settings");

        $Config['title']        = $this->translate('Not found');
        $Config['description']  = get($Settings,'data.description','seo'); 
        $Config['url']          = APP.'/404';
        $Config['disabled']     = 'on';

        $this->setVariable("Config", $Config);   
        $this->view("noting", "app");
    }

}