<?php
if( isset($_GET["memory"])){
$usage= memory_get_usage(true) ;
echo json_encode( array("memory_usage"=>memory_get_usage(),"total_memory"=> ini_get('memory_limit') ) );
exit();
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title> Memory usage </title>
  </head>
  <body>
    <div> Memory Usage : <span id="memory_info" style="color: blue;" > Loadding..  </span> </div>
    <script>
      window.onload=function(){
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
               // Typical action to be performed when the document is ready:
               var mem=JSON.parse(xhttp.responseText);
               var memory_usage=mem.memory_usage;
               var memory_limit=mem.total_memory;
               document.getElementById("memory_info").innerHTML = convertTOMemoryUnit(memory_usage) +" / " +  memory_limit ;
               setTimeout(function(){
                 getMemory();
               },10);
            }
        };
        var getMemory=function(){
          xhttp.open("GET", "./memory_info.php?memory=", true);
          xhttp.send();
        }
        getMemory();
      }

      function convertTOMemoryUnit(memoryvalue){
        var inKb="kB";
        var inMb="MB";
        var inGB="GB";
        var inByte="byte";

        if(memoryvalue/1024<1){
          return (memoryvalue).toFixed(3) +" " + inByte;
        }else if(memoryvalue/(1024*1024)<1){
          return (memoryvalue/(1024)).toFixed(3) +" " + inKb;
        }else if(memoryvalue/(1024*1024*1024)<1){
          return (memoryvalue/(1024*1024)).toFixed(3) +" " + inMb;
        }else{
          return (memoryvalue/(1024*1024*1024)).toFixed(3) +" " + inGB;
        }

      }

    </script>
  </body>
</html>
