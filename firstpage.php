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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sensidia - The Best shop You Ever had </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,600;1,100;1,400;1,500;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet"href="./src/index.css">
</head>
<body>
    <header>
        <h1>Sensidia - The Hottest Products on Sale!</h1>
    </header>
    
    <main>
        <section>
            <div class = "buttons">
                <h2>
                    Product List
                </h2>

                <a href="./Addproduct.php">
                    <button id="#add-product-btn">
                    Add
                    </button>
                </a>

                <button id="delete-product-btn" type="submit">
                    Mass Delete
                   
                </button>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                    window.onload = function() {
                    const deleteBtn = document.getElementById('delete-product-btn');
                        deleteBtn.addEventListener('click', function() {
                            var checkboxes = document.getElementsByName("product[]");
                            var selectedProducts = [];
                            for (var i = 0; i < checkboxes.length; i++) {
                            if (checkboxes[i].checked) {
                                selectedProducts.push(checkboxes[i].value);
                            }
                            }
                            if (selectedProducts.length === 0) {
                            alert("Please select at least one product to delete.");
                            return;
                            }

                            if (confirm("Are you sure you want to delete the selected products?")) {
                                var form = document.createElement("form");
                                form.method = "POST";
                                form.action = "./src/mass_delete.php";
                                for (var i = 0; i < selectedProducts.length; i++) {
                                    var input = document.createElement("input");
                                    input.type = "hidden";
                                    input.name = "product[]";
                                    input.value = selectedProducts[i];
                                    form.appendChild(input);
                                }
                                document.body.appendChild(form);

                                fetch('./src/mass_delete.php', {
                                    method: 'POST',
                                    body:new FormData(form)
                                })
                                .then(response => response.json())
                                .then(data => {
                                    alert(data.message);
                                    if (data.sucess) {
                                        location.reload();
                                    }
                                   location.reload() 
                                })
                                .catch(error => {
                                    location.reload();
                                })
                                
                            }
                        });
                    };      
                </script>
            </div>

            <div class="ProductsList" id="ProductsList">
            <!--Where the products will be shown-->
            <?php
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
                $result = mysqli_query($conn, $sql);
                
                if ($result->num_rows > 0) {
                    while ($row = $result ->fetch_assoc()) {
                        $productId = $row['id'];

                        echo '<div class= "product">';
                        echo '<img src="'. $row["image"]. '"alt ="'.$row["name"] .'"><br>';
                        echo "<label><input type='checkbox' name='product[]' value='$productId'></label>";
                        echo "SKU: ".$row["SKU"]."<br>";
                        echo "<h3 class= 'ProductName'> ". $row["name"] . "</h3><br>";
                        echo "<p class = 'price'>$" . $row["price"] . "</p><br>";
                        
                        echo "<div class= 'statsProducts'>";
                        if (!empty($row["weight"])) {
                            echo "<p>Weight: ".$row["weight"]."g</p>";
                        }if ($row["product_type"] === "dvd" && isset($row["size"])) {
                            echo "<p>Size: ".$row["size"]."MB</p>";
                        }if (!empty($row["height"]) && !empty($row["width"]) && !empty($row["length"])) {
                            echo "<p>Dimensions: ".$row["height"]."x".$row["width"]."x".$row["length"]."</p>";
                        }if (empty($row["weight"]) && empty($row["length"]) && empty($row["height"]) && empty($row["width"]) && empty($row["size"])) {
                            echo "<p>Information not available</p>";
                        }
                        echo "</div>";
                        echo '</div>';
                    }
                } else {
                    echo "0 results";
                }
                $conn->close();
            ?>
            </div>
        </section>
    </main>

    <footer id="footer">
        <p>&copy; 2023 - Scandiweb Test Assigment</p>

        <script>
            var footer = document.getElementById('footer');
            var lastScrollPosition = 0;

            window.addEventListener('scroll', function() {
            var currentScrollPosition = window.scrollY || document.documentElement.scrollTop;
            if (currentScrollPosition > lastScrollPosition) {
                // Scroll para baixo
                if (currentScrollPosition + window.innerHeight >= document.documentElement.scrollHeight) {
                // Chegou ao final da página, mostra o footer
                footer.style.bottom = '0';
                }
            } else {
                // Scroll para cima
                if (currentScrollPosition + window.innerHeight < document.documentElement.scrollHeight - footer.clientHeight) {
                // Ainda não chegou ao final da página, esconde o footer
                footer.style.bottom = '-100px';
                }
            }
            lastScrollPosition = currentScrollPosition;
            });
        </script>
    </footer>
</body>
</html>