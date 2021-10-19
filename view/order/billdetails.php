<?php session_start() ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>

        <meta charset="utf-8">
        <title>Bloomfield</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="icon" href="images/bloomfieldlogo.png" sizes="32*32">
        <link rel="stylesheet" href="../style/crud.css">
        <script type="text/javascript" src="../script/additem.js"></script>
        <script type="text/javascript" src="../script/updatedata.js"></script>

  </head>
  <body>
  <?php
        require_once "../../model/database.php";
        $DB = new DB;
        $data = explode("=", $_GET['data']);
        $id = $data[1];
        // $col = explode("[", json_encode( $data[0]))[1];
        $col = $data[0];
        $col = substr($col, 7, -1);
        $query = "SELECT * FROM plunk.bill WHERE $col=$id";
        $result = $DB->runQuery($query)[0];
    ?>

    <div class=main>
    <div class= left>
    <div class="form">
			<h2 class="center-text"><b>Order/Bill Details</b></h2>
                <!-- <image src = "../images/bin.png" class="bin"></image></h2> -->
			
        
        <form>
            <table class="formtable">
            <tr>
                <div class="form-group">
                   <td><label for="ItemID">Bill ID</label></td> 
                    <td><input type="number" id= "ItemID" name="ItemID" required class="form-control" value = "<?php echo "$result[BillID]";?>" disabled/></td>
                </div>
            </tr>
            
            <tr>
                <div class="form-group">
                   <td><label for="ItemName">Customer Name</label></td> 
                    <td><input type="text" id= "ItemName" name="ItemName" required class="form-control" value = "<?php echo "$result[CustomerName]";?>" <?php if($_SESSION['UserType'] != 'Cashier'){echo "disabled";}?>/></td>
                </div>
            </tr>
            <tr>
                <div class="form-group">
                    <td><label for="Price">Price</label></td>
                    <td><input type="number" id="Price" name="Price" required class="form-control" min=0 oninput="validity.valid||(value='');" value = "<?php echo "$result[Price]";?>" disabled/></td>
                </div>
            </tr>
            <tr>
                <div class="form-group">
                    <td><label for="Discount">Discount</label></td>
                    <td><input type="number" id="Discount" name="Discount" required class="form-control" min=0 oninput="validity.valid||(value='');" value = "<?php echo "$result[Discount]";?>" disabled/></td>
                </div>
            </tr>
            
            </table>
            
            <!-- <div class="form-group">
                <button type="button" name="submit" value="Submit" class="button submit">Cash</button>
                <button type="burron" name="cancel" value="cancel" class="button submit">Card</button>
            </div> -->
    </form>                
    </div>
</div>
<div class= right>
        <div class="righttable">
        <div class="itemtable">
            <h3>Ordered Items</h3>
            <iframe src="../orderitem/details.php?OrderID=<?php echo $result['OrderID'] ?>" class="item"></iframe>
        </div>
</div>
</div>
</div>
     
  </body>

 
</html>
