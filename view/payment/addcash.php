<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="icon" href="images/bloomfieldlogo.png" sizes="32*32">
    <link rel="stylesheet" href="../style/crud.css">
    <title>Bloomfield</title>
</head>
<body>
    <?php
        if(isset($_GET['id'])){
            require_once "../../model/database.php";
            $DB = new DB;
            $sql = "SELECT * FROM plunk.booking WHERE BookingID=$_GET[id]";
            $result = $DB->runQuery($sql)[0];
        }

        date_default_timezone_set("Asia/Kolkata");
    ?>
    <div class="main">
        <div class="left">
            <div class="form">
                <h2 class="center-text"><b>Cash Payment</b></h2>
                <form action="../../controller/CRUD.php" method="post">
                    <input name ="add-cash" type="hidden" >
                    <table>
                        <div class="form-group">
                            <tr>
                                <td style="text-align: right"><label for="PaymentDate">Payment Date</label></td>
                                <td><input name ="PaymentDate" id="PaymentDate" type="date" value="<?php echo date("Y-m-d") ?>" readonly></td>
                                <td width=50px>&nbsp;</td>
                                <td style="text-align: right"><label for="PaymentTime">Payment Time</label></td>
                                <td><input name ="PaymentTime" id="PaymentTime" type="time" value="<?php echo date("H:i") ?>" readonly></td>
                            </tr>
                        </div>
                    </table>
                    <table>
                    <tr><td><br></td></tr>
                    <tr>
                        <div class="form-group">
                            <td><label for="BookingID">Booking ID</label></td>
                            <td></td>
                            <td><input type="number" id= "BookingID" name="BookingID" required class="form-control" placeholder="Enter the Booking ID" value = "<?php echo "$result[BookingID]";?>"/></td>
                        </div>
                    </tr>
                    <tr><td><br></td></tr>
                    <tr>
                        <div class="form-group">
                            <td><label for="Customername">Customer Name</label></td>
                            <td></td>
                            <td><input type="text" id= "Customername" name="Customername" required class="form-control" placeholder="Enter the Customer name" value = "<?php echo "$result[CustomerName]";?>"/></td>
                        </div>
                    </tr>
                    <tr><td><br></td></tr>
                    <tr>
                        <div class="form-group">
                            <td><label for="ContactNo">Contact No</label></td>
                            <td></td>
                            <td><input type="text" id= "ContactNo" name="ContactNo" required class="form-control" placeholder="Enter the contact no" value = "<?php echo "$result[ContactNo]";?>"/></td>
                        </div>
                    </tr>
                    <tr><td><br></td></tr>

                <tr>
                    <div class="form-group">
                        <td><label for="Reservation">Reservation</label></td>
                        <td></td>
                        <td><input type="text" id= "Reservation" name="Reservation" required class="form-control" placeholder="Enter the reservation" value = "<?php echo "$result[Reservation]";?>"/></td>
                    </div>
                </tr>
                <tr><td><br></td></tr>
                <tr>
                    <div class="form-group">
                        <td><label for="Total">Total Value</label></td>
                        <td></td>
                        <td><input type="text" id= "Total" name="Total" required class="form-control" placeholder="Enter the total value" value = "<?php echo "$result[Total]";?>"/></td>
                    </div>
                </tr>
                <tr><td><br></td></tr>
                <tr>
                    <div class="form-group">
                        <td><label for="Receipt">Receipt NO :</label></td>
                        <td></td>
                        <td><input type="text" id= "Receipt" name="Receipt" required class="form-control" placeholder="Enter the receipt no"/></td>
                    </div>
                </tr>
                <tr><td><br></td></tr>
                <tr>
                    <div class="form-group">
                        <td><label for="Sign">Signed Person Name</label></td>
                        <td></td>
                        <td><input type="text" id= "Sign" name="Sign" required class="form-control" placeholder="Enter the Sign person name"/></td>
                    </div>
                </tr>
                <tr><td><br></td></tr>
                </table>

                    <div class="form-group">
                        <button type="submit" name="submit" value="Submit" class="button submit" ><a class="cancel" href="addcashsuccess.html">Pay</a></button>
                        <button type="reset" name="reset" value="Reset" class="button reset" ><a class="cancel" href="add.php">Cancel</a></button>
                    </div>
                </form>
            </div>
        </div>
        <div class= right>
      <div class = "righttop">
        <div class="itemtable">
            <h4>CRICKET CLUB PROPERTY BOOKING TABLE</h4>
            <iframe src="paymentbooking.php" class="item"></iframe>
        </div>
        
       </div>
        <div class = "rightbottom">
            <div class="itemtable">
                <h4>CASH PAYMENT DETAILS TABLE</h4>
                <iframe src="cash.php" class="item"></iframe>
            </div>  
        </div>
    </div>
        
    </div>
</body>
</html>
