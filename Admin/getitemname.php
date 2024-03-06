<?php include 'Includes/dbcon.php';
   $rollnumber=10001;
    $pid = intval($_GET['q']);
$qry= "SELECT * FROM items where cid='$pid' ORDER BY icode ASC";
$result = $conn->query($qry);
$num = $result->num_rows;   
 if ($num > 0){
               echo ' <select required name="item" class="form-control mb-3">';
               echo'<option value="">--Select Item--</option>';
               while ($rows = $result->fetch_assoc()){
                       echo'<option value="'.$rows['icode'].'" >'.$rows['itemname'].'</option>';
                 }
                    echo '</select>';
                 }
 ?>  
                    
   
   
        
 


