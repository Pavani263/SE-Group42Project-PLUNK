<?php 
session_start();
require_once "../../model/database.php";
$DB = new DB;
$query = "SELECT * FROM plunk.user WHERE UserID=$_SESSION[UserID]";
$result = $DB->runQuery($query)[0];
// print_r($result);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>

        <meta charset="utf-8">
        <title>Bloomfield</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,height=device-height, initial-scale=1">
        <link rel="icon" type="icon" href="../images/bloomfieldlogo.png" sizes="32*32">
        <link rel="stylesheet" href="../style/profile.css">



  </head>
  <body>
    <div class="main">
        <div class="profformbox">
          <form class="profform" action="../../controller/CRUD.php" method="POST" enctype = "multipart/form-data">
          <input type="hidden" name="edit-profile">
          <input type="hidden" name="UserID" value="<?php print_r($result['UserID'])?>" >
          <div class="imagebox">
            <input type="file" accept="image/*" name="image" id="file" onchange="loadFile(event)" style="display: none;">

            <?php 
            if($result['ProfilePic'] != NULL){
              echo '<img id="output" alt="No Profile Picture" src="data:image/jpeg;base64,'.base64_encode($result['ProfilePic']).'"/>';
            }else{
              echo '<img id="output" src="../images/profile.png" alt="profile icon">';
            }
            ?>
            <label for="file" class="upload"><b>Upload Image</b> </label>

            <script>
            var loadFile = function(event) {
            	var image = document.getElementById('output');
            	image.src = URL.createObjectURL(event.target.files[0]);
            };
            </script>

          </div><br>
          <div class="forminputs">
            <label for="">Name with initials :</label>
            <input type="text" name="Name" value="<?php print_r($result['Name'])?>" >
          </div><br>
          <div class="forminputs">
            <label for="">Contact No :</label>
            <input type="tel" name="ContactNo" value="<?php print_r($result['ContactNo'])?>" >
          </div><br>
          <div class="forminputs">
            <label for="">E-mail :</label>
            <input type="email" name="Email" value="<?php print_r($result['Email'])?>" >
          </div><br>
          <div class="forminputs">
              <label for="UserName"> User Name :</label>
              <input type="text" id="UserName" name="UserName" maxlength="50" value="<?php print_r($result['UserName'])?>" >
          </div><br>
          <div class="forminputbtn">
            <button type="submit" name="button" class="save"><b>Save</b> </button>
          </div>
          </form>

        </div>

        </div>
    </body>
</html>
