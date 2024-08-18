<?php

include('connection.php');


$stmt = $conn ->prepare("SELECT *FROM products LIMIT 4");

$stmt->execute();

$featured_product= $result = $stmt->get_result();


?>