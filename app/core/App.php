<?php 
/**
 * Main app
 */
use Cache\Cache;
use Cache\Psr16\Cache as Psr16Cache;
class App
{
    protected $router;
    protected $controller;
    protected $plugins; 
    protected static $routes = [];
    public static $lang_array = [];


    /**
     * summary
     */
    public function __construct($lang_array = array())
    {
        $this->controller = new Controller;

    }

    /**
     * Get the translate file.
     *
     * @param  string|int $key
     * @return string|false
     */
    public static function translate($key)
    {
        
        if(isset(self::$lang_array[$key])) {
            return Input::cleaner(self::$lang_array[$key]);
        } else {
            return Input::cleaner($key);
        } 
    }

    /**
     * Adds a new route to the App:$routes static variable
     * App::$routes will be mapped on a route 
     * initializes on App initializes
     * 
     * Format: ["METHOD", "/uri/", "Controller"]
     * Example: App:addRoute("GET|POST", "/post/?", "Post");
     */
    public static function addRoute()
    {
        $route = func_get_args();
        if ($route) {
            self::$routes[] = $route;
        }
    }


    /**
     * Get App::$routes
     * @return array An array of the added routes
     */
    public static function getRoutes()
    {
        return self::$routes;
    }



    /**
     * Check and get authorized user data
     * Define $AuthUser variable
     */
    public function auth() {   
        $AuthUser = null;
        if(isset($_COOKIE[AUTH_NAME])) {
            $db         = new Database();
            $AuthUser   = $db->from("users")->where('token',$_COOKIE[AUTH_NAME],'=','AND')->where('status',1)->first();
        }
        return $AuthUser;
    } 





    /**
     * Analize route and load proper controller
     * @return App
     */
    private function route()
    {
        // Initialize the router
        $router = new Router();
        $router->setBasePath(BASEPATH);

        // Load plugin/theme routes first
        // TODO: Update router.map in modules to App::addRoute();
        $GLOBALS["_ROUTER_"] = $router;
        \Event::trigger("router.map", "_ROUTER_");
        $router = $GLOBALS["_ROUTER_"];


        // Load global routes
        include PATH."/config/routes.config.php";
        
        // Map the routes
        $router->addRoutes(App::getRoutes());

        // Match the route
        $route = $router->match();
        $route = json_decode(json_encode($route));

        if ($route) {

            $Disallow = array(
                'login',
                'comments',
                'search',
                'filter'
            );
            if(ENVIRONMENT == 'demo')  {
                if($route->target[1] == 'Delete' OR (isset($_POST['_ACTION']) AND !in_array($_POST['_ACTION'], $Disallow))) {

                    $Notify['type']     = 'warning';
                    $Notify['text']     = 'Demo Mode: Disabled Action'; 
                    $this->notify($Notify);
                    header("location:".$_SERVER['HTTP_REFERER']);
                    exit();
                    
                }
            }

            if (is_array($route->target)) {
                require_once PATH.'/controller/'.$route->target[0].'/'.$route->target[1].'.php';
                $controller = $route->target[1];

            } elseif(isset($route->target)) {
                $controller = $route->target;
            }
        } else {
            header("HTTP/1.0 404 Not Found");
            $controller = "Noting";
        }

        $this->controller = new $controller;
        $this->controller->setVariable("Route", $route);
        $this->controller->setVariable("CacheFile", $controller);
    }




    /**
     * Process
     */
    public function process()
    {  
        ob_start();

        // Initialize the router
        $router = new Router();
        $router->setBasePath(BASEPATH);

        // Load global routes
        include PATH."/config/routes.config.php";
        // Map the routes
        $router->addRoutes(App::getRoutes());

        // Match the route
        $route = $router->match();
        $route = json_decode(json_encode($route));
        $Allowed = array(
            'Main',
            'Movie',
            'Episode',
            'Serie'
        );

        if ($route) {
            if (is_array($route->target)) { 
                $CacheFile = $route->target[1];
            } elseif(isset($route->target)) {
                $CacheFile = $route->target;
            }
        } else {
            $CacheFile = 'Noting';
        }
        $CacheName = md5($_SERVER['REQUEST_URI']); 
        

        $cache  = new Cache(PATH.'/cache/'); 
 


        $db             = new Database(); 
        $Settings       = $db->from("settings")->all();

        // Check Language
        if (isset($route->target) AND is_array($route->target)) {
            define('ACTIVE_LANG', get($Settings,'data.dashboard_language','general')); 
        } elseif(isset($route->target)) {
            define('ACTIVE_LANG', get($Settings,'data.language','general')); 
        } else {
            define('ACTIVE_LANG', get($Settings,'data.language','general')); 
        }

        // Language
        if(file_exists(PATH.'/lang/'.ACTIVE_LANG.'.php')) {
            include PATH.'/lang/'.ACTIVE_LANG.'.php';
            self::$lang_array = $Lang;
        } else {
            include PATH.'/lang/en.php';
            self::$lang_array = $Lang;
        }
 

        $AuthUser = $this->auth(); 
        if (empty($AuthUser['id']) AND $cache->has($CacheName) AND in_array($CacheFile, $Allowed)) { 
            $data = $cache->get($CacheName);
            echo $data;

        } else {
            $this->route(); 
            
            $Ads            = $db->from("ads")->where('status',1)->all();

            $this->controller->setVariable("AuthUser", isset($AuthUser) ? $AuthUser : null) 
                             ->setVariable("Token", Csrf::token())
                             ->setVariable("isValid", Csrf::all())
                             ->setVariable("Settings", isset($Settings) ? $Settings : null) 
                             ->setVariable("Ads", isset($Ads) ? $Ads : null) 
                             ->setVariable("Notify", Controller::notify()); 

            $this->controller->process();

            if(empty($AuthUser['id']) AND CACHE == true AND in_array($CacheFile, $Allowed)) {
                $data = ob_get_contents();
                $cache->set($CacheName, $data);
            }
        }
 
    }
    
    public static function notify($data = array()) {
        if(count($data)>1) { 
            $_SESSION['notify']['display']      = 'hidden';
            $_SESSION['notify']['text']         = $data['text'];
            $_SESSION['notify']['type']         = $data['type'];
        }
    }
    public function __destruct() { 
        if((isset($_SESSION['notify']['display']) AND $_SESSION['notify']['display'] == 'visible') AND isset($_SESSION['notify']['text'])) {
          
            unset($_SESSION['notify']);
        }elseif((isset($_SESSION['notify']['display']) AND $_SESSION['notify']['display'] == 'hidden') AND isset($_SESSION['notify']['text'])) {
            $_SESSION['notify']['display'] = true;
        }  
    }
}