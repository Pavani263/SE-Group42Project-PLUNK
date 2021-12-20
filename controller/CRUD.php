<?php
    session_start();
    require_once "../model/database.php";
    require_once "pages.php";

    //--------------------------------------------------------order--------------------------------------------------------
    if(isset($_POST['add-order'])){
        $DB = new DB;
        if($_POST['rowCount']!=0){
            try {
                $sql = "INSERT INTO plunk.order (OrderDate, OrderTime, OrderPlace, Total, UserID) VALUES ('$_POST[OrderDate]', '$_POST[OrderTime]', '$_POST[OrderPlace]', '$_POST[Total]', '$_SESSION[UserID]');";
                $DB->runQuery($sql);
                $sql = "SELECT OrderID FROM plunk.order ORDER BY OrderID ASC;";
                $OrderID = end($DB->runQuery($sql))['OrderID'];
                $itemRow = 1;
                $rowCount = $_POST['rowCount'];
                while($rowCount > 0){
                    if(isset($_POST['ItemID' . $itemRow])){
                        $rowCount--;
                        $ItemRow = 'ItemID' . $itemRow;
                        $QuanRow = 'Quantity' . $itemRow;
                        $sql = "INSERT INTO plunk.orderitem (OrderID, ItemID, Quantity) VALUES ('$OrderID', '$_POST[$ItemRow]',  '$_POST[$QuanRow]');";
                        $DB->runQuery($sql);
                        $sql = "UPDATE plunk.item SET Quantity = Quantity - $_POST[$QuanRow] WHERE ItemID = $_POST[$ItemRow];";
                        $DB->runQuery($sql);
                        $sql = "UPDATE plunk.item SET Availability = IF(Quantity<=0, 'No', 'Yes') WHERE ItemID = $_POST[$ItemRow];";
                        $DB->runQuery($sql);
                    }
                    $itemRow++;
                }
                $billPrice = $_POST['BillTotal'];
                echo $billPrice;
                $sql = "INSERT INTO plunk.bill (CustomerName, Price, Discount, BillDate, UserID, OrderID) VALUES('$_POST[CustomerName]', '$billPrice', $_POST[Discount], '$_POST[OrderDate]', '$_SESSION[UserID]', $OrderID)";
                $DB->runQuery($sql);
                $sql = "SELECT * FROM plunk.bill ORDER BY BillID DESC LIMIT 1;";
                $BillData = $DB->runQuery($sql);
                $record = http_build_query(array('record' => $BillData));
                $newPage = new Page("../view/bill/add.php?data=$record");
                $newPage->show();
            } catch (\Throwable $th) {
                throw $th;
            }
        }
        else{
            echo "<script>alert('Order was Incomplete. Please check again before Adding order.')</script>";
            // print_r($_COOKIE);
        }
    }

    if(isset($_POST['delete-order'])){
        $DB = new DB;

        try {
            $sql = "DELETE FROM plunk.order WHERE Order_ID=\"$_POST[Order_ID]\"";
            $DB->runQuery($sql);
        } catch (\Throwable $th) {
            throw $th;
        }

    }

    if(isset($_POST['update-order'])){
        $DB = new DB;

        try {;
            $sql = "UPDATE plunk.order SET OrderDate=\"$_POST[OrderDate]\", OrderTime=\"$_POST[OrderTime]\", OrderPlace=\"$_POST[OrderPlace]\", Total=\"$_POST[Total]\", UserID=\"$_POST[UserID]\" WHERE OrderID=\"$_POST[OrderID]\"";
            $DB->runQuery($sql);
        } catch (\Throwable $th) {
            throw $th;
        }

    }

    if(isset($_POST['search-order'])){
        $DB = new DB;

        try {
            $sql = "SELECT * FROM plunk.order WHERE Order_ID=\"$_POST[Order_ID]\"";
            $result = $DB->runQuery($sql);
            $rows = count($result, 0);
            if ($rows == 0){
                echo "Could not find Order: " . $_POST['Order_ID'] . "\n";
            }
            elseif ($rows > 1){
                echo "Multiple rows found. Please contact Admit to resolve issues.\n";
            }
            else{
                $row = $result[0];
                echo "Order ID\t:" . $row['Order_ID'] . "\n";
                echo "Order Place\t:" . $row['Order_Place'] . "\n";
                echo "Quantity\t:" . $row['Quantity'] . "\n";
                echo "Memebr ID\t:" . $row['Member_ID'] . "\n";
                echo "Staff ID\t:" . $row['Staff_ID'] . "\n";
            }

        } catch (\Throwable $th) {
            throw $th;
        }

    }

    //--------------------------------------------------------bill--------------------------------------------------------
    if(isset($_POST['pay-bill'])){
        $DB = new DB;
        print_r($_POST);
        try {
            $sql = "UPDATE plunk.bill SET Paid=2 WHERE BillID=$_POST[BillID];";
            $DB->runQuery($sql);
            $newPage = new Page("../view/Dashboards/cashierdash.php");
            $newPage->show();
        } catch (\Throwable $th) {
            throw $th;
        }

    }

    if(isset($_POST['update-bill'])){
        $DB = new DB;

        try {
            $sql = "UPDATE plunk.bill SET $_POST[Column]=\"$_POST[Value]\" WHERE Bill_ID=\"$_POST[Bill_ID]\"";
            $DB->runQuery($sql);
        } catch (\Throwable $th) {
            throw $th;
        }

    }

    if(isset($_POST['search-bill'])){
        $DB = new DB;

        try {
            $sql = "SELECT * FROM plunk.bill WHERE Bill_ID=\"$_POST[Bill_ID]\"";
            $result = $DB->runQuery($sql);
            $rows = count($result, 0);
            if ($rows == 0){
                echo "Could not find Bill: " . $_POST['Bill_ID'] . "\n";
            }
            elseif ($rows > 1){
                echo "Multiple rows found. Please contact Admit to resolve issues.\n";
            }
            else{
                $row = $result[0];
                echo "Bill ID\t:" . $row['Bill_ID'] . "\n";
                echo "Payment Type\t:" . $row['Payment_Type'] . "\n";
                echo "Discount\t:" . $row['Discount'] . "\n";
                echo "Steward Name\t:" . $row['Steward_Name'] . "\n";
                echo "Staff ID\t:" . $row['Staff_ID'] . "\n";
                echo "Order ID\t:" . $row['Order_ID'] . "\n";
            }
        } catch (\Throwable $th) {
            throw $th;
        }

    }

