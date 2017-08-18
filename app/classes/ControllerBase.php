<?php
abstract class ControllerBase {
    protected $registry;
    /**
     * Controller constructor.
     * @access public
     */
    public function __construct($registry) {
        $this->registry = $registry;
        //return new ModelBase($this->registry);
    }

    abstract function index();

    /**
     * Locad model.
     * @access public
     */
    public function model($model) {
        $model = explode('/',$model);
        $modelName='Model'.ucfirst($model[0]);
        return new $modelName($this->registry);
    }

    /**
     * Output view to browser.
     * @access public
     * @ author Moriarti <mor.moriarti@gmail.com>
     */
    public function view($view, array $params = []) {
        $Template = new Templater('views/');
        echo $Template->mkTemplate($view,$params);
        return true;
    }
} // EOF Controller_Base.
