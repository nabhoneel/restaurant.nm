<?php include 'connection.php';?>
<?php

$q = "SELECT SUM(`amount`) AS 'sum', WEEK(`date`) AS `week` FROM `orders` GROUP BY CONCAT(YEAR(`date`), '/', WEEK(`date`))";

$result = $mysqli->query($q);
//printf("%d rows", $result->num_rows);

$data = array();
foreach($result as $row)
    $data[] = $row;

$result->close(); $mysqli->close();

print json_encode($data);
?>
