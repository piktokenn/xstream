<?php
/**
 * Settings Controller
 */
class Settings extends Controller
{
    /**
     * Process
     */
    public function process()
    {    
		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");
        $Settings       = $this->getVariable("Settings");

        $Config['title']        = $this->translate('Settings');
        $Config['description']  = get($Settings,'data.description','seo'); 
        $Config['url']          = APP.'/404';
        $Config['disabled']     = 'on';

        if(isset($_POST['_ACTION']) AND $_POST['_ACTION'] == 'save' AND isset($AuthUser['id'])) {
            $this->update();
        }
        $this->setVariable("Config", $Config);   
        $this->view("settings", "dashboard");
    }

    public function update() {
        require PATH . '/config/array.config.php'; 
        $AuthUser        = $this->getVariable("AuthUser");       
        if(isset($_POST['email']) AND $AuthUser['email'] != Input::cleaner($_POST['email'])) {
            $EmailCheck      = $this->db->from('users')->where('email',Input::cleaner($_POST['email']),'=','AND')->first();
            if (isset($EmailCheck['email'])) {
                $Notify['type']     = 'warning';
                $Notify['text']     = 'Email already registered !';
                $this->notify($Notify);
            }
        }
        if(in_array(Input::cleaner($_POST['username']), $blacklist) AND $AuthUser['username'] != Input::cleaner($_POST['username'])) {
            $Notify['type'] = 'warning';
            $Notify['text'] = 'You cannot use the username'; 
            $this->notify($Notify);
        }

        if(isset($_POST['username']) AND $AuthUser['username'] != Input::cleaner($_POST['username'])) {
            $UsernameCheck      = $this->db->from('users')->where('username',Input::cleaner($_POST['username']),'=','AND')->first();
            if (isset($UsernameCheck['username'])) {
                $Notify['type']     = 'warning';
                $Notify['text']     = 'Username already registered !';
                $this->notify($Notify);
            }
        } 

        if (empty($Notify)) {   

            
            if(!empty($_FILES['image'])) {

                unlink(UPLOADPATH . '/'.AVATAR_FOLDER.'/'.$AuthUser['avatar']);
                unlink(UPLOADPATH . '/'.AVATAR_FOLDER.'/thumb-'.$AuthUser['avatar']);
                unlink(UPLOADPATH . '/'.AVATAR_FOLDER.'/'.str_replace('png', 'webp', $AuthUser['avatar']));
                unlink(UPLOADPATH . '/'.AVATAR_FOLDER.'/thumb-'.str_replace('png', 'webp', $AuthUser['avatar']));
                
                $ImageName  = randomcode();
                $image      = uploader($_FILES['image'],$ImageName,UPLOADPATH.'/'.AVATAR_FOLDER.'/',AVATAR_X.','.AVATAR_Y,'png');
                uploader($_FILES['image'],$ImageName,UPLOADPATH.'/'.AVATAR_FOLDER.'/',AVATAR_X.','.AVATAR_Y,'webp');
                uploader($_FILES['image'],'thumb-'.$ImageName,UPLOADPATH.'/'.AVATAR_FOLDER.'/',AVATAR_THUMB_X.','.AVATAR_THUMB_Y,'png');
                uploader($_FILES['image'],'thumb-'.$ImageName,UPLOADPATH.'/'.AVATAR_FOLDER.'/',AVATAR_THUMB_X.','.AVATAR_THUMB_Y,'webp');

            } else {
                $image = $AuthUser['avatar'];
            }
 

            if(isset($_POST['newpassword']) AND mb_strlen(Input::cleaner($_POST['newpassword'])) > 4) {
                $Password = Input::cryptor($_POST['newpassword']);
            }else{
                $Password = $AuthUser['password'];
            }

            $dataarray          = array( 
                "firstname"     => Input::cleaner($_POST['firstname']), 
                "lastname"      => Input::cleaner($_POST['lastname']), 
                "username"      => Input::cleaner($_POST['username']), 
                "email"         => Input::cleaner($_POST['email']), 
                "password"      => $Password, 
                "avatar"        => Input::cleaner($image),
                "gender"        => Input::cleaner($_POST['gender']), 
                "about"         => Input::cleaner($_POST['about'])
            );   
            $this->db->update('users')->where('id',$AuthUser['id'])->set($dataarray); 
 
            $Notify['type']     = 'success';
            $Notify['text']     = $this->translate('Action completed successfully'); 
            $this->notify($Notify);
            header("location: ".APP.'/dashboard/settings');
        }else{ 
            $this->notify($Notify);
        } 
        return $this;
    }
}