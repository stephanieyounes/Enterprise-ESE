<?php


echo '
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #333;
  position: fixed;
  top: 0;
  width: 100%;
}

li {
  float: left;
}

li a {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

li a:hover {
  background-color: #f0efef;
}
.collapsible {
  background-color: #ddeedd;
  color: black;
  cursor: pointer;
  padding: 18px;
  width: 100%;
  border: none;
  text-align: left;
  outline: none;
  font-size: 15px;
  font-weight: bold;
}
.content {
  padding: 0 18px;
  display: none;
  overflow: hidden;
  background-color: #c2d4dd;
}
body {background-color: #f0efef;}
</style>

';

$page = "reporting.php";
include("functions.php");

$dblink=db_connect("docstorage");
$sql="Select * from `documents` where `file_type`='pdf'";

$result=$dblink->query($sql) or
	die("Something wentwrong with: $sql<br>".$dblink->error);

//echo "All files";
//while($data=$result->fetch_array(MYSQLI_ASSOC))
//{
//	echo '<div>'.$data['name'].'</div>';
//}


/*nav bar*/
echo '<ul style="list-style: none; background-color: #ddeedd; ">';
echo '<li><a style="color: black;font-weight: bold; font-size: 22px;" href="#first">Unique Loans</a></li>';
echo '<li><a style="color: black;font-weight: bold; font-size: 22px;" href="#second">Document Sizes</a></li>';
 echo '<li><a style="color: black;font-weight: bold; font-size: 22px;" href="#third">Missing Documents</a></li>';

echo '</ul>';

//bullet point1

$loanArray=array();
while($data=$result->fetch_array(MYSQLI_ASSOC))
{
	$tmp=explode("-",$data['name']);
	//storing all loan numbers in loanArray
	$loanArray[]=$tmp[0];
//	$sizeArray[] = $tmp[1];
	$docArray[]=$tmp[1];
	

}


echo '<br /><br /><br />';


echo '<div id="first">';

echo '<h2 >Unique Loans & Number of Documents (First & Third Bullet)</h2>';


//$sizeUnique=array_unique($sizeArray);
$loanUnique=array_unique($loanArray);
$uniqueSize= sizeof($loanUnique);


echo '<h3>Number of Unique Loans:'.$uniqueSize.'<h3>';

echo '<button type="button" class="collapsible">Click to View Loans & Document Number</button>';
echo '<div class="content">';
foreach($loanUnique as $key=>$value)
{
	$sql="Select count(`name`) from `documents` where `name`
	like '%$value%'";
	$rst=$dblink->query($sql) or 
		die("Something wentwrong with: $sql<br>".$dblink->error);
	$tmp=$rst->fetch_array(MYSQLI_NUM);
	echo '<div style="font-size: 15px;">Loan number: '.$value. ' has '.$tmp[0].' documents</div>';
	
		
}
echo '</div>';


echo '<h3>Average Number of Loan documents: '.$tmp[0].'<h3>';

echo '</div>';
echo '<hr>';

echo '<div id="second">';

echo '<h2 >Document Size: Sum & Average (Second Bullet)</h2>';




$sum = "SELECT SUM(size) FROM `documents`";

$average = "SELECT AVG(size) FROM `documents`";

$result = $dblink->query($sum) or

    die("Something wentwrong with: $sql<br>".$dblink->error);

while ($row = $result->fetch_assoc()) {

    echo '<h3>Total of All File Sizes: ' . $row['SUM(size)'] . '</h3>';
	
}

$result = $dblink->query($average) or

	die("Something wentwrong with: $sql<br>".$dblink->error);

while ($row = $result->fetch_assoc()) {


    echo '<h3>Average File Size: ' . round($row['AVG(size)']) . '</h3>';

    

}

echo '</div>';

echo '<hr>';



//last big part
$tags = array("Credit"=>0, "Closing"=>0, "Financial"=>0, "Personal"=>0, "Title"=>0,
			  "Internal"=>0,  "Other"=>0,"Legal"=>0);


echo '<h2>Loan Numbers With Missing Documents (Fourth Bullet)</h2>';




//$docArray[]=$tmp[1]

echo '<button type="button" class="collapsible">Click to View Present & Missing Documents</button>';

echo '<div class="content"  id= "third">';
	
$i=0;
foreach($loanUnique as $key=>$value)
{
	$sql="Select count(`name`) from `documents` where `name`
	like '%$value%'";
	$rst=$dblink->query($sql) or 
		die("Something wentwrong with: $sql<br>".$dblink->error);
	$tmp=$rst->fetch_array(MYSQLI_NUM);
	echo '<div style="font-size: 16px;font-weight: bold;">Loan number: '.$value. ' has a  '.$docArray[$i].' document</div>';
	echo '<div>Missing:</div>';
	
	if(!strcmp("Credit", $docArray[$i]) == false ){
		echo ' Credit ';
		
	}
	if(!strcmp("Closing", $docArray[$i]) == false ){
		echo ' Closing ';
		
	}
	if(!strcmp("Title", $docArray[$i]) == false ){
		echo ' Title ';
		
	}
	if(!strcmp("Financial", $docArray[$i]) == false ){
		echo ' Financial ';
		
	}
	if(!strcmp("Personal", $docArray[$i]) == false ){
		echo 'Personal';
		
	}
	if(!strcmp("Internal", $docArray[$i]) == false ){
		echo ' Internal';
		
	}
	if(!strcmp("Legal", $docArray[$i]) == false ){
		echo ' Legal ';
		
	}
	echo '<hr>';
	$i++;
	
	
	
	
	
		
}



echo '</div>';





$i=0;
$credit = 0;
$closing = 0;
$title = 0;
$financial = 0;
$personal = 0;
$other = 0;
$internal = 0;
$legal = 0;
$count = [];
$all = [];
foreach($loanUnique as $key=>$value)
{
	
	$sql="Select count(`name`) from `documents` where `name`
	like '%$value%'";
	$rst=$dblink->query($sql) or 
		die("Something wentwrong with: $sql<br>".$dblink->error);
	$tmp=$rst->fetch_array(MYSQLI_NUM);
	
	
	if(strcmp("Credit", $docArray[$i])){
		$credit++;
		$count[$i]++;
		
	}
	if(strcmp("Closing", $docArray[$i])){
		$closing++;
		$count[$i]++;
		
	}
	if(strcmp("Title", $docArray[$i]) ){
		$title++;
		$count[$i]++;
		
	}
	if(strcmp("Financial", $docArray[$i])){
		$financial++;
		$count[$i]++;
		
	}
	if(strcmp("Personal", $docArray[$i]) ){
		$personal++;
		$count[$i]++;
		
	}
	if(strcmp("Internal", $docArray[$i])){
		$internal++;
		$count[$i]++;
		
	}
	if(strcmp("Legal", $docArray[$i])){
		$legal++;
		$count[$i]++;
		
	}
	if(strcmp("Other", $docArray[$i])){
		$other++;
		$count[$i]++;
		
	}
	if($count[$i] == 8){
		$all[$i] = 1;
	}
	else{
		$all = [-1];
	}
	
	$i++;
	

}
echo '<br />';
echo '<br />';

$i=0;

foreach($loanUnique as $key=>$value)
{
	if($all[$i] == 1)
	{
		echo $value.'has all documents';
	}
	
	
	
}
if($all = [-1])
	{
		echo '<div style="font-size: 16px;font-weight: bold;">No loan number has all the documents</div>';
	}

echo '<br />';
echo '<br />';



echo 'Total Number of Credit Documents: '.$credit; 
echo '<br />';
echo 'Total Number of Closing Documents: '.$closing;
echo '<br />';
echo 'Total Number of Title Documents: '.$title; 
echo '<br />';
echo 'Total Number of Financial Documents: '.$financial; 
echo '<br />';
echo 'Total Number of Personal Documents: '.$personal; 
echo '<br />';
echo 'Total Number of Internal Documents: '.$internal; 
echo '<br />';
echo 'Total Number of Legal Documents: '.$legal; 
echo '<br />';
echo 'Total Number of "Other" Documents: '.$other; 
echo '<br />';











	












?>
<script>
var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.display === "block") {
      content.style.display = "none";
    } else {
      content.style.display = "block";
    }
  });
}
</script>