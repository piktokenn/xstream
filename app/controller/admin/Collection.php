<?php
/**
 * Collection Controller
 */
class Collection extends Controller
{
    /**
     * Process
     */
    public function process()
    {    

		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");
 
        // Config
        $Config['btn']  = 'collection';
        $Config['nav']  = 'collections';

        if (isset($Route->params->id)) {
            $Listing    = $this->db->from('collections')->where('id',$Route->params->id,'=')->first();

            // Posts
            $Posts = $this->db->from(
                null,
                '
                SELECT 
                collections_post.id, 
                collections_post.post_id, 
                posts.title,  
                posts.type,  
                posts.self,   
                posts.image
                FROM `collections_post` 
                LEFT JOIN posts ON collections_post.post_id = posts.id     
                WHERE collections_post.collection_id = ' . $Listing['id'] . '
                ORDER BY collections_post.id ASC'
            )->all();
        }

        $this->setVariable('Listing',isset($Listing) ? $Listing : null); 
        $this->setVariable('Posts',isset($Posts) ? $Posts : null); 
        $this->setVariable('Config', $Config);  

        if(Input::cleaner((isset($_POST['_ACTION']) ? $_POST['_ACTION'] : null)) == 'save' AND empty($Listing['id'])) {
            $this->save();
        } elseif(Input::cleaner((isset($_POST['_ACTION']) ? $_POST['_ACTION'] : null)) == 'save' AND isset($Listing['id'])) {
            $this->update();
        }

        $this->view("collection", "admin");
    }

    public function save() { 
        $AuthUser        = $this->getVariable("AuthUser");       
        if (empty($Notify)) {  
  
        
            if(empty($_POST['self'])) {
                $self = Input::seo($_POST['name']);
            } else {
                $self = Input::seo($_POST['self']);
            }
            $dataarray          = array(
                "user_id"           => $AuthUser['id'],
                "name"              => Input::cleaner($_POST['name']),
                "self"              => $self,
                "color"             => Input::cleaner($_POST['color']),
                "privacy"           => Input::cleaner($_POST['privacy'],'0'),
                "featured"          => (int)Input::cleaner($_POST['featured'],'0'),
                "created"           => date('Y-m-d H:i:s')
            );   
            $this->db->insert('collections')->set($dataarray); 

            $collection_id = $this->db->lastId();

            // Collection    
            foreach ($_POST['collection'] as $Collection) {
                if (isset($Collection['post_id'])) {
                    $dataarray = array(
                        "collection_id"     => $collection_id,
                        "post_id"           => Input::cleaner($Collection['post_id'])
                    );
                    $this->db->insert('collections_post')->set($dataarray);
                }
            }

            $Notify['type']     = 'success';
            $Notify['text']     = $this->translate('Action completed successfully'); 
            $this->notify($Notify);
            header("location: ".APP.'/admin/collections');
        }else{ 
            $this->notify($Notify);
        }
        return $this;
    }

    public function update() {
        $Listing        = $this->getVariable("Listing");       
        if (empty($Notify)) {

            if(empty($_POST['self'])) {
                $self = Input::seo($_POST['name']);
            } else {
                $self = Input::seo($_POST['self']);
            }
            $dataarray          = array(
                "name"              => Input::cleaner($_POST['name']),
                "self"              => $self,
                "color"             => Input::cleaner($_POST['color']),
                "privacy"           => Input::cleaner($_POST['privacy'],'0'),
                "featured"          => (int)Input::cleaner($_POST['featured'],'0')
            );   
            $this->db->update('collections')->where('id',$Listing['id'])->set($dataarray);



            // Collection    
            foreach ($_POST['collection'] as $Collection) { 
                if (empty($Collection['id']) AND isset($Collection['post_id'])) {
                    $dataarray = array(
                        "collection_id"     => $Listing['id'],
                        "post_id"           => Input::cleaner($Collection['post_id'])
                    );
                    $this->db->insert('collections_post')->set($dataarray);
                }
            }

            $Notify['type']     = 'success';
            $Notify['text']     = $this->translate('Action completed successfully'); 
            $this->notify($Notify);
            header("location: ".APP.'/admin/collections');
        }else{ 
            $this->notify($Notify);
        } 
        return $this;
    }
}