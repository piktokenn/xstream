<?php
/**
 * Country Controller
 */
class Country extends Controller
{
    /**
     * Process
     */
    public function process()
    {    

		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");
 
        // Config
        $Config['btn']  = 'country';
        $Config['nav']  = 'settings';

        if (isset($Route->params->id)) {
            $Listing    = $this->db->from('countries')->where('id',$Route->params->id,'=')->first();
        }

        $this->setVariable('Listing',isset($Listing) ? $Listing : null); 
        $this->setVariable('Config', $Config);  

        if(Input::cleaner((isset($_POST['_ACTION']) ? $_POST['_ACTION'] : null)) == 'save' AND empty($Listing['id'])) {
            $this->save();
        } elseif(Input::cleaner((isset($_POST['_ACTION']) ? $_POST['_ACTION'] : null)) == 'save' AND isset($Listing['id'])) {
            $this->update();
        }

        $this->view("country", "admin");
    }

    public function save() {
        $AuthUser       = $this->getVariable("AuthUser");     
        if (empty($Notify)) {  
        
            if(isset($_FILES['icon'])) {
                $foo = new \Verot\Upload\Upload($_FILES['icon']);
                if ($foo->uploaded) {
                    $foo->file_auto_rename = true;
                    $foo->file_new_name_body = Input::seo($_POST['name']);
                    $foo->Process(UPLOADPATH . '/country/');
                    $Icon = $foo->file_dst_name;
                }
            }
            $dataarray          = array(
                "name"              => Input::cleaner($_POST['name']),
                "language"          => Input::cleaner($_POST['language']),
                "code"              => Input::cleaner($_POST['code']),
                "icon"              => isset($Icon) ? $Icon : null,
                "subtitle"          => Input::cleaner($_POST['subtitle'])
            );   
            $this->db->insert('countries')->set($dataarray); 
            $Notify['type']     = 'success';
            $Notify['text']     = $this->translate('Action completed successfully'); 
            $this->notify($Notify);
            header("location: ".APP.'/admin/countries');
        }else{ 
            $this->notify($Notify);
        }
        return $this;
    }

    public function update() {
        $AuthUser       = $this->getVariable("AuthUser");    
        $Listing        = $this->getVariable("Listing");       
        if (empty($Notify)) {  
            if(isset($_FILES['icon'])) {
                $foo = new \Verot\Upload\Upload($_FILES['icon']);
                if ($foo->uploaded) {
                    unlink(UPLOADPATH . '/country/' . $Listing['icon']); 
                    $foo->file_auto_rename = true;
                    $foo->file_new_name_body = Input::seo($_POST['name']);
                    $foo->Process(UPLOADPATH . '/country/');
                    $Icon = $foo->file_dst_name;
                }else{
                    $Icon = $Listing['icon'];   
                }
            }
            $dataarray          = array(
                "name"              => Input::cleaner($_POST['name']),
                "language"          => Input::cleaner($_POST['language']),
                "code"              => Input::cleaner($_POST['code']),
                "icon"              => isset($Icon) ? $Icon : null,
                "subtitle"          => Input::cleaner($_POST['subtitle'])
            );   
            $this->db->update('countries')->where('id',$Listing['id'])->set($dataarray);
            $Notify['type']     = 'success';
            $Notify['text']     = $this->translate('Action completed successfully'); 
            $this->notify($Notify);
            header("location: ".APP.'/admin/countries');
        }else{ 
            $this->notify($Notify);
        } 
        return $this;
    }
}