<?php
/**
 * User Controller
 */
class User extends Controller
{
    /**
     * Process
     */
    public function process()
    {    

		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");
 
        // Config
        $Config['btn']      = 'user';
        $Config['nav']      = 'users';
        $Config['search']   = true;
        $Config['page']     = $this->translate('Users');

        if (isset($Route->params->id)) {
            $Listing            = $this->db->from('users')->where('id',$Route->params->id,'=')->first();
        }

        $this->setVariable('Listing',isset($Listing) ? $Listing : null); 
        $this->setVariable('Config', $Config);  

        if(Input::cleaner((isset($_POST['_ACTION']) ? $_POST['_ACTION'] : null)) == 'save' AND empty($Listing['id'])) {
            $this->save();
        } elseif(Input::cleaner((isset($_POST['_ACTION']) ? $_POST['_ACTION'] : null)) == 'save' AND isset($Listing['id'])) {
            $this->update();
        }

        $this->view("user", "admin");
    }

    public function save() { 
        
        if(isset($_POST['email'])) {
            $EmailCheck      = $this->db->from('users')->where('email',Input::cleaner($_POST['email']),'=','AND')->first();
            if (isset($EmailCheck['email'])) {
                $Notify['type']     = 'warning';
                $Notify['text']     = 'Email already registered !';
                $this->notify($Notify);
            }
        }

        if(isset($_POST['username'])) {
            $UsernameCheck      = $this->db->from('users')->where('username',Input::cleaner($_POST['username']),'=','AND')->first();
            if (isset($UsernameCheck['username'])) {
                $Notify['type']     = 'warning';
                $Notify['text']     = 'Username already registered !';
                $this->notify($Notify);
            }
        }  
    

        if (empty($Notify)) {   
            if(isset($_FILES['image']) AND $_FILES['image']['error'] != '4') {

                
                $ImageName  = randomcode();
                $image      = uploader($_FILES['image'],$ImageName,UPLOADPATH.'/'.AVATAR_FOLDER.'/',AVATAR_X.','.AVATAR_Y,'png');
                uploader($_FILES['image'],$ImageName,UPLOADPATH.'/'.AVATAR_FOLDER.'/',AVATAR_X.','.AVATAR_Y,'webp');
                uploader($_FILES['image'],'thumb-'.$ImageName,UPLOADPATH.'/'.AVATAR_FOLDER.'/',AVATAR_THUMB_X.','.AVATAR_THUMB_Y,'png');
                uploader($_FILES['image'],'thumb-'.$ImageName,UPLOADPATH.'/'.AVATAR_FOLDER.'/',AVATAR_THUMB_X.','.AVATAR_THUMB_Y,'webp');

            }


            if(Input::cleaner($_POST['password']) AND Input::cleaner($_POST['newpassword'])) {
                $Password = Input::cryptor($_POST['password']);
            }else{
                $Password = $Listing['password'];
            }

            $dataarray          = array(
                "firstname"     => Input::cleaner($_POST['firstname']), 
                "lastname"      => Input::cleaner($_POST['lastname']), 
                "username"      => Input::cleaner($_POST['username']), 
                "email"         => Input::cleaner($_POST['email']), 
                "password"      => $Password, 
                "avatar"        => $image,
                "gender"        => Input::cleaner($_POST['gender']), 
                "account_type"  => Input::cleaner($_POST['account_type']), 
                "about"         => Input::cleaner($_POST['about']), 
                "status"        => Input::cleaner($_POST['status'],1), 
            );   
            $this->db->insert('users')->set($dataarray); 

            $Notify['type']     = 'success';
            $Notify['text']     = 'Action completed successfully'; 
            $this->notify($Notify);
            header("location: ".APP.'/admin/categories');
        }else{ 
            $this->notify($Notify);
        }
        return $this;
    }

    public function update() {
        $Listing        = $this->getVariable("Listing");       
        if(isset($_POST['email']) AND $Listing['email'] != Input::cleaner($_POST['email'])) {
            $EmailCheck      = $this->db->from('users')->where('email',Input::cleaner($_POST['email']),'=','AND')->first();
            if ($EmailCheck['email']) {
                $Notify['type']     = 'warning';
                $Notify['text']     = 'Email already registered !';
                $this->notify($Notify);
            }
        }

        if(isset($_POST['username']) AND $Listing['username'] != Input::cleaner($_POST['username'])) {
            $UsernameCheck      = $this->db->from('users')->where('username',Input::cleaner($_POST['username']),'=','AND')->first();
            if ($UsernameCheck['username']) {
                $Notify['type']     = 'warning';
                $Notify['text']     = 'Username already registered !';
                $this->notify($Notify);
            }
        } 

        if (empty($Notify)) {   

            
            if(isset($_FILES['image']) AND $_FILES['image']['error'] != '4') {

                unlink(UPLOADPATH . '/'.AVATAR_FOLDER.'/'.$Listing['avatar']);
                unlink(UPLOADPATH . '/'.AVATAR_FOLDER.'/thumb-'.$Listing['avatar']);
                unlink(UPLOADPATH . '/'.AVATAR_FOLDER.'/'.str_replace('png', 'webp', $Listing['avatar']));
                unlink(UPLOADPATH . '/'.AVATAR_FOLDER.'/thumb-'.str_replace('png', 'webp', $Listing['avatar']));
                
                $ImageName  = randomcode();
                $image      = uploader($_FILES['image'],$ImageName,UPLOADPATH.'/'.AVATAR_FOLDER.'/',AVATAR_X.','.AVATAR_Y,'png');
                uploader($_FILES['image'],$ImageName,UPLOADPATH.'/'.AVATAR_FOLDER.'/',AVATAR_X.','.AVATAR_Y,'webp');
                uploader($_FILES['image'],'thumb-'.$ImageName,UPLOADPATH.'/'.AVATAR_FOLDER.'/',AVATAR_THUMB_X.','.AVATAR_THUMB_Y,'png');
                uploader($_FILES['image'],'thumb-'.$ImageName,UPLOADPATH.'/'.AVATAR_FOLDER.'/',AVATAR_THUMB_X.','.AVATAR_THUMB_Y,'webp');

            } else {
                $image = $Listing['avatar'];
            }

            foreach ($_POST['data'] as $key => $value) {
                if ($value) {
                    $SettingsData['data'][$key] = $value;
                }
            }

            if(Input::cleaner($_POST['password']) AND Input::cleaner($_POST['newpassword'])) {
                $Password = Input::cryptor($_POST['password']);
            }else{
                $Password = $Listing['password'];
            }

            $dataarray          = array(
                "account_type"  => Input::cleaner($_POST['account_type']), 
                "firstname"     => Input::cleaner($_POST['firstname']), 
                "lastname"      => Input::cleaner($_POST['lastname']), 
                "username"      => Input::cleaner($_POST['username']), 
                "email"         => Input::cleaner($_POST['email']), 
                "password"      => $Password, 
                "avatar"        => $image,
                "gender"        => Input::cleaner($_POST['gender']), 
                "about"         => Input::cleaner($_POST['about']), 
                "status"        => Input::cleaner($_POST['status'],1), 
            );   
            $this->db->update('users')->where('id',$Listing['id'])->set($dataarray); 
 
            $Notify['type']     = 'success';
            $Notify['text']     = $this->translate('Action completed successfully'); 
            $this->notify($Notify);
            header("location: ".APP.'/admin/user/'.$Listing['id']);
        }else{ 
            $this->notify($Notify);
        } 
        return $this;
    }
}