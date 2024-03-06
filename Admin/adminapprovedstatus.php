<?php session_start();
?>
<?php 
error_reporting(0);
include 'Includes/dbcon.php';
include 'Includes/session.php';
$totalbalanc=0;
//------------------------SAVE--------------------------------------------------

if(isset($_POST['update'])){
    
    extract($_POST);
    if($requestapprove=='Approved')
    {
     
            $query1=mysqli_query($conn,"select * from  student_balance where regnumber='$regnumber'");
            $getdetails=$query1->fetch_assoc();
            $totalbalanc=$getdetails['pcost']-$discountamount;

            $query6=mysqli_query($conn," update student_balance set pcost='".$totalbalanc."' where regnumber='$regnumber' and stdcnic='$stdcnic'");
            
            $message='Discount Amount='.$discountamount.'Approved Against Request ID='.$discountid;



             $query1=mysqli_query($conn,"update  student_discounts set discountstatus='Approved', approvedby='".$_SESSION['empcode'].'-'. $_SESSION['firstname'].''. $_SESSION['lastname']."',approvedon=NOW() where discountid='$discountid'");
            $message='Discount Amount='.$discountamount.'Approved Against Request ID='.$discountid;


        $query4=mysqli_query($conn,"INSERT INTO `studentlagers`(`stdlagerid`, `firstname`, `lastname`, `regnumber`, `stdcnic`, `contact`, `email`, `pcode`, `pname`, `description`, `creadedby`, `creadtedon`, `paid`, `outbalance`) VALUES ('','$fname','$lname','$regnumber','$stdcnic','$contact','$email','$pcode','$pname','".$message."','".$_SESSION['empcode'].'-'. $_SESSION['firstname'].''. $_SESSION['lastname']."',NOW(),'$discountamount','".$totalbalanc."')");
        $totalbalanc=0;
        $message='Discount Amount='.$discountamount.'Approved Against Request ID='.$discountid;
        $query2=mysqli_query($conn,"INSERT INTO `adminactivity`(`aid`, `empcode`, `empname`, `createdon`,`pcode`,`pname`, `activity`) VALUES ('','".$_SESSION['empcode']."','". $_SESSION['firstname'].''. $_SESSION['lastname']."',NOW(),'$pcode','$pname','$message' )");
        



        $message='';
            if ($query1) {
                
                
                    echo "<script>alert('Successfully Accepted!')</script>";
                    echo "<script>window.location = 'concessionrequests.php'</script>";
                         
                    
                    }
                    else
                    {
                        
                        echo "<script>alert('Error Occour!')</script>";
                    echo "<script>window.location = 'concessionrequests.php'</script>";
                        
                       
                    }
             
           }
       }

      if($requestapprove=='Reject')
       {

              $query1=mysqli_query($conn,"update  student_discounts set discountstatus='Rejected', approvedby='".$_SESSION['empcode'].'-'. $_SESSION['firstname'].''. $_SESSION['lastname']."',approvedon=NOW() where discountid='$discountid'");
              
                $query2=mysqli_query($conn,"INSERT INTO `adminactivity`(`aid`, `empcode`, `empname`, `createdon`,`pcode`,`pname`, `activity`) VALUES ('','".$_SESSION['empcode']."','". $_SESSION['firstname'].''. $_SESSION['lastname']."',NOW(),'$pcode','$pname','Created Program' )");

                     if ($query1) {
                
                
                    echo "<script>alert('Request Rejected!')</script>";
                    echo "<script>window.location = 'concessionrequests.php'</script>";
                         
                    
                    }
                    else
                    {
                        
                        echo "<script>alert('Error Occour!')</script>";
                    echo "<script>window.location = 'concessionrequests.php'</script>";
                        
                       
                    }



       }

 if($requestapprove=='Pending')
       {
             echo "<script>alert('Request Kept on Pending!')</script>";
                    echo "<script>window.location = 'concessionrequests.php'</script>";
                }
 

?>