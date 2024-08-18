<?php

include('connection.php');


$stmt = $conn ->prepare("SELECT *FROM products WHERE product_category='woman' LIMIT 4");

$stmt->execute();

$woman_featured_product= $result = $stmt->get_result();


?>