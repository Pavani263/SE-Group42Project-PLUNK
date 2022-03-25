<!-- <!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>

        <meta charset="utf-8">
        <title>Bloomfield</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="icon" href="images/bloomfieldlogo.png" sizes="32*32">
        <link rel="stylesheet" href="../style/stafftable.css">

  </head>
  <body>
        <div class="main" >
            <div class="coverheader">

              <div class="tableheader">
                    <div class="innerdiv">
                    </div>
                    <h2>Payment</h2>
              </div>
            </div>
            <div class="covertable">
                <div class="table">
                    <div class="upperbar">
                    <div >
                              <select id="PaymentType" name="PaymentType" class="search" placeholder="Select payment type" onchange="changeType(this);">
                                    <option selected>Choose payment type...</option>
                                    <option value="Cash">Cash Payment</option>
                                    <option value="Card">Card Payment</option>
                              </select>
                  </div>
                    <div >
                              <button type = "submit" class = "search" ><b>Search</b></button>
                        </div>
                          
                        <div class="addicon">
                              <a href="../payment/add.php" class="add"><button type="button" name="button" class="addbtn"><b>+</b></button></a>
                        </div>        
                    </div>
                    <div class="detailtable">

                            <iframe src="paymenttable.php" class="staff"></iframe>
                    </div>

                </div>

            </div>


        </div>

  </body>
</html> -->

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>

        <meta charset="utf-8">
        <title>Bloomfield</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="icon" href="images/bloomfieldlogo.png" sizes="32*32">
        <link rel="stylesheet" href="../style/stafftable.css">
        <script type="text/javascript">
            function isEmpty(){
                var search = document.getElementById("paymentsearch");
                // console.log(search.value);
                if (search.value.length){
                    return true;
                }
                else{ return false; }
            }
        </script>
  </head>
  <body>
        <div class="main" >
            <div class="coverheader">

              <div class="tableheader">
                    <div class="innerdiv">
                    </div>
                    <h2>Payments</h2>
              </div>
            </div>
            <div class="covertable">
                <div class="table">
                  <div class="upperbar">
                  <form method="POST" action="paymentpage.php" onclick = "return isEmpty()">
                        <input type = "text" name="paymentsearch" class = "search" placeholder="Enter the payment type"/>
                        <button type = "submit" class = "search" ><b>Search</b></button>
                  </form>
                  <div class="addicon">
                                <a href="add.php" class="add"><button type="button" name="button" class="addbtn"><b>+</b></button></a>
                          </div>
                         
                    </div>
                    <div class="detailtable">
                    <?php 
                         //print_r($_POST['paymentsearch']);
                        if(isset($_POST['paymentsearch'])){
                              echo '<iframe src="paymenttable.php?paymentsearch=' . $_POST['paymentsearch'] . '" name="searchinfo" class="staff"></iframe>';
                        }
                        else{
                              echo '<iframe src="paymenttable.php" name="searchinfo" class="staff"></iframe>';
                        }
                  ?>
                    </div>

                </div>

            </div>


        </div>

  </body>
</html>