//---------------------------------------------------Item-----------------------------------------------------------------------
//---------Add Item------------

if(isset($_POST['add-item'])){
    $DB = new DB;

    try {
        if($_POST['ItemType'] != "Choose type..."){
            if($_POST['Company'] != "Select the Company"){
                $sql = "INSERT INTO plunk.item (ItemID, Company,ItemName, PurchasePrice,SellingPrice, Discount, Availability , Quantity, ItemType, ReorderQuantity,IsDeleted) VALUES ( '' , '$_POST[Company]','$_POST[ItemName]', '$_POST[PurchasePrice]',  '$_POST[SellingPrice]','$_POST[Discount]', '$_POST[Availability]', '$_POST[Quantity]','$_POST[ItemType]','$_POST[ReorderQuantity]','No');";               
                $DB->runQuery($sql);    
                $newPage = new Page('../view/items/additemsuccess.html');
                $newPage->show(); 
                
            }
            else{
                $newPage = new Page('../view/items/companyerror.html');
                $newPage->show();  
               
            }
        }
        else{
            $newPage = new Page('../view/items/Itemtypeerror.html');
            $newPage->show();
        }

    } catch (\Throwable $th) {
        throw $th;
    }

}
//---------Update Item------------

if(isset($_POST['update-item'])){
    $DB = new DB;

    try {
        if($_POST['ItemType'] != "Choose type..."){
            $sql = "UPDATE plunk.item SET `ItemID`='$_POST[ItemID]',`ItemType`='$_POST[ItemType]',`Company`='$_POST[Company]',`ItemName`='$_POST[ItemName]',`PurchasePrice`='$_POST[PurchasePrice]',`SellingPrice`='$_POST[SellingPrice]',`Quantity`='$_POST[Quantity]',`Discount`='$_POST[Discount]',`Availability`='$_POST[Availability]',`ReorderQuantity`='$_POST[ReorderQuantity]' WHERE `ItemID` = '$_POST[ItemID]'";
            $DB->runQuery($sql);
            $newPage = new Page('../view/items/updateitemsuccess.html');
            $newPage->show();
        }
        else{
            $newPage = new Page('../view/items/Itemtypeerror.html');
            $newPage->show();
        }
    } catch (\Throwable $th) {
        throw $th;
    }


}

