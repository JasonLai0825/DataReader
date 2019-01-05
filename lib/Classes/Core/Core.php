<?php
/**
 * Name: DataSolver core class.
 * Purpose: to define a core class which controls how DataSolver MVC framework works.
 * Comment:
 * 
 * Editor: Jason Lai
 * Edit Time: 2018/12/23
 * Update Time: 2018/12/23
 */
class core
{
    // default settings
    private $controllerName = 'Index';
    private $actionName = 'index';
    private $queryString = array();

    /**
     * Execute core MVC settings of DAtaSolver project.
     */
    function run(){
        spl_autoload_register(array($this, 'loadClass'));
        $this -> setREporting();
        $this -> unregisterGlobals();
        $this -> Route();
    }

    /**
     * Set route settings of DataSolver MVC project.
     */
    function Route(){
        if(!empty($_GET['url'])){
            $url = $_GET['url'];
            $urlArr = explode('/', $url);

            // obtain controller name
            $this->controllerName = ucfirst($urlArr[0]);

            // obtain action name
            array_shift($urlArr);
            $this->actionName = empty($urlArr[0]) ? $this->actionName : $urlArr[0];

            // obtain url parameters
            array_shift($urlArr);
            $this->queryString = empty($urlArr) ? array() : $urlArr;
        }

        $controller = $this->controllerName . 'Controller';
        $dispatch = new $controller($this->controllerName, $this->actionName);

        // execite function when both controller and action exist
        if((int)method_exists($controller, $this->actionName)){
            call_user_func_array(array($dispatch, $this->actionName), $this->queryString);
        }else{
            exit($controller . ' not found.');
        }
    }

    /**
     * Depends on the application mode to set error report settings.
     */
    function setReporting(){
        error_reporting(E_ALL);
        if(APP_DEBUG === true){
            ini_set('display_errors', 'On');
        }else{
            ini_set('display_errors', 'Off');
            ini_set('log_errors', 'On');
            ini_set('error_log', RUNTIME_PATH . 'error.log');
        }
    }

    /**
     * Unset all of global variables.
     */
    function unregisterGlobals(){
        if(ini_get('register_globals')){
            $globals = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
            foreach($globals as $var){
                foreach($GLOBALS[$var] as $key => $value){
                    if($value === $GLOBALS[$key]){
                        unset($GLOBALS[$key]);
                    }
                }
            }
        }
    }

    /**
     * Autoload controllers and models.
     * @param string $className: class name.
     */
    static function loadClass($className){
        $coreClass = FRAME_PATH . "Classes/Core/$className.php";
        $class = FRAME_PATH . "Classes/$className.php";
        $controller = FRAME_PATH . "Controllers/$className.php";
        $model = FRAME_PATH . "Models/$className.php";
        if(file_exists($coreClass)){
            include_once $coreClass;
        }else if(file_exists($class)){
            include_once $class;
        }else if(file_exists($controller)){
            include_once $controller;
        }else if(file_exists($model)){
            include_once $model;
        }else {
            var_dump("File $className not found.");
        }
    }
}
?>