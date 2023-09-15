<?php
/**
 * Reset Controller
 */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class Reset extends Controller
{
    /**
     * Process
     */
    public function process()
    {    
		$AuthUser		= $this->getVariable("AuthUser");
		$Route			= $this->getVariable("Route");
        $Settings       = $this->getVariable("Settings");

        $Config['title']        = $this->translate('Reset password').' – '.get($Settings,'data.title','seo');
        $Config['description']  = get($Settings,'data.description','seo');
        $Config['url']          = APP.'/'.$this->translate('reset-password');
        $Config['disabled']     = 'on';


        if (isset($AuthUser['id'])) {
            header("Location: ".APP);
            exit;
        }
        if (isset($_POST['_ACTION']) AND Input::cleaner($_POST['_ACTION']) == "reset") {
            $this->check();
        } 
        $this->setVariable("Config", $Config);   
        $this->view("reset", "app");
    }

    /**
     * check
     * @return void
     */
    private function check()
    { 
        $Settings       = $this->getVariable("Settings");

        if (empty($_POST['email'])) {
            $Notify['type'] = 'warning';
            $Notify['text'] = 'Fill in the blanks';
        }

        if (empty($Notify)) {
            $Listing    = $this->db->from('users')->where('email', Input::cleaner($_POST['email']))->first();    

            if(isset($Listing['status']) AND $Listing['status'] == 3) {
                
                $notify['type'] = 'danger';
                $notify['text'] = 'Your account has been banned for abuse';
                $this->notify($Notify);
    
            } elseif (isset($Listing['email']) AND $Listing['status'] == 1 AND Input::cleaner($_POST['email']) == $Listing['email']) {
                // Send confirm mail
                $mail = new PHPMailer;
                $mail->IsSMTP();
                $mail->SMTPDebug    = 0; 
                $mail->SMTPAuth     = true;
                $mail->SMTPSecure   = get($Settings,'data.security','email');
                $mail->CharSet      = 'utf-8';
                $mail->Port         = get($Settings,'data.port','email');
                $mail->Host         = get($Settings,'data.host','email');
                $mail->Username     = get($Settings,'data.username','email');
                $mail->Password     = get($Settings,'data.password','email');
                $mail->From         = get($Settings,'data.username','email');
                $mail->FromName     = get($Settings,'data.company','general');
                $mail->IsHTML(true);
                $mail->WordWrap     = 50;
                $mail->AddAddress($_POST['email']);
                $mail->Subject      = $this->translate('Reset password');
                $template   = file_get_contents(APP."/public/email/email-template.inc.php");
                $html       = str_replace(["{{site_name}}","{{email_content}}","{{foot_note}}"], 
                                [
                                    'COMPANY',
                                    $this->translate('Reset password'),
                                    $this->translate('Click the link below to reset your password').'
                                    <a href="'.APP.'/recovery/'.Input::hasher('encode',$_POST['email']).'?_TOKEN='.Input::cryptor($Listing['id']).'" style="font-size: 16px; line-height: 22px;  color: #fff;background-color: '.get($Settings,'data.color','customize').';border-radius: 1000px;padding: 16px 40px;display: inline-block;text-decoration: none;margin-top:15px;">'.$this->translate('Reset password').'</a>'
                                ], 
                                $template
                );
                $mail->Body = $html;
                $mail->send();   
                header("location: " . APP.'/'.$this->translate('login'));
             
            } elseif(isset($Listing['status']) AND $Listing['status'] != 1) {
                
                $Notify['type'] = 'danger';
                $Notify['text'] = 'Your account has been banned for abuse';
                $this->notify($Notify);
    
            } else {
                $Notify['type'] = 'danger';
                $Notify['text'] = 'Email or password is incorrect';
                $this->notify($Notify);
            }
        } else {
            $this->notify($Notify);
        }
        return $this;
    }
}