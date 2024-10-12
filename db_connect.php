<?php 

$conn= new mysqli('localhost','root','','house_rental_latest')or die("Could not connect to mysql".mysqli_error($con));

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
