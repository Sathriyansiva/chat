<?php
$servername = "166.62.27.150";
$username = "donatefunddb";
$password = "donatefunddb";
$dbname = "donatefunddb";

/* $servername = "localhost";
$username = "root";
$password = "";
$dbname = "life_health";
 */ 
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);


// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
date_default_timezone_set('Asia/Kolkata');

if(isset($_GET['id']))
{
$id=$_GET['id'];


 $format = strtolower($_GET['format']) == 'json'; //xml is the default

		
		$query = mysqli_query($conn,"SELECT DATE_FORMAT(fromdate,'%H:%i') as time,prod_name,DATE_FORMAT(fromdate, '%Y-%m-%d') as fromdate,DATE_FORMAT(todate, '%Y-%m-%d') as todate,points FROM do_product_hdr where prod_cate='$id'") or die(mysqli_error()); 
 $posts = array();
  if(mysqli_num_rows($query)) {
    while($rows = mysqli_fetch_assoc($query)) {
		
		$prod_name= $rows['prod_name'];
		$time= $rows['time'];
		$fromdate1= $rows['fromdate'];
		$todate1= $rows['todate'];
		$points= $rows['points'];
		$fromdate= strtotime($rows['fromdate']);
		$todate= strtotime($rows['todate']);
		
$timeDiff = abs($todate - $fromdate);

$numberDays = $timeDiff/86400;  // 86400 seconds in one day

// and you might want to convert to integer
$numberDays = intval($numberDays);
               
		
		 $posts[] = array('prod_name' => $prod_name,'fromdate' =>$fromdate1, 'todate' =>$todate1,'interval'=>$numberDays,'time'=>$time,'points'=>$points);
		
	}
	
  }
  if($format == 'json') {
    header('Content-type: application/json');
    echo json_encode(array('posts'=>$posts));
  }
  else {
    header('Content-type: text/xml');
    echo '';
    foreach($posts as $index => $post) {
      if(is_array($post)) {
        foreach($post as $key => $value) {
          echo '<',$key,'>';
          if(is_array($value)) {
            foreach($value as $tag => $val) {
              echo '<',$tag,'>',htmlentities($val),'</',$tag,'>';
            }
          }
          echo '</',$key,'>';
        }
      }
    }
    echo '';
  }




}

else
{


 $format = strtolower($_GET['format']) == 'json'; //xml is the default

		
		$query = mysqli_query($conn,"SELECT * FROM do_category ") or die(mysqli_error());
 $posts = array();
  if(mysqli_num_rows($query)) {
    while($rows = mysqli_fetch_assoc($query)) {
		
		$category= $rows['cat_name'];
		$cat_id  = $rows['cat_id'];
		$points = $rows['points'];
		
		 $posts[] = array('category' => $category,'id' =>$cat_id,'points' =>$points);
		
	}
	
  }
  if($format == 'json') {
    header('Content-type: application/json');
    echo json_encode(array('posts'=>$posts));
  }
  else {
    header('Content-type: text/xml');
    echo '';
    foreach($posts as $index => $post) {
      if(is_array($post)) {
        foreach($post as $key => $value) {
          echo '<',$key,'>';
          if(is_array($value)) {
            foreach($value as $tag => $val) {
              echo '<',$tag,'>',htmlentities($val),'</',$tag,'>';
            }
          }
          echo '</',$key,'>';
        }
      }
    }
    echo '';
  }
  
  }
  
  
	?>