<?php
/**
 * Main Controller
 */ 
class Main extends Controller
{
    /**
     * Process
     */
    public function process()
    {    

		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");
        $Settings       = $this->getVariable("Settings");

        $Config['title']        = get($Settings,'data.title','seo');
        $Config['description']  = get($Settings,'data.description','seo');
        $Config['cache']        = 'true';
        $Config['url']          = APP;
        $Modules        = $this->db->from("modules")->where('page','home')->where('status',1)->orderby('sortable','ASC')->all();
        $this->setVariable("Config", $Config);  
        $this->setVariable("Modules", $Modules);

        $this->view("main", "app");
    }
}