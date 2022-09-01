<?php

include "dbConnect.php";
session_start();

$id = $_SESSION['User_id'];

$id = $_POST['userId'];

$query = mysqli_query($base,"UPDATE `person` SET `Admin`='1' WHERE `User_id`='$id'");
echo 0;