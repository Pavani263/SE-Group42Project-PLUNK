<!DOCTYPE html>
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
                    <h2>GRN</h2>
              </div>
            </div>
            <div class="covertable">
                <div class="table">
                    <div class="upperbar">
                        <div class="search">
                              <input placeholder="Enter the company name"/>
                              <button type = "Submit" class= "submit">Search</button>
                        </div>               
                        <div class="addicon">
                              <a href="../grn/addgrn.html" class="add"><button type="button" name="button" class="addbtn"><b>+</b></button></a>
                        </div>
                    </div>
                    <div >
                    <?php
                        require_once "../../controller/showtable.php";
                        $grnTable = new Table("grn");
                        $grnTable->show("SELECT * FROM plunk.grn", false);
                      ?>
                    </div>    

                </div>

            </div>


        </div>

  </body>
</html>


