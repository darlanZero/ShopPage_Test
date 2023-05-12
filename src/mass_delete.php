-- Active: 1683342554096@@127.0.0.1@3306@sensidia
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
dvd.size AS dvd_size,
dimensions.height, 
dimensions.width, 
dimensions.size 
FROM products
LEFT JOIN dvd ON products.id = dvd.product_id
LEFT JOIN furniture ON products.id = furniture.product_id
LEFT JOIN dimensions ON furniture.id = dimensions.furniture_id
LEFT JOIN book ON products.id = book.product_id";




    $product_ids = $_POST['product'];
    // Verifica se pelo menos um produto foi selecionado
    
        // Cria a lista de placeholders para a cláusula IN da query SQL
        $placeholders = implode(',', array_fill(0, count($product_ids), '?'));

        // Prepara a query SQL para deletar os produtos selecionados
        $sql = "DELETE FROM products WHERE id IN ($placeholders)";
        $stmt = $conn->prepare($sql);

        // Associa os valores dos IDs dos produtos aos placeholders na query
        $stmt->bind_param(str_repeat('i', count($product_ids)), ...$product_ids);

        // Executa a query SQL
        if ($stmt->execute()) {
            echo "Os produtos selecionados foram deletados com sucesso!";
        } else {
            echo "Erro ao deletar os produtos selecionados. Erro: " . $conn->error;
        }


var_dump($_POST);

if (isset($sql)) {
    header("Location: '../firstpage.php'");
    mysqli_query($conn, $sql);
}
?>