-- Active: 1682557258003@@127.0.0.1@3306@sensidia
<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Sensidia";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed ".$conn->connect_error);
    } else {
        echo "";
    }
    
    $sql = "SELECT 
    products.id, 
    products.product_type, 
    products.image, 
    products.name, 
    products.description, 
    products.price,
    products.SKU, 
    book.weight, 
    dvd.size AS dvd_size,
    dimensions.height, 
    dimensions.width, 
    dimensions.size 
    FROM products
    LEFT JOIN dvd ON products.id = dvd.product_id
    LEFT JOIN furniture ON products.id = furniture.product_id
    LEFT JOIN dimensions ON furniture.id = dimensions.furniture_id
    LEFT JOIN book ON products.id = book.product_id";
    $result = mysqli_query($conn, $sql);
?>