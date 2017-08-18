<?php

class ModelAuth extends ModelBase {

    private $input;

    public function __construct($registry) {
        parent::__construct(); // Must be here if you want using parents class.
        $this->input=$registry['Input']['r'];
    }

    public function getData() {
        return $this->login();
    }

    public function checkAuth(){
            if(array_key_exists('email',$_SESSION)) {

            }else{
                $this->login();
            }
    }

    public function login() {
        try {
            $auth=$this->db->query($this->logQuery("SELECT `id`,`email` FROM `users` WHERE `email`=''".$this->input['login']."'' AND `passowrd`=".sha1($this->input['password'])." AND `status`='active' LIMIT 1;"))->fetch(PDO::FETCH_ASSOC);
            if(array_key_exists('email',$auth)){
                session_start();
                $_SESSION['email']=$auth['email'];
                return true;
            }else{
                return false;
            }
        } catch(PDOException $e) {
            echo $this->logPDOException($e);
            return false;
        }
    }

    public function register() {

    }

    public function restorePassword() {

    }
}
