<?php

include 'connection.php';

$whichUser = $_POST["id"];
$username = $_POST["username"];
$query = "SELECT * from ".$whichUser." WHERE `username` = \"".$username."\"";

$result = $mysqli->query($query);
if($result->num_rows > 0)
{
    $row = $result->fetch_assoc();
    if($_POST["password"] == $row["password"])
    {
        session_start();
        $_SESSION["verification"] = "true";
        $_SESSION["username"] = $username;
        $_SESSION["name"] = $row["name"];
        $_SESSION["area"] = $row["area"];
        $_SESSION["address"] = $row["home address"];
        $_SESSION["contact"] = $row["contact number"];
        $_SESSION["premium status"] = $row["premium status"];
        $_SESSION["user"] = "customer";
        header("Location: menu.php");
    }
    else displayError($whichUser, 1);
}
else displayError($whichUser, 2);

function displayError($whichUser, $status)
{
    if($whichUser == "customers") header("Location: index.php?tab=login&status=".$status);
    else header("Location: index.php?tab=member&status=".$status);
}
?>
