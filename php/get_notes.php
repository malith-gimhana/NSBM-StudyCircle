<?php
include "db.php";

$sql = "SELECT id, title, subject, description, file_name
        FROM notes
        ORDER BY id DESC";

$result = $conn->query($sql);
?>