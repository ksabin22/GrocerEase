<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Three Photo Layout</title>
    <style>
        .container-o {
            display: flex;
            height: 60vh;
            width: 180%;
            max-width: 1200px;
        }

        h1 {
            margin: 20px 0;
            font-size: 2rem;
            color: #333;
        }

        .left-side-photo, .right-side-photo {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .left-side-photo {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 1fr 1fr;
            gap: 10px;
            padding: 20px;
            box-sizing: border-box;
        }

        .left-side-photo .product {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: 2px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
            width: 100%;
            height: 100%;
            overflow: hidden;
            background-color: #fff;
            text-align: center;
        }

        .left-side-photo .product img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
            cursor: pointer;
        }

        .right-side-photo {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f4f4f4;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .right-side-photo img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
            border-radius: 10px;
        }
    </style>
</head>
<body style="background-color:azure;">
    <h1>Our Products</h1>
    <div class="container-o"  style="background-color:beige;">
        <div class="left-side-photo">
            <div class="product"  style="background-color:beige;">
                <a href="filter.php">
                    <img src="assets/images/ProductImage/chocolate_cake.jpeg" alt="Product 1">
                </a>
            </div>
            <div class="product"  style="background-color:beige;">
                <a href="filter.php">
                    <img src="assets/images/ProductImage/brie.jpg" alt="Product 2">
                </a>
            </div>
            <div class="product"  style="background-color:beige;">
                <a href="filter.php">
                    <img src="assets/images/ProductImage/cinamon_roll.jpeg" alt="Product 3">
                </a>
            </div>
            <div class="product"  style="background-color:beige;">
                <a href="filter.php">
                    <img src="assets/images/ProductImage/pork_chops.jpg" alt="Product 4">
                </a>
            </div>
        </div>
        <div class="right-side-photo"  style="background-color:beige;">
            <img src="assets/images/ProductImage/maybeshop.jpg" alt="Large Photo">
        </div>
    </div>
</body>
</html>
