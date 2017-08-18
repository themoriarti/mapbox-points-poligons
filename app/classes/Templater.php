<?php
/* (C) Moriarti Engine. */
/* Rebuild from template for universal use by Moriarti <mor.moriarti@gmail.com> 10:57:52 29.12.2016 */
final class Templater {

    public $r;

    protected $ext='tpl';

    protected $tplPath='';
    // Input params.
    public $params;
    //
//    public $configParams;
    //
//    public $translationParams;

    public function __construct($viewsPath = ''){
        if(!isset($viewsPath)){
            $this->tplPath=realpath(dirname(__FILE__).'/../views').'/';
        }
        $this->tplPath=$viewsPath;
    }

    public function __toString(){
        return $this->r;
    }

    protected function openFromFile($fn){
	$fullName=$this->tplPath.$fn.".".$this->ext;
	
      if(!file_exists($fullName)){
	    //return new throw Exception();
	    exit($fullName." File not found -> " . $fn . ".html");
      }
     $comment="";
      if(DEBUG){
	    $comment="\n<!-- ".$fullName." //-->\n";
      }
      return $comment.file_get_contents($fullName);
    }

    protected function openTemp($fn){
        return $this->openFromFile($fn);
    }

    public function mkTemplate($fn,$params){
	$this->params=$params;
	return $this->htmlRegex($this->openTemp($fn));
    }

    // Simple template only for <#var_name> variables.
    public function simpleTemplate($t){
	$T=$this->params;
        if(is_array($T)){
            $t=preg_replace("/<#(.+?)>/ei","\$T['\\1']",$t);
        }
        return $t;
    }

    /**
     * Create HTML select list.
     */
    public function CreateSelect($params,$db=null){
	//$params['select_name'];
	$params['table_name']=array_key_exists('table_name',$params)?$params['table_name']:$params['select_name'];
	$params['id_name']=array_key_exists('id_name',$params)?$params['id_name']:"id";
	$params['option_name']=array_key_exists('option_name',$params)?$params['option_name']:"name";
	$where=array_key_exists('where',$params)?" WHERE ".$params['where']:"";
	$setDefault=explode("=",$params['setDefault']);
	$mnemo=array_key_exists('setDefault',$params)?",`s`.`".$setDefault[0]."` AS `mnemo`":"";
	
	$sql="SELECT `s`.`".$params['id_name']."` AS `id`,`s`.`".$params['option_name']."` AS `name`".$mnemo." FROM `".$params['table_name']."` AS `s`".$where.";";

	try{
	    $ret="<select id=\"select_".$params['select_name']."\" name=\"".$params['select_name']."\">\n";
	    foreach($db->query($sql, PDO::FETCH_ASSOC) as $r){
		if($mnemo!=""&&$r['mnemo']==$_SERVER['GEOIP_COUNTRY_CODE']){
		    $selected="selected";
		}else{
		    $selected="";
		}
		$ret.="<option value=\"".$r['id']."\" ".$selected.">".$r['name']."</option>";
	    }
	    $ret.="</select>";
	}catch(PDOException $e){
	    $ret="Err";
	    if(DEBUG){
		$ret="Method: ".__METHOD__.". PDOException: ".$e->getMessage();
	    }
	}
    return $ret;
    }

    // Static function for html_regex preg_replace_callback $T.
    function repT($mat){
      $T=$this->params;
      $ma=$mat[1];
      return $T[$ma];
    }

    // Static function for html_regex preg_replace_callback "exp" match.
    static function expRep($mat){
	$mas=explode($mat[1],$mat[2]);
	foreach($mas as $k => $v) {
	    if ($v != "") {
		$c .= "<script>wp(\"" . $v . "\");</script>\n";
	    }
	}
	return $c;
    }

    // Static function for html_regex preg_replace_callback "select" match.
    static function genSelect($mat){
	if(preg_match("/^name=\'([a-z0-9_-]{1,32})\'/",$mat[1],$match)){
	    $param['select_name']=$match[1];
	}
	$match='';
	if(preg_match("/table=\'([a-z0-9_-]{1,32})\'/",$mat[1],$match)){
	    $param['table_name']=$match[1];
	}
	$match='';
	if(preg_match("/id=\'([a-z0-9_-]{1,32})\'/",$mat[1],$match)){
	    $param['id_name']=$match[1];
	}
	$match='';
	if(preg_match("/option_name=\'([a-z0-9_-]{1,32})\'/",$mat[1],$match)){
	    $param['option_name']=$match[1];
	}
	$match='';
	if(preg_match("/where=\'([a-z0-9-_=]{1,32})\'/",$mat[1],$match)){
	    $param['where']=$match[1];
	}
	if(preg_match("/setDefault=\'([a-z0-9-_=]{1,32})\'/",$mat[1],$match)){
	    $param['setDefault']=$match[1];
	}
	if(preg_match("/lang_name/",$mat[1],$match)){
	    global $lang;
	    $param['option_name']="name_".$lang;
	}
	$match='';
	return self::CreateSelect($param);
    }

