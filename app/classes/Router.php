<?php
/**
 * Router for load controllers.
 * @author Moriarti <mor.moriarti@gmail.com>
 */
class Router {
    private $registry;
    private $path;
    private $args = array();
    public $type;
    public $lang;
    private $controller;

    public function __construct($registry) {
        $this->registry = $registry;
        $this->registry->set('router',$this);
        // Analaize path.
        $this->getController($controller, $action);
        // Active class.
        $class = 'Controller' . ucfirst($controller);
        $controller = new $class($this->registry);
        // Check callable.
        if (!is_callable(array($controller, $action))) { die ('404 Not Found. Not callable method.'); }
        // Run controller.
        $controller->$action();
        //$controller = new ControllerBase($this->registry);
    }

    private function setPath($path) {
        if (!is_dir($path)) { throw new Exception ('Invalid controller path: `' . $path . '`'); }
        $this->path = $path;
    }

    private function getController(&$controller, &$action) {
        $route = (empty($_GET['route'])) ? '' : $_GET['route'];
        if (empty($route)) { $route = 'auth/login'; }
        // Get exploded chunk.
        $route = trim($route, "/\\");
        $parts = explode('/', $route);
        // Get module controller.
        $this->controller = $controller = array_shift($parts);
        // Get work action.
        $action = $this->action = array_shift($parts);
        if (empty($action)) { $action ='index'; }
        $this->args = $parts;
    }
} // EOF class Router.
