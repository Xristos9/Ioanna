<?php

include "dbConnect.php";
session_start();

$id = $_SESSION['User_id'];

$new = $_POST['newUsername'];
$result2 = mysqli_query($base,"UPDATE person SET Username='$new' WHERE User_id='$id'");
$_SESSION['username'] = $new;
echo 0;
