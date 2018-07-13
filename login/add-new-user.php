<?php
include("database/db_conection.php");

if(isset($_POST['reg']))
{if($_POST['un']=="" || $_POST['pwd']=="" || $_POST['email']=="" )
{
    $err="fill your user name first";
}
else
{
    $r=mysqli_query($dbcon,"SELECT * FROM users where user_name='{$_POST['un']}'");
    $t=mysqli_num_rows($r);
    if($t)
    {
        $err="user <b>". $_POST['un'] ." </b>already exists. Please choose user with different username<br><br>";
        echo "$err";
    }
    else
    {
        $sql = "INSERT INTO users values('','{$_POST['un']}','{$_POST['pwd']}','{$_POST['email']}')";

        if ($dbcon->query($sql) == TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $dbcon->error;
        }
    }
}
}
?>





<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>registration</title>
</head>
<body>

<form method="post" >
    <table >
        <tr>
            <td >Enter Your User Name </td>
            <td ><input type="text" name="un"/></td>
        </tr>
        <tr>
            <td >Enter Your Password </td>
            <td><input type="password" name="pwd"/></td>
        </tr>
        <tr>
            <td >Enter Your Email </td>
            <td><input type="text" name="email"/></td>
        </tr>

        <tr>
            <td align="center" colspan="2">
                <input type="submit" name="reg" value="Register"/>
        </tr>
    </table>
</form>


</body>
</html>
