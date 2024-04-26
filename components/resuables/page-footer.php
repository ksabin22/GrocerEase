<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class=" page-footer">
        <div class="container">

        <div class="page-footer-wrapper">

        
        <div class="page-footer__desc">

            <div class="page-footer__desc__logo">
                <img src="./assets/images/logo-01.png"/>
            </div>
            <div class="page-footer__desc__content">
            The easiest approach to purchase goods made locally. Acquired by the Cleckhudderfax dealers. Purchase at any time and from anyplace.

            </div>

        </div>

        <?php
         if($isCustomer){
         ?>
        <div class=" page-footer__quick-links">
            <div class="page-footer__quick-links__header">
                Quick Links
            </div>
            <div class="page-footer__quick-links__links">
                <ul>
                    <a href="index.php">
                    <li>
                        Home
                    </li>
                    </a>
                    <a href="filter.php">
                    <li>
                        Products
                    </li>
                    </a>
                    <a href="maintopdeal.php">
                    <li>
                        Top deals
                    </li>
                    </a>
                </ul>

            </div>
        </div>
        <?php
         }
        ?>

        


        </div>

       
    
        </div>

    </div>
</body>
</html>