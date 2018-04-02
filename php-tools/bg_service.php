<?php 
echo "Starting";

$no_hop="\"C:\Program Files\Git\usr\bin\nohup.exe\"";

$cmd="$no_hop php shel_exec.php &";

shell_exec($cmd);

// $descriptorspec = array(
//     0 => array("pipe", "r"),
//     1 => array("pipe", "w"),
//     2 => array("pipe", "w")    //here curaengine log all the info into stderror
// );
// $process = proc_open($cmd, $descriptorspec, $pipes);

echo " Running";
?>