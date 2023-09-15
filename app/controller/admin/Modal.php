<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Modal extends Controller
{
    public function process()
    {
        $AuthUser = $this->getVariable("AuthUser");
        $Route = $this->getVariable("Route");
        if(isset($Route->params->modal) AND $Route->params->modal == 'video') {
            $this->video();
        }
        $this->view('modal/'.$Route->params->modal, 'admin');

    }

    public function video($value='')
    {
        $Services = $this->db->from('options')->where('type','service')->all();
        $this->setVariable('Services',isset($Services) ? $Services : null); 
    }
    
}
