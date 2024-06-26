<!DOCTYPE html>
<html lang="en">
<head>
    <title>Menu</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="global.css">
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <style>

        * {
            font-family: "Roboto", sans-serif;
            font-weight: 400;
            font-style: normal;
        }

        .product-profile {
            display:flex;
            flex-direction: row;
            margin: auto;
            margin-top: 100px;
            gap: 20px;
            justify-content: space-between;
        }

        .product-image {
            height: 450px;
            border-radius: 20px;
            box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;
        }

        .product-information {
            display: flex;
            flex-direction: column;
            gap: 10px;
            text-align: right;
        }

        .description {
            box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;
            padding: 20px;
            text-align: left;
        }

        .comment-header {
            display: flex;
            margin: auto;
            margin-bottom: 30px;
        }
        
        .description-header {
            display: flex;
            margin: auto;
            margin-top: 20px;
            margin-bottom: 10px
        }

        .comment-card {
            display: flex;
            flex-direction: row;
            margin: auto;
            border-radius: 10px;
            box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;
            padding: 10px;
        }

        .comment-list {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
            gap: 20px;
        }

        .input-comment {
            width: 80vh;

        }

        .textarea-comment {
            display: flex;
            margin: auto;
        }

        .add-comment-wrapper {
            width: 70%;
            margin: 20px auto;
            gap: 10px;
            display: flex;
        }

    </style>

</head>
<body>

    <nav class="navbar nav-style navbar-fixed-top" >
        <div class="container-fluid width-format" >
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

    <?php showProduct() ?>

    <br>
    <br>

    <h2 class="width-format comment-header" >Comments</h2>
    
    <div class="add-comment-wrapper">
        <form action="addComment.php" method="POST">
            <input type="hidden" name="productID" value="<?php echo $_GET['id'] ?>">
            <textarea name="comment" class=" width-format form-control textarea-comment " rows="3"></textarea>
            <button type="submit" name="add_comment" class="btn btn-primary"  >Add Comment</button>
        </form>    
    </div>

    <div class="comment-list">

        <?php showComments(); ?>    

        <!-- <div class="comment-card width-format">
            <img src="https://icons.veryicon.com/png/o/internet--web/prejudice/user-128.png" alt="" width='50' height='50' >
            
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia accusantium excepturi reprehenderit rerum omnis provident quod quae, commodi tempore eius? Voluptatibus ut a veritatis neque cumque reiciendis quia quis ea.</p>

        </div>

        <div class="comment-card width-format">
            <img src="https://icons.veryicon.com/png/o/internet--web/prejudice/user-128.png" alt="" width='50' height='50' >
            
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia accusantium excepturi reprehenderit rerum omnis provident quod quae, commodi tempore eius? Voluptatibus ut a veritatis neque cumque reiciendis quia quis ea.</p>

        </div>

        <div class="comment-card width-format">
            <img src="https://icons.veryicon.com/png/o/internet--web/prejudice/user-128.png" alt="" width='50' height='50' >
            
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia accusantium excepturi reprehenderit rerum omnis provident quod quae, commodi tempore eius? Voluptatibus ut a veritatis neque cumque reiciendis quia quis ea.</p>

        </div> -->
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

    function showProduct() {
        include("includes/sqlconnection.php");

        $productId = $_GET['id'];
        $sql = "SELECT * FROM products WHERE id = $productId";
        $result = $conn->query($sql);

        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()) {
                echo "

                <div class='product-profile width-format'>
                    <img class='product-image' src='images/$row[pic]' alt=''>
            
                    <div class='product-information'>
                        <h2>$row[prodName]</h2>
                        <p style='font-size: 1.5em; margin: 0;' >$row[price]</p>
            
                        <button onclick='addToCart($row[id])' class='btn btn-primary' style='width:fit-content; margin-left:auto;' >Add to Cart</button>
            
                        <p class='description'>
                            $row[description]
                        </p>
                    </div>
            
                </div>
                ";
            }
        }
        else {
            echo "";
        }

        $conn->close();

    }

    function showComments(){
        include("includes/sqlconnection.php");

        $productId = $_GET['id'];
        $sql = "SELECT * FROM comments WHERE productID = $productId";
        $result = $conn->query($sql);

        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()) {
                echo "
                <div class='comment-card width-format'>
                    <img src='https://icons.veryicon.com/png/o/internet--web/prejudice/user-128.png' alt='' width='50' height='50' >
                    <p>$row[comment]</p>
                </div>
                ";
            }
        }
        else {
            echo "";
        }

        $conn->close();
    }

?>