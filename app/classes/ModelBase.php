<?php
/**
 * (C) Moriarti Engine 3
 * @author Moriarti <mor.moriarti@gmail.com>
 * Created at 2016-04-23 00:29:52 GMT+2.
 */
class ModelBase {

    protected $db;

    protected $registry;

    /**
     * Constructor of the class
     *
     * @access public
     * @author Moriarti <mor.moriarti@gmail.com>
     */
    public function __construct($registry) {
        $this->registry = $registry;
        $this->connector();
        $this->configConnection();
        //	$registry->set('db', $this->db);
    }

    private function connector() {
        // Connect to MySQL database.
        try{
            $this->db=new PDO('mysql:'.DBCONN.';dbname='.DBNAME,DBUSER,DBPASSWD);
            $this->db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            return true;
        }catch(PDOExeption $e){
            die("Error ".$this->logPDOException($e));
        }
    }

    private function configConnection() {
        $this->db->query("SET NAMES ".DBCHARSET);
        $this->db->query("SET time_zone = '".DBTIMEZONE."'");
    }

    private function logPDOException($exception){
        $data="Code#".$exception->getCode()." Message#".$exception->getMessage();
        return (DEBUG)?$this->logStore('pdo',$data):$data;
    }

    public function logQuery($query){
        return (DEBUG)?$this->logStore('query',$query):$query;
    }

    private function logStore($logName,$data){
        file_put_contents("logs/".$logName.".log",$data);
        return $data;
    }

    public function __destruct() {
        $this->db = null;
    }
} // EOF Model_Base
