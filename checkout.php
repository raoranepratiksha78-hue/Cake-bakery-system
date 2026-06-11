<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once('includes/dbconnection.php');
require('vendor/autoload.php');
require_once('includes/email-functions.php');

use Razorpay\Api\Api;

$keyId = 'rzp_test_zwGAAdzsZ0ipyn';
$keySecret = 'ciXHr12iV08gvHlWSp8YPk1f';
$api = new Api($keyId, $keySecret);

// Initialize total variables
$grandtotal = 0;
$totalAmount = 0;

// Calculate total amount at the start
$userid = $_SESSION['fosuid'];
$query = mysqli_query($con, "SELECT SUM(tblfood.ItemPrice) as total 
    FROM tblorders 
    JOIN tblfood ON tblfood.ID=tblorders.FoodId 
    WHERE tblorders.UserId='$userid' AND tblorders.IsOrderPlaced is null");
$row = mysqli_fetch_array($query);
$grandtotal = floatval($row['total'] ?: 0); // Convert to float
$totalAmountPaise = number_format($grandtotal * 100, 0, '.', ''); // Format without decimals

if (strlen($_SESSION['fosuid'] == 0)) {
    header('location:logout.php');
} else {

    // Modify the sendJsonResponse function
    function sendJsonResponse($status, $message, $data = [])
    {
        header('Content-Type: application/json');
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        echo json_encode(array_merge([
            'status' => $status,
            'message' => $message
        ], $data));
        exit();
    }

    // Add this at the very beginning of the file, before any HTML output
    if (isset($_POST['is_ajax']) || isset($_POST['razorpay_payment_id'])) {
        try {
            // For initial order creation
            if (isset($_POST['is_ajax']) && isset($_POST['placeorder'])) {
                $orderNumber = mt_rand(100000000, 999999999);
                $_SESSION['checkout_data'] = array(
                    'flatbldgnumber' => mysqli_real_escape_string($con, $_POST['flatbldgnumber']),
                    'streename' => mysqli_real_escape_string($con, $_POST['streename']),
                    'area' => mysqli_real_escape_string($con, $_POST['area']),
                    'landmark' => mysqli_real_escape_string($con, $_POST['landmark']),
                    'city' => mysqli_real_escape_string($con, $_POST['city']),
                    'payment_type' => 'Razorpay',
                    'orderno' => $orderNumber
                );

                $orderData = [
                    'receipt' => strval($orderNumber),
                    'amount' => strval($totalAmountPaise), // Ensure amount is string
                    'currency' => 'INR',
                    'payment_capture' => 1
                ];

                $razorpayOrder = $api->order->create($orderData);
                $_SESSION['razorpay_order_id'] = $razorpayOrder['id'];

                sendJsonResponse('success', 'Order created', [
                    'order_id' => $razorpayOrder['id'],
                    'amount' => strval($totalAmountPaise), // Ensure amount is string
                    'receipt' => strval($orderNumber)
                ]);
                exit();
            }

            // For payment verification
            if (isset($_POST['razorpay_payment_id']) && isset($_POST['razorpay_order_id'])) {
                try {
                    error_log("====== Payment Verification Started ======");
                    $payment_id = $_POST['razorpay_payment_id'];
                    $razorpay_order_id = $_POST['razorpay_order_id'];

                    error_log("Payment ID: " . $payment_id);
                    error_log("Order ID: " . $razorpay_order_id);
                    error_log("Session Order ID: " . $_SESSION['razorpay_order_id']);

                    // Fetch and verify payment
                    $payment = $api->payment->fetch($payment_id);
                    error_log("Payment Status: " . $payment->status);

                    // Skip order ID verification temporarily for debugging
                    if ($payment && ($payment->status === 'authorized' || $payment->status === 'captured')) {
                        mysqli_begin_transaction($con);

                        try {
                            $data = $_SESSION['checkout_data'];
                            error_log("Checkout Data: " . json_encode($data));

                            // Update orders
                            $update_query = "UPDATE tblorders SET 
                            OrderNumber='" . $data['orderno'] . "',
                            IsOrderPlaced=1,
                            PaymentType='Razorpay',
                            PaymentID='" . $payment_id . "',
                            orderId='" . $razorpay_order_id . "'
                            WHERE UserId='" . $userid . "' AND IsOrderPlaced is null";

                            $result1 = mysqli_query($con, $update_query);
                            error_log("Update Query: " . $update_query);
                            error_log("Update Result: " . ($result1 ? 'Success' : 'Failed'));

                            if (!$result1) {
                                throw new Exception("Order update failed: " . mysqli_error($con));
                            }

                            // Insert address
                            $insert_query = "INSERT INTO tblorderaddresses(
                            UserId, Ordernumber, Flatnobuldngno, StreetName, Area, Landmark, City
                        ) VALUES (
                            '$userid',
                            '{$data['orderno']}',
                            '{$data['flatbldgnumber']}',
                            '{$data['streename']}',
                            '{$data['area']}',
                            '{$data['landmark']}',
                            '{$data['city']}'
                        )";

                            $result2 = mysqli_query($con, $insert_query);
                            error_log("Insert Result: " . ($result2 ? 'Success' : 'Failed'));

                            if (!$result2) {
                                throw new Exception("Address insert failed: " . mysqli_error($con));
                            }

                            mysqli_commit($con);

                            // Add email sending here, after successful database transaction
                            $emailSent = sendOrderConfirmationEmail($userid, $data['orderno']);

                            if (!$emailSent) {
                                error_log("Warning: Order confirmation email could not be sent for order " . $data['orderno']);
                            }

                            // Clear session data
                            unset($_SESSION['checkout_data']);
                            unset($_SESSION['razorpay_order_id']);

                            error_log("Transaction completed successfully");

                            sendJsonResponse('success', 'Payment successful', [
                                'orderno' => $data['orderno'],
                                'emailSent' => $emailSent // Include email status in response
                            ]);
                        } catch (Exception $e) {
                            mysqli_rollback($con);
                            error_log("Database Error: " . $e->getMessage());
                            throw $e;
                        }
                    } else {
                        throw new Exception("Invalid payment status: " . $payment->status);
                    }
                } catch (Exception $e) {
                    error_log("Payment Error: " . $e->getMessage());
                    sendJsonResponse('error', $e->getMessage());
                }
            }
        } catch (Exception $e) {
            error_log("Request Error: " . $e->getMessage());
            sendJsonResponse('error', $e->getMessage());
        }
    }

    // Regular form submission handling
    if (isset($_POST['placeorder']) && !isset($_POST['is_ajax'])) {
        if (empty($grandtotal)) {
            echo "<script>alert('Your cart is empty!'); window.location.href='cart.php';</script>";
            exit();
        }

        // Store form data in session
        $_SESSION['checkout_data'] = array(
            'flatbldgnumber' => mysqli_real_escape_string($con, $_POST['flatbldgnumber']),
            'streename' => mysqli_real_escape_string($con, $_POST['streename']),
            'area' => mysqli_real_escape_string($con, $_POST['area']),
            'landmark' => mysqli_real_escape_string($con, $_POST['landmark']),
            'city' => mysqli_real_escape_string($con, $_POST['city']),
            'payment_type' => $_POST['payment_type'],
            'orderno' => mt_rand(100000000, 999999999)
        );

        if ($_POST['payment_type'] == 'cod') {
            // For COD, insert immediately
            $data = $_SESSION['checkout_data'];
            $query = "UPDATE tblorders SET 
            OrderNumber='$data[orderno]',
            IsOrderPlaced='1',
            PaymentType='COD',
            CashonDelivery='Cash on Delivery' 
            WHERE UserId='$userid' AND IsOrderPlaced is null;";
            $query .= "INSERT INTO tblorderaddresses(UserId,Ordernumber,Flatnobuldngno,StreetName,Area,Landmark,City) 
            VALUES('$userid','$data[orderno]','$data[flatbldgnumber]','$data[streename]','$data[area]','$data[landmark]','$data[city]');";

            if (mysqli_multi_query($con, $query)) {
                // Clear any pending results before sending email
                while (mysqli_more_results($con)) {
                    mysqli_next_result($con);
                }

                // Send confirmation email
                $emailSent = sendOrderConfirmationEmail($userid, $data['orderno']);

                if (!$emailSent) {
                    error_log("Warning: Order confirmation email could not be sent for order " . $data['orderno']);
                }

                unset($_SESSION['checkout_data']);
                echo "<script>alert('Order placed successfully. Order number is: $data[orderno]" .
                    ($emailSent ? ". Confirmation email has been sent to your email address." : "") . "');
                window.location.href='my-order.php';</script>";
            }
        } else {
            // For online payment - create Razorpay order first
            try {
                $orderData = [
                    'receipt' => $_SESSION['checkout_data']['orderno'],
                    'amount' => $totalAmountPaise,
                    'currency' => 'INR',
                    'payment_capture' => 1
                ];

                $razorpayOrder = $api->order->create($orderData);

                // Store both Razorpay order ID and receipt in session
                $_SESSION['razorpay_order_id'] = $razorpayOrder['id'];
                $_SESSION['razorpay_receipt'] = $orderData['receipt'];

                // Return order details for the frontend
                if (isset($_POST['is_ajax'])) {
                    echo json_encode([
                        'order_id' => $razorpayOrder['id'],
                        'amount' => $totalAmountPaise,
                        'receipt' => $orderData['receipt']
                    ]);
                    exit;
                }
            } catch (Exception $e) {
                error_log("Razorpay Order Creation Error: " . $e->getMessage());
                echo "<script>alert('Payment gateway error. Please try again.');</script>";
                exit;
            }
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Cake Bakery System || Checkout Page</title>

        <!-- Icon css link -->
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <link href="vendors/linearicons/style.css" rel="stylesheet">
        <link href="vendors/flat-icon/flaticon.css" rel="stylesheet">
        <link href="vendors/stroke-icon/style.css" rel="stylesheet">
        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Rev slider css -->
        <link href="vendors/revolution/css/settings.css" rel="stylesheet">
        <link href="vendors/revolution/css/layers.css" rel="stylesheet">
        <link href="vendors/revolution/css/navigation.css" rel="stylesheet">
        <link href="vendors/animate-css/animate.css" rel="stylesheet">

        <!-- Extra plugin css -->
        <link href="vendors/owl-carousel/owl.carousel.min.css" rel="stylesheet">
        <link href="vendors/magnifc-popup/magnific-popup.css" rel="stylesheet">
        <link href="vendors/jquery-ui/jquery-ui.min.css" rel="stylesheet">
        <link href="vendors/nice-select/css/nice-select.css" rel="stylesheet">

        <link href="css/style.css" rel="stylesheet">
        <link href="css/responsive.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

        <!-- Add Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">

        <style>
            /* Modern Base Styles */
            body {
                font-family: 'Poppins', sans-serif;
                background: linear-gradient(135deg, #fff5f5 0%, #fff 100%);
                line-height: 1.6;
            }

            /* Enhanced Banner */
            .banner_area {
                background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('img/banner/banner-bg.jpg');
                padding: 80px 0;
                background-size: cover;
                background-position: center;
                margin-bottom: 50px;
            }

            .banner_text {
                text-align: center;
                color: #fff;
                animation: fadeIn 0.8s ease-out;
            }

            .banner_text h3 {
                font-size: 42px;
                font-weight: 700;
                margin-bottom: 15px;
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            }

            /* Enhanced Billing Form */
            .billing_form_area {
                background: white;
                padding: 30px;
                border-radius: 15px;
                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
                margin-bottom: 30px;
            }

            .form-group {
                margin-bottom: 25px;
            }

            .form-group label {
                color: #333;
                font-weight: 500;
                margin-bottom: 8px;
                font-size: 14px;
            }

            .form-control {
                border-radius: 8px;
                border: 1px solid #e2e8f0;
                padding: 12px 15px;
                transition: all 0.3s ease;
                font-size: 14px;
            }

            .form-control:focus {
                border-color: #ff6b6b;
                box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.1);
            }

            /* Enhanced Order Summary Box */
            .order_box_price {
                background: white;
                padding: 30px;
                border-radius: 15px;
                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            }

            .main_title h2 {
                font-size: 24px;
                font-weight: 600;
                margin-bottom: 25px;
                color: #333;
                position: relative;
                padding-bottom: 10px;
            }

            .main_title h2:after {
                content: '';
                position: absolute;
                left: 0;
                bottom: 0;
                width: 50px;
                height: 3px;
                background: linear-gradient(45deg, #ff6b6b, #ff8e8e);
                border-radius: 2px;
            }

            /* Product List Styling */
            .price_single_cost h5 {
                display: flex;
                justify-content: space-between;
                margin-bottom: 12px;
                color: #666;
                font-size: 14px;
            }

            .price_single_cost h4 {
                display: flex;
                justify-content: space-between;
                padding: 15px 0;
                border-top: 1px solid #eee;
                border-bottom: 1px solid #eee;
                margin: 15px 0;
                font-weight: 600;
            }

            .price_single_cost h3 {
                display: flex;
                justify-content: space-between;
                color: #ff6b6b;
                font-weight: 700;
                font-size: 24px;
                margin-top: 20px;
            }

            /* Payment Method Styling */
            .accordion_area {
                margin: 25px 0;
            }

            .card-header {
                background: #f8f9fa;
                border: none;
                padding: 15px;
                border-radius: 8px !important;
                margin-bottom: 10px;
            }

            .card-header h5 {
                margin: 0;
                font-size: 14px;
            }

            input[type="radio"] {
                margin-right: 10px;
            }

            /* Enhanced Button */
            .pest_btn {
                background: linear-gradient(45deg, #ff6b6b, #ff8e8e);
                border-radius: 25px;
                padding: 15px 30px;
                width: 100%;
                text-align: center;
                color: white;
                font-weight: 500;
                text-transform: uppercase;
                letter-spacing: 1px;
                border: none;
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(255, 107, 107, 0.2);
            }

            .pest_btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(255, 107, 107, 0.3);
                background: linear-gradient(45deg, #ff8e8e, #ff6b6b);
            }

            /* Animations */
            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(-10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* Responsive Improvements */
            @media (max-width: 768px) {

                .billing_form_area,
                .order_box_price {
                    padding: 20px;
                }

                .banner_text h3 {
                    font-size: 32px;
                }

                .main_title h2 {
                    font-size: 20px;
                }

                .price_single_cost h3 {
                    font-size: 20px;
                }
            }
        </style>

    </head>

    <body>

        <!--================Main Header Area =================-->
        <?php include_once('includes/header.php'); ?>
        <!--================End Main Header Area =================-->

        <!--================End Main Header Area =================-->
        <section class="banner_area">
            <div class="container">
                <div class="banner_text">
                    <h3>Chekout</h3>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="checkout.php">Chekout</a></li>
                    </ul>
                </div>
            </div>
        </section>
        <!--================End Main Header Area =================-->

        <!--================Billing Details Area =================-->
        <section class="billing_details_area p_100">
            <div class="container">

                <div class="row">
                    <div class="col-lg-7">
                        <div class="main_title">
                            <h2>Billing Details</h2>
                        </div>
                        <div class="billing_form_area">
                            <form class="billing_form row" action="" method="post" id="contactForm"
                                onsubmit="return handlePayment(this);">
                                <div class="form-group col-md-6">
                                    <label for="first">Flat or Building Number *</label>
                                    <input type="text" name="flatbldgnumber" placeholder="Flat or Building Number"
                                        class="form-control" required="true">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="last">Street Name *</label>
                                    <input type="text" name="streename" placeholder="Street Name" class="form-control"
                                        required="true">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="company">Area</label>
                                    <input type="text" name="area" placeholder="Area" class="form-control" required="true">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="address">Landmark if any</label>
                                    <input type="text" name="landmark" placeholder="Landmark if any" class="form-control">

                                </div>
                                <div class="form-group col-md-12">
                                    <label for="city">Town / City *</label>
                                    <input type="text" name="city" placeholder="City" class="form-control" equired="true">
                                </div>

                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="order_box_price">
                            <div class="main_title">
                                <h2>Your Order</h2>
                            </div>
                            <div class="payment_list">
                                <div class="price_single_cost">

                                    <h5>Prodcut <span>Total</span></h5>
                                    <?php
                                    $userid = $_SESSION['fosuid'];
                                    $items_query = mysqli_query($con, "select tblfood.ItemName,tblfood.ItemPrice from tblorders 
    join tblfood on tblfood.ID=tblorders.FoodId 
    where tblorders.UserId='$userid' and tblorders.IsOrderPlaced is null");

                                    if (mysqli_num_rows($items_query) > 0) {
                                        while ($item = mysqli_fetch_array($items_query)) {
                                            ?>
                                            <h5><?php echo $item['ItemName'] ?>
                                                <span>₹<?php echo number_format($item['ItemPrice'], 2) ?></span>
                                            </h5>
                                        <?php
                                        }
                                    }
                                    ?>
                                    <h4>Subtotal <span>₹<?php echo number_format($grandtotal, 2); ?></span></h4>
                                    <h5>Shipping And Handling<span class="text_f">Free Shipping</span></h5>
                                    <h3>Total <span>₹<?php echo number_format($grandtotal, 2); ?></span></h3>
                                </div>
                                <div id="accordion" class="accordion_area">
                                    <div class="card">
                                        <div class="card-header" id="headingOne">
                                            <h5 class="mb-0">
                                                <input type="radio" name="payment_type" value="cod" required> Cash on
                                                Delivery (COD)
                                            </h5>
                                        </div>
                                        <div class="card-header" id="headingTwo">
                                            <h5 class="mb-0">
                                                <input type="radio" name="payment_type" value="online" required> Pay Online
                                                (Razorpay)
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" value="submit" name="placeorder" class="btn pest_btn">Place
                                    Order</button></form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--================End Billing Details Area =================-->

        <?php include_once('includes/footer.php'); ?>





        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="js/jquery-3.2.1.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <!-- Rev slider js -->
        <script src="vendors/revolution/js/jquery.themepunch.tools.min.js"></script>
        <script src="vendors/revolution/js/jquery.themepunch.revolution.min.js"></script>
        <script src="vendors/revolution/js/extensions/revolution.extension.actions.min.js"></script>
        <script src="vendors/revolution/js/extensions/revolution.extension.video.min.js"></script>
        <script src="vendors/revolution/js/extensions/revolution.extension.slideanims.min.js"></script>
        <script src="vendors/revolution/js/extensions/revolution.extension.layeranimation.min.js"></script>
        <script src="vendors/revolution/js/extensions/revolution.extension.navigation.min.js"></script>
        <!-- Extra plugin js -->
        <script src="vendors/owl-carousel/owl.carousel.min.js"></script>
        <script src="vendors/magnifc-popup/jquery.magnific-popup.min.js"></script>
        <script src="vendors/isotope/imagesloaded.pkgd.min.js"></script>
        <script src="vendors/isotope/isotope.pkgd.min.js"></script>
        <script src="vendors/datetime-picker/js/moment.min.js"></script>
        <script src="vendors/datetime-picker/js/bootstrap-datetimepicker.min.js"></script>
        <script src="vendors/nice-select/js/jquery.nice-select.min.js"></script>
        <script src="vendors/jquery-ui/jquery-ui.min.js"></script>
        <script src="vendors/lightbox/simpleLightbox.min.js"></script>



        <script src="js/theme.js"></script>
        <script>
            function validateForm() {
                var required = ['flatbldgnumber', 'streename', 'area', 'city'];
                for (var i = 0; i < required.length; i++) {
                    var field = document.getElementsByName(required[i])[0];
                    if (!field.value.trim()) {
                        alert('Please fill in all required fields');
                        field.focus();
                        return false;
                    }
                }

                if (!document.querySelector('input[name="payment_type"]:checked')) {
                    alert('Please select a payment method');
                    return false;
                }
                return true;
            }

            // Replace the existing handlePayment function
            function handlePayment(form) {
                if (!validateForm()) {
                    return false;
                }

                if (form.payment_type.value === 'online') {
                    event.preventDefault();

                    const formData = new FormData(form);
                    formData.append('is_ajax', '1');
                    formData.append('placeorder', '1');

                    fetch(window.location.href, {
                        method: 'POST',
                        body: formData
                    })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Order creation response:', data); // Add debugging

                            if (data.status === 'error') {
                                throw new Error(data.message);
                            }

                            const options = {
                                key: "<?php echo $keyId; ?>",
                                amount: String(data.amount), // Ensure amount is string
                                currency: "INR",
                                name: "Cake Bakery",
                                description: "Order Payment",
                                order_id: data.order_id,
                                handler: function (response) {
                                    console.log('Payment response:', response); // Add debugging

                                    fetch(window.location.href, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/x-www-form-urlencoded'
                                        },
                                        body: new URLSearchParams({
                                            razorpay_payment_id: response.razorpay_payment_id,
                                            razorpay_order_id: response.razorpay_order_id
                                        })
                                    })
                                        .then(res => {
                                            if (!res.ok) {
                                                throw new Error('Network response was not ok');
                                            }
                                            return res.json();
                                        })
                                        .then(result => {
                                            console.log('Verification result:', result);
                                            if (result.status === 'success') {
                                                alert('Payment successful! Order placed successfully.' +
                                                    (result.emailSent ? ' Confirmation email has been sent to your email address.' : ''));
                                                window.location.href = 'my-order.php';
                                            } else {
                                                throw new Error(result.message);
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Payment verification error:', error);
                                            alert('Payment verification failed. Please contact support.');
                                        });
                                },
                                prefill: {
                                    name: "<?php echo isset($_SESSION['fname']) ? $_SESSION['fname'] : ''; ?>",
                                    email: "<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>",
                                    contact: "<?php echo isset($_SESSION['contact']) ? $_SESSION['contact'] : ''; ?>"
                                },
                                theme: {
                                    color: "#F37254"
                                },
                                modal: {
                                    ondismiss: function () {
                                        console.log('Payment window closed');
                                    }
                                }
                            };

                            const rzp = new Razorpay(options);
                            rzp.open();
                        })
                        .catch(error => {
                            console.error('Order creation error:', error);
                            alert(error.message || 'Failed to initialize payment. Please try again.');
                        });

                    return false;
                }
                return true;
            }

            // Add this to prevent form resubmission
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }

        <?php } ?>
    </script>

</body>

</html>