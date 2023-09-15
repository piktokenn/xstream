<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Tab extends Controller
{
    public function process()
    {
        $AuthUser       = $this->getVariable("AuthUser");
        $Route          = $this->getVariable("Route");
        $Settings       = $this->getVariable("Settings");
        
        $this->view('common/'.$Route->params->tab, 'app');

    }
    
}
