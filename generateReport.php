<?php
session_start();
include 'connection.php';
?>

<?php

$startDate = $_GET["start"];
$endDate = $_GET["end"];
$results = $mysqli->query("SELECT * FROM `orders` WHERE date(`date`) >= \"$startDate\" AND date(`date`) <= \"$endDate\" AND `customer name` = \"".$_SESSION["username"]."\";");
?>
<table class="table table-hover">
    <thead>
      <tr>
        <th>Order ID</th>
        <th>Date</th>
        <th>Area</th>
        <th>Payment Mode</th>
        <th>Total Amount</th>
      </tr>
    </thead>
        <tbody>
            <?php
            $counter = 0;
            while($rows = $results->fetch_assoc())
            {
                echo "<tr>";
                $d = explode(" ", $rows["date"]);
                echo "<td>".++$counter."</td><td>".$d[0]."</td><td>".$rows["location"]."</td><td>".$rows["paymode"]."</td><td>".$rows["amount"]."&nbsp;";
            ?>
            <button data-toggle="collapse" data-target=<?php echo "\"#items$counter\"" ?>><span class="glyphicon glyphicon-list-alt"></span></button></td></tr>
            <tr><td colspan=5><div id=<?php echo "\"items$counter\"" ?> class="collapse">
                <?php
                $item_results = $mysqli->query("SELECT `menu`.`name`, `items`.`cost`, `items`.`quantity` FROM `items`, `menu` WHERE `items`.`item id` = `menu`.`id` AND `items`.`order id` = ".$rows["id"].";");
                ?>
                <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Item Name</th>
                        <th>Unit Price</th>
                        <th>Quantity</th>
                      </tr>
                    </thead>
                    <?php
                    while($item_rows = $item_results->fetch_assoc())
                    {
                        echo "<tr><td>".$item_rows["name"]."</td><td>".$item_rows["cost"]."</td><td>".$item_rows["quantity"]."</td></tr>";
                    }
                    ?>
                </table>
            </div></td></tr>
            <?php } ?>
        </tbody>
</table>

<script>
<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();
});
</script>
</script>
