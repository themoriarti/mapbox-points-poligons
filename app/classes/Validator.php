<?php
/**
 * Validator class
 */

class Validator {

    private $_errors_array = array();
    private $_validation_rules = array();
    private $_validation_variable = array();

    public function __construct() {}

    public function setRules($validation_array) {
        if(is_array($validation_array) and count($validation_array) > 0) {
            $this->_validation_rules = $validation_array;
        } else {
            return true;
        }
    }

    public function validate() {
        if(is_array($this->_validation_rules) and count($this->_validation_rules) > 0) {
            foreach ($this->_validation_rules as $key => $value) {
                if(count($value) == 2) {
                    if(!is_int($key)) {
                        if(!is_array($value[0])) {
                            if(isset($value[1]) and is_array($value[1])) {
                                foreach ($value[1] as $rule_key => $rule_value) {
                                    if(is_array($rule_value)) {
                                        $validator_name = $rule_key."Validator";
                                        $validator_param = $rule_value;
                                    } else {
                                        $validator_name = $rule_value."Validator";
                                        $validator_param = array();
                                    }
                                    if(is_callable(array(get_class($this),$validator_name))) {
                                        call_user_func_array(array(get_class($this),$validator_name), array($value[0],$key,$validator_param));
                                    } else {
                                        throw new Exception("Validation rule name '".$validator_name."' is not defined");
                                    }
                                }

                            } else {
                                throw new Exception("Validation rules must define in array");
                            }
                        } else {
                            throw new Exception("Validation first param must be not array");
                        }
                    } else {
                        throw new Exception("Array key of validation rules must be stings ");
                    }
                } else {
                    throw new Exception("Validation array must have 2 params");

                }
            }
            if(count($this->_errors_array) != 0) {
                return false;
            }
        }
        return true;
    }

    public function getErrors() {
        return $this->_errors_array;
    }

    public function getError($variable_name) {
        if(isset($variable_name[$variable_name])) {
            return $this->_errors_array;
        } else {
            throw new Exception("Variable name ".$variable_name." not found");
        }
    }

    public function getValues() {
        return $this->_validation_variable;
    }

    public function getValue($value_name) {
        if(isset($this->_validation_variable[$value_name])) {
            return $value_name;
        } else {
            throw new Exception("Variable name ".$value_name." not found");
        }
    }

    protected function setError($variable_name,$message_array) {
        if($variable_name != "") {
            $this->_errors_array[$variable_name][] = $message_array;
        } else {
            throw new Exception("Variable name ".$variable_name." not defined!");
        }
    }

    protected function setValue($variable_name,$variable_value) {
        if($variable_name != "") {
            $this->_validation_variable[$variable_name] = $variable_value;
        } else {
            throw new Exception("Variable name ".$variable_name." not defined!");
        }
    }


    /* BEGIN VALIDATORS */

    protected function requireValidator($value, $variable_name, $param = null) {
        if($value == "") {
            $this->setError($variable_name, array("message" => "variable  ".$variable_name." is empty!"));
            return false;
        }
        return true;
    }

    protected function numberValidator($value, $variable_name, $param = null) {
        if(!is_int($value)) {
            $this->setError($variable_name, array("message" => "variable  ".$variable_name." is not number!"));
            return false;
        }
        return true;
    }

    protected function min_lenValidator($value, $variable_name, $param = null) {
        if(strlen($value) < $param[0]) {
            $this->setError($variable_name, array("message" => "variable  ".$variable_name." len < ".$param[0]." curent len = ".strlen($value)." !"));
            return false;
        }
        return true;
    }

    protected function max_lenValidator($value, $variable_name, $param = null) {
        if(strlen($value) > $param[0]) {
            $this->setError($variable_name, array("message" => "variable  ".$variable_name." len > ".$param[0]." curent len = ".strlen($value)." !"));
            return false;
        }
        return true;
    }

    protected function lenValidator($value, $variable_name, $param = null) {
        if(strlen($value) != $param[0]) {
            $this->setError($variable_name, array("message" => "variable  ".$variable_name." len != ".$param[0]." curent len = ".strlen($value)." !"));
            return false;
        }
        return true;
    }

    protected function emailValidator($value, $variable_name, $param = null) {
        if(!preg_match("/^[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/", $value)) {
            $this->setError($variable_name, array("message" => "variable  ".$variable_name." not valid email address!"));
            return false;
        }
        return true;
    }

    protected function valid_base64Validator($value, $variable_name, $param = null) {
        if(!preg_match('/[a-zA-Z0-9\/\+=]/', $value)) {
            $this->setError($variable_name, array("message" => "variable  ".$variable_name." no base64 code"));
            return false;
        }
        return true;
    }

    /* alpha validate */
    function alpha_numericValidator($value, $variable_name,$param = null) {
        if(!preg_match("/^([a-z0-9])+$/i", $value)){
            $this->setError($variable_name, array("message" => "variable  ".$variable_name." is not alpha numeric!"));
            return false;
        }
        return true;
    }

    /* integer validate */
    function integerValidator($value ,$variable_name,$param = null) {
        if(!preg_match( '/^[\-+]?[0-9]+$/', $value)){
            $this->setError($variable_name, array("message" => "variable  ".$variable_name." is not integer type !"));
            return false;

        }
        return true;
    }

    /* natural validator */
    function naturalValidator($value,$variable_name, $param = null) {
        if(!preg_match( '/^[0-9]+$/', $value)){
            $this->setError($variable_name, array("message" => "variable  ".$variable_name." are not valid natural digits!"));
            return false;
        }
        return true;
    }

    function valid_ipValidator($value,$variable_name, $param = null) {
        if(inet_pton($value) === false){
            $this->setError($variable_name, array("message" => "variable  ".$variable_name." is not valid ip!"));
            return false;
        }
        return true;
    }

    /* bad simbol */
    function filename_securityValidator($str) {
        $bad = array(
            "../","./","<!--","-->",
            "<",">","'",'"','&','$',
            '#','{','}','[',']',
            '=',';','?',"%20","%22",
            "%3c","%253c","%3e","%0e",
            "%28","%29","%2528",
            "%26","%24","%3f","%3b","%3d"
        );
        return stripslashes(str_replace($bad, '', $str));
    }


    /* TODO: valid IP client(ipv4/ipv6),  valid base64(check_sum) назви файлів які заборонені в Windows і UNIX */
    /* END VALIDATORS */

    public function __destruct() {
        $this->_errors_array = array();
        $this->_validation_rules = array();
    }

}
