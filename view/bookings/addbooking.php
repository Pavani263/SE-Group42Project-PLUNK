<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>

        <meta charset="utf-8">
        <title>Bloomfield</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="icon" href="../images/bloomfieldlogo.png" sizes="32*32">
        <link rel="stylesheet" href="../style/addbooking.css">

  </head>
  <body>
    <?php

    session_start();
    require "../../model/database.php";
    $DB = new DB;
    $query = "SELECT * FROM plunk.user WHERE UserID=$_SESSION[UserID]";
    $result = $DB->runQuery($query)[0];


      date_default_timezone_set("Asia/Kolkata");
     ?>

        <div class="main" >
            <div class="header">
              <div class="upperrow"></div>
              <h2>Restaurant Bookings</h2>

            </div><br>
            <form class="addbooking" action="..\..\controller\CRUD.php" method="post" autocomplete="on" >
              <input type="hidden" name="addbook">

              <div class="submain">
                <input type="hidden" name="UserID" value="<?php echo($result['UserID'])?>">
                <div class="questions">

                        <label for="CreatedDate">Date :</label>
                        <input type="date" name="CreatedDate" id="today" value="<?php echo date("Y-m-d") ?>" readonly>

                </div><br>
                <div class="questions">
                  <label for="type">Booking Type   :</label>
                  <input type="text" name="BookingType" id="type" value="Restaurant" readonly>

                </div><br>
                  <div class="questions">
                      <label for="name">Name :</label>
                      <input type="text" name="CustomerName" value="<?php echo($result['Name'])?>"required>
                  </div><br>

                  <div class="questions">
                      <label for="reservation1">Reservation  :</label>
                      <input type="text" name="Reservation" id="ReservationName" autocomplete="off" readonly required>
                  </div><br>
                  <div class="questions">
                      <label for="reservation1">Price  :</label>
                      <input type="text" name="Total" id="Cost" readonly required>
                  </div><br>


                  <div class="questions">
                        <label for="NoOfPeaople">No of People:</label>
                        <input type="number" name="NoOfPeaople" min="1" value="1" required>
                  </div><br>
                  <div class="questions">
                        <label for="date">Reserved Date :</label>
                        <input type="date" name="ReservedDate" min="<?php echo date("Y-m-d") ?>" value="<?php echo date("Y-m-d") ?>" required>
                  </div>
                  <div class="questions">
                    <p class=" tips">Please enter between 05.00 p.m and 10.30 p.m</p>
                        <label for="time">Reserved Time:</label>
                        <input type="time" name="ReservedTime" min="17:00" max="22:30" value="<?php echo date("H:i") ?>" required>

                  </div>
                  <div class="questions">
                    <p class=" tips">Please enter between 05.30 p.m and 11.00 p.m</p>
                        <label for="EndTime">End Time :</label>
                        <input type="time" name="EndTime" min="17:30" max="23:00" required>

                  </div><br>
                  <div class="questions">
                        <label for="contactno">Contact No :</label>
                        <input type="tel" name="ContactNo" value="<?php echo($result['ContactNo'])?>" required>
                  </div><br>

                </div>
                <div class="line3">
                  <button type="submit" name="button" class="add" ><b>Add</b> </button>
                  <button type="reset" name="button"   class="add"><b>Reset</b> </button>

                </div>


            </form>
            <div class="holidaytable">
              <h3 class="ReservationMenu">Holidays</h3>
              <table id="table1" >
                <tr>
                  <th>Date</th>
                  <th>Reason</th>

                </tr>

              <?php
              require '..\..\model\bookingdatabaseconnection.php';
              $today= date("Y-m-d");
              $days = mysqli_query($conn,"SELECT Holiday,Reason FROM plunk.holidays WHERE Type ='Restaurant'or Type ='Restaurant and Club' AND Holiday>=$today ");
              while($data = mysqli_fetch_array($days))
              {
              ?>
                <tr>
                  <td><?php echo $data['Holiday']; ?></td>
                  <td><?php echo $data['Reason']; ?></td>

                </tr>
              <?php
              }
              ?>
              </table>

              <?php mysqli_close($conn); // Close connection ?>
              <script>

                              var table = document.getElementById('table1');

                              for(var i = 1; i < table.rows.length; i++)
                              {
                                  table.rows[i].onclick = function()
                                  {
                                       //rIndex = this.rowIndex;
                                       document.getElementById("Holiday").value = this.cells[0].innerHTML;
                                       document.getElementById("Reason").value = this.cells[1].innerHTML;
                                  };
                              }

                       </script>


            </div> <br>
            <div class="resevationtable">
              <h3 class="ReservationMenu">Reservation Menu</h3>
              <table id="table" >
                <tr>
                  <th>Reservation Name</th>
                  <th>Price</th>

                </tr>

              <?php
              require '..\..\model\bookingdatabaseconnection.php';
// C:\xampp\htdocs\project\SE-Group42Project-PLUNK\model\bookingdatabaseconnection.php
              $records = mysqli_query($conn,"SELECT * FROM plunk.reservationmenu WHERE Type ='Restaurant' AND Availability='Yes' and IsDeleted='No'");
              while($data = mysqli_fetch_array($records))
              {
              ?>
                <tr>
                  <td><?php echo $data['ReservationName']; ?></td>
                  <td><?php echo $data['Cost']; ?></td>

                </tr>
              <?php
              }
              ?>
              </table>

              <?php mysqli_close($conn); // Close connection ?>
              <script>

                              var table = document.getElementById('table');

                              for(var i = 1; i < table.rows.length; i++)
                              {
                                  table.rows[i].onclick = function()
                                  {
                                       //rIndex = this.rowIndex;
                                       document.getElementById("ReservationName").value = this.cells[0].innerHTML;
                                       document.getElementById("Cost").value = this.cells[1].innerHTML;

                                  };
                              }

                       </script>


            </div>
        </div>


  </body>
</html>