//-----------Delete Item--------------------
if(isset($_POST['delete-item'])){
    $DB = new DB;
    try {
        
            if($_POST['Quantity'] == 0){
                $sql = "UPDATE plunk.item SET `IsDeleted`= 'Yes' WHERE `ItemID` = '$_POST[ItemID]'";
                $DB->runQuery($sql);
                $newPage = new Page('../view/items/deleteitemsuccess.html');
                $newPage->show();
            }
        else{
            $newPage = new Page('../view/items/qerror.html');
            $newPage->show();
        }
    } catch (\Throwable $th) {
        throw $th;
    }


}

//-----------Search Item---------------------

//---------------------------------------------------Invoice-----------------------------------------------------------------------
    if(isset($_POST['add-invoice'])){
        $DB = new DB;
        //if($_POST['rowCount']!=0){

            try {
                if($_POST['ItemType'] != "Choose type..."){
                    $sql = "INSERT INTO plunk.invoice (Company, Type, ReceivedDate, DueDate, Total, UserID ) VALUES ('$_POST[CompanyName]', '$_POST[ItemType]', '$_POST[ReceivedDate]', '$_POST[DueDate]', '$_POST[Total]','$_SESSION[UserID]');";
                    $DB->runQuery($sql);
                    //$sql = "SELECT InvoiceID FROM plunk.invoice;";
                    //$InvoiceID = end($DB->runQuery($sql))['InvoiceID'];
                // $itemRow = 1;
                // $rowCount = $_POST['rowCount'];
                // while($rowCount > 0){
                //     if(isset($_POST['ItemID' . $itemRow])){
                //         $rowCount--;
                //         $IDRow = 'ItemID' . $itemRow;
                //         $NameRow = 'ItemName' . $itemRow;
                //         $QuanRow = 'Quantity' . $itemRow;
                //         $sql = "INSERT INTO plunk.invoiceitem (InvoiceID, ItemID, ItemName, Quantity) VALUES ('$InvoiceID', '$_POST[$IDRow]', '$_POST[$NameRow]',  '$_POST[$QuanRow]');";
                //         $DB->runQuery($sql);
                        $newPage = new Page('../view/invoice/addinvoicesuccess.html');
                        $newPage->show();

                        // $sql = "UPDATE plunk.item SET Quantity = Quantity + $_POST[$QuanRow] WHERE ItemID = $_POST[$ItemRow];";
                        // $DB->runQuery($sql);
                    }
                    //$itemRow++;
            
            else{
                $newPage = new Page('../view/invoice/Invoicetypeerror.html');
                $newPage->show();
            }

            } catch (\Throwable $th) {
                throw $th;
            }
        //}
    }
//---------Update Invoice------------

if(isset($_POST['update-invoice'])){
    $DB = new DB;

    try {
        $sql = "UPDATE plunk.invoice SET `InvoiceID`='$_POST[InvoiceID]',`Company`='$_POST[Company]',`Type`='$_POST[Type]',`ReceivedDate`='$_POST[ReceivedDate]',`DueDate`='$_POST[DueDate]',`Total`='$_POST[Total]'  WHERE InvoiceID = '$_POST[InvoiceID]'";
        $DB->runQuery($sql);
        $newPage = new Page('../view/invoice/updateinvoicesuccess.html');
        $newPage->show();
    } catch (\Throwable $th) {
        throw $th;
    }

}

