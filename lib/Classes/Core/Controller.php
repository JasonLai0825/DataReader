<?php
/**
 * Name: Class Controller
 * Purpose:
 * Comment:
 * 
 * Editor: Jason Lai
 * Edit Time: 2018/12/24
 * Update Time: 2018/12/25
 */
class Controller
{
    private $controller;
    private $action;
    private $view;

    /**
     * Constructor of class Controller.
     * According to controller and action to initizlize the correspond view.
     * @param string $controller: controller name which you want to initialize.
     * @param string $action: action name which you want to initialize.
     */
    function __construct($controller, $action){
        $this->controller = $controller;
        $this->action = $action;
        $this->view = new View($controller, $action);
    }

    /**
     * Destructor of class Controller.
     * To render the correspond view.
     */
    function __destruct(){
        $this->view -> render();
    }

    /**
     * To assign the variable's name and value to the correspond view.
     * @param string $name:
     * @param string $value:
     */
    public function assign($name, $value){
        $this->view -> assign($name, $value);
    }
}
?>