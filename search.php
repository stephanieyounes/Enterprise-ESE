<!DOCTYPE html>
<link href="assets/css/bootstrap.css" rel="stylesheet" />
<link href="assets/css/bootstrap-fileupload.min.css" rel="stylesheet" />
<!-- JQUERY SCRIPTS -->
<script src="assets/js/jquery-1.12.4.js"></script>
<!-- BOOTSTRAP SCRIPTS -->
<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/bootstrap-fileupload.js"></script>
<?php

//somthing wrong here 
include("functions.php");

$dblink=db_connect("docstorage");


echo '<div id="page-inner">';

echo '<h1 class="page-head-line">Search for File in DocStorage</h1>';
echo '<div class="panel-body">';

if (!isset($_POST['submit']))
{
echo '<form action="" method="post">';
echo '<div class="form-group">';
echo '<label>Search String</label>';
echo '<input type="text" class="form-control"  name=searchString>';
echo '</div>';

echo '<select name="searchType">';
echo '<option value="name">Name</option>';
echo '<option value="uploadBy">Uploaded By</option>';
echo '<option value="uploadDate">Date</option>';
echo '<option value="all">All</option>';
echo '</select>';
echo '<hr>';
echo '<button type="submit" name="submit" value="submit">Search</button>';
echo '</form';	
}



if (isset($_POST['submit']))
{
	
	$searchType=$_POST['searchType'];
	$searchString=addslashes($_POST['searchString']);
	switch($searchType)
	{
		case "name":
//			$sql="Select `name`, `file_type`, `upload_date`, `auto_id` from `documents` where `name` like '%$searchString%'";
			$sql="Select * from `documents` where `name` like '%$searchString%'";
			break;
		case "uploadBy":
			$sql="Select * from `documents` where `uploadBy` like '%$searchString%'";
			break;
		case "uploadDate":
			$sql="Select * from `documents` where `uploadDate` like '%$searchString%'";
			break;
		case "all":
			$sql="Select * from `documents`";
			break;
		default:
			redirect("search.php?msg=searchTypeError");
			break;
	}
	
//$sql="Select * from `documents` where `status`='active'";
	//echo "SQL: $sql";
//	die();
	$result=$dblink->query($sql) or
		die("Something went wrong with $sql<br>".$dblink->error);
	echo '<table>';
	while ($data=$result->fetch_array(MYSQLI_ASSOC))
	{
		echo '<tr>';
		echo '<td>'.$data['name'].'</td>';
		echo '<td>'.$data['upload_date'].'</td>';
		echo '<td><a href="view.php?fid='.$data['auto_id'].'">View</a></td>';
		echo '</tr>';
	}
	echo '</table>';
}
echo '</div>';//end panel-body
echo '</div>';//end page-inner
?>