if(isset($_POST['search-invoice'])){
    $DB = new DB;

    try {
        $sql = "SELECT * FROM plunk.invoice WHERE InvoiceID=\"$_POST[InvoiceID]\"";
        $result = $DB->runQuery($sql);
        $rows = count($result, 0);
        if ($rows == 0){
            echo "Could not find Invoice: " . $_POST['InvoiceID'] . "\n";
        }
        elseif ($rows > 1){
            echo "Multiple rows found. Please contact Admit to resolve issues.\n";
        }
        else{
            $row = $result[0];
            echo "Invoice ID\t:" . $row['InvoiceID'] . "\n";
            echo "Company\t:" . $row['Companyname'] . "\n";
            echo "Type\t:" . $row['Type'] . "\n";
            echo "Received Date\t:" . $row['ReceivedDate'] . "\n";
            echo "Due Date\t:" . $row['DueDate'] . "\n";
            echo "Total\t:" . $row['Total'] . "\n";
        }
    } catch (\Throwable $th) {
        throw $th;
    }

}
//--Delete
if(isset($_POST['delete-invoice'])){
    $DB = new DB;

    try {
        $sql = "SELECT * FROM plunk.invoice WHERE InvoiceID=$_POST[InvoiceID]";
        $data = $DB->runQuery($sql);
        print_r($data);
        // $sql = "DELETE FROM plunk.invoice WHERE InvoiceID=$_POST[InvoiceID]";
        // $DB->runQuery($sql);
    } catch (\Throwable $th) {
        throw $th;
    }

}

//---------------------------------------------------User-----------------------------------------------------------------------
if(isset($_POST['add-staff'])||isset($_POST['add-member'])){
    $DB = new DB;

    $hashedpassword = Password_hash("$_POST[Password]", PASSWORD_BCRYPT);

    try {
          $sql = "INSERT INTO plunk.user (UserID, Name, UserName, Password, Email, ContactNo, JoinedYear, DisplayID,UserType) VALUES ( '' , '$_POST[Name]',  '$_POST[UserName]','$hashedpassword', '$_POST[Email]', '$_POST[ContactNo]','$_POST[JoinedYear]','$_POST[DisplayID]','$_POST[UserType]')";
         $DB->runQuery($sql);
         $type="$_POST[UserType]";
         if($type=='Manager'||$type=='Admin'||$type=='Accountant'||$type=='Restaurant Manager'||$type=='Cashier'||$type=='Staff Member'){
           $newPage = new Page('..\view\user\success.html');
           $newPage->show();
         }
         elseif ($type=='Life Member'||$type=='Ordinary Member'||$type=='HL Member') {
           $newPage = new Page('..\view\user\Addmembersuccess.html');
           $newPage->show();
         }
         else {

               $sql = "DELETE FROM plunk.user WHERE DisplayID='$_POST[DisplayID]'";
               $DB->runQuery($sql);
               $newPage = new Page('..\view\user\Errormg.html');
               $newPage->show();

         }


    } catch (\Throwable $th) {
        throw $th;
    }
}

if(isset($_POST['update-user'])){
    $DB = new DB;

    try {
        $sql = "UPDATE plunk.user SET Name='$_POST[Name]', DisplayID='$_POST[DisplayID]',UserID='$_POST[UserID]', UserType='$_POST[UserType]', JoinedYear='$_POST[JoinedYear]', Email='$_POST[Email]', ContactNo='$_POST[ContactNo]' WHERE UserID='$_POST[UserID]'";
        $DB->runQuery($sql);
        $type="$_POST[UserType]";
        if($type=='Manager'||$type=='Admin'||$type=='Accountant'||$type=='Restaurant Manager'||$type=='Cashier'||$type=='Staff Member'){
          $newPage = new Page('..\view\user\updatestaffsuccess.html');
          $newPage->show();
        }
        elseif ($type=='Life Member'||$type=='Ordinary Member'||$type=='HL Member') {
          $newPage = new Page('..\view\user\updatemembersuccess.html');
          $newPage->show();
        }
    } catch (\Throwable $th) {
        throw $th;
    }

}

