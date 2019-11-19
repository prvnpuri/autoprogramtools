<?php 

$pid = pcntl_fork();

if($pid==-1){

}else if($pid){
    
    echo "Parent Block runnning";
    pcntl_wait($status);
    
}else{
    
    for ($i = 0; $i<10 ;$i++){
        echo $i;
        sleep(1);
    }
    
}


?>