<?php session_start();
?>
<?php 
error_reporting(0);
include 'Includes/dbcon.php';
include 'Includes/session.php';

//------------------------SAVE--------------------------------------------------

if(isset($_POST['save'])){
    extract($_POST);
   
         $yearcheck = date("Y");
         $query=mysqli_query($conn,"select * from allocatebudget where cid ='$category' And month='$getmonth' and year='". $yearcheck."' and createdby='".$_SESSION['email']."' ");
         $ret=mysqli_fetch_array($query);
         if($ret > 0)
         { 

          $queryprice=mysqli_query($conn,"select sum(price) as totalprice from  inventoryrequests where cid ='$category' And month='$getmonth' and year='". $yearcheck."' and createdby='".$_SESSION['email']."'");
          $gettotalprice=mysqli_fetch_array($queryprice);
          $totalexpenseamount=$gettotalprice['totalprice']+$price;

          if(0 && ($totalexpenseamount> $ret['amount']))
                       {
                        $statusMsg = "<div id='moo' class='alert alert-danger bg-danger text-light border-0 alert-dismissible fade show' auto-close='2000'>Budget Outed! <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
                       }
                       else
                       {



          $stamp=date("Y-m-d h:i:sa");
          $query1=mysqli_query($conn,"select * from  inventory where cid ='$category' and icode='$item' And month='$getmonth' and year='". $yearcheck."' and createdby='".$_SESSION['email']."'");
          $ret56=mysqli_fetch_array($query1);
          if($ret56['quantity']<$quantity)
                    {
                      $statusMsg = "<div id='moo' class='alert alert-danger bg-danger text-light border-0 alert-dismissible fade show' auto-close='2000'>Requested amount larger than stock! <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";

                    }
                    else
                    {
                      $query17=mysqli_query($conn,"select * from items where icode ='$item'");
                    $resultexpense17=$query17->fetch_assoc();

                    $query1=mysqli_query($conn,"select * from category where cid ='$category'");
                    $resultexpense=$query1->fetch_assoc();

                    $query111=mysqli_query($conn,"select * from  inventory where cid ='$category' and icode ='$item' and year='". $yearcheck."' and month='$getmonth' and createdby='".$_SESSION['email']."' ");

                    $resultexpense111=$query111->fetch_assoc();
                    $remainingquantity=$resultexpense111['quantity']-$quantity;

                    $query1115=mysqli_query($conn,"update  inventory set quantity='".$remainingquantity."' where cid ='$category' and icode ='$item' and month='$getmonth' and year='".$yearcheck."' and createdby='".$_SESSION['email']."' ");

                    $query=mysqli_query($conn,"insert into  inventoryrequests value('','".$resultexpense['cid']."','".$resultexpense['category']."','$item','".$resultexpense17['itemname']."','-','$quantity','-','".$stamp."','$getmonth','".$yearcheck."','".$_SESSION['email']."')");

                  if ($query) {
                      
                      $statusMsg = "<div id='moo' class='alert alert-success bg-success text-light border-0 alert-dismissible fade show' auto-close='2000'>Created Successfully! <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
                  }
                  else
                  {
                       $statusMsg = "<div id='moo' class='alert alert-danger bg-danger text-light border-0 alert-dismissible fade show' auto-close='2000'>An error Occurred! <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
                  }
                }
              }
                  
              

      } 
      else
      {

         $statusMsg = "<div id='moo' class='alert alert-danger bg-danger text-light border-0 alert-dismissible fade show' auto-close='2000'>No Budget Allocated for this Month! <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
                    
     }


}


    

//---------------------------------------EDIT-------------------------------------------------------------






//--------------------EDIT------------------------------------------------------------

 if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "edit")
  {
        $Id= $_GET['Id'];

        $query=mysqli_query($conn,"select * from  inventoryrequests where iid ='$Id'");
        $row=mysqli_fetch_array($query);

        //------------UPDATE-----------------------------

        if(isset($_POST['update'])){
    
            extract($_POST);

            $query2=mysqli_query($conn,"select * from  inventoryrequests where iid ='$Id'");
    $getmonth1=mysqli_fetch_array($query2);
    if($getmonth1>0)
    {
      $rowgetamount=$query2->fetch_assoc();
      if($price > $getmonth1['income'])
      {
        $statusMsg = "<div id='moo' class='alert alert-danger bg-danger text-light border-0 alert-dismissible fade show' auto-close='2000'>Allocated Budget is Greather than Income! <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";

      } else
      {
        
            $query=mysqli_query($conn,"update inventoryrequests set quantity='$quantity' where iid='$Id'");

            if ($query) {
              $statusMsg = "<div id='moo' class='alert alert-warning bg-warning border-0 alert-dismissible fade show' role='alert' auto-close='2000'>Updated Record Successfully!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
                
               
            }
            else
            {
                $statusMsg = "<div id='moo' class='alert alert-danger bg-danger text-light border-0 alert-dismissible fade show' auto-close='2000'>An error Occurred! <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
            }
      }
        
    }
}
}

