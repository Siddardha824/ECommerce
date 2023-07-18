<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="../Shared/styles.css" rel="stylesheet">
</head>
<body class="bgcol">
<?php

    $upass1 = $_POST["upass1"];
    $upass2 = $_POST["upass2"];
    $uname = $_POST["uname"];
    $utype = $_POST["utype"];

    if ($upass1 != $upass2)
    {
        echo "<div><div class='regfail'>
            <div class='regfailtex'>Password Mismatch</div>
            <a class='btn btn-warning bagc mt-2' href='register.html'>Try again</a>
        </div></div>";
        die;
    }

    include_once "connection.php";

    $check =  mysqli_query($conn,"Select userID from users where User_Name = '$uname'");

    if(! $check)
    {
        echo "<div><div class='regfail'>
            <div class='regfailtex'>Registration Failed</div>
            <a class='btn btn-warning bagc mt-2' href='register.html'>Try again</a>
            <div>";
        echo mysqli_error($conn);
        echo "</div></div></div>";
        die;
    }

    if($check->num_rows > 0)
    {
        echo "<div><div class='regfail'>
                <div class='regfailtex'>User Name already in use. Use another user name</div>
                <a class='btn btn-warning bagc mt-2' href='register.html'>Try again</a>
            </div></div>";
        die;
    }

    $status =  mysqli_query($conn,"Insert into users(User_Name,Password,UserType) values('$uname','$upass1','$utype')");

    if($status)
    {
        echo "<div><div class='regsucc'>
            <div class='regsucctex'>Registration Success</div>
            <a class='btn btn-success bagc mt-2' href='login.html'>Login</a>
        </div></div>";
    }
    else
    {
        echo "<div><div class='regfail'>
            <div class='regfailtex'>Registration Failed</div>
            <a class='btn btn-warning bagc mt-2' href='register.html'>Try again</a>
            <div>";
        echo mysqli_error($conn);
        echo "</div></div></div>";
    }

?>
</body>
</html>