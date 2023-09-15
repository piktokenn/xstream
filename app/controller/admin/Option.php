<?php
/**
 * Option Controller
 */
class Option extends Controller
{
    /**
     * Process
     */
    public function process()
    {    

		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");
 
        // Config
        $Config['btn']  = 'option';
        $Config['nav']  = 'settings';

        if (isset($Route->params->id)) {
            $Listing    = $this->db->from('options')->where('id',$Route->params->id,'=')->first();
        }

        $this->setVariable('Listing',isset($Listing) ? $Listing : null); 
        $this->setVariable('Config', $Config);  

        if(Input::cleaner((isset($_POST['_ACTION']) ? $_POST['_ACTION'] : null)) == 'save' AND empty($Listing['id'])) {
            $this->save();
        } elseif(Input::cleaner((isset($_POST['_ACTION']) ? $_POST['_ACTION'] : null)) == 'save' AND isset($Listing['id'])) {
            $this->update();
        }

        $this->view("option", "admin");
    }

    public function save() { 
        if (empty($Notify)) {  
  
            if(isset($_FILES['icon'])) {
                $foo = new \Verot\Upload\Upload($_FILES['icon']);
                if ($foo->uploaded) {
                    $foo->file_auto_rename = true;
                    $foo->file_new_name_body = Input::seo($_POST['name']);
                    $foo->Process(UPLOADPATH . '/icon/');
                    $Icon = $foo->file_dst_name;
                }
            }
        
            $dataarray          = array(
                "name"              => Input::cleaner($_POST['name']),
                "type"              => Input::cleaner($_POST['type']),
                "icon"              => isset($Icon) ? $Icon : null
            );   
            $this->db->insert('options')->set($dataarray); 
            $Notify['type']     = 'success';
            $Notify['text']     = $this->translate('Action completed successfully'); 
            $this->notify($Notify);
            header("location: ".APP.'/admin/options');
        }else{ 
            $this->notify($Notify);
        }
        return $this;
    }

    public function update() {
        $Listing        = $this->getVariable("Listing");       
        if (empty($Notify)) {
            if(isset($_FILES['icon'])) {
                $foo = new \Verot\Upload\Upload($_FILES['icon']);
                if ($foo->uploaded) {
                    unlink(UPLOADPATH . '/icon/' . $Listing['icon']); 
                    $foo->file_auto_rename = true;
                    $foo->file_new_name_body = Input::seo($_POST['name']);
                    $foo->Process(UPLOADPATH . '/icon/');
                    $Icon = $foo->file_dst_name;
                }else{
                    $Icon = $Listing['icon'];   
                }
            }
            
            $dataarray          = array(
                "name"              => Input::cleaner($_POST['name']),
                "type"              => Input::cleaner($_POST['type']),
                "icon"              => isset($Icon) ? $Icon : null
            );   
            $this->db->update('options')->where('id',$Listing['id'])->set($dataarray);
            $Notify['type']     = 'success';
            $Notify['text']     = $this->translate('Action completed successfully'); 
            $this->notify($Notify);
            header("location: ".APP.'/admin/options');
        }else{ 
            $this->notify($Notify);
        } 
        return $this;
    }
}