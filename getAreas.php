<div class="form-group">
  <label for="sel1">Select area</label>
  <select class="form-control" id="sel1" name="area" placeholder="Area">

<?php

include 'connection.php';

$query = "SELECT `location` FROM areas";
$results = $mysqli->query($query);
if($results->num_rows > 0)
    while($row = $results->fetch_assoc())
    {
    ?>
        <option><?php echo $row["location"] ?></option>
    <?php
    }
else echo "<option>none</option>";

?>
  </select>
</div>
