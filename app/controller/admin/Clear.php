<?php
/**
 * Clear Controller
 */
class Clear extends Controller
{
    /**
     * Process
     */
    public function process()
    {    

		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");

        // Config
        $Config['nav']  = 'settings';  

        $this->setVariable("Config", $Config);  
        removefolder(PATH.'/cache');
        
        $this->view("clear", "admin");
    }
}