<?php

class ControllerAuth extends ControllerBase {

    private $authModel;
    protected $registry;

    public function __construct($registry) {
        // Constructor.
        parent::__construct();
        $this->registry = $registry;
        $this->authModel = new ModelAuth($this->registry);
    }

    public function index() {
        return $this->login();
    }

    public function login() {
        $this->view('authLogin');
    }

    public function checkAuth() {
        $this->authModel->checkAuth();
    }

    public function register() {

    }

    public function restorePassword() {

    }
}
