<?php
/**
 * People Controller
 */
class People extends Controller
{
    /**
     * Process
     */
    public function process()
    {    

		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");
 
        // Config
        $Config['btn']  = 'people';
        $Config['nav']  = 'peoples';
        $Config['api']  = 'getPeople';

        if (isset($Route->params->id)) {
            $Listing    = $this->db->from('peoples')->where('id',$Route->params->id,'=')->first();
        }

        $this->setVariable('Listing',isset($Listing) ? $Listing : null); 
        $this->setVariable('Config', $Config);  

        if(Input::cleaner((isset($_POST['_ACTION']) ? $_POST['_ACTION'] : null)) == 'save' AND empty($Listing['id'])) {
            $this->save();
        } elseif(Input::cleaner((isset($_POST['_ACTION']) ? $_POST['_ACTION'] : null)) == 'save' AND isset($Listing['id'])) {
            $this->update();
        }

        $this->view("people", "admin");
    }

    public function save() { 
        if (empty($Notify)) {  
  
            if(!empty($_POST['image_url'])) {
                $path_image = UPLOADPATH . '/temp/' . randomcode() . '.jpg';
                downloader($_POST['image_url'], $path_image);
                $_FILES['image'] = $path_image;
            }
            if(isset($_FILES['image']) AND $_FILES['image']['error'] != '4') {
                $ImageName = randomcode();
                $image      = uploader($_FILES['image'],$ImageName,UPLOADPATH.'/'.PEOPLE_FOLDER.'/',PEOPLE_X.','.PEOPLE_Y,'png');
                uploader($_FILES['image'],$ImageName,UPLOADPATH.'/'.PEOPLE_FOLDER.'/',PEOPLE_X.','.PEOPLE_Y,'webp');
                uploader($_FILES['image'],'thumb-'.$ImageName,UPLOADPATH.'/'.PEOPLE_FOLDER.'/',PEOPLE_THUMB_X.','.PEOPLE_THUMB_Y,'png');
                uploader($_FILES['image'],'thumb-'.$ImageName,UPLOADPATH.'/'.PEOPLE_FOLDER.'/',PEOPLE_THUMB_X.','.PEOPLE_THUMB_Y,'webp');
            }
            if(isset($_POST['self'])) {
                $self = Input::seo($_POST['self']);
            } else {
                $self = Input::seo($_POST['name']);
            }

            $dataarray          = array(
                "name"              => Input::cleaner($_POST['name']),
                "self"              => $self,
                "biography"         => Input::cleaner($_POST['biography']),
                "department"        => Input::cleaner($_POST['department']),
                "gender"            => Input::cleaner($_POST['gender']),
                "tmdb_id"           => Input::cleaner($_POST['tmdb_id']),
                "imdb_id"           => Input::cleaner($_POST['imdb_id']),
                "image"             => isset($image) ? $image : null,
                "featured"          => (int)Input::cleaner($_POST['featured'],'0'),
                "created"           => date('Y-m-d H:i:s')
            );   
            $this->db->insert('peoples')->set($dataarray); 
            $Notify['type']     = 'success';
            $Notify['text']     = $this->translate('Action completed successfully'); 
            $this->notify($Notify);
            header("location: ".APP.'/admin/peoples');
        }else{ 
            $this->notify($Notify);
        }
        return $this;
    }

    public function update() {
        $Listing        = $this->getVariable("Listing");       
        if (empty($Notify)) {
            if(!empty($_POST['image_url'])) {
                $path_image = UPLOADPATH . '/temp/' . randomcode() . '.jpg';
                downloader($_POST['image_url'], $path_image);
                $_FILES['image'] = $path_image;
            }
            if(isset($_FILES['image']) AND $_FILES['image']['error'] != '4') {

                unlink(UPLOADPATH . '/'.PEOPLE_FOLDER.'/'.$Listing['image']);
                unlink(UPLOADPATH . '/'.PEOPLE_FOLDER.'/thumb-'.$Listing['image']);
                unlink(UPLOADPATH . '/'.PEOPLE_FOLDER.'/'.str_replace('png', 'webp', $Listing['image']));
                unlink(UPLOADPATH . '/'.PEOPLE_FOLDER.'/thumb-'.str_replace('png', 'webp', $Listing['image']));
                
                $ImageName  = randomcode();
                $image      = uploader($_FILES['image'],$ImageName,UPLOADPATH.'/'.PEOPLE_FOLDER.'/',PEOPLE_X.','.PEOPLE_Y,'png');
                uploader($_FILES['image'],$ImageName,UPLOADPATH.'/'.PEOPLE_FOLDER.'/',PEOPLE_X.','.PEOPLE_Y,'webp');
                uploader($_FILES['image'],'thumb-'.$ImageName,UPLOADPATH.'/'.PEOPLE_FOLDER.'/',PEOPLE_THUMB_X.','.PEOPLE_THUMB_Y,'png');
                uploader($_FILES['image'],'thumb-'.$ImageName,UPLOADPATH.'/'.PEOPLE_FOLDER.'/',PEOPLE_THUMB_X.','.PEOPLE_THUMB_Y,'webp');

            } else {
                $image = $Listing['image'];
            }

            if(isset($_POST['self'])) {
                $self = Input::seo($_POST['self']);
            } else {
                $self = Input::seo($_POST['name']);
            }

            $dataarray          = array(
                "name"              => Input::cleaner($_POST['name']),
                "self"              => $self,
                "biography"         => Input::cleaner($_POST['biography']),
                "birthday"          => Input::cleaner($_POST['birthday']),
                "department"        => Input::cleaner($_POST['department']),
                "gender"            => Input::cleaner($_POST['gender']),
                "tmdb_id"           => Input::cleaner($_POST['tmdb_id']),
                "imdb_id"           => Input::cleaner($_POST['imdb_id']),
                "image"             => isset($image) ? $image : null,
                "featured"          => (int)Input::cleaner($_POST['featured'],'0')
            );   
            $this->db->update('peoples')->where('id',$Listing['id'])->set($dataarray);
            $Notify['type']     = 'success';
            $Notify['text']     = $this->translate('Action completed successfully'); 
            $this->notify($Notify);
            header("location: ".APP.'/admin/peoples');
        }else{ 
            $this->notify($Notify);
        } 
        return $this;
    }
}