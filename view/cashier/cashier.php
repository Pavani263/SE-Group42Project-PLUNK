<?php session_start() ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>

        <meta charset="utf-8">
        <title>Bloomfield</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,height=device-height, initial-scale=1">

        <link rel="icon" type="icon" href="../images/bloomfieldlogo.png" sizes="32*32">
        <link rel="stylesheet" href="../style/user.css">
        <script type="text/javascript" src="../script/user.js"></script>
  </head>
  <body>
    <div class="main">

          <div class="header" id="myheader">
                  <div class="leftheader">

                   
                      <img class="plunk" src="../images/projectlogo.png" alt="plunk logo"><br>
                      <div class="menudiv">
                         <a href="navbtn.html" class="menubtn" target="navigation"><button type="button" name="Menu" class="Menu" onclick=myFunction() >&#9776;</button></a>

                      </div>
                  </div>

                  <div class="middleheader">

                      <h2>Bloomfield C. & A.C.</h2>

                      <h3>Cashier <?php echo $_SESSION['UserID'] ?></h3>
                  </div>

                  <div class="rightheader">
                      <button type="button" class="logout" name="Log out"><a href="../cover.html" class="linkbutton"> L<br>o<br>g<br>O<br>u<br>t </a></button>

                      <img class="Logo" src="../images/bloomfieldlogo.png" alt="Bloomfield Logo">

                      
                  </div>

          </div>
              <div class="middle">
                            <div id="panel" class=" panel">
                                <iframe id="navv"class="nav" name="navigation" title="iframe for nav"></iframe>
                            </div>

                            <div class="mainpages" id="mainpages">
                                    <iframe class="page" name="Pages"  title="Iframe for pages"></iframe>

                            </div>

                      </div>
              </div>
        </body>

</html>