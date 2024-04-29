<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .container {
            flex: 1;
        }

        .page-footer {
            background-color: #f2f2f2;
            padding: 20px 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .contact-list li {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .contact-list li img {
            margin-right: 10px;
        }

        .useful-links {
            flex: 1;
            margin-left: 30px;
        }

        .contact-us {
            flex: 1;
            margin: 0 10px;
        }

        @media (max-width: 768px) {

            .useful-links,
            .contact-us {
                margin: 10px 0;
            }
        }
    </style>

</head>

<body>
    <div class="container">
        <div class="page-footer-wrapper">
        </div>
    </div>
    <div class="page-footer">
        <div class="useful-links">
            <div class="page-footer__quick-links">
                <div class="page-footer__quick-links__header">
                    Useful Links
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
        </div>
        <div class="contact-us">
            <div class="page-footer__quick-links">
                <div class="page-footer__quick-links__header">
                    Contact Us
                </div>
                <div class="page-footer__quick-links__links">
                    <ul class="contact-list">
                        <li>
                            <img src="../../assets/images/call.png" alt="" width="28px" height="25px"> <a> (+44) 7960640277</a>
                        </li>
                        <li>
                            <img src="../../assets/images/email.png" alt="" width="28px" height="25px"> <a> grocerEase@gmail.com </a>
                        </li>
                        <li>
                            <img src="../../assets/images/fax.png" alt="" width="28px" height="25px"> <a> Cleckhuddersfax</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="page-footer__desc">
            <div class="page-footer__desc__logo">
                <img src="./assets/images/logo-01.png" />
            </div>
            <div class="page-footer__desc__content" style="text-align: left;">
                The easiest approach to purchase goods made locally. Acquired by the Cleckhudderfax dealers. Purchase at any time and from anyplace.
            </div>

        </div>
    </div>
</body>

</html>