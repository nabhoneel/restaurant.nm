<?php

$quantity = $_GET["q"];
$id = $_GET["id"];

include 'connection.php';

$query = "SELECT `name`, `cost` FROM menu WHERE `id`=".$id;
$results = $mysqli->query($query);
while($row=$results->fetch_assoc())
{
    $cost = $row["cost"];
    $name = $row["name"];

    ?>
    <div class="col-sm-10 finalOrderItem"><?php echo $name; ?></div>
    <div class="col-sm-2 finalOrderItem"><?php echo $cost; ?></div>
    <?php
}

?>
