<?php
$host = "localhost"; //địa chỉ mysql server sẽ kết nối đến
$dbname="asm_php1"; //tên database sẽ kết nối đến
$username = "root"; //username để kết nối đến database 
$password = ""; // mật khẩu để kết nối đến database
$conn = new PDO("mysql:host=$host; dbname=$dbname; charset=utf8", $username, $password);  // kết nối đến database. $conn gọi là đối tượng kết nối.