if(isset($_POST['delete-user'])){
    $DB = new DB;



    try {
          $sql = "INSERT INTO plunk.deleteuser (UserID, Name,  Email, ContactNo, JoinedYear, DisplayID,UserType,Reason) VALUES ( '$_POST[UserID]' , '$_POST[Name]',  '$_POST[Email]', '$_POST[ContactNo]','$_POST[JoinedYear]','$_POST[DisplayID]','$_POST[UserType]','$_POST[Reason]')";
         $DB->runQuery($sql);
    } catch (\Throwable $th) {
        throw $th;
    }

    try {
        $sql = "DELETE FROM plunk.user WHERE UserID='$_POST[UserID]'";
        $DB->runQuery($sql);
        $newPage = new Page('..\view\user\deleteusersuccess.html');
        $newPage->show();
    } catch (\Throwable $th) {
        throw $th;
    }

}
//---------------------------------------------------Nortification-----------------------------------------------------------------------
//---------Add notification------------

if(isset($_POST['add-notifications'])){
    $DB = new DB;

    try {
        if($_POST['EventType'] != "Choose type..."){
            $sql = "INSERT INTO plunk.notification (`NotificationID`, `FromDate`, `ToDate`, `EventType` ,`Message`, `UserID`) VALUES ( '' , '$_POST[FromDate]', '$_POST[ToDate]', '$_POST[EventType]',  '$_POST[Message]','$_SESSION[UserID]')";
            $DB->runQuery($sql);
            print_r($DB);
            $newPage = new Page('../view/notifications/addnotifysuccess.html');
            $newPage->show();
        }
        else{
            $newPage = new Page('../view/notifications/notificationtypeerror.html');
            $newPage->show();
        }
       
    } catch (\Throwable $th) {
        throw $th;
    }
    
}
//---------Update Notification------------
if(isset($_POST['update-notifications'])){
    $DB = new DB;

    try {
        if($_POST['EventType'] != "Choose type..."){
            $sql = "UPDATE plunk.notification SET `NotificationID`='$_POST[NotificationID]' ,`FromDate` = '$_POST[FromDate]', `ToDate` = '$_POST[ToDate]', `EventType` ='$_POST[EventType]' ,`Message` = '$_POST[Message]' WHERE `NotificationID` = '$_POST[NotificationID]'";
            $DB->runQuery($sql);
            $newPage = new Page('../view/notifications/updatenotifysuccess.html');
            $newPage->show();
        }
        else{
            $newPage = new Page('../view/notifications/notificationtypeerror.html');
            $newPage->show();
        }
       
    } catch (\Throwable $th) {
        throw $th;
    }
    
}
//-----------Delete Notification--------------------
if(isset($_POST['delete-notification'])){
    $DB = new DB;
    try {
        
        $sql = "DELETE FROM plunk.notification WHERE `NotificationID` = '$_POST[NotificationID]'";
        $DB->runQuery($sql);

        $newPage = new Page('../view/notifications/deletenotifysuccess.html');
        $newPage->show();
      
    } catch (\Throwable $th) {
        throw $th;
    }


}

//..........................................................Reservation Menu................................................................................

//---------Add Reservation Menu------------

if(isset($_POST['add-reservation'])){
    $DB = new DB;

    try {
        if($_POST['Type'] == "Restaurant" || $_POST['Type'] == "Club"){
            $sql = "INSERT INTO plunk.reservationmenu(`ReservationName`, `Type`, `Cost`, `IsDeleted`) VALUES ('$_POST[ReservationName]','$_POST[Type]','$_POST[Cost]','No')";
            $DB->runQuery($sql);
            $newPage = new Page('../view/reservationmenu/addreservationsuccess.html');
            $newPage->show();
        }
        else{
            $newPage = new Page('../view/reservationmenu/reservationtypeerror.html');
            $newPage->show();
        }
       
    } catch (\Throwable $th) {
        throw $th;
    }
    
}
//---------Update Reservation Menu------------
if(isset($_POST['update-reservation'])){
    $DB = new DB;

    try {
        if($_POST['Type'] == "Restaurant" || $_POST['Type'] == "Club" ){
            $sql = "UPDATE plunk.reservationmenu SET `ReservationName`='$_POST[ReservationName]',`Type`='$_POST[Type]',`Cost`='$_POST[Cost]',`IsDeleted`='No' WHERE `ReservationName`='$_POST[ReservationName]'";
            $DB->runQuery($sql);
            $newPage = new Page('../view/reservationmenu/updateresrvationsuccesssuccess.html');
            $newPage->show();
        }
        else{
            $newPage = new Page('../view/reservationmenu/reservationtypeerror.html');
            $newPage->show();
        }
       
    } catch (\Throwable $th) {
        throw $th;
    }
    
}

