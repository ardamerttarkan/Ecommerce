<?php

include('connection.php');


$stmt = $conn ->prepare("SELECT *FROM products WHERE product_category='child' LIMIT 4");

$stmt->execute();

$child_featured_product= $result = $stmt->get_result();


?>