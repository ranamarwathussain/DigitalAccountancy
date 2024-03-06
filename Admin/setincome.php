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
   
    $query=mysqli_query($conn,"select * from monthlybudget where month ='$getmonth' and year='".$yearcheck ."' and createdby='".$_SESSION['email']."'");
    $ret=mysqli_fetch_array($query);

    if($ret > 0){ 

        $statusMsg = "<div id='moo' class='alert alert-danger bg-danger text-light border-0 alert-dismissible fade show' auto-close='2000'>Budget Already Set! <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
    }
    else{
          $stamp=date("Y-m-d h:i:sa");
          $year = date("Y");
        $query=mysqli_query($conn,"insert into monthlybudget value('','$income','$getmonth','".$stamp."','".$year."','".$_SESSION['email']."')");

    if ($query) {
        
        $statusMsg = "<div id='moo' class='alert alert-success bg-success text-light border-0 alert-dismissible fade show' auto-close='2000'>Created Successfully! <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
    }
    else
    {
         $statusMsg = "<div id='moo' class='alert alert-danger bg-danger text-light border-0 alert-dismissible fade show' auto-close='2000'>An error Occurred! <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
    }
  }
}

//---------------------------------------EDIT-------------------------------------------------------------






//--------------------EDIT------------------------------------------------------------

 if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "edit")
	{
        $Id= $_GET['Id'];

        $query=mysqli_query($conn,"select * from monthlybudget where bid ='$Id'");
        $row=mysqli_fetch_array($query);

        //------------UPDATE-----------------------------

        if(isset($_POST['update'])){
    
            extract($_POST);
        
            $query=mysqli_query($conn,"update monthlybudget set income='$income' where bid='$Id'");

            if ($query) {
              $statusMsg = "<div id='moo' class='alert alert-warning bg-warning border-0 alert-dismissible fade show' role='alert' auto-close='2000'>Updated Record Successfully!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
                
               
            }
            else
            {
                $statusMsg = "<div id='moo' class='alert alert-danger bg-danger text-light border-0 alert-dismissible fade show' auto-close='2000'>An error Occurred! <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
            }
        }
    }


//--------------------------------DELETE------------------------------------------------------------------

  if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "delete")
	{
        $Id= $_GET['Id'];

        $query = mysqli_query($conn,"DELETE FROM monthlybudget WHERE bid='$Id'");

        if ($query == TRUE) {
                $statusMsg = "<div id='moo' class='alert alert-danger bg-danger text-light border-0 alert-dismissible fade show' auto-close='2000'>Deleted Record Successfully! <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
                 
                 
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
            <h1 class="h3 mb-0 text-gray-800">Set Income</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Set Income</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Set Income Section</h6>
                    <?php echo $statusMsg; ?>
                </div>
                <div class="card-body">
                  <form method="post">
                    <div class="form-group row mb-3">
                        
                    
                   
                        <div class="col-xl-6">
                            <label class="form-control-label">In-come<span class="text-danger ml-2">*</span></label>
                      <input type="number" class="form-control" name="income" value="<?php echo $row['income'];?>"   placeholder="In-Come" oninput="this.value = this.value.toUpperCase()" required>
                        </div>


                        <div class="col-xl-6">
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
                    
                    <button type="submit" name="update" class="btn btn-warning">Update</button>
                    <button type="button"  onclick="window.location.href='setincome.php'" name="addvendor" class="btn btn-primary">Set New Budget</button>
                     
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <?php
                    } else {           
                    ?>
                    <button type="submit" name="save" class="btn btn-success">Set</button>
                    <?php
                    }         
                    ?>
                  </form>
                </div>
              </div>

              <!-- Input Group -->
                 <div class="row">
              <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">budget's Data</h6>
                </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        
                        <th>Budget</th>
                        <th>Month</th>
                        <th>Created Date&Time</th>
                        <th>EDIT</th>
                        <th>Delete</th>
                      </tr>
                    </thead>
                  
                    <tbody>

                  <?php
                      $query = "SELECT * FROM monthlybudget where createdby='".$_SESSION['email']."' ";
                      $rs = $conn->query($query);
                      $num = $rs->num_rows;
                       
                      if($num > 0)
                      { 
                        while ($rows = $rs->fetch_assoc())
                          {
                             
                            echo"
                              <tr>
                                
                                <td>".$rows['income']."</td>
                              
                                <td>".$rows['month']."</td>
                                
                                <td>".$rows['datetime']."</td>";
                               echo " <td><a href='?action=edit&Id=".$rows['bid']."'><i class='fas fa-fw fa-edit'></i></a></td>
                                <td><a href='?action=delete&Id=".$rows['bid']."'><i class='fas fa-fw fa-trash'></i></a></td>
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