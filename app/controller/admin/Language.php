<?php
/**
 * Language Controller
 */
class Language extends Controller
{
    /**
     * Process
     */
    public function process()
    {    

		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");
 
        // Config
        $Config['btn']  = 'language';
        $Config['nav']  = 'settings';

        $Lang = array();
        if (isset($Route->params->id)) {
            $Listing    = $this->db->from('languages')->where('id',$Route->params->id,'=')->first();
            if(file_exists(PATH.'/lang/'.$Listing['language'].'.php')){ 
                include PATH.'/lang/'.$Listing['language'].'.php';
            }else{
                include PATH.'/lang/en.php';
            }
        } else {
            include PATH.'/lang/en.php';
        }


        $this->setVariable('Listing',isset($Listing) ? $Listing : null); 
        $this->setVariable('Config', $Config);  
        $this->setVariable("Lang",$Lang);  

        if(Input::cleaner((isset($_POST['_ACTION']) ? $_POST['_ACTION'] : null)) == 'save' AND empty($Listing['id'])) {
            $this->save();
        } elseif(Input::cleaner((isset($_POST['_ACTION']) ? $_POST['_ACTION'] : null)) == 'save' AND isset($Listing['id'])) {
            $this->update();
        }

        $this->view("language", "admin");
    }

    public function save() {
        $AuthUser       = $this->getVariable("AuthUser");     
        if (empty($Notify)) {  
        
            $dataarray          = array(
                "name"              => Input::cleaner($_POST['name']),
                "language"          => Input::cleaner($_POST['language']),
                "text_direction"    => Input::cleaner($_POST['text_direction']),
                "currency"          => Input::cleaner($_POST['currency']),
                "status"            => (int)Input::cleaner($_POST['status'],2)
            );   
            $this->db->insert('languages')->set($dataarray); 
            file_put_contents(PATH.'/lang/'.Input::cleaner($_POST['language']).'.php', '<?php $Lang = ' . var_export($_POST['lang'], true) . ';');
            $Notify['type']     = 'success';
            $Notify['text']     = $this->translate('Action completed successfully'); 
            $this->notify($Notify);
            header("location: ".APP.'/admin/languages');
        }else{ 
            $this->notify($Notify);
        }
        return $this;
    }

    public function update() {  
        $Listing        = $this->getVariable("Listing");       
        if (empty($Notify)) { 
            $dataarray          = array(
                "name"              => Input::cleaner($_POST['name']),
                "language"          => Input::cleaner($_POST['language']),
                "text_direction"    => Input::cleaner($_POST['text_direction']),
                "currency"          => Input::cleaner($_POST['currency']),
                "status"            => (int)Input::cleaner($_POST['status'],2)
            );   
            $this->db->update('languages')->where('id',$Listing['id'])->set($dataarray);
            file_put_contents(PATH.'/lang/'.Input::cleaner($_POST['language']).'.php', '<?php $Lang = ' . var_export($_POST['lang'], true) . ';');
            $Notify['type']     = 'success';
            $Notify['text']     = $this->translate('Action completed successfully'); 
            $this->notify($Notify);
            header("location: ".APP.'/admin/languages');
        }else{ 
            $this->notify($Notify);
        } 
        return $this;
    }
}