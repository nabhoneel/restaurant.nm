<?php session_start(); ?>

<html lang="en">
<head>
  <title>Menu | CalUniv Restaurant</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/custom_profile.css">
  <script src="./js/jquery.min.js"></script>
  <script src="./js/bootstrap.min.js"></script>
</head>

<div class="outer">
    <div class="middle">
        <div class="inner">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <h2><?php echo $_SESSION["name"]; ?>'s Profile</h2>
                        <h3>Area: <?php echo $_SESSION["area"]; ?></h3>
                        <h3>Address: <?php echo $_SESSION["address"]; ?></h3>
                        <h3>Contact: <?php echo $_SESSION["contact"]; ?></h3>
                        <button type="button" class="btn btn-info" onclick="goBack()"><span class="glyphicon glyphicon-arrow-left"></span> Go back to Menu</button>
                    </div>
                    <div class="col-sm-3">
                        <h3>Start Date</h3><input type="date" id="start">
                    </div>
                    <div class="col-sm-3">
                        <h3>End Date</h3><input type="date" id="end">
                    </div>
                    <div class="col-sm-6 btn-group">
                        <button type="button" class="btn btn-info btn-lg pay" data-toggle="modal" data-target="#myModal" onclick="createReport()">
                            <span class="glyphicon glyphicon-th-list"></span> Get order history
                        </button>
                        <button type="button" class="btn btn-info btn-lg pay" data-toggle="modal" data-target="#mySales">
                            <span class="glyphicon glyphicon-th-list"></span> Get overall sales report (by weeks)
                        </button>
                    </div>
                </div>
                <div id="myModal" class="modal fade" role="dialog">
                  <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Order History</h4>
                      </div>
                      <div class="modal-body" id="modal-body">
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="mySales" class="modal fade" role="dialog">
                  <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Sales analysis</h4>
                      </div>
                      <div class="modal-body" id="sales-modal-body">
                          <?php include 'generateSalesReport.php'; ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function createReport()
{
    //window.alert(document.getElementById('start').value + document.getElementById('end').value);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("modal-body").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "generateReport.php?start=" + document.getElementById('start').value + "&end=" + document.getElementById('end').value, true);

    xmlhttp.send();
    //window.alert(document.getElementById('start').value + document.getElementById('end').value);
}

function goBack() {
    window.history.back();
}
</script>