//--------------------------------DELETE------------------------------------------------------------------

  if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "delete")
  {
        $Id= $_GET['Id'];

        $query = mysqli_query($conn,"DELETE FROM  inventoryrequests WHERE iid='$Id'");

        if ($query == TRUE) {
                $statusMsg = "<div id='moo' class='alert alert-danger bg-danger text-light border-0 alert-dismissible fade show' auto-close='2000'>Deleted Record Successfully! <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
                unset($Id);
                echo '<script>window.location.href="setexpense.php";</script>';
                 
                 
        }
        else{

            $statusMsg = "<div id='moo' class='alert alert-danger bg-danger text-light border-0 alert-dismissible fade show' auto-close='2000'>An error Occurred! <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>"; 
         }
      
  }


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="../img/logo.png" rel="icon">
<?php include 'Includes/title.php';?>
  <link href="../Includes/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../Includes/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="Includes/css/ruang-admin.min.css" rel="stylesheet">
   <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="Includes/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="Includes/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="Includes/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="Includes/assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="Includes/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="Includes/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="Includes/assets/vendor/simple-datatables/style.css" rel="stylesheet">
<script>
function showUser(str) {
  if (str == "") {
    document.getElementById("txtHint1").innerHTML = "";
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("txtHint1").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET","getitemname2.php?q="+str,true);
    xmlhttp.send();
  }
}
</script>
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
      <?php include "Includes/sidebar.php";?>
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
       <?php include "Includes/topbar.php";?>
        <!-- Topbar -->

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Inventory Section</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Inventory Section</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Inventory Section</h6>
                    <?php echo $statusMsg; ?>
                </div>
                <div class="card-body">
      <?php 
                   $query2=mysqli_query($conn,"select * from category where createdby='".$_SESSION['email']."'");
    $getmonth1=mysqli_fetch_array($query2);
    if($getmonth1>0)
    {

      ?>
                  <form method="post">
                    <div class="form-group row mb-3">
                      <?php
                      if (isset($Id))
                    {
                    ?>
                    <div class="col-xl-6">
                            <label class="form-control-label">Category<span class="text-danger ml-2">*</span></label>
                      <input type="text" class="form-control" name="amount" value="<?php echo $row['category'];?>"     oninput="this.value = this.value.toUpperCase()" disabled>
                        </div>
                         <div class="col-xl-6">
                            <label class="form-control-label">Item<span class="text-danger ml-2">*</span></label>
                      <input type="text" class="form-control" name="amount" value="<?php echo $row['itemname'];?>"     oninput="this.value = this.value.toUpperCase()" disabled>
                        </div>
                      <?php 
                    }
                      else
                      {

                        ?>

                    
                         <div class="col-xl-6">
                        <label class="form-control-label">Select Category<span class="text-danger ml-2">*</span></label>
                         <?php
                        $qry= "SELECT * FROM category where createdby='".$_SESSION['email']."' ORDER BY cid ASC";
                        $result = $conn->query($qry);
                        $num = $result->num_rows;   
                        if ($num > 0){
                          echo ' <select required name="category" onchange="showUser(this.value)" class="form-control mb-3">';
                          echo'<option value="">--Select Category--</option>';
                          while ($rows = $result->fetch_assoc()){
                          echo'<option value="'.$rows['cid'].'" >'.$rows['category'].'</option>';
                              }
                                  echo '</select>';
                              }
                            ?>  
                        </div>
                      <?php } ?>
                    
                       <div class="col-xl-6">
                        <label>Item Name</label><span class="text-danger ml-2">*</span>
                          <?php
                                echo"<div id='txtHint1'></div>";
                            ?>
                        </div>
                        
                        
                        <div class="col-xl-12">
                            <label class="form-control-label">Use Quantity<span class="text-danger ml-2">*</span></label>
                      <input type="number" class="form-control" name="quantity" value="<?php echo $row['quantity'];?>"   placeholder="Quantity" oninput="this.value = this.value.toUpperCase()" required>
                        </div>

                          
                        <div class="col-xl-12">
                            <label class="form-control-label">Month<span class="text-danger ml-2">*</span></label>
                       <select class="form-control" name='getmonth' placeholder="Select Month">
                               
                              <option value="January">January</option>
                              <option   value="February">February</option>
                              <option  value="March">March</option>
                              <option   value="April">April</option>
                            	<option   value="May">May</option>
                              <option value="June">June</option>
                              <option   value="July">July</option>
                              <option  value="August">August</option>
                            	<option  value="September">September</option>
                              <option  value="October">October</option>
                              <option   value="November">November</option>
                              <option   value="December">December</option>
                            </select>

                     <!-- <input type="text" class="form-control" Id="getmonth" name="getmonth"  value ="<?php echo date('Y-m-d') ?>" oninput="this.value = this.value.toUpperCase()"  readonly> -->
                        </div>
  </div>
                    
                     
                      
                      <?php
                    if (isset($Id))
                    {
                    ?>
                     <button type="button"  onclick="window.location.href='issueinventory.php'" name="addvendor" class="btn btn-primary">Add New Requsition </button>
                     
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <?php
                    } else {           
                    ?>
                    <button type="submit" name="save" class="btn btn-success">Add Request</button>
                    <?php
                    }         
                    ?>
                  </form>
                  <?php
                }else
                {?>
                    <div id='moo' class='alert alert-danger bg-danger text-light border-0 alert-dismissible fade show' auto-close='2000'>No Category Found! <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div> 
                  <?php }
                  ?>
                </div>
              </div>

              <!-- Input Group -->
                 <div class="row">
              <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Inventory's Data</h6>
                </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>Category</th>
                        <th>Item Name</th>
                        
                        <th>Use Quantity</th>
                        <th>Month</th>
                        <th>Edit</th>
                        <th>Delete</th>
                      </tr>
                    </thead>
                  
                    <tbody>

                  <?php
                      $query = "SELECT * FROM inventoryrequests where createdby='".$_SESSION['email']."' ";
                      $rs = $conn->query($query);
                      $num = $rs->num_rows;
                       
                      if($num > 0)
                      { 
                        while ($rows = $rs->fetch_assoc())
                          {
                             
                            echo"
                              <tr>
                                
                                <td>".$rows['category']."</td>
                                 <td>".$rows['itemname']."</td>
                                  
                                 <td>".$rows['quantity']."</td>
                                  
                                  <td>".$rows['month']."</td>";
                               echo "<td><a href='?action=edit&Id=".$rows['iid']."'><i class='fas fa-fw fa-edit'></i></a></td>
                               <td><a href='?action=delete&Id=".$rows['iid']."'><i class='fas fa-fw fa-trash'></i></a></td>
                              </tr>";
                        
                          }
                      }
                      else
                      {
                           echo   
                           "<div class='alert alert-danger' role='alert'>
                            No Record Found!
                            </div>";
                      }
                      
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            </div>
          </div>
          

        </div>
        <!---Container Fluid-->
      </div>
      <!-- Footer -->
        
      <!-- Footer -->
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="../Includes/vendor/jquery/jquery.min.js"></script>
  <script src="../Includes/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../Includes/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../Includes/js/ruang-admin.min.js"></script>
   <!-- Page level plugins -->
  <script src="../Includes/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../Includes/vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script>
    $(document).ready(function () {
      $('#dataTable').DataTable(); // ID From dataTable 
      $('#dataTableHover').DataTable(); // ID From dataTable with Hover
    });
    $(function() {
  var alert = $('div.alert[auto-close]');
  alert.each(function() {
    var that = $(this);
    var time_period = that.attr('auto-close');
    setTimeout(function() {
      that.alert('close');
    }, time_period);
  });
});
  </script>
    <script type="text/javascript">
    const mnames = ["January", "February", "March", "April", "May", "June",
  "July", "August", "September", "October", "November", "December"
];

const dat = new Date();
var month=( mnames[dat.getMonth()]);
document.getElementById('getmonth').value = month ;
</script>
</body>

</html>