    /**
     * Generate datatable DIV
     *
     */
    static function genDatatableDiv($datatableName){
	$dt['datatableName']=$datatableName[1];
        return preg_replace_callback("/<#(.+?)>/i",function($mat) use ($dt){return $dt[$mat[1]];},$this->openTemp('datatableDiv'));
    }

    // HTML template translate to HTML.
    protected function htmlRegex($t, $a = ''){
        // Do not change the order processing.
        $T=$this->params;
//	$C=$this->configParams;
//	$L=$this->translationParams;
        // Select generate in template.
        // Special exp method.
	// Example:
	//		Minimal style in tpl - <#select(name='element_name')>
        if(@preg_match("/<#select\((.*)\)>/",$t,$select_mat)) {
            $t=preg_replace_callback("/<#select\((.*)\)>/",array(&$this,"genSelect"),$t);
        }
        // Called quick as a fast method implementation, speed of execution of this method is slow.
        // Use only if no other method.
        // Example:
        // 		Style in tpl - <#fast_list['','']>
        // 		Style in PHP - $s->list_table('template_name',"SELECT ...; SQL query.");
    //    if(preg_match("/<#fast_list\[\'(.*)\',\'(.+?)\'\]>/", $t)) {
    //        $t=preg_replace_callback("/<#fast_list\[\'(.*)\',\'(.*)\'\]>/",create_function('$mat', "\$m=new template; return \$m->list_table(\$mat[1],\$mat[2]);"), $t);
    //    }
	// Insert datatable DIV action construct.
        if(preg_match("/<#datatable\[\'([a-z_]{1,32})\'\]>/", $t)) {
	    $t=preg_replace_callback("/<#datatable\[\'([a-z_]{1,32})\'\]>/",array(&$this,"genDatatableDiv"),$t);
        }
        // Num variable from database result array. Special for list_table method.
        // Example:
        // 		Style in tpl - <#0>;
        // 		Style in PHP - $result_array[0][0].
//        if(is_array($a)) {
            //preg_match("/(<#([0-9]{1,3})>)/",$t,$tt);
            //if(array_key_exists($tt[2],$a)){
        	// old 5.5
        	//$t = preg_replace("/<#(list|[0-9]{1,3})>/ei", "\$a['\\1']", $t);
        	// New fix for 7.0
//        	$t=preg_replace_callback("/<#(list|[0-9]{1,3})>/i",function($mat) use ($a){return $a[$mat[1]];}, $t);
    	    //}
//        }
	
	// Old. Parse configuration array $C.
	//if(is_array($C)){
	//	$t=preg_replace("/<#c\{\'(.+?)\'\}>/ei","\$C['\\1']",$t);
	//}
	
        // Lang template variable.
        // Example:
        // 		Style in tpl - <#l{'key_name'}>;
        // 		Style in PHP - $L['key_name'].
        if(is_array($L)){
            // Old 5.5
            //$t=preg_replace("/<#l\{\'(.+?)\'\}>/ei","\$L['\\1']",$t);
            // New fix 7.0
            $t=preg_replace_callback("/<#l\{\'(.+?)\'\}>/i",function($mat) use ($L){return $L[$mat[1]];},$t);
        }
        // Special exp method.
        if(is_array($a) && preg_match("/<#exp\[\'(.*)\'\]>/", $t)) {
            $t=preg_replace_callback("/<#exp\[\'(.*)\',\'(.*)\'\]>/",array(&$this,"expRep"),$t);
        }
        // General template variable.
        // Example:
        // 		Style in tpl - <#var name>;
        // 		Style in PHP - $T['var_name'].
        if(is_array($T)) {
	    if(!preg_match("/<#([0-9]{1,3})>/",$t,$tt)){
            //if(array_key_exists($tt[2],$T)){
		//$t=preg_replace("/<#(.+?)>/ei","\$T['\\1']",$t);
		$t=preg_replace_callback("/<#(.+?)>/",array(&$this,"repT"),$t);
	    }
        }
        // Template if operation.
        //if(preg_match("/\{if (.*)\}(.*)\{\if\}/",$t)){$t=preg_replace_callback("/\{if (.*)\}(.*)\{\if\}/",create_function('$var',"if(\$var[1]){\return $var[2];}"),$t);}
        return $t;
    }

} // EOF template.
?>