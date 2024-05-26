<?php
include './connection.php';
$invoicesql = "SELECT * FROM ORDERPLACE 
            INNER JOIN USERS ON ORDERPLACE.USER_ID= USERS.USER_ID           
            WHERE ORDERPLACE_ID=" . $_GET['order-id'] . " 
            ORDER BY ORDERPLACE_ID DESC";
$result = oci_parse($conn, $invoicesql);
oci_execute($result);
$row = oci_fetch_array($result);

$user_id = $_SESSION['user_id'];
?>
<div class="invoice-details"  style="background-color:beige;">
<div class="customer-section"  style="background-color:beige;">
    <div class="container page__body"  style="background-color:beige;">
        <div class="invoice-print"  style="background-color:beige;">
        <div class="invoice-details-part"  style="background-color:beige;">
            <h2>
                Invoice Details </h2>
</div>
</br> 
            <div class="invoice-headings"  style="background-color:beige;">
                <div class="invoice-headings__subheading">

                   <h3> Order Number: <h/3>
                </div>
                <div class="invoice-headings__number"  style="background-color:beige;">
                    <?php
                    echo $row['ORDERPLACE_ID'];
                    ?>
                </div>

            </div>

            <!--Customer Details Section-->
            <div class="detail-body-section"  style="background-color:beige;">
                <div class="invoice-subheading"  style="background-color:beige;">
                    Customer Details
                </div>

                <div class="details-section"  style="background-color:beige;">
                    <div class="details-section__body"  style="background-color:beige;">
                        <div class="invoice-customer-section__heading headingbold"  style="background-color:beige;">
                            Customer Name:
                        </div>
                        <div class="invoice-customer-section__description"  style="background-color:beige;">
                            <?php
                            echo $row['USERNAME'];
                            ?>
                        </div>
                    </div>

                    <div class="details-section__body"  style="background-color:beige;">
                        <div class="invoice-customer-section__heading headingbold"  style="background-color:beige;">
                            Customer Email:
                        </div>
                        <div class="invoice-customer-section__description"  style="background-color:beige;">
                            <?php
                            echo $row['EMAIL'];
                            ?>

                        </div>
                    </div>

                    <div class="details-section__body"  style="background-color:beige;">
                        <div class="invoice-customer-section__heading headingbold"  style="background-color:beige;">
                            Customer Contact Number:
                        </div>
                        <div class="invoice-customer-section__description"  style="background-color:beige;">
                            <?php
                            echo $row['PHONE_NO'];
                            ?>

                        </div>
                    </div>

                </div>
            </div>
            <?php
            $detailsql = "SELECT * FROM ORDERLIST
            INNER JOIN PRODUCT ON ORDERLIST.PRODUCT_ID= PRODUCT.PRODUCT_ID 
            WHERE ORDERLIST.ORDERPLACE_ID=" . $_GET['order-id'];
            $stid = oci_parse($conn, $detailsql);
            oci_execute($stid);
            $nrows = oci_fetch_all($stid, $res);

            $paymentsql = "SELECT * FROM ORDERPLACE WHERE ORDERPLACE_ID=" . $_GET['order-id'];
            $paymentstid = oci_parse($conn, $paymentsql);
            oci_execute($paymentstid);
            while (oci_fetch($paymentstid)) {
                $paymentstatus = oci_result($paymentstid, 'PAYMENT_STATUS');
            }

            ?>
            <!--Order Details Section-->
            <div class="invoice-subheading"  style="background-color:beige;">
                Order Details
            </div>
            <div class="order-payment-container"  style="background-color:beige;">
                <div class="order-details"  style="background-color:beige;">
                    <div class="order_body_right"  style="background-color:beige;">
                        <div class="order_bodyright_body"  style="background-color:beige;">

                            <?php
                            $total = 0;
                            for ($j = 0; $j < $nrows; $j++) {
                                $productid = $res['PRODUCT_ID'][$j];
                                $name = $res['PRODUCT_NAME'][$j];
                                $image = $res['PRODUCT_IMAGE'][$j];
                                $price = $res['PRICE'][$j];
                                $quantity = $res['QUANTITY'][$j];


                            ?>
                                <div class="invoice-product-card"  style="background-color:beige;">
                                    <div class="invoice-product-card__left"  style="background-color:beige;">
                                    <div class="invoice-product-card_left_image product-image-container"  style="background-color:beige;">
    <img src="assets/images/ProductImage/<?php echo $image; ?>" />
</div>
                                        <div class="invoice-product-card_left_desc"  style="background-color:beige;">
                                            <div class="checkout-product-card_leftdesc_name"  style="background-color:beige;">
                                                <?php
                                                echo $name;
                                                ?>
                                            </div>
                                            <div class="invoice-product-card_leftdesc_rate"  style="background-color:beige;">
                                                £

                                                <?php
                                                $oldPrice = $res['PRICE'][$j];
                                                $discountPrice = 0;
                                                $stidDiscount = "SELECT DISCOUNT_RATE FROM DISCOUNT WHERE PRODUCT_ID=$productid";
                                                $stidDiscount = oci_parse($conn, $stidDiscount);
                                                oci_execute($stidDiscount);
                                                while (oci_fetch($stidDiscount)) {
                                                    $discountPrice = oci_result($stidDiscount, 'DISCOUNT_RATE');
                                                }
                                                if ($discountPrice > 0) { ?><i><strike><?php echo $oldPrice;
                                                                                        ?></strike></i> <?php echo ($oldPrice - $discountPrice);
                                                                                                    } else {
                                                                                                        echo $price;
                                                                                                    }
                                                                                                        ?>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="invoice-product-card__right"  style="background-color:beige;">
                                        <div class="invoice-product-card_right_quantity"  style="background-color:beige;">
                                            x
                                            <?php
                                            echo $quantity;
                                            ?>
                                        </div>
                                        <div class="invoice-product-card_right_total"  style="background-color:beige;">
                                            £
                                            <?php
                                            $subtotal = ($price - $discountPrice) * $quantity;
                                            echo number_format(($subtotal), 2);
                                            $total += $subtotal;
                                            ?>
                                        </div>
                                    </div>
                                </div>

                            <?php
                            }
                            ?>


                            <div class="order_bodyright_subtotal"  style="background-color:beige;">
                                <div class="order_bodyrightsubtotal_title"  style="background-color:beige;">
                                    Sub Total
                                </div>
                                <div class="order_bodyrightsubtotal_price"  style="background-color:beige;">
                                    £
                                    <?php
                                    echo $total;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!--Payment Details Section-->
                <div class="order-details"  style="background-color:beige;">
                    <div class="invoice-subheading"  style="background-color:beige;">
                        Payment Details
                    </div>
                    <div class="payment-details"  style="background-color:beige;">
                        <div class="payment-details__subheading"  style="background-color:beige;">
                            Order Total
                        </div>
                        <div class="payment-details__number"  style="background-color:beige;">
                            £
                            <?php
                            echo $total;
                            ?>
                        </div>
                    </div>

                    <div class="invoice-paymentmode"  style="background-color:beige;">
                        <?php

                        if ($paymentstatus == "true") {

                            echo "Paid Via PayPal";
                        } else { ?>
                            <span style="color:red;">Order Cancelled </span>
                        <?php

                        } ?>

                    </div>
                </div>
            </div>

            <?php
            $date = $row['DATE_OF_COLLECTION'];
            $time = $row['TIMESLOT'];

            ?>


            <!--Collection Details Section-->
            <div class="detail-body-section"  style="background-color:beige;">
                <div class="invoice-subheading"  style="background-color:beige;">
                    Collection Details
                </div>

                <div class="details-section"  style="background-color:beige;">
                    <div class="details-section__body"  style="background-color:beige;">
                        <div class="invoice-customer-section__heading headingbold"  style="background-color:beige;">
                            Date of Collection:
                        </div>
                        <div class="invoice-customer-section__description"  style="background-color:beige;">
                            <?php
                            echo $date;
                            ?>
                        </div>
                    </div>

                    <div class="details-section__body"  style="background-color:beige;">
                        <div class="invoice-customer-section__heading headingbold">
                            Time of Collection:
                        </div>
                        <div class="invoice-customer-section__description"  style="background-color:beige;">
                            <?php
                            switch ($time) {
                                case "morning":
                                    echo '6:00 - 12:00';
                                    break;

                                case "afternoon":
                                    echo '12:00 - 13:00';
                                    break;

                                case "evening":
                                    echo "15:00 - 18:00";
                                    break;
                            }

                            ?>
                        </div>
                    </div>

                    <div class="details-section__body"  style="background-color:beige;">
                        <div class="invoice-customer-section__heading headingbold"  style="background-color:beige;">
                            Collection Location:
                        </div>
                        <div class="invoice-customer-section__description"  style="background-color:beige;">
                            Cleckhudderfax Central, Cleckhudderfax, Leeds, United Kingdom
                        </div>
                    </div>

                </div>
            </div>
        </div>


















    </div>
</div>
                        </div>
                        </html>
