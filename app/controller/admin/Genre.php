<?php
/**
 * Genre Controller
 */
class Genre extends Controller
{
    /**
     * Process
     */
    public function process()
    {    

		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");
 
        // Config
        $Config['btn']  = 'genre';
        $Config['nav']  = 'genres';

        if (isset($Route->params->id)) {
            $Listing    = $this->db->from('genres')->where('id',$Route->params->id,'=')->first();
        }

        $this->setVariable('Listing',isset($Listing) ? $Listing : null); 
        $this->setVariable('Config', $Config);  

        if(Input::cleaner((isset($_POST['_ACTION']) ? $_POST['_ACTION'] : null)) == 'save' AND empty($Listing['id'])) {
            $this->save();
        } elseif(Input::cleaner((isset($_POST['_ACTION']) ? $_POST['_ACTION'] : null)) == 'save' AND isset($Listing['id'])) {
            $this->update();
        }

        $this->view("genre", "admin");
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
        
            if(empty($_POST['self'])) {
                $self = Input::seo($_POST['name']);
            } else {
                $self = Input::seo($_POST['self']);
            }
            $dataarray          = array(
                "name"              => Input::cleaner($_POST['name']),
                "self"              => $self,
                "description"       => Input::cleaner($_POST['description']),
                "color"             => Input::cleaner($_POST['color']),
                "type"              => Input::cleaner($_POST['type']),
                "icon"              => isset($Icon) ? $Icon : null,
                "footer"            => Input::cleaner($_POST['footer'],'0'),
                "featured"          => (int)Input::cleaner($_POST['featured'],'0')
            );   
            $this->db->insert('genres')->set($dataarray); 
            $Notify['type']     = 'success';
            $Notify['text']     = $this->translate('Action completed successfully'); 
            $this->notify($Notify);
            header("location: ".APP.'/admin/genres');
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
            
            if(empty($_POST['self'])) {
                $self = Input::seo($_POST['name']);
            } else {
                $self = Input::seo($_POST['self']);
            }
            $dataarray          = array(
                "name"              => Input::cleaner($_POST['name']),
                "self"              => $self,
                "description"       => Input::cleaner($_POST['description']),
                "color"             => Input::cleaner($_POST['color']),
                "type"              => Input::cleaner($_POST['type']),
                "icon"              => isset($Icon) ? $Icon : null,
                "footer"            => Input::cleaner($_POST['footer'],'0'),
                "featured"          => (int)Input::cleaner($_POST['featured'],'0')
            );   
            $this->db->update('genres')->where('id',$Listing['id'])->set($dataarray);
            $Notify['type']     = 'success';
            $Notify['text']     = $this->translate('Action completed successfully'); 
            $this->notify($Notify);
            header("location: ".APP.'/admin/genres');
        }else{ 
            $this->notify($Notify);
        } 
        return $this;
    }
}