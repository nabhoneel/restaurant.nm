<?php

include 'connection.php';

$username = $_POST["username"];
$password = $_POST["password"];
$name = $_POST["name"];
$area = $_POST["area"];
$home = $_REQUEST["homeaddress"];
$contact = $_REQUEST["contactnumber"];

$query = "INSERT INTO customers (`username`, `password`, `name`, `area`, `home address`, `contact number`, `premium status`)";
$query .= " values (\"$username\", \"$password\", \"$name\", \"$area\", \"$home\", \"$contact\", \"false\");";

if($mysqli->query($query) === TRUE)
{
    session_start();
    $_SESSION["verification"] = "true";
    $_SESSION["name"] = $name;
    $_SESSION["area"] = $area;
    $_SESSION["premium status"] = "false";
    $_SESSION["user"] = "customer";
    $_SESSION["username"] = $username;
    $_SESSION["address"] = $home;
    $_SESSION["contact"] =$contact;
    $_SESSION["premium status"] = "false";
    $_SESSION["user"] = "customer";

    header("Location: menu.php");
}
else displayError(3);

function displayError($status)
{
    header("Location: index.php?tab=register&status=".$status);
}
?>
