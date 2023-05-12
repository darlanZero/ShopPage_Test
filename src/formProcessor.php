-- Active: 1682557258003@@127.0.0.1@3306@sensidia
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Sensidia";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed " . $conn->connect_error);
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
dvd.size,
dimensions.height, 
dimensions.width, 
dimensions.length 
FROM products
LEFT JOIN dvd ON products.id = dvd.product_id
LEFT JOIN furniture ON products.id = furniture.product_id
LEFT JOIN dimensions ON furniture.id = dimensions.furniture_id
LEFT JOIN book ON products.id = book.product_id";

    // Armazenando valores das variáveis do formulário
    $image = $_POST['image'];
    $sku = $_POST['SKU'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $product_type = $_POST['product_type'];
    $description = $_POST['description'];
    
    // Preparando a query de SQL INSERT

    $sql = "INSERT INTO products (image, sku, name, price, product_type, description) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param( "sssdss", $image ,$sku, $name, $price, $product_type, $description);
    
    // Executando a query
    if ($stmt->execute()) {
         $product_id = $conn->insert_id;
      echo "New record created successfully. Last Inserted ID is:".$product_id;
    } else {
        echo "Failed to add the record to the database. Here's why:<br>" . $stmt->error;
    }
   
    
    if ($product_type == 'dvd') {
        $size = $_POST['size'];
        $sql = "INSERT INTO dvd (product_id, size) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("id",$product_id, $size);
    
        // Executando a query
        if (!$stmt->execute()) {
            echo "Failed to add the record to the database. Here's why:<br>" . $stmt->error;
        }
    } elseif ($product_type == 'book') {
        $weight = $_POST['weight'];
        $sql = "INSERT INTO book (product_id, weight) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("id",$product_id, $weight);
    
        // Executando a query
        if (!$stmt->execute()) {
            echo "Failed to add the record to the database. Here's why:<br>" . $stmt->error;
        }
    } elseif ($product_type == 'furniture') {
        $height = $_POST['height'];
        $width = $_POST['width'];
        $length = $_POST['length'];
        $sql = "INSERT INTO furniture(product_id) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $sql = "INSERT INTO dimensions (furniture_id, height, width, length) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iddd",$product_id, $height, $width, $length);
    
        // Executando a query
        if (!$stmt->execute()) {
            echo "Failed to add the record to the database. Here's why:<br>" . $stmt->error;
        }
    }
    
    var_dump($_POST);
    die;
    
    // insere informações adicionais com base no tipo de produto (continuação)
    if (isset($sql)) {
        header("Location: '../firstpage.php'");
        mysqli_query($conn, $sql);
    }

/*if (isset($_POST['product-form'])) {
    // coleta as informações do produto
   
}*/


?>