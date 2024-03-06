<?php include 'session.php';
include 'dbcon.php';
extract($_POST);
$sql2="select * from register where email='$emailprimary'";
$result2=$conn->query($sql2);
$rowcount=mysqli_num_rows($result2);
if($rowcount>0){
		echo "<script LANGUAGE='JavaScript'>
		    window.alert('Already Esist Please Login');
		    window.location.href='index.php';
		   </script>";
		
}else
{ 	$pass=md5($password);
		$sql="insert into register values('$username','$emailprimary','".$pass."','$hnumber','$fnumber')";
		$result=$conn->query($sql);
		if($result)
		{
			echo "<script LANGUAGE='JavaScript'>
		    window.alert('Succesfully Register Please Login');
		    window.location.href='index.php';
		   </script>";

		}
		else
		{
			echo "<script LANGUAGE='JavaScript'>
		    window.alert('Login Faild');
		    window.location.href='index.php';
		    </script>";
		}


}

?>