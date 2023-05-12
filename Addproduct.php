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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Your Product</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,600;1,100;1,400;1,500;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="src/index.css">
    <link rel="stylesheet" href="src/formpage.css">
</head>
<body>
    <header>
        <h1>
            Add Your Product!
        </h1>

        <p>We Accept Books, DVDs and Furnitures</p>
        <a href="./firstpage.php">
            <button>
                Go Back

            </button>
        </a>
    </header>

    <main>
        <div class= "product-form-div">
            <form action="" method="POST"  class="product-form" id="product-form" name="product-form" enctype="multipart/form-data" >
                <label for="image">Image: </label>
                <input type="text" id="image" name="image" required placeholder="Place an Link Image - Provide the Image">

                <label for="SKU">SKU: </label>
                <input type="text" name="SKU" id="SKU" placeholder="Unique Code Identificator">
                <br>

                <label for="name">Name *: </label>
                <input type="text" id="name" name="name" required placeholder="Provide the product name">
                <br>

                <label for="price">Price($) *:</label>
                <input type="number" id="price" name="price" step="0.01" required placeholder="Provide the price">
                <br>

                <label for="product_type" class="productType" >Product Type</label>
                <select name="product_type" id="productType" >
                    <option value="null" placeholder="Choose One!">Choose One!</option> 
                    <option value="dvd">DVD</option>
                    <option value="book">Book</option>
                    <option value="furniture">Furniture</option>
                </select>
                <br>

                <div class="DescriptionProduct">
                    <div id="DVD">
                        <label for="size">Size(MB) *:</label>
                        <input type="number" id="size" name="size" placeholder="What are the MBs?">
                        <br>
                    </div>

                    <div id="Book">
                        <label for="weight">Weight(KG) *:</label>
                        <input type="number" id="weight" name="weight" step="0.001" placeholder="The book's Weight?">
                        <br>
                    </div>

                    <div id="dimensions">
                        <label for="height">Height(CM) *:</label>
                        <input type="number" id="height" name="height" step="0.01" placeholder="Product's Height please">
                        <br>
                        <label for="width">Width(CM) *:</label>
                        <input type="number" id="width" name="width" step="0.01" placeholder="Product's Width please">
                        <br>
                        <label for="length">Length(CM) *:</label>
                        <input type="number" id="length" name="length" step="0.01" placeholder="Product's Lenght please">
                        <br>
                    </div>

                    <label for="description">Description *:</label>
                    <textarea name="description" id="description" required placeholder="Describe more about your product."></textarea>

                    <div class="buttons">
                        <button id="save-product-btn" name="save-product-btn" type="submit">
                            Save
                        </button>

                        <a>
                            <button>
                                Cancel
                            </button>
                        </a>
                    </div>
                </div> 
            </form>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                $(document).ready(function() {
                $("#save-product-btn").click(function() {
                    $.ajax({
                    url: "./src/formProcessor.php",
                    type: "POST",
                    data: $("#product-form").serialize(),
                    success: function(response) {
                        $("./src/formProcessor.php").html(response);
                    }
                    });
                });
                });
            </script>
            


            <script>
                document.getElementById('DVD').style.display = 'none';
                document.getElementById('Book').style.display = 'none';
                document.getElementById('dimensions').style.display = 'none';

                document.getElementById('productType').addEventListener('change', function() {
                    document.getElementById('DVD').style.display = 'none';
                    document.getElementById('Book').style.display = 'none';
                    document.getElementById('dimensions').style.display = 'none';

                    var option =this.value;
                    if (option == 'book') {
                        document.getElementById('Book').style.display = 'block';
                    }else if (option == 'dvd') {
                        document.getElementById('DVD').style.display = 'block';
                    }else if (option == 'furniture') {
                        document.getElementById('dimensions').style.display = 'block';
                    }
                });
            </script>
        </div>
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

