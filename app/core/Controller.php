<?php
/**
 * Controller
 */
class Controller
{   
    protected $variables;
    protected $resp; 

    /**
     * Initialize variables
     * @param array $variables  [description]
     */
    public function __construct($variables = array())
    {
        $this->variables    = array();
        $this->resp         = new stdClass;
        $this->db           = new Database();
    }



    /**
     * View
     * @param  string $view name of view file
     * @param  string $context 
     * @return void       
     */
    public function view($view, $context = "app")
    {
        foreach ($this->variables as $key => $value) {
            ${$key} = $value;
        }

        switch ($context) {
            case "admin":
                if (isset($AuthUser['id']) AND $AuthUser['id'] and $AuthUser['account_type'] == 'admin') {
                    $path = PATH."/view/".$view.".php";
                }else{
                    header('location:'.APP);
                }
                break;
                
            case "dashboard":
                if (isset($AuthUser['id'])) {
                    $path = PATH."/theme/view/dashboard/".$view.".php";
                }else{
                    header('location:'.APP);
                }
                break;

            case "app":
                $path = PATH."/theme/view/".$view.".php";
                break;

            default: 
                $path = $view;
        }


        require_once $path;
    }


    /**
     * Set new variable for view.
     * @param string $name  Name of the variable.
     * @param mixed $value 
     */
    public function setVariable($name, $value)
    {
        $this->variables[$name] = $value;
        return $this;
    }


    /**
     * Get variable
     * @param  string $name Name of the varaible.
     * @return mixed       
     */
    public function getVariable($name)
    {
        return isset($this->variables[$name]) ? $this->variables[$name] : null;
    }
    
    /**
     * Get the translate file.
     *
     * @param  string|int $key
     * @return string|false
     */
    public function translate($key)
    {
        if(isset(App::$lang_array[$key])) {
            return Input::cleaner(App::$lang_array[$key]);
        } else {
            return Input::cleaner($key);
        } 
    }
    
    public static function notify($data = array()) {
        if(count($data)>1) { 
            $_SESSION['notify']['display']      = 'hidden';
            $_SESSION['notify']['text']         = $data['text'];
            $_SESSION['notify']['type']         = $data['type'];
        }
    }
 
}
