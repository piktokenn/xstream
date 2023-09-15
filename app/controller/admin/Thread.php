<?php
/**
 * Thread Controller
 */
class Thread extends Controller
{
    /**
     * Process
     */
    public function process()
    {    

		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");
 
        // Config
        $Config['btn']  = 'thread';
        $Config['nav']  = 'community';

        if (isset($Route->params->id)) {
            $Listing = $this->db->from(null,'
                SELECT 
                discussions.*,
                posts.title as post_title,
                posts.title_sub,
                posts.image,
                posts.type
                FROM `discussions`
                LEFT JOIN posts ON discussions.post_id = posts.id AND discussions.post_id IS NOT NULL 
                WHERE discussions.id = "'.$Route->params->id.'"')
            ->first();
        }

        $this->setVariable('Listing',isset($Listing) ? $Listing : null); 
        $this->setVariable('Config', $Config);  

        if(Input::cleaner((isset($_POST['_ACTION']) ? $_POST['_ACTION'] : null)) == 'save' AND empty($Listing['id'])) {
            $this->save();
        } elseif(Input::cleaner((isset($_POST['_ACTION']) ? $_POST['_ACTION'] : null)) == 'save' AND isset($Listing['id'])) {
            $this->update();
        }

        $this->view("thread", "admin");
    }

    public function save() {
        $AuthUser       = $this->getVariable("AuthUser");     
        if (empty($Notify)) {  
        
            if(empty($_POST['self'])) {
                $self = Input::seo($_POST['title']);
            } else {
                $self = Input::seo($_POST['self']);
            }
            $dataarray          = array(
                "title"             => Input::cleaner($_POST['title']),
                "self"              => $self,
                "description"       => Input::cleaner($_POST['description']),
                "user_id"           => $AuthUser['id'],
                "featured"          => (int)Input::cleaner($_POST['featured'],'0'),
                "status"            => (int)Input::cleaner($_POST['status'],'0'),
                "created"           => date('Y-m-d H:i:s')
            );   
            $this->db->insert('discussions')->set($dataarray); 
            $Notify['type']     = 'success';
            $Notify['text']     = $this->translate('Action completed successfully'); 
            $this->notify($Notify);
            header("location: ".APP.'/admin/community');
        }else{ 
            $this->notify($Notify);
        }
        return $this;
    }

    public function update() {
        $AuthUser       = $this->getVariable("AuthUser");    
        $Listing        = $this->getVariable("Listing");       
        if (empty($Notify)) { 
            if(empty($_POST['self'])) {
                $self = Input::seo($_POST['title']);
            } else {
                $self = Input::seo($_POST['self']);
            }
            $dataarray          = array(
                "title"             => Input::cleaner($_POST['title']),
                "self"              => $self,
                "description"       => Input::cleaner($_POST['description']),
                "featured"          => (int)Input::cleaner($_POST['featured'],'0'),
                "status"            => (int)Input::cleaner($_POST['status'],'0'),
                "created"           => date('Y-m-d H:i:s')
            );  
            $this->db->update('discussions')->where('id',$Listing['id'])->set($dataarray);
            $Notify['type']     = 'success';
            $Notify['text']     = $this->translate('Action completed successfully'); 
            $this->notify($Notify);
            header("location: ".APP.'/admin/community');
        }else{ 
            $this->notify($Notify);
        } 
        return $this;
    }
}