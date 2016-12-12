<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

abstract  class MysqlConnection{
    private static $connect;
    
    public static function connect(){
        if((self::$connect=mysql_connect("localhost","root",""))){
            if(mysql_select_db("tour"))
            {
                echo "database selected";
            	return true;
            }else{
            	echo "database could not be selected";
                return false;
            }
        }else{
        	echo "outter else";
            return false;
        }
    } 
    public static function getConnection(){
        return self::$connect;
    }
    public static function close() {
        return mysql_close(self::$connect);
    }
    public static function error(){
    	return "mysql_Error:". mysql_errno(self::$connect)." : ". mysql_error(self::$connect);
    }
    
    
}