//--------------------------------------------feedback-------------------------------------------
//----give feedback-------
if(isset($_POST['give-feedback'])){
    $DB = new DB;

    try {
        $sql = "INSERT INTO plunk.feedback (FeedBackID,FeedBack,FeedBackDate, UserID) VALUES ('','$_POST[FeedBack]','$_POST[CreatedDate]','$_SESSION[UserID]')";
        $DB->runQuery($sql);

        $newPage = new Page('..\view\feedback\feebacksuccess.html');
        $newPage->show();

    } catch (\Throwable $th) {
        throw $th;
    }

}
//----give reply--------
if(isset($_POST['reply-feedback'])){
    $DB = new DB;

    try {
        $sql = "UPDATE plunk.feedback SET Reply='$_POST[Reply]', ReplyDate='$_POST[replydDate]',ReplyPersonID='$_SESSION[UserID]' WHERE FeedBackID='$_POST[FeedBackID]'";
        $DB->runQuery($sql);

        $newPage = new Page('..\view\feedback\replysuccess.html');
        $newPage->show();

    } catch (\Throwable $th) {
        throw $th;
    }

}

//--------------------------------------------------------edit-profile--------------------------------------------------------
if(isset($_POST['edit-profile'])){
    $DB = new DB;
    
    //--------------------------------------------------------upload-profile-picture-------------------------------------------------------
   if(isset($_FILES['image'])){
      $errors= array();
      $file_name = $_FILES['image']['name'];
      $file_size = $_FILES['image']['size'];
      $file_tmp = $_FILES['image']['tmp_name'];
      $file_type = $_FILES['image']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
      
      $extensions= array("jpeg","jpg","png");
      
      if(in_array($file_ext,$extensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      }
      
      if($file_size > 2097152) {
         $errors[]='File size must be excately 2 MB';
      }
      
      if(empty($errors)==true) {
            // move_uploaded_file($file_tmp,"images/".$file_name);
            $image = $_FILES['image']['tmp_name']; 
            $imgContent = addslashes(file_get_contents($image)); 
            
            // Insert image content into database 
            $result = $DB->runQuery("UPDATE plunk.user SET ProfilePic='$imgContent' WHERE UserID=$_POST[UserID]"); 
      }else{
         print_r($errors);
      }
   }
    try {
        $sql = "UPDATE plunk.user SET Name='$_POST[Name]', ContactNo='$_POST[ContactNo]',Email='$_POST[Email]', UserName='$_POST[UserName]' WHERE UserID='$_POST[UserID]'";
        $DB->runQuery($sql);
        
        $newPage = new Page('..\view\profile\prfileui.php');
        $newPage->show();
        
    } catch (\Throwable $th) {
        throw $th;
    }
}

//--------------------------------------------------------update-password--------------------------------------------------------
if (isset($_POST['update-password'])){
    $DB = new DB;
    $query = "SELECT * FROM plunk.user WHERE UserID=$_SESSION[UserID]";
    $result = $DB->runQuery($query)[0];

    if (count($_POST) > 0) {
        $verify = password_verify($_POST["currentPassword"], $result["Password"]);
        $confirm = ($_POST["newPassword"] == $_POST["confirmPassword"]);

        if (!$verify){
            $message = "Current Password is not correct";
        }
        if (!$confirm){
            $message = "Password confirmation doesn't match the password";
        }
        if (!$verify and !$confirm){
            $message = "Current Password is not correct
            Password confirmation doesn't match the password";
        }
        if ($verify and $confirm) {
            $hashedpassword = Password_hash("$_POST[newPassword]", PASSWORD_BCRYPT);
            $result = $DB->runQuery("UPDATE plunk.user set password='" . $hashedpassword . "' WHERE userId=$_SESSION[UserID]");
            // print_r($_POST['newPassword']);
            $message = "Password Changed";
        }
        $pageURL = '..\view\profile\change_password.php?msg=' . $message;
        $newPage = new Page($pageURL);
        $newPage->show();
    }
}
?>

