<?php
/**
 * Platform Controller
 */
class Platform extends Controller
{
    /**
     * Process
     */
    public function process()
    {    

		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");
 
        // Config
        $Config['btn']  = 'platform';
        $Config['nav']  = 'platforms';
        $Config['api']  = 'getNetwork';

        if (isset($Route->params->id)) {
            $Listing    = $this->db->from('platforms')->where('id',$Route->params->id,'=')->first();
        }

        $Countries  = $this->db->from('countries')->orderby('name','ASC')->all();
        $this->setVariable('Listing',isset($Listing) ? $Listing : null); 
        $this->setVariable('Countries', $Countries);  
        $this->setVariable('Config', $Config);  

        if(Input::cleaner((isset($_POST['_ACTION']) ? $_POST['_ACTION'] : null)) == 'save' AND empty($Listing['id'])) {
            $this->save();
        } elseif(Input::cleaner((isset($_POST['_ACTION']) ? $_POST['_ACTION'] : null)) == 'save' AND isset($Listing['id'])) {
            $this->update();
        }

        $this->view("platform", "admin");
    }

    public function save() { 
        if (empty($Notify)) {  
  
            if(isset($_POST['image_url'])) {
                $path_image = UPLOADPATH . '/temp/' . randomcode() . '.jpg';
                downloader($_POST['image_url'], $path_image);
                $image      = uploader($path_image,$ImageName,UPLOADPATH.'/'.PLATFORM_FOLDER.'/',PLATFORM_X,'png');
                uploader($path_image,$ImageName,UPLOADPATH.'/'.PLATFORM_FOLDER.'/',PLATFORM_X,'webp');
                unlink($path_image);
            }
            if(isset($_FILES['image']) AND $_FILES['image']['error'] == '0') {
                $ImageName = randomcode();
                $image      = uploader($_FILES['image'],$ImageName,UPLOADPATH.'/'.PLATFORM_FOLDER.'/',PLATFORM_X,'png');
                uploader($_FILES['image'],$ImageName,UPLOADPATH.'/'.PLATFORM_FOLDER.'/',PLATFORM_X,'webp');
                unlink($path_image);
            }
            if(isset($_POST['self'])) {
                $self = Input::seo($_POST['self']);
            } else {
                $self = Input::seo($_POST['name']);
            }

            $dataarray          = array(
                "name"              => Input::cleaner($_POST['name']),
                "self"              => $self,
                "website"           => Input::cleaner($_POST['website']),
                "tmdb_id"           => Input::cleaner($_POST['tmdb_id']),
                "image"             => isset($image) ? $image : null,
                "featured"          => (int)Input::cleaner($_POST['featured'],'0'),
                "created"           => date('Y-m-d H:i:s')
            );   
            $this->db->insert('platforms')->set($dataarray); 
            $Notify['type']     = 'success';
            $Notify['text']     = $this->translate('Action completed successfully'); 
            $this->notify($Notify);
            header("location: ".APP.'/admin/platforms');
        }else{ 
            $this->notify($Notify);
        }
        return $this;
    }

    public function update() {
        $Listing        = $this->getVariable("Listing");       
        if (empty($Notify)) {
            if(isset($_POST['image_url'])) {
                $ImageName = randomcode();
                $path_image = UPLOADPATH . '/temp/' . randomcode() . '.jpg';
                downloader($_POST['image_url'], $path_image);
                $image      = uploader($path_image,$ImageName,UPLOADPATH.'/'.PLATFORM_FOLDER.'/',PLATFORM_X,'png');
                uploader($path_image,$ImageName,UPLOADPATH.'/'.PLATFORM_FOLDER.'/',PLATFORM_X,'webp');
                unlink($path_image);
            }
            if(isset($_FILES['image']) AND $_FILES['image']['error'] == '0') {
                $ImageName = randomcode();
                $image      = uploader($_FILES['image'],$ImageName,UPLOADPATH.'/'.PLATFORM_FOLDER.'/',PLATFORM_X,'png');
                uploader($_FILES['image'],$ImageName,UPLOADPATH.'/'.PLATFORM_FOLDER.'/',PLATFORM_X,'webp');
                unlink($path_image);
            }

            if(isset($_POST['self'])) {
                $self = Input::seo($_POST['self']);
            } else {
                $self = Input::seo($_POST['name']);
            }

            $dataarray          = array(
                "name"              => Input::cleaner($_POST['name']),
                "self"              => $self,
                "website"           => Input::cleaner($_POST['website']),
                "tmdb_id"           => Input::cleaner($_POST['tmdb_id']),
                "image"             => empty($image) ? $Listing['image'] : $image,
                "featured"          => (int)Input::cleaner($_POST['featured'],'0')
            );   
            $this->db->update('platforms')->where('id',$Listing['id'])->set($dataarray);
            $Notify['type']     = 'success';
            $Notify['text']     = $this->translate('Action completed successfully'); 
            $this->notify($Notify);
            header("location: ".APP.'/admin/platforms');
        }else{ 
            $this->notify($Notify);
        } 
        return $this;
    }
}