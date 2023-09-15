<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Modal extends Controller
{
    public function process()
    {
        $AuthUser       = $this->getVariable("AuthUser");
        $Route          = $this->getVariable("Route");
        $Settings       = $this->getVariable("Settings");
        if(isset($Route->params->modal) AND ($Route->params->modal == 'report' OR $Route->params->modal == 'bookmark')) {
            $Listing = $this->db->from('posts')->where('id',(int)Input::cleaner($_GET['id']))->first();
            if(empty($Listing['id'])) {
                header('location:'.APP.'/404');
            }
            $this->setVariable("Listing", $Listing);  
        }
        $this->view('modal/'.$Route->params->modal, 'app');

    }
    
}
