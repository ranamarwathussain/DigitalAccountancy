<?php include 'Includes/dbcon.php';
   $rollnumber=10001;
    $pid = intval($_GET['q']);
$qry= "SELECT * FROM items as it join inventory as iv on iv.icode=it.icode where it.cid='$pid' ORDER BY it.icode ASC";
$result = $conn->query($qry);
$num = $result->num_rows;   
 if ($num > 0){
               echo ' <select required name="item" class="form-control mb-3">';
               echo'<option value="">--Select Item--</option>';
               while ($rows = $result->fetch_assoc()){
                       echo'<option value="'.$rows['icode'].'" >'.'Available QT <b>'.$rows['quantity'].' '.'-'.$rows['icode'].'-'.$rows['itemname'].'</option>';
                 }
                    echo '</select>';
                 }
 ?>  
                    
   
   
        
 


