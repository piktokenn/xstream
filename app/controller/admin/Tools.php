<?php
/**
 * Tools Controller
 */
class Tools extends Controller
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
        $Config['page']     = $this->translate('Tools');


        $this->setVariable("Config", $Config);  

        $this->view("tools", "admin");
    }
}