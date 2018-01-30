<?php
session_start();
if(empty($_SESSION)) header("Location: http://localhost/restaurant.nm?previous=menu");
if(!($_SESSION["verification"] == "true")) header("Location: http://localhost/restaurant.nm?previous=menu");

$name = $_SESSION["name"];

function generateMenu()
{
    include 'connection.php';
    $query = "SELECT DISTINCT `type` FROM menu";

    $result = $mysqli->query($query);

    ?>
    <div class="panel-group" id="accordion">
    <?php
    while($row=$result->fetch_assoc())
    {
        $section = $row["type"];
        ?>
        <div class="panel panel-default">
         <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href= <?php echo "\"#$section\""?>>
            <?php echo $section?></a>
          </h4>
         </div>
        <div id=<?php echo "\"$section\""?> class="panel-collapse collapse">
          <div class="panel-body">
              <?php
              $items = $mysqli->query("SELECT `cost`, `id`, `name` FROM menu WHERE `type` = \"$section\"");
              while($x=$items->fetch_assoc())
              {
                  $id = $x["id"];
                  $cost = $x["cost"];
                  ?>
                  <div>
                      <div class="row">
                          <div class="col-sm-8">
                              <span class="item-name" id=<?php echo "\"name_".$id."\""; ?>><?php echo $x["name"]; ?></span>
                          </div>
                          <div class="col-sm-2">₹
                              <span class="badge" id=<?php echo "\"cost_".$id."\""; ?>><?php echo $cost; ?></span>
                          </div>
                          <div class="col-sm-2">
                              <button type="button" class="btn btn-info btn-lg circularbutton-small" onclick=<?php echo "\"increase($id)\"" ?>>
                                  <span class="glyphicon glyphicon-plus"></span>
                              </button>
                              <span class="badge" id=<?php echo "\"quantity_counter_$id\"" ?>>0</span>
                              <button type="button" class="btn btn-info btn-lg circularbutton-small" onclick=<?php echo "\"decrease($id)\"" ?>>
                                  <span class="glyphicon glyphicon-minus"></span>
                              </button>
                          </div>
                      </div>
                  </div>
                  <?php
              }
              ?>
          </div>
        </div>
      </div>
        <?php
    }
    echo "</div>";
}
?>

<html lang="en">
<head>
  <title>Menu | CalUniv Restaurant</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/custom.css">
  <script src="./js/jquery.min.js"></script>
  <script src="./js/bootstrap.min.js"></script>

  <script>
  // Get the modal
  var modal = document.getElementById('myModal');

  // Get the button that opens the modal
  var btn = document.getElementById("myBtn");

  // Get the <span> element that closes the modal
  var span = document.getElementsByClassName("close")[0];

    function proceed()
    {
        var output = "";
        var total = 0;
        for(var i=1; i<=20; i++)
        {
            if(parseInt(document.getElementById("quantity_counter_" + i).innerHTML) > 0)
            {
                output = output + "<div class=\"row\"><div class=\"col-sm-10 finalOrderItem\">" + document.getElementById("name_" + i).innerHTML + "</div><div class=\"col-sm-2 finalOrderItem\"><span class=\"badge\" style=\"width: 6.5em;\">" + parseInt(document.getElementById("quantity_counter_" + i).innerHTML) + " × ₹" + document.getElementById("cost_" + i).innerHTML + "</span></div></div>";

                total = total + parseInt(document.getElementById("quantity_counter_" + i).innerHTML) * parseInt(document.getElementById("cost_" + i).innerHTML);
            }
        }
        output = output + "<div class=\"row\"><div class=\"col-sm-10 finalOrderItem\"></div><div class=\"col-sm-2 finalOrderItem\"><span class=\"badge\" style=\"width: 6.5em;\">₹" + total + "</span></div></div><input type=\"hidden\" value=" + total + " id=total>";
        document.getElementById('modal-body').innerHTML = output;
        document.getElementById('myModal').style.display = "block";
    }

    function pay()
    {
        for(var i=1; i<=20; i++)
            document.cookie = "id" + i + "=" + document.getElementById("quantity_counter_" + i).innerHTML;
        document.cookie = "total=" + document.getElementById('total').value;
        if(document.getElementById("paymentmode").checked)
            document.cookie = "mode=online";
        else document.cookie = "mode=offline";
        window.location = "generateBill.php";
    }

    function close()
    {
        document.getElementById('myModal').style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event)
    {
        if (event.target == document.getElementById('myModal'))
        {
            document.getElementById('myModal').style.display = "none";
        }
    }

    function redirectToProfile()
    {
        window.location = "profile.php";
    }

    function increase(id)
    {
        var identity = "quantity_counter_" + id;
        if(parseInt(document.getElementById(identity).innerHTML) < 10)
            document.getElementById(identity).innerHTML = parseInt(document.getElementById(identity).innerHTML) + 1;
    }
    function decrease(id)
    {
        var identity = "quantity_counter_" + id;
        if(parseInt(document.getElementById(identity).innerHTML) > 0)
            document.getElementById(identity).innerHTML = parseInt(document.getElementById(identity).innerHTML) - 1;
    }

    function logout()
    {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                alert("You are being logged out" + xmlhttp.responseText);
            }
        };
        xmlhttp.open('GET','destroy_session.php', true);
        xmlhttp.send(null);
        window.location = "index.php";
    }
  </script>
</head>

<body>
    <div class="outer">
        <div class="middle">
            <div class="inner">
                <div class="container">
                    <div class="page-header">
                        <div class="row">
                            <div class="col-sm-10">
                            <h1>Welcome, <?php echo $_SESSION["name"]; ?>!</h1>
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-info btn-lg circularbutton" onclick="redirectToProfile()">
                                    <span class="glyphicon glyphicon-user"></span>
                                </button>
                                <button type="button" class="btn btn-info btn-lg circularbutton" onclick="logout()">
                                    <span class="glyphicon glyphicon-log-out"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php if(isset($_GET["orderPlaced"])) if($_GET["orderPlaced"] == "yes") echo "<center><div class=\"alert alert-success alert-dismissable\">Your order has been placed!<br>If you wish, you can place another order</div></center>"; ?>
                    <?php generateMenu(); ?>
                    <button type="button" class="btn btn-info btn-lg" onclick="proceed()" id="myBtn">
                        <span class="glyphicon glyphicon-cutlery"></span> Order!
                    </button>

                    <div id="myModal" class="modal">
                      <!-- Modal content -->
                      <div class="modal-content">
                        <div class="modal-header">
                          <center><h2>Your Order</h2></center>
                        </div>
                        <div class="modal-body" id="modal-body">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info btn-lg pay" onclick="pay()" id="myBtn">
                                <span class="glyphicon glyphicon-credit-card"></span> Pay
                            </button>
                            <label class="radio-inline"><input type="radio" name="optradio" id="paymentmode" checked>Online</label>
<label class="radio-inline"><input type="radio" name="optradio">Offline</label>
                        </div>
                      </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>
