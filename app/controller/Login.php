<?php
/**
 * Login Controller
 */
class Login extends Controller
{
    /**
     * Process
     */
    public function process()
    {    
		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");
        $Settings       = $this->getVariable("Settings");

        $Config['title']        = $this->translate('Log In').' – '.get($Settings,'data.title','seo');
        $Config['description']  = get($Settings,'data.description','seo');
        $Config['url']          = APP.'/login';
        $Config['disabled']     = 'on';

        if (isset($AuthUser['id'])) {
            header("Location: ".APP);
            exit;
        }
        if (isset($_POST['_ACTION']) AND Input::cleaner($_POST['_ACTION']) == "login") {
            $this->check();
        } 
        $this->setVariable("Config", $Config);   
        $this->view("login", "app");
    }

    /**
     * check
     * @return void
     */
    private function check()
    {
        $email      = Input::cleaner($_POST['email']);
        $password   = Input::cleaner($_POST['password']); 

        if (empty($email) || empty($password)) {
            $notify['type'] = 'warning';
            $notify['text'] = $this->translate('Fill in the blanks');
        }

        if (empty($notify)) {
            $login          = $this->db->from('users')
            ->where('username',$email)
            ->where('email', $email,'=','OR')
            ->where('password', Input::cryptor($password), '=','AND')
            ->first();    
            if(isset($login['status']) AND $login['status'] == 3) {
                
                $notify['type'] = 'danger';
                $notify['text'] = $this->translate('Your account has been banned for abuse');
                $this->notify($notify);
    
            } elseif (isset($login['email']) AND $login['status'] == 1 AND ($email == $login['email'] || $email == $login['username']) and (Input::cryptor($password) == $login['password'])) {
                $AuthToken      = Input::cryptor($login['email'] . $login['password'] . $login['id']);
                setcookie(AUTH_NAME, $AuthToken, time() + (86400 * 365), "/");

                $this->db->update('users')->where('id', $login['id'], '=')->set(array('token' => $AuthToken));
                header("location: " . APP);
             
            } elseif(isset($login['status']) AND $login['status'] != 1) {
                
                $notify['type'] = 'danger';
                $notify['text'] = $this->translate('Your account has been banned for abuse');
                $this->notify($notify);
    
            } else {
                $notify['type'] = 'danger';
                $notify['text'] = $this->translate('Email or password is incorrect');
                $this->notify($notify);
            }
        } else {
            $this->notify($notify);
        }
        return $this;
    }
}