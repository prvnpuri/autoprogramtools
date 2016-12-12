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
		<style>
.label{
	width:200px;
	display: inline-block;
}
.input{
	width:300px;
}
.textarea{
	width:700px;
	height:400px;
}
.error{
	color: red;
	font-weight: bold;
}
</style>
	</head>
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

echo "<!-- @author: Praveen Goswami. -->";

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
	echo "<textarea class='coltext textarea'>";
	while ($meta = mysql_fetch_assoc($result)) {
		if($i==0){
			echo " ALTER TABLE `$tablename` ";
		}else{
			echo " , \n ";		
		}
		$isNull=$meta["Null"]=="YES";
			echo " ADD COLUMN `".$meta["Field"]."` ".$meta["Type"]." ".($isNull?" NULL ":" ");
	 	if(isset($afterFields)){
			echo "AFTER `$afterFields` ";
		}
		$i++;
		$afterFields=$meta["Field"];
		
	}		
	echo "; </textarea>";
}else{
	echo "Something wrong.";
}


?>

</body>
</html>