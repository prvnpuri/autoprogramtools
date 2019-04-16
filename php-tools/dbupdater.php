<?php
// dbupdater.php for local system and development env only. This will support Windows and Linux both
// usage : cmd> php dbupdater.php

// Env variables

define( "done_folder_path","./../donedbupdates/");
define( "failed_folder_path","./../faileddbupdates/");
define( "current_dir", "./" );
$mysql_host='localhost';
$mysql_user='root';
$mysql_pass='';
$mysql_db='catalyst_solutia_dev';
//other settings
define( "move_error_to_failed_folder", false );
define( "move_executefile_to_done_folder", false );
// DB updater script

function log_strln($str){
    echo "[INFO] ";
    fwrite(STDOUT, $str);
    echo "\n";
}

function log_error($str){
    echo "[ERROR] ";
    fwrite(STDERR, $str);
    echo "\n";
}

$mysql_connect = mysqli_connect($mysql_host,$mysql_user,$mysql_pass);
if(!$mysql_connect){
    log_error("-- DB connection Error with Host: '$mysql_host' , user : '$mysql_user' ");
    log_error("Failed to connect database.");
    exit(1);
}else{
    
    
    if(!mysqli_select_db($mysql_connect, $mysql_db)){
        log_error("Unable to select db - `$mysql_db` for DB connection Host: '$mysql_host' , user : '$mysql_user' ");
        exit(1);
    }
    
    log_strln("Connected DB : $mysql_host/$mysql_user/$mysql_db \n");
    
}



function move_to_failed($file){
    $soruce=realpath(current_dir.$file);
    $destination=realpath(  failed_folder_path)."/". basename( $file);
    log_strln("Moving file into Failed Folder :  $soruce to $destination \n")  ;
    rename($soruce, $destination);
}

function move_to_done($file){
    
    $soruce=realpath(current_dir.$file);
    $destination=realpath(  done_folder_path)."/". basename( $file);
    log_strln("Moving file into Done Folder :  $soruce to $destination \n " );
    rename($soruce, $destination);
}

function mysql_file_exec($file,$mysql_link){
    $isSuccess=false;
    log_strln( "-- Running File : $file  --\n" );
    try{
        $file_string=file_get_contents ($file);
        // To DO - Execute Script
                
        
        $isSuccess=mysqli_multi_query($mysql_link, $file_string);
        if(!$isSuccess || mysqli_error($mysql_link) !=0 ){
            throw new Exception( "[ ERR_CODE ". mysqli_errno($mysql_link). "] : " . mysqli_error($mysql_link));
        }else{
            do {
                mysqli_store_result($mysql_link);
            } while ( mysqli_more_results($mysql_link) && mysqli_next_result($mysql_link) );
            log_strln("[ SUCCESSFULLY EXECUTED ] $file ");
            if(move_executefile_to_done_folder==true) move_to_done($file);
        }
    }catch(Exception $e){
        log_error( " Error [ $file ] : " . $e->getMessage() . " \n ");
        if(move_error_to_failed_folder) move_to_failed($file);
    }
    log_strln( "-- Done file : $file --\n");
    return $isSuccess;
}


$files= glob( current_dir.'*.sql');
$sortedSqlList=[];

if( $files==null || count($files)==0){
    log_strln("Sql files : 0 , Nothing for update.");
    exit(0);
}

log_strln( "Found Files -  ". count($files)."\n");


foreach ( $files as $file ){
    log_strln( $file . "\n");
    $nameArray=explode('-', $file);
    $sortedSqlList[$nameArray[0]]= $file;
}
ksort($sortedSqlList);
$successCount=0;
$errorCount=0;
$errorFiles=[];
log_strln( "-- Executing SQL Files -- \n");
echo "\n";

foreach ( $sortedSqlList as $file ){
    if(mysql_file_exec($file,$mysql_connect)){
        $successCount++;
    }else{
        $errorFiles[$errorCount]["file"]=$file;
        $errorFiles[$errorCount]["error"]="[ ERR_CODE ". mysqli_errno($mysql_connect). "] : " . mysqli_error($mysql_connect);        
        $errorCount++;
    }
}

mysqli_close($mysql_connect);
log_strln( "---------- Execution Done : ------------\n");
log_strln("Change done for host: $mysql_host, user: $mysql_user, db:$mysql_db");
log_strln( "Total Executed  : ". count($sortedSqlList). " , Success : $successCount ". " , Error : $errorCount");

if($errorCount>0){
    $error_file= realpath("./"). "/". "error_report_".date('Y-m-d')."_".time().".csv";
    $errfile = fopen($error_file,"w");
    fputcsv($errfile,['File','Error']);
    log_error(" --   Error files are -- [ Total Error Files - $errorCount ] ");
    foreach ( $errorFiles as $k => $error ){
        fputcsv($errfile,$error);
        $sqlfile_path=move_error_to_failed_folder==true?  realpath(  failed_folder_path)."/". basename( $error["file"]) : realpath( $error["file"] ) ;
        log_error( ($k+1) . " - " . $sqlfile_path);
    }
    fclose($errfile);
    log_strln('Error Log saved in '.$error_file);
}

