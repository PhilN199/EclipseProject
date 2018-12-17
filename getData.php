<?php



$host = "localhost"; 
$user = "root";
$password = "root"; 
$dbname = "nasa_v2";

$con = mysqli_connect($host, $user, $password,$dbname);
// Check connection
if (!$con) {
 die("Connection failed: " . mysqli_connect_error());
}

$data = json_decode(file_get_contents("php://input"));


$search = $data->searchText;	// Search value
$sortColumn = $data->sortColumn;	// Sort Column name
$sortOrder = $data->sortOrder; // Boolean value

$sortBy = "asc";
if($sortOrder){
	$sortBy = "desc";
}


$select_emp = "select * from fake_love where 1 ";

if($search != ''){
	$select_emp .= " and (date like '%".$search."%')";
}

$select_emp .= " order by ".$sortColumn." ".$sortBy;


$fetchRecords = mysqli_query($con,$select_emp);
$data = array();

while ($row = mysqli_fetch_array($fetchRecords)) {
	$data[] = array("date" => $row['date'],
	    "time" => $row['time'],
	    "longitude" => $row['latitude'],
	    "latitude" => $row['longitude']
	);
}

echo json_encode($data);
