<?php
#!/usr/bin/php -q
for($x=0; $x<10; $x++){
    shell_exec ( "echo ".date("Y-m-d h:i:sa")."  >> C:\\xampp\\htdocs\\autoprogramtools\\app.log" );
    sleep(1);
}