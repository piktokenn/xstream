<?php
/**
 * Register Controller
 */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class Register extends Controller
{
    /**
     * Process
     */
    public function process()
    {    
		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");
        $Settings       = $this->getVariable("Settings");

        $Config['title']        = $this->translate('Sign up').' – '.get($Settings,'data.title','seo');
        $Config['description']  = get($Settings,'data.description','seo');
        $Config['url']          = APP.'/register';
        $Config['disabled']     = 'on';

        if ($AuthUser) {
            header("Location: ".APP);
            exit;
        }
        if (isset($_POST['_ACTION']) AND Input::cleaner($_POST['_ACTION']) == "register") {
            $this->check();
        }  
        $this->setVariable("Config", $Config);   
        $this->view("register", "app");
    }

    /**
     * check
     * @return void
     */
    private function check()
    {
        require PATH . '/config/array.config.php'; 
        $email          = Input::cleaner($_POST['email']);
        $password       = Input::cleaner($_POST['password']);
        $firstname      = Input::cleaner($_POST['firstname']);
        $lastname       = Input::cleaner($_POST['lastname']); 
        $username       = Input::cleaner($_POST['username']); 
        if (!$email || !$password || !$firstname || !$lastname || !$username) {
            $Notify['type'] = 'warning';
            $Notify['text'] = 'Fill in the blanks'; 
        } 
        if(in_array($username, $blacklist)) {
            $Notify['type'] = 'warning';
            $Notify['text'] = 'You cannot use the username'; 
        }
        if (empty($Notify)) {
            $emailCheck         = $this->db->from('users')->where('email',$email,'=','AND')->first();
            $usernameCheck      = $this->db->from('users')->where('username',$username,'=','AND')->first();
            if (isset($emailCheck['email']) AND $email == $emailCheck['email']) {
                $Notify['type']     = 'warning';
                $Notify['text']     = 'Email already registered';
            }
            if (isset($usernameCheck['username']) AND $username == $usernameCheck['username']) {
                $Notify['type']     = 'warning';
                $Notify['text']     = 'Username already taken';
            }
            if (mb_strlen($password) < 5) {
                $Notify['type']     = 'warning';
                $Notify['text']     = 'Password must be at least 5 characters'; 
            }
            if (mb_strlen($firstname) < 3) {
                $Notify['type']     = 'warning';
                $Notify['text']     = 'Your Firstname must be at least 3 characters'; 
            }
            if (mb_strlen($lastname) < 3) {
                $Notify['type']     = 'warning';
                $Notify['text']     = 'Your Lastname must be at least 3 characters'; 
            }
            
            if (empty($Notify)) {
                $AuthToken      = Input::cryptor($_POST['email'] . $_POST['password'] . rand(0,10));
                $dataarray        = array(
                    "account_type"      => 'user',
                    "firstname"         => Input::cleaner($_POST['firstname']),
                    "lastname"          => Input::cleaner($_POST['lastname']), 
                    "email"             => Input::cleaner($_POST['email']),
                    "username"          => Input::seo($_POST['username']),
                    "password"          => Input::cryptor($password),
                    "color"             => getRandomColor(),
                    "token"             => $AuthToken,
                    "status"            => 1,
                    "created"           => date("Y-m-d H:i:s")
                );
                $this->db->insert('users')->set($dataarray); 
                setcookie(AUTH_NAME, $AuthToken, time() + (86400 * 365), "/");
                
                header('location:'.APP);
            }else{
                $this->notify($Notify);
            }
        } else {
            $this->notify($Notify);
        }
        return $this;
    }
}