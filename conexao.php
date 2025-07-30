<?php

session_start();

$conn = mysqli_connect("localhost", "root", "", "cadastro");

if (!$conn) {
    die("mãezinha!! " . mysqli_connect_error());
}
?>