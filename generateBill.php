<?php
session_start();

include 'connection.php';

$mode = $_COOKIE["mode"];
$amount = $_COOKIE["total"];
$username = $_SESSION["username"];
$location = $_SESSION["area"];

$mysqli->query("INSERT INTO `orders` (`customer name`, `location`, `amount`, `paymode`) VALUES ('$username', '$location', '$amount', '$mode');");

$r1 = $mysqli->query("SELECT max(`id`) AS 'Max' FROM `orders`");
$row = $r1->fetch_assoc();
$orderid = $row["Max"];

$items = array();
$r2 = $mysqli->query("SELECT `id`, `cost` FROM `menu` ORDER BY `id`");
while($row = $r2->fetch_assoc())
    $items[$row["id"]] = $row["cost"];

for($i=1; $i<=20; $i++)
{
    if((int)$_COOKIE["id".$i]>0)
    {
        $item_query = "INSERT INTO `items` (`order id`, `item id`, `cost`, `quantity`) VALUES (".(int)$orderid.",".(int)$i.",".(int)$items[$i].",".(int)$_COOKIE["id".$i].")";

        $mysqli->query($item_query);
    }
}

header("Location: menu.php?orderPlaced=yes");

?>
