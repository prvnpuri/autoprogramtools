<!--
/*
 * Funtion: This program is used for find column name
 * which follows cakephp standards. 
 * Its provide's sets of all fields available in columns
 * in table. 
 * 
 */
-->
<?php 
$mysql_conn=mysql_connect("localhost","root","");
if(!isset($mysql_conn)){
	echo "Mysql Server connection failed";
}

$res=mysql_query("show databases",$mysql_conn);
$dbnames=array("No database found");
if(isset($res)){
	$dbnames=array("");
	while($row= mysql_fetch_assoc($res)){
		$dbnames[]=$row['Database'];
	}
}
$dbname="";
$tables=array("No tables found");
if(isset($_GET["dbname"])){
	$dbname=$_GET["dbname"];
	if(!mysql_select_db($dbname)){
		echo "db Connect failed";
	}
	$res=mysql_query("show tables",$mysql_conn);
	if(isset($res)){
		$tables=array("");
		while($row= mysql_fetch_row($res)){
			$tables[]=$row[0];
		}
	}
}
$tablename="";
if(isset($_GET["tablename"])){
	
	$tablename=$_GET["tablename"];
}


?>
<html>
	<head>
		<title>Add column query builder for Mysql.</title>
		<link rel=stylesheet href="./jslibs/codemirror/lib/docs.css">
		<link rel="stylesheet" href="./jslibs/codemirror/lib/codemirror.css" />
        <script src="./jslibs/codemirror/lib/codemirror.js"></script>
        <script src="./jslibs/codemirror/lib/matchbrackets.js"></script>
        <script src="./jslibs/codemirror/lib/sql/sql.js"></script>
        <link rel="stylesheet" href="./jslibs/codemirror/lib/sql/show-hint.css" />
        <script src="./jslibs/codemirror/lib/sql/show-hint.js"></script>
        <script src="./jslibs/codemirror/lib/sql/sql-hint.js"></script>
<style>
.label{
	width:200px;
	display: inline-block;
}
.input{
	width:300px;
}

.error{
	color: red;
	font-weight: bold;
}
</style>
	</head>
<script>
window.onload = function() {
  var mime = 'text/x-mariadb';
  // get mime type
  if (window.location.href.indexOf('mime=') > -1) {
    mime = window.location.href.substr(window.location.href.indexOf('mime=') + 5);
  }
  window.editor = CodeMirror.fromTextArea(document.getElementById('code'), {
    mode: mime,
    indentWithTabs: true,
    smartIndent: true,
    lineNumbers: true,
    matchBrackets : true,
    autofocus: true,
    extraKeys: {"Ctrl-Space": "autocomplete"},
    
  });
};
</script>	
<body>
<h1>Add column query builder for Mysql.</h1>

<form method="get">
	<div>
		<label class="label">Database Name</label>
		<select name="dbname" class="input">
			<?php 
				foreach($dbnames as $db){
					echo "<option value='$db' ".($dbname==$db?'selected':'').">$db</option>";
					
				}
			?>
		</select>
	</div>
	<div>
		<label class="label">Table Name</label>
		<select name="tablename" class="input">
			<?php 
				foreach($tables as $tb){
					echo "<option value='$tb' ".($tablename==$tb?'selected':'').">$tb</option>";
					
				}
			?>
		</select>
	</div>

	<br/>
	<div>
		<input type="submit">
	</div>
</form>

<?php 

echo "<!-- xXx -->";

if($dbname==""){
	echo "<label class='error'>Enter db name</lable>";exit();
}

if(trim($tablename," ")==""){
	echo "<label class='error'>Enter table name</label>";exit();
}




$result=mysql_query("desc `$tablename`",$mysql_conn);

if(isset($result)){
	$i=0;
	$afterFields=null;
	echo "<textarea id='code' class='coltext textarea'>";
    echo "-- SQL burner -- ";	
	while ($meta = mysql_fetch_assoc($result)) {
	    $isNull=$meta["Null"]=="YES";
	    $null= $isNull ? " NULL ":" ";
	    $after=$afterFields==null?"":"AFTER `$afterFields`";
	    echo "
-- Table : {$tablename} and column {$meta["Field"]}
Set @Query=( select  if(EXISTS(SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='{$tablename}' AND column_name='{$meta["Field"]}' and TABLE_SCHEMA=database()) ,
    \"ALTER TABLE `{$tablename}` MODIFY  `{$meta["Field"]}` {$meta["Type"]} {$null} {$after}; \",
    \"ALTER TABLE `{$tablename}` ADD COLUMN  `{$meta["Field"]}` {$meta["Type"]} {$null} {$after};\"  )) ;
PREPARE queryPre from @Query;
EXECUTE queryPre ;
DEALLOCATE PREPARE queryPre;
\n
";	    
	    
// 	    if($i==0){
// 			echo " ALTER TABLE `$tablename` ";
// 		}else{
// 			echo " , \n ";		
// 		}
		
// 			echo " ADD COLUMN `".$meta["Field"]."` ".$meta["Type"]." ".($isNull?" NULL ":" ");
// 	 	if(isset($afterFields)){
// 			echo "AFTER `$afterFields` ";
// 		}
// 		$i++;
// 		$afterFields=$meta["Field"];
		
	}		
	echo "; </textarea>";
}else{
	echo "Something wrong.";
}


?>

</body>
</html>