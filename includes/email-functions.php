<?php
require_once('mail-config.php');
require_once('dbconnection.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendOrderConfirmationEmail($userId, $orderNumber) {
    try {
        global $con;
        
        // Clear any pending results first
        while(mysqli_more_results($con)) {
            mysqli_next_result($con);
        }
        
        // Store all data first, then build email
        $orderData = array();
        
        // Get user details using a prepared statement
        $stmt = mysqli_prepare($con, "SELECT FirstName, LastName, Email FROM tbluser WHERE ID = ?");
        mysqli_stmt_bind_param($stmt, "s", $userId);
        mysqli_stmt_execute($stmt);
        $userResult = mysqli_stmt_get_result($stmt);
        $orderData['user'] = mysqli_fetch_assoc($userResult);
        mysqli_stmt_close($stmt);
        
        if (!$orderData['user']) {
            throw new Exception("User not found");
        }
        
        // Get order items using prepared statement
        $stmt = mysqli_prepare($con, "SELECT tblfood.ItemName, tblfood.ItemPrice 
            FROM tblorders 
            JOIN tblfood ON tblfood.ID=tblorders.FoodId 
            WHERE tblorders.OrderNumber = ?");
        mysqli_stmt_bind_param($stmt, "s", $orderNumber);
        mysqli_stmt_execute($stmt);
        $itemsResult = mysqli_stmt_get_result($stmt);
        
        $orderData['items'] = array();
        while ($item = mysqli_fetch_assoc($itemsResult)) {
            $orderData['items'][] = $item;
        }
        mysqli_stmt_close($stmt);
        
        // Get order address using prepared statement
        $stmt = mysqli_prepare($con, "SELECT * FROM tblorderaddresses 
            WHERE Ordernumber = ? AND UserId = ?");
        mysqli_stmt_bind_param($stmt, "ss", $orderNumber, $userId);
        mysqli_stmt_execute($stmt);
        $addressResult = mysqli_stmt_get_result($stmt);
        $orderData['address'] = mysqli_fetch_assoc($addressResult);
        mysqli_stmt_close($stmt);
        
        // Calculate total
        $total = 0;
        foreach ($orderData['items'] as $item) {
            $total += floatval($item['ItemPrice']);
        }
        $orderData['total'] = $total;

        // Now build the email
        $mail = new PHPMailer(true);
        
        // Server settings
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USERNAME;
        $mail->Password = SMTP_PASSWORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = SMTP_PORT;

        // Recipients
        $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
        $mail->addAddress($orderData['user']['Email'], 
            $orderData['user']['FirstName'] . ' ' . $orderData['user']['LastName']);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Order Confirmation - Order #' . $orderNumber;

        // Build email body
        $body = '<html><body style="font-family: Arial, sans-serif; color: #333;">';
        $body .= '<div style="max-width: 600px; margin: 0 auto; padding: 20px;">';
        $body .= '<h2 style="color: #ff6b6b;">Thank you for your order!</h2>';
        $body .= '<p>Dear ' . $orderData['user']['FirstName'] . ',</p>';
        $body .= '<p>Your order has been successfully placed. Here are your order details:</p>';
        $body .= '<h3 style="color: #4a4a4a;">Order Number: ' . $orderNumber . '</h3>';
        
        // Order Items Table
        $body .= '<table style="width: 100%; border-collapse: collapse; margin: 20px 0;">';
        $body .= '<tr style="background-color: #f8f9fa;">
            <th style="padding: 10px; border: 1px solid #ddd;">Item</th>
            <th style="padding: 10px; border: 1px solid #ddd;">Price</th>
        </tr>';
        
        foreach ($orderData['items'] as $item) {
            $body .= '<tr>
                <td style="padding: 10px; border: 1px solid #ddd;">' . $item['ItemName'] . '</td>
                <td style="padding: 10px; border: 1px solid #ddd;">₹' . number_format($item['ItemPrice'], 2) . '</td>
            </tr>';
        }
        
        $body .= '<tr style="background-color: #f8f9fa;">
            <td style="padding: 10px; border: 1px solid #ddd;"><strong>Total</strong></td>
            <td style="padding: 10px; border: 1px solid #ddd;"><strong>₹' . number_format($orderData['total'], 2) . '</strong></td>
        </tr></table>';

        // Delivery Address
        $body .= '<h4 style="color: #4a4a4a;">Delivery Address:</h4>';
        $body .= '<p style="margin: 5px 0;">' . $orderData['address']['Flatnobuldngno'] . ',<br>';
        $body .= $orderData['address']['StreetName'] . ',<br>';
        $body .= $orderData['address']['Area'] . ',<br>';
        if (!empty($orderData['address']['Landmark'])) {
            $body .= 'Landmark: ' . $orderData['address']['Landmark'] . ',<br>';
        }
        $body .= $orderData['address']['City'] . '</p>';

        $body .= '<p style="margin-top: 20px;">If you have any questions about your order, please contact us.</p>';
        $body .= '<p style="color: #ff6b6b;">Thank you for choosing CakeCrave!</p>';
        $body .= '</div></body></html>';

        $mail->Body = $body;
        $mail->AltBody = strip_tags($body);

        $mail->send();
        error_log("Order confirmation email sent successfully to " . $orderData['user']['Email']);
        return true;
    } catch (Exception $e) {
        error_log("Email sending failed: " . $e->getMessage());
        return false;
    }
}
