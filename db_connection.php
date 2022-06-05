<?php
$conn = new mysqli("localhost", "root", "", "exceldbase");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
?>