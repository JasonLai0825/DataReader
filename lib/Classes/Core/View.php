<?php
/**
 * Name: Class View
 * Purpose: To render correspond view automatically.
 * Comment:
 * 
 * Editor: Jason Lai
 * Edit Time: 2019/01/04
 * Update Time: 2019/01/04
 */
class View
{
    protected $variables = array();
    protected $controller;
    protected $action;

    function __construct($controller, $action){
        $this->controller = $controller;
        $this->action = $action;
    }

    /**
     * Assign key-pair values into variables.
     * @param string $name: variable name.
     * @param string $value: variable value.
     */
    public function assign($name, $value){
        $this->variables[$name] = $value;
    }

    /**
     * To render this current page.
     */
    public function render(){
        extract($this->variables);
        $default_header = FRAME_PATH . 'Views/header.html';
        $default_footer = FRAME_PATH . 'Views/footer.html';

        include($default_header);
        include(FRAME_PATH . 'Views/' . $this->action . '.html');
        include($default_footer);
    }
}
?>