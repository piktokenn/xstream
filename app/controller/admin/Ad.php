<?php
/**
 * Ad Controller
 */
class Ad extends Controller
{
    /**
     * Process
     */
    public function process()
    {    

		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");
 
        // Config
        $Config['btn']  = 'ad';
        $Config['nav']  = 'settings';

        if (isset($Route->params->id)) {
            $Listing    = $this->db->from('ads')->where('id',$Route->params->id,'=')->first();
            $Data       = json_decode($Listing['ads_data'], true);     
        }

        $this->setVariable('Listing',isset($Listing) ? $Listing : null); 
        $this->setVariable('Data',isset($Data) ? $Data : null); 
        $this->setVariable('Config', $Config);  

        if(Input::cleaner((isset($_POST['_ACTION']) ? $_POST['_ACTION'] : null)) == 'save' AND empty($Listing['id'])) {
            $this->save();
        } elseif(Input::cleaner((isset($_POST['_ACTION']) ? $_POST['_ACTION'] : null)) == 'save' AND isset($Listing['id'])) {
            $this->update();
        }

        $this->view("ad", "admin");
    }

    public function save() {
        $AuthUser       = $this->getVariable("AuthUser");     
        if (empty($Notify)) {  
            if(isset($_POST['type']) AND $_POST['type'] == 'image') {
                $foo = new \Verot\Upload\Upload($_FILES['image']);
                if ($foo->uploaded) { 
                    $foo->file_auto_rename      = true;
                    $foo->file_new_name_body    = randomcode();
                    $foo->Process(UPLOADPATH . '/ads/');
                    $Image = $foo->file_dst_name;

                } elseif($Data['image']) {
                    $Image = $Data['image'];
                }
            }

            if(isset($_POST['type']) AND $_POST['type'] == 'code') {
                $Settings['image']  = null;
            }elseif(isset($_POST['type']) AND $_POST['type'] == 'image') {
                $Settings['image']  = $Image;
                $Settings['link']   = Input::cleaner($_POST['link']);
            }

            $dataarray          = array( 
                "name"              => Input::cleaner($_POST['name']),
                "type"              => Input::cleaner($_POST['type']),
                "ads_data"          => json_encode($Settings, JSON_UNESCAPED_UNICODE),
                "ads_code"          => htmlspecialchars($_POST['ads_code']),
                "display_user"      => Input::cleaner($_POST['display_user'],2),
                "status"            => Input::cleaner($_POST['status'],2)
            );   
            $this->db->insert('ads')->set($dataarray); 
            $Notify['type']     = 'success';
            $Notify['text']     = $this->translate('Action completed successfully'); 
            $this->notify($Notify);
            header("location: ".APP.'/admin/ad/'.$this->db->lastId());
        }else{ 
            $this->notify($Notify);
        }
        return $this;
    }

    public function update() {
        $AuthUser       = $this->getVariable("AuthUser");    
        $Listing        = $this->getVariable("Listing");       
        $Data        = $this->getVariable("Data");       
        if (empty($Notify)) {  
            if(isset($_POST['type']) AND $_POST['type'] == 'image') {
                $foo = new \Verot\Upload\Upload($_FILES['image']);
                if ($foo->uploaded) { 
                    unlink(UPLOADPATH . '/ads/'.$Data['image']);
                    $foo->file_auto_rename      = true;
                    $foo->file_new_name_body    = randomcode();
                    $foo->Process(UPLOADPATH . '/ads/');
                    $Image = $foo->file_dst_name;

                } elseif($Data['image']) {
                    $Image = $Data['image'];
                }
            }

            if(isset($_POST['type']) AND $_POST['type'] == 'code') {
                $Settings['image']  = null;
            }elseif(isset($Image)) {
                $Settings['image']  = $Image;
                $Settings['link']   = Input::cleaner($_POST['link']);
            }
            
            $dataarray          = array( 
                "name"              => Input::cleaner($_POST['name']),
                "type"              => Input::cleaner($_POST['type']),
                "ads_data"          => json_encode($Settings, JSON_UNESCAPED_UNICODE),
                "ads_code"          => htmlspecialchars($_POST['ads_code']),
                "display_user"      => Input::cleaner($_POST['display_user'],2),
                "status"            => Input::cleaner($_POST['status'],2)
            );   
            $this->db->update('ads')->where('id',$Listing['id'])->set($dataarray);
            $Notify['type']     = 'success';
            $Notify['text']     = $this->translate('Action completed successfully'); 
            $this->notify($Notify);
            header("location: ".APP.'/admin/ad/'.$Listing['id']);
        }else{ 
            $this->notify($Notify);
        } 
        return $this;
    }
}