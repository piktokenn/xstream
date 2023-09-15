<?php
/**
 * Page Controller
 */
class Page extends Controller
{
    /**
     * Process
     */
    public function process()
    {    

		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");
 
        // Config
        $Config['btn']  = 'page';
        $Config['nav']  = 'settings';

        if (isset($Route->params->id)) {
            $Listing    = $this->db->from('pages')->where('id',$Route->params->id,'=')->first();
        }

        $this->setVariable('Listing',isset($Listing) ? $Listing : null); 
        $this->setVariable('Config', $Config);  

        if(Input::cleaner((isset($_POST['_ACTION']) ? $_POST['_ACTION'] : null)) == 'save' AND empty($Listing['id'])) {
            $this->save();
        } elseif(Input::cleaner((isset($_POST['_ACTION']) ? $_POST['_ACTION'] : null)) == 'save' AND isset($Listing['id'])) {
            $this->update();
        }

        $this->view("page", "admin");
    }

    public function save() { 
        if (empty($Notify)) {  
  
            if(isset($_POST['self'])) {
                $self = Input::seo($_POST['self']);
            } else {
                $self = Input::seo($_POST['name']);
            }
        
            $dataarray          = array(
                "name"          => Input::cleaner($_POST['name']),
                "self"          => $self,
                "description"   => Input::cleaner($_POST['description']),
                "body"          => htmlspecialchars($_POST['body']),
                "footer"        => (int)Input::cleaner($_POST['footer'],2),
                "status"        => Input::cleaner($_POST['status'],2)
            );   
            $this->db->insert('pages')->set($dataarray); 
            $Notify['type']     = 'success';
            $Notify['text']     = 'Değişiklik kaydedildi'; 
            $this->notify($Notify);
            header("location: ".APP.'/admin/pages');
        }else{ 
            $this->notify($Notify);
        }
        return $this;
    }

    public function update() {
        $Listing        = $this->getVariable("Listing");       
        if (empty($Notify)) { 
            
            if(isset($_POST['self'])) {
                $self = Input::seo($_POST['self']);
            } else {
                $self = Input::seo($_POST['name']);
            }
            $dataarray          = array(
                "name"          => Input::cleaner($_POST['name']),
                "self"          => $self,
                "description"   => Input::cleaner($_POST['description']),
                "body"          => htmlspecialchars($_POST['body']),
                "footer"        => (int)Input::cleaner($_POST['footer'],2),
                "status"        => Input::cleaner($_POST['status'],2)
            );   
            $this->db->update('pages')->where('id',$Listing['id'])->set($dataarray);
            $Notify['type']     = 'success';
            $Notify['text']     = 'Değişiklik kaydedildi'; 
            $this->notify($Notify);
            header("location: ".APP.'/admin/pages');
        }else{ 
            $this->notify($Notify);
        } 
        return $this;
    }
}