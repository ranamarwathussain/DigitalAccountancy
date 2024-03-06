 <?php session_start(); 
include 'Includes/dbcon.php';

extract($_POST);
$sql="SELECT * FROM `allocatebudget`as ab JOIN monthlybudget as mb WHERE mb.month='$month' and ab.month='$month' and ab.year='$year' and mb.year='$year' ;";
$result=$conn->query($sql);
$row=$result->fetch_assoc();
?>
<html lang="en">
 
<head>
  <meta charset="UTF-8">
  <title>Monthly - Reports</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Add your other CSS links here -->
  <style>
    /* Add your custom styles here */
    @media print {
      /* Adjust styles for printing */
      .col-md-4,
      .col-md-5,
      .col-md-6,
      .col-md-2 {
        float: left;
        width: 33.33%;
      }
      .jumbotron {
        padding: 10px; /* Adjust as needed */
      }

      hr {
        width: 100%;
      }
      .print-hidden {
            display: none !important;
        }
        a.print-link {
            display: inline !important;
            text-decoration: none !important;
            color: inherit !important;
            visibility: visible !important;
        }
        .print-link {
            position: absolute;
            left: -9999px;
        }
        .hidden-print {
    display: none !important;
  }
    }
  </style>
 
 
  <meta charset="UTF-8">
<!-- Latest compiled and minified CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  <title>Monthly - Reports</title>
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

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script type="text/javascript">
        //custom script
        $(function(){
            $('.panel').filter(function(){ return $('.tego-bg-red', this).length})
                    .find('.panel-heading')
                    .removeClass('tego-bg-green')
                    .addClass('tego-bg-red')
        })
  </script>
    <style>
        .tego-bg-red .panel-title, .tego-bg-green .panel-title {
            color: #fff;
        }
        .tego-bg-red {
            background-color: #e74c3c !important;
        }
        .tego-bg-green {
            background-color: #27ae60 !important;
        }
        .tego-color-red {
            color: #c0392b;
            font-weight: bold;
        }
        .tego-color-green {
            color: #27ae60;
            font-weight: bold;
        }
    </style>
     <style>
            hr {
  border: 0;
  clear:both;
  display:block;
  width: 96%;               
  background-color:#000000;
  height: 1px;
}

hr {
  height: 4px; /* Adjust this value to change thickness */
  background-color: black; /* Change color if needed */
  border: solid;
}
        </style>
</head>
<body>

  <div class="container">
    <div class="jumbotron">
    <div class="row">
  
      <div class="panel panel-primary">
        <div class="panel-heading">Budget Information for Month of <b><?php echo $month.' '.$year;?></b></div>
        <div class="panel-body">
           <b> <div class="col-md-4">Opening Balance</b></div><div class="col-md-6"><b><?php echo $row['income'].' '.'';?></b></div>
         <br> <b>
      <div class="col-md-4">Allocated Categories</div>
             <div class="col-md-5">Budget Amount Utilised</div>
             <div class="col-md-2">Remaining Amount</div>
             </b><br><br>
              <hr>
           
            <?php 
            $sql="SELECT * FROM `allocatebudget`as ab JOIN monthlybudget as mb WHERE mb.month='$month' and ab.month='$month' and ab.year='$year' and mb.year='$year';";
$result=$conn->query($sql);
$totalexpenses=0;
$totalremainingsamounts=0;
 
while($getrow=$result->fetch_assoc()){
    
    $sql2="SELECT amount FROM allocatebudget where cid='".$getrow['cid']."' and year='$year' and month='$month';";
        $result2=$conn->query($sql2);
        $rowgeet2=$result2->fetch_assoc();
        $totalamount=$rowgeet2['amount'];
         
    
    $sql="SELECT sum(price) as total FROM expense where cid='".$getrow['cid']."' and year='$year'  and month='$month';";
    $result1=$conn->query($sql);
    $rowgeet=$result1->fetch_assoc();
    $totalexpenses+=$rowgeet['total'];
    $xyz=$rowgeet2['amount']-$rowgeet['total'];
    $totalremainingsamounts+=$xyz;
    ?>
            <div class="col-md-4"><b><?php echo $getrow['category'].'--('.$getrow['amount'].')';?></b></div>
            <div class="col-md-5"><b><?php echo $rowgeet['total'].' '.'';?></b></div>
            <div class="col-md-2"><b><?php echo $totalamount-$rowgeet['total'].' '.'';?></b></div>
            
<?php
        }
 ?>
       
         <hr>
         <div class="col-md-4">Report</div>
             <div class="col-md-5"><b><?php echo $totalexpenses;?></b></div>
             <div class="col-md-2"><b><?php echo $totalremainingsamounts;?></b></div>
             <br><br>
            
        </div>

            <!-- <div class="col-md-4" class="content hidden-print">Allocated Categories</div>
              <div class="col-md-4" class="content hidden-print" >Allocated Budget Amount</div><br><br> -->
           
            <?php 
            $sql="SELECT * FROM `allocatebudget`as ab JOIN monthlybudget as mb WHERE mb.month='$month' and ab.month='$month';";
$result=$conn->query($sql);
$totalamount=0;
while($getrow=$result->fetch_assoc()){
    $totalamount+=$getrow['amount'];?>
              <div class="col-md-4" class="content hidden-print"><b>
                <a href='checkitem.php?catcheck=<?php echo $getrow['category'];?>' target="_blank" class="print-link">
            <?php echo $getrow['category'];?>
                </a>
                 
             </b>
        </div>

            <!--<div class="col-md-6" class="content hidden-print"><b><?php //echo $getrow['amount'].' '.'';?></b></div>-->
            
            <?php
        }?>
     
        
      </div>
 
      
    </div>

         
      
    </div>
  </div>
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
</body>
</html>
 