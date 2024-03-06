<?php session_start();
?>
<?php 
error_reporting(0);
include 'Includes/dbcon.php';
include 'Includes/session.php';
 $catcheck1=$_GET["catcheck"];
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
    document.getElementById("txtHint").innerHTML = "";
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("txtHint").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("GET","getitemname.php?q="+str,true);
    xmlhttp.send();
  }
}
</script>

</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
     
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">

        <div class="container-fluid" id="container-wrapper">
          
          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              

              <!-- Input Group -->
                 <div class="row">
              <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Showing Expense's Data For <?php echo  $catcheck1; ?></h6>
                </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                         <th>Category</th>
                         <th>Item Name</th>
                         <th>Location</th>
                         <th>Price</th>
                         <th>Quantity</th>
                         <th>Month</th>
                         <th>Date</th>
                          
                      </tr>
                    </thead>
                  
                    <tbody>

                  <?php

                     
                      $query = "SELECT * FROM expense where createdby='".$_SESSION['email']."' AND category='".$catcheck1."' ";
                      $rs = $conn->query($query);
                      $num = $rs->num_rows;
                       
                      if($num > 0)
                      { 
                        while ($rows = $rs->fetch_assoc())
                          {
                            $query155=mysqli_query($conn,"select * from budgetremaining where cid ='".$rows['cid']."' and month='".$rows['month']."' and createdby='".$_SESSION['email']."' ");
                              $row155=$query155->fetch_assoc();
                             
                            echo"
                              <tr>
                                ";
                                if($row155['remaining']==0)
                                {
                                echo"
                                <strong><td style='color:red;'>".$rows['category']."</td></strong>";
                                 echo"<td>".$rows['itemname']."</td>
                                 <td>".$rows['location']."</td>
                                 
                                 <td>".$rows['price']."</td>
                                 <td>".$rows['quantity']."</td>
                                  <td>".$rows['month']."</td>
                                  <td>".$rows['datetime']."</td>";
                                }else{
                                  echo"
                                <td style='color:green;'>".$rows['category']."</td>";

                                 echo"<td>".$rows['itemname']."</td>
                                 <td>".$rows['location']."</td>
                                
                                 <td>".$rows['price']."</td>
                                 <td>".$rows['quantity']."</td>
                                  <td>".$rows['month']."</td>
                                   <td>".$rows['datetime']."</td>
                                   ";
                                }
                               " </tr>";
                        
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
</script>
    <script type="text/javascript">
    const mnames = ["January", "February", "March", "April", "May", "June",
  "July", "August", "September", "October", "November", "December"
];

const dat = new Date();
var month=( mnames[dat.getMonth()]);
document.getElementById('getmonth').value = month ;
</script>
<script src="../Includes/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../Includes/vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="../Includes/vendor/jquery/jquery.min.js"></script>
  <script src="../Includes/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../Includes/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="Includes/js1/ruang-admin.min.js"></script>
   <!-- Page level plugins -->
  <script src="../Includes/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../Includes/vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script>
     
    $(document).ready(function () {
      $('#dataTable').DataTable(); // ID From dataTable 
      //$('#dataTableHover').DataTable(); // ID From dataTable with Hover
      $('#dataTableHover').DataTable({
    "lengthMenu": [ [10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "All"] ], // Define the length menu including 500
    "pageLength": 10 // Set the initial page length, this will be overridden by the lengthMenu
  });
    

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
<?php include 'script.php'?>

</script>

</body>

</html>