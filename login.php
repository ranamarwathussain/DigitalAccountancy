<?php include 'session.php';
include 'dbcon.php';
extract($_POST);
$pass=md5($password_1);
$query = "SELECT * FROM register WHERE email = '$your_email_1' AND password = '".$pass."'";
$rs = $conn->query($query);
$num = $rs->num_rows;
$rows = $rs->fetch_assoc();

if($num > 0){

        $_SESSION['username']= $rows['username'];
        $_SESSION['email'] = $rows['email'];
 echo "<script type = \"text/javascript\">
        window.location = ('Admin/index.php')
        </script>";
       
      }else
      {
      	echo "<script type = \"text/javascript\">
        window.location = ('index.php')
        </script>";
      }

?>