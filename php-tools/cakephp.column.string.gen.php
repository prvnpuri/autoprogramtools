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
$alias="";
if(isset($_GET["alias"])){
	$alias=$_GET["alias"];
}
$arrayvarname="";
if(isset($_GET["arrayvar"])){
	$arrayvarname=$_GET["arrayvar"];
}
$inline=false;
if(isset($_GET["inline"])){
	$inline=$_GET["inline"]==1?true:false;
}
$inarray=false;
if(isset($_GET["inarray"])){
	$inarray=$_GET["inarray"]==1?true:false;
}


?>
<html>
	<head>
		<title>Cakephp Table field builder.</title>
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
<h1>Cakephp Table field builder.</h1>

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
	<div>
		<label class="label">Alias</label>
		<input value="<?php echo $alias; ?>" type="text" placeholder="enter alias" name="alias" class="input">
	</div>
	<div>
		<label class="label">Show in Line</label>
		<input type="checkbox" value="1" name="inline"  <?php echo $inline?"checked":""; ?>>
	</div>
	<div>
		<label class="label">In Array</label>
		<input type="checkbox" value="1" name="inarray"  <?php echo $inarray?"checked":""; ?>>
	</div>
	<div>
		<label class="label">Array Variable</label>
		<input type="text" value="<?php echo $arrayvarname;?>" placeholder='Enter Array Variable.' class="input" name="arrayvar" >
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

if($tablename==""){
	echo "<label class='error'>Enter table name</label>";exit();
}




$result=mysql_query("select * from  `$tablename` limit 0,1",$mysql_conn);

if(isset($result)){
	$i=0;
	echo mysql_num_fields($result). " Columns found: <br/><br/> <textarea class='coltext textarea'>";
	while ( $i < mysql_num_fields($result) ) {
		$meta = mysql_fetch_field($result, $i);
		if($inarray){
			echo $arrayvarname. ( trim($alias," ")!="" ? "['".$alias."']"   :"") . "['".$meta->name."']";
		}else{
			echo "'".(trim($alias," ")=="" ? "" : $alias.".") . $meta->name ."', ";
		}
		if(!$inline){
			echo "\n";
		}
		$i++;
	}		
	echo "</textarea>";
}else{
	echo "Something wrong.";
}


?>

</body>
</html>