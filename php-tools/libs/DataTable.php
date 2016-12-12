<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DataTable{
	 public $table;
	 public $csql="";
	 public function __construct($table=null) {
	 	 $this->table=$table;
	 }	 
	 public function getError(){
	 	return "SQL: '$this->csql' ".MysqlConnection::error()." ";
	 }
    public function exist($cols=array()){
        $prsql="where 1=1  ";
        foreach ($cols as $colk => $colval){
            $prsql.=" AND `$colk`= '$colval'";
        }
        $sql="Select exists (select 1 from ".$this->table." $prsql ) as isExists";
        $ch=FALSE;
        $result=  mysql_query($sql);
        if(isset($result)&&(gettype($result)=='resource')&&($row=  mysql_fetch_array($result))!=null){
            $ch=$row["isExists"]==1?true:false;
        }else{
           throw  new Exception(mysql_error(MysqlConnection::getConnection())." on Execution Of  SQL:'$sql'");
        }
        return $ch;
    }  
    public function add($cols=array()){
    	$colcount=0;
    	$col_names='';
    	$values='';
    	foreach ($cols as $k => $val){
    		$col_names.="`$k`";
    		$col_names.=count($cols)-1==$colcount?"":",";
    		$values.="'".mysql_real_escape_string($val)."'";
    		$values.=count($cols)-1==$colcount?"":",";
    		$colcount++;
    	}
    	if(count($cols)==0){
    		return  false;
    	}
    	unset($colcount);
    	$this->csql="insert into ".$this->table." ($col_names) values ($values)";
    	return mysql_query($this->csql,  MysqlConnection::getConnection());
    }
    public function update($cols=array(),$conditions=array()){
        $cond_sql='where 1=1 ';
        foreach ($conditions as $k => $val){
            $cond_sql.=" AND `$k` = '$val' ";
        }
        $update_sql='Set ';
        $colcount=0;
        foreach ($cols as $k => $val){
            $update_sql.=" ".(($colcount++ !=0)?",":""). " `$k` = '$val'";
        }
        unset($colcount);
        $sql="update `".$this->table."` $update_sql $cond_sql";
        return mysql_query($sql,  MysqlConnection::getConnection());
    }
    public function find($data=  array()){
        $conditions=isset($data["conditions"])?$data["conditions"]:array();
        $limit=isset($data["limit"])?$data["limit"]:20;
        $start=isset($data["start"])?$data["start"]:0;
        $order=isset($data["order"])? " Order by  ".$data["order"]:"";
        $group=isset($data["group"])?" group by ".$data["group"]:"";
        $fields=isset($data["fields"])?$data["fields"]:array(" * ");
        $cond_sql='where 1=1 ';
        foreach ($conditions as $k => $val){
            $cond_sql.=" AND `$k` = '$val' ";
        }
        $field_sql=" ";
        $colcount=0;
        $limit_sql=" limit $start,$limit";
        foreach ($fields as $val){
            $field_sql.=" ".(($colcount++ !=0)?",":""). " $val ";
        }
        unset($colcount);
        $sql="select ".$field_sql." from ".$this->table." $cond_sql $order $group $limit_sql  ";
        $selectdata=array();
        $result=  mysql_query($sql,  MysqlConnection::getConnection());
        if(isset($result)&&(gettype($result)=='resource')){
            while ($row = mysql_fetch_assoc($result)) {
                $selectdata[]=$row;
            }
        }else{
               throw  new Exception(mysql_error(MysqlConnection::getConnection())." on Execution Of SQL:'$sql'");
        }
        return $selectdata;
    }
}