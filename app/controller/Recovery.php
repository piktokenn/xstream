<?php
/**
 * Recovery Controller
 */
class Recovery extends Controller
{
    /**
     * Process
     */
    public function process()
    {    
		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");
        $Settings       = $this->getVariable("Settings");

        $Config['title']        = get($Settings,'data.title','seo');
        $Config['description']  = get($Settings,'data.description','seo');
        $Config['url']          = APP.'/'.$this->translate('reset-password');
        $Config['disabled']     = 'on';

 
        if (isset($Route->params->hash)) {
            $Email      = Input::hasher('decode',$Route->params->hash);
            $Listing    = $this->db->from('users')->where('email',$Email)->first();     
            $this->setVariable("Listing", $Listing);   
            if(empty($Listing['id'])) {
                header("Location: ".APP);
            } elseif(isset($Listing['id'])) {
                if (isset($_POST['_ACTION']) AND Input::cleaner($_POST['_ACTION']) == "recovery") {
                    $this->check();
                } 
            }
        } 


        $this->setVariable("Config", $Config);   
        $this->view("recovery", "app");
    }

    /**
     * check
     * @return void
     */
    private function check()
    {   
        $Notify = null;
        $Listing        = $this->getVariable("Listing");
        $password       = Input::cleaner($_POST['password']); 
        if (empty($password)) {
            $Notify['type'] = 'warning';
            $Notify['text'] = 'Fill in the blanks'; 
        } 

        if (mb_strlen($password) < 5) {
            $Notify['type']     = 'warning';
            $Notify['text']     = 'Password must be at least 5 characters'; 
        }
 

        if (empty($Notify) AND isset($Listing['email'])) {

            $AuthToken      = Input::cryptor($Listing['email'] . $Listing['password'] . $Listing['id']);
            setcookie(AUTH_NAME, $AuthToken, time() + (86400 * 365), "/");

            $this->db->update('users')->where('id', $Listing['id'], '=')->set(array('password' => Input::cryptor($password),'token' => $AuthToken));
            header("location: " . APP);
        } else {
            $this->notify($Notify);
        }
        return $this;
    }
}