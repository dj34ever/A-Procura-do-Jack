<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$dbUser = "david_web";
$dbPass = "T8L6KlQlAN";
$dbDatabase = "david_dicas";
$dbHost = "localhost";


$dbConn = mysqli_connect($dbHost, $dbUser, $dbPass);
if ($dbConn) {
    mysqli_select_db($dbConn, $dbDatabase);
} else {
    die(printf(mysqli_connect_errno()));
}

?>