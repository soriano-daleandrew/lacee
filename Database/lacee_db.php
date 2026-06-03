<?php
$HOST = 'localhost';
$USER = 'root';
$PASS = '';
$DATA = 'lacee_db';

$connect = mysqli_connect($HOST, $USER, $PASS, $DATA);

if (!$connect) {
    die('[SERVER] Error: ' . mysqli_connect_error());
}