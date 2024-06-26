<!DOCTYPE html>
<html lang="en">
<head>
    <title>Menu</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="global.css">
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <style>
        .featured {
            width: fit-content;
            display: flex;
            margin: 10px auto;
            font-size: 2.8em;
            font-style: italic;
        }

        .card-container {
            margin: auto;
            border-radius: 20px ;
            padding: 20px;
            display: flex;
            flex-direction: row;
            gap: 20px;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .custom-card {
            width: 250px;
        }

    </style>

</head>
<body>
    <nav class="navbar nav-style navbar-fixed-top" >
        <div class="container-fluid width-format">
            <div class="navbar-header">
                <a href="#" class="navbar-brand roboto-bold store-name">TastySlices</a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <li><a class="light-black" href="index.php">Home</a></li>
                <li><a class="light-black" href="products.php">Products</a></li>
                <li><a class="light-black" href="cart.php">Cart</a></li>
                <li><a class="light-black" href="aboutUs.php">About Us</a></li>
            </ul>
        </div>
    </nav>

    <p class="featured merriweather-bold" style="margin-top: 70px;" >Featured</p>

    <div class="width-format card-container" style="background: #cbf6d9" >
        <?php showFeatured(); ?>
    </div>

    <p class="featured merriweather-bold" style="margin-top: 70px;" >All Products</p>

    <div class="width-format card-container" >
        <?php showProducts(); ?>
    </div>
    

</body>
<script>

    addToCart = (id) => {
        $(document).ready(function() {
            $.ajax({
                url: 'addtocart.php', // Path to your PHP file
                type: 'POST', // Method used to send the data
                data: { id: id }, // Data to be sent
                success: function(response) {
                    if(response == "success"){
                        alert("Added to Cart!");
                    } else {
                        alert("Add to Cart Failed.");
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText); // Log any errors
                }
            });
        });
    }

</script>

</html>

<?php

    function showFeatured() {

        include("includes/sqlconnection.php");
        
        $sql = "SELECT * FROM products WHERE isFeatured='1'";
        $result = $conn->query($sql);

        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()) {
                
                echo "
                <div class='card custom-card' >

                    <a href='productDetails.php?id=$row[id]' > 
                        <img class='card-img-top card-img' src='images/$row[pic]' alt='Card image cap' style='cursor: pointer;'>
                    </a>
                    
                    <div class='card-body'>
                        <h5 class='card-title'>$row[prodName]</h5>
                        <p class='card-text'>$row[description]</p>
                    </div>
                    
                    <button onclick='addToCart($row[id])' class='btn btn-primary'>Add to cart</button>
                </div>
                ";
            }
        } else {
            echo "
                <div></div>
            ";
        }

        $conn->close();

    }

    function showProducts(){

        include("includes/sqlconnection.php");
        
        $sql = "SELECT * FROM products";
        $result = $conn->query($sql);

        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()) {
                
                echo "
                <div class='card custom-card' >
                    <a href='productDetails.php?id=$row[id]' > 
                        <img class='card-img-top card-img' src='images/$row[pic]' alt='Card image cap' style='cursor: pointer;'>
                    </a>
                    <div class='card-body'>
                        <h5 class='card-title'>$row[prodName]</h5>
                        <p class='card-text'>$row[description]</p>
                    </div>
                    <button onclick='addToCart($row[id])' class='btn btn-primary'>Add to cart</button>
                </div>
                ";
            }
        } else {
            echo "
                <div></div>
            ";
        }

        $conn->close();
    }

?>