<?php
include 'config.php';
if (isset($_POST['product'])) {
    $selectedProduct = $_POST['product'];

    // Query to fetch product details from the database
    $sql = "SELECT `id`,`price`,`quantity` FROM `stockinv` WHERE `name` = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param('s', $selectedProduct);
    $stmt->execute();
    $stmt->bind_result($pid, $productPrice, $actlStk);
    $stmt->fetch();
    $stmt->close();

    // Return the data as JSON
    echo json_encode(['pid' => $pid, 'product_price' => $productPrice, 'actlStk' => $actlStk]);
}
