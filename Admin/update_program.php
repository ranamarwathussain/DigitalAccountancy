<?php session_start();
?>
<?php 
error_reporting(0);
include 'Includes/dbcon.php';
include 'Includes/session.php';
	
	if(ISSET($_POST['update'])){
		extract($_POST);
        
		
		mysqli_query($conn, "update `program` set   pduration='$pduration', pname='$pname' ,pfeemode='$feemode',pdegree='$degree',pshift='$shift'  where pid='$pid'") or die(mysqli_error());

		mysqli_query($conn,"INSERT INTO `adminactivity`(`aid`, `empcode`, `empname`, `createdon`,`pcode`,`pname`, `activity`) VALUES ('','".$_SESSION['empcode']."','". $_SESSION['firstname'].''. $_SESSION['lastname']."',NOW(),'$pcode','$pname','Updated Program' )");
		
	echo "<script>alert('Successfully updated!')</script>";
		echo "<script>window.location = 'addprogram.php'</script>";
	}
?>