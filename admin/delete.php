<?php
// Include the database connection file
require_once("koneksi.php");

// Get id parameter value from URL
$id = $_GET['id'];
echo "hi";
// Delete row from the database table
$result = mysqli_query($conn, "DELETE FROM books WHERE id = $id");

// Redirect to the main display page 
header("Location:homeadmin.php");