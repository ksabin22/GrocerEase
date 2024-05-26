<?php
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->SMTPDebug = 0;                      // Enable verbose debug output
    $mail->isSMTP();                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';       // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                   // Enable SMTP authentication
    $mail->Username   = 'grocerease0@gmail.com'; // SMTP username
    $mail->Password   = 'xdwd ykkd bgzp pcss';  // SMTP password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;
    // Recipients
    $mail->setFrom('grocerease0@gmail.com', 'GrocerEase');
    $getemail = "SELECT EMAIL FROM USERS WHERE USER_ID=$userId";
    $emailid = oci_parse($conn, $getemail);
    oci_execute($emailid, OCI_NO_AUTO_COMMIT);
    oci_commit($conn);

    // Fetch email
    $count = oci_fetch_all($emailid, $res);

    if ($count == 1) {
        foreach ($res as $key => $value) {
            if ($key == "EMAIL") {
                $email = $value[0];
            }
        }
    }

    $mail->addAddress($email);   // Add a recipient
    $mail->addReplyTo("grocerease0@gmail.com", "GrocerEase");

    $emailUSer = "SELECT USERNAME,EMAIL FROM USERS WHERE USER_ID=$userId";
    $stidEmail = oci_parse($conn, $emailUSer);
    oci_execute($stidEmail, OCI_DEFAULT);
    while (($rowname = oci_fetch_object($stidEmail))) {
        $username = $rowname->USERNAME;
    }

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'GrocerEase INVOICE';

    $sqlEmailSelect = "
        SELECT 
            p.PRODUCT_NAME, 
            SUM(o.QUANTITY) AS QUANTITY, 
            o.PRODUCT_ID, 
            COALESCE(d.DISCOUNT_RATE, 0) AS DISCOUNT_RATE,
            p.PRICE
        FROM 
            ORDERLIST o 
        JOIN 
            PRODUCT p ON o.PRODUCT_ID = p.PRODUCT_ID 
        LEFT JOIN 
            DISCOUNT d ON o.PRODUCT_ID = d.PRODUCT_ID 
        WHERE 
            o.ORDERPLACE_ID = $orderId 
        GROUP BY 
            o.PRODUCT_ID, p.PRODUCT_NAME, p.PRICE, d.DISCOUNT_RATE
    ";

    $stiEmailSelect = oci_parse($conn, $sqlEmailSelect);
    oci_execute($stiEmailSelect, OCI_NO_AUTO_COMMIT);

    $mail->Body = "
        <h3 style='text-align: center; font-size: 20px;'>Thank you <b style='text-transform: uppercase;'>$username</b> for Choosing GrocerEase<br>Here is your Invoice Detail </h3>
  
        <h1 style='font: bold 100% sans-serif; padding:10px; width:100%; text-align: center; text-transform: uppercase;background-color:#7FA8D4; color:white; font-size: 18px;'>Invoice Details</h1>
        <br>
        <table border=1 style='border-collapse: collapse; width:70%; text-align:center;margin-right:auto;margin-left:auto; font-size: 15px;'>
            <thead>
                <tr style=' color:white; background-color:#7FA8D4; font-weight:bold;'>
                    <th style=' padding: 15px;'>Product Name</th>   
                    <th style=' padding: 15px;'>Quantity</th>
                    <th style=' padding: 15px;'>Price</th>
                </tr>   
            </thead>
            <tbody>
    ";

    $totalPrice = 0;
    while ($row = oci_fetch_array($stiEmailSelect, OCI_ASSOC + OCI_RETURN_NULLS)) {
        $discount = $row['DISCOUNT_RATE'];
        $price = $row['PRICE'];
        $priceWithDiscount = $price - $discount;

        $totalPrice += $priceWithDiscount * $row['QUANTITY'];

        // Check if Quantity is set, otherwise set it to 0
        $quantity = isset($row['QUANTITY']) ? $row['QUANTITY'] : 0;
        $mail->Body .= "
            <tr>
                <td style=' padding: 15px;'>" . $row['PRODUCT_NAME'] . "</td>
                <td style=' padding: 15px;'>" . $quantity . "</td>
                <td style=' padding: 15px;'>" . number_format($priceWithDiscount, 2) . "</td>
            </tr>
        ";
    }

    $mail->Body .= "
            <tr>
                <td colspan='3' style='padding: 15px;'>Total price =&nbsp; £" . number_format($totalPrice, 2) . "</td>
            </tr>
        </tbody>
        </table>
        <p style='text-align: center;'><b>Hope your cart was as full as your heart. Come back soon!GrocerEase<b></p>
    ";

    // Alternate body for non-HTML mail clients
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    // Send email
    $mail->send();
} catch (Exception $e) {
    // Handle exceptions
}
