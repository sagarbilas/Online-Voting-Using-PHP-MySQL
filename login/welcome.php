<?php
session_start();

if (!$_SESSION['email']) {
    header("Location: login.php");//redirect to login page to secure the welcome page without login access.
}
?>

<html>
<head>
    <link rel="stylesheet" href="poll.css" type="text/css"/>
    <title> Registration </title>
</head>


<body>
<!--<h1>Welcome To The Voting pool</h1>-->

<?php
//echo "<b>your are logged in with email: </b>" . $_SESSION['email'];
//echo "<br>";
?>


<?php
$dbcon = mysqli_connect("localhost", "root", "");
mysqli_select_db($dbcon, "votingpoll_myself1");

//GET WITH WHIH EMAIL ADDRESS THE USER HAS LOGGED IN
$loggedin_email = $_SESSION['email'];
//echo "$loggedin_email";



//CHECK WHETHER THE USER HAVE ALREADY VOTED OR NOT
$query = "select login_email from users_voted_already ";
$result = mysqli_query($dbcon, $query);
$rows = array();

while ($query_row = mysqli_fetch_assoc($result)) {
    $rows[] = $query_row;
}

$login_emails = array_column($rows, 'login_email');
//echo "login_emails = ". $rows["login_email"]. "<br>";

if (in_array($loggedin_email, $login_emails)) {
    $flag = 1;
    // echo "The value of Flag present: " . "$flag" . "<br>";
} else {
    $flag = 0;
    // echo "The value of Flag: " . "$flag" . "<br>";
}


$val = "select gr, re, ye from count_tbl";
$query = mysqli_query($dbcon, $val);
$row = mysqli_fetch_assoc($query);

$green = $row['gr'];
$red = $row['re'];
$yellow = $row['ye'];

if (isset($_POST["submit"])) {

    //echo "<br> checking for : " . $query_row['login_email'] . " email address";
    if ($flag != 1) {

        if ($_POST['color'] == 'green') {
            $green += 1;
            $query = "UPDATE count_tbl SET gr='" . $green . "'";
            mysqli_query($dbcon, $query);
            //echo "<br> Congrats. you have voted for Green <br>";
            echo "<script>alert('Congrats! You have voted for Green')</script>";

            $query = "INSERT INTO users_voted_already (login_email) VALUES ( '$loggedin_email');";
            mysqli_query($dbcon, $query);

            $q2 = "INSERT INTO vote_track (vote_email, vote_color) VALUES ( '$loggedin_email','Green');";
            mysqli_query($dbcon, $q2);
        }

        if ($_POST['color'] == 'red') {
            $red += 1;
            $query = "UPDATE count_tbl SET re='" . $red . "'";
            mysqli_query($dbcon, $query);
            //echo "<br>Congrats. you have voted for Red <br>";
            echo "<script>alert('Congrats! You have voted for Red')</script>";

            $query = "INSERT INTO users_voted_already (login_email) VALUES ( '$loggedin_email');";
            mysqli_query($dbcon, $query);

            $q3 = "INSERT INTO vote_track (vote_email, vote_color) VALUES ( '$loggedin_email','Red');";
            mysqli_query($dbcon, $q3);
        }

        if ($_POST['color'] == 'yellow') {
            $yellow += 1;
            $query = "UPDATE count_tbl SET ye='" . $yellow . "'";
            mysqli_query($dbcon, $query);
            //echo "<br>Congrats. you have voted for yellow <br>";
            echo "<script>alert('Congrats! You have voted for yellow')</script>";

            $query = "INSERT INTO users_voted_already (login_email) VALUES ( '$loggedin_email');";
            mysqli_query($dbcon, $query);

            $q4 = "INSERT INTO vote_track (vote_email, vote_color) VALUES ( '$loggedin_email','Yellow');";
            mysqli_query($dbcon, $q4);
        }
    } else {
        //echo "<br>you can't vote twice<br>";
        echo "<script>alert('you can not vote twice')</script>";
    }
}
?>


<form class="poll" action='welcome.php' method='POST'>


    <p class="question"><b>What is Your Favourite Color?</b></p>
    <p class="txt" >
        <?php

        //TO PRINT THE USERNAME OF LOGGED ON USER
        $qu = "select user_name from users where user_email = '$loggedin_email' ";
        $res = mysqli_query($dbcon, $qu);

        if (mysqli_num_rows($res) > 0) {
            // output data of each row
            while ($row2 = mysqli_fetch_assoc($res)) {
                echo "<br>username: " . $row2["user_name"] . "  ";
            }
        } else {
            echo "you are not loggin in";
        }
        echo "<br>";



        //TO PRINT THE COLOR THAT THE USER HAVE ALREADY VOTED
        $q5 = "select vote_color from vote_track where vote_email = '$loggedin_email' ";
        $res5 = mysqli_query($dbcon, $q5);

        if (mysqli_num_rows($res5) > 0) {
            // output data of each row
            while ($row5 = mysqli_fetch_assoc($res5)) {
                echo "you have already voted: " . $row5["vote_color"];
            }
        } else {
            echo "you have not voted yet";
        }
        ?>

    </p>


    <fieldset>

        <ul>
            <li>
                <label class='poll_active'>
                    <input type='radio' name='color' value='green'>
                    Green
                </label>
            </li>

            <li>
                <label class='poll_active'>
                    <input type='radio' name='color' value='red'>
                    Red
                </label>
            </li>

            <li>
                <label class='poll_active'>
                    <input type='radio' name='color' value='yellow'>
                    Yellow
                </label>
            </li>
        </ul>

        <!--        <input type="radio" name="color" value="green"> Green<br>-->
        <!--        <input type="radio" name="color" value="red"> Red<br>-->
        <!--        <input type="radio" name="color" value="yellow"> Yellow-->

    </fieldset>
    <br/>
    <p class="buttons">
        <button type="submit" class="vote" name='submit'>Vote</button>&nbsp;
        <input type="button" value="View Result" class="view-result"
               onClick="document.location.href='view-result.php'"/>
        <br><br>
        <input type="button" value="Logout" class="logout" onClick="document.location.href='logout.php'"/>
    </p>

    <!--    <p class="buttons">-->
    <!--    <br/><input class="vote" type='submit' name='submit' value='Vote'/><br/>-->
    <!--    </p>-->
</form>


<!--<h4><a href="view-result.php">View Result</br></br></br></br></br></a></h4>-->
<!--<h2><a href="logout.php">Logout</a></h2>-->


</body>

</html>

