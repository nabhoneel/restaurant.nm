<html lang="en">
<head>
  <title>CalUniv Restaurant</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <script src="./js/jquery.min.js"></script>
  <script src="./js/bootstrap.min.js"></script>

  <style>
  .outer {
    display: table;
    height: 100%;
    width: 100%;
    }

    .middle {
        display: table-cell;
        vertical-align: middle;
    }

    .inner {
        margin: auto;
        padding: auto;
        width: 100%; /*whatever width you want*/
    }

    .container {
        top: 0;
        width: 35em;
    }
  </style>

  <script language="javascript">
    function loadAreas()
    {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("area").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("POST", "getAreas.php", true);
        xmlhttp.send();
    }

  </script>
</head>

<?php
$status = "";
$tab = "login";
$previousPage = "";

if(isset($_GET["previous"]))
    $previousPage = $_GET["previous"];
if(!empty($_GET) && (isset($_GET["status"]) || isset($_GET["tab"])))
{
    $status = $_GET["status"];
    $tab = $_GET["tab"];
}

function generateErrorMessage($message)
{
    ?>
    <p align=center class="text-danger"><kbd><?php echo $message; ?></kbd></p>
    <?php
}
?>

<body onload="loadAreas();">
<div class="outer">
  <div class="middle">
    <div class="inner">
        <div class="container">
          <?php if(!($previousPage == "")) echo "<center><div class=\"alert alert-warning alert-dismissable\">You need to sign in first!</div></center>"; ?>
          <ul class="nav nav-tabs nav-justified">
            <?php if($tab == "login"){ ?><li class="active">
            <?php } else { ?><li><?php } ?>
            <a data-toggle="tab" href="#login">Login</a></li>
            <?php if($tab == "register"){ ?><li class="active">
            <?php } else { ?><li><?php } ?>
            <a data-toggle="tab" href="#register">Register</a></li>
            <!--<?php if($tab == "member"){ ?><li class="active">
            <?php } else { ?><li><?php } ?>
            <a data-toggle="tab" href="#memberLogin">Member Login</a></li>-->
          </ul>

          <div class="tab-content">

            <div id="login" class=<?php if($tab == "login") echo "\"tab-pane fade in active\""; else echo "\"tab-pane fade\""; ?>>
              <h3 align=center>Login</h3>
                  <form action="checkUser.php" method="post">
                  <input type=hidden value="customers" name="id">
                  <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" name="username">
                  </div>
                  <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" name="password">
                  </div>
                  <?php if($status == "1") generateErrorMessage("Incorrect password");
                        if($status == "2") generateErrorMessage("No account under that username exists"); ?>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>

            <div id="register" class=<?php if($tab == "register") echo "\"tab-pane fade in active\""; else echo "\"tab-pane fade\""; ?>>
                <h3 align=center>Create an account</h3>
                    <form action="createUser.php" method="post">
                    <div class="form-group">
                      <input type="text" class="form-control" name="username" placeholder="Username" required>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" name="password" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" name="name" placeholder="Name" required>
                    </div>
                    <div class="form-group" id="area">
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" name="homeaddress" placeholder="Home address" required>
                    </div>
                    <div class="form-group">
                      <input type="text" class="form-control" name="contactnumber" placeholder="Contact number" required>
                    </div>
                    <?php if($status == "3") generateErrorMessage("Sorry, that username already exists"); ?>
                    <center><button type="submit" class="btn btn-primary">Create my account!</button></center>
                  </form>
            </div>

            <!--<div id="memberLogin" class=<?php if($tab == "member") echo "\"tab-pane fade in active\""; else echo "\"tab-pane fade\""; ?>>
                <h3 align=center>Member's Login</h3>
                    <form action="checkUser.php" method="post">
                    <input type=hidden value="members" name="id">
                    <div class="form-group">
                      <label for="username">Username:</label>
                      <input type="text" class="form-control" name="username">
                    </div>
                    <div class="form-group">
                      <label for="password">Password:</label>
                      <input type="password" class="form-control" name="password">
                    </div>
                    <?php if($status == "1") generateErrorMessage("Incorrect password");
                          if($status == "2") generateErrorMessage("No account under that username exists"); ?>
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </form>
            </div>-->
          </div>
        </div>
    </div>
  </div>
</div>

</body>
</html>
