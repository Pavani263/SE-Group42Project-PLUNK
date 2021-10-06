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
                    <h2>Bill</h2>
              </div>
            </div>
            <div class="covertable">
                <div class="table">
                    <div class="upperbar">
                        <form method="POST" action="details.php">
                              <input type="text" name="billsearch" class="search" placeholder="Search..." >
                              <button type="submit" target="staff">Search</button>
                        </form>
                          <div class="addicon">
                                <a href="add.html" class="add"><button type="button" name="button" class="addbtn"><b>+</b></button></a>
                          </div>
                    </div>
                    <div class="detailtable">

                            <iframe src="details.php" class="staff"></iframe>
                    </div>

                </div>

            </div>


        </div>

  </body>
</html>
