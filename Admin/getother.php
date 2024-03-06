<?php include 'Includes/dbcon.php';
   $rollnumber=10001;
    $pid = intval($_GET['q']);
$qry= "SELECT * FROM items where cid='$pid' ORDER BY icode ASC";
$result = $conn->query($qry);
$row=$result->fetch_assoc();
$num = $result->num_rows;   ?>
 
                            <label class="form-control-label">Quantity<span class="text-danger ml-2">*</span></label>
                      <input type="number" class="form-control" name="quantity" value="<?php echo $row['quantity'];?>"   placeholder="Quantity" oninput="this.value = this.value.toUpperCase()" required>
                       

               
   
   
        
 


