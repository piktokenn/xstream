<?php 
use EasySlugger\Slugger;
use EasySlugger\Utf8Slugger;
class Input
{

    public function __construct(){
    }
 
        
    public static function cleaner($data = null, $return = null)
    {   
        if(!empty($data)) {
            $data = strip_tags($data);
            $get_data = $data;
            // Fix &entity\n;
            $data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
            $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
            $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
            $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');
     
            $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);
     
            $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
            $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
            $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);
     
            $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
            $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
            $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);
     
            $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);
            do
            {
                $old_data = $data;
                $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
                
            }
            while ($old_data !== $data); 
        }
        // we are done...
        if (!empty($data)) {
            return htmlspecialchars($data);
        } elseif ($return || $return == '0') {
            return $return;
        } else {
            return null;
        } 
    }
    public static function seo($string = ""){
        if (!is_string($string)) {
            $string = "";
        } 
        return trim(Utf8Slugger::slugify($string));
    }


    public static function cryptor($password = null)
    {
        return md5(sha1(md5(sha1($password))));
    }

    public static function hasher($action, $string = null) {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key     = KEY.'-';
        $secret_iv      = KEY.'-546128';
        $key            = hash('sha256', $secret_key);

        $iv = substr(hash('sha256', $secret_iv) , 0, 16);
        if ($action == 'encode') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        }
        else if ($action == 'decode') {
            $output = openssl_decrypt(base64_decode($string) , $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }

}