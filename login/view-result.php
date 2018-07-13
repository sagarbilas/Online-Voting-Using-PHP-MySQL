<?php
include("database/db_conection.php");


$val = "select gr, re, ye from count_tbl";
$query = mysqli_query($dbcon, $val);
$row = mysqli_fetch_assoc($query);

$green = $row['gr'];
$red = $row['re'];
$yellow = $row['ye'];

//echo "<b>The Result is:</b> <br><br><br>";
//echo "<b>Number of Users Liked: </b><br> " . "Green Color: " . $green . "<br>"
//    . "Red Color: " . $red . "<br>"
//    . "yellow Color: " . $yellow . "<br>";
//
$total_votes = $green + $red + $yellow;
//echo "<br><br> Total number of votes:<br>" . $total_votes;
?>


<html>
    <head>
            <link rel="stylesheet" href="view-result.css" type="text/css"/>
    </head>
<body

<form class="resultForm" action='view-result.php' method='GET'>
    <fieldset>
        <h1>Result of Vote</h1>
    <h2 class="resultHeader">Colors Liked By Users: </h2>
        <p class="result-green" >Green Color: <?php echo "$green" ?> </p>
        <p class="result-red" >Red Color: <?php echo "$red" ?> </p>
        <p class="result-yellow" >Yellow Color: <?php echo "$yellow" ?> </p>
        <p class="result-total" ><b>Total Number of Users Voted:</b> <?php echo "$total_votes" ?> </p>

    </fieldset>
</form>

</body>
</html>

