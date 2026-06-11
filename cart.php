<?php
session_start();
error_reporting(0);
include_once('includes/dbconnection.php');
if (strlen($_SESSION['fosuid'] == 0)) {
    header('location:logout.php');
} else {
    // Code for deleting product from cart
    if (isset($_GET['delid'])) {
        $rid = intval($_GET['delid']);
        $query = mysqli_query($con, "delete from tblorders where ID='$rid'");
        echo "<script>alert('Data deleted');</script>";
        echo "<script>window.location.href = 'cart.php'</script>";


    }

    // Initialize grandtotal at the top of the file after session_start()
    $grandtotal = 0;

    //placing order

    if (isset($_POST['placeorder'])) {
        //getting address
        $fnaobno = $_POST['flatbldgnumber'];
        $street = $_POST['streename'];
        $area = $_POST['area'];
        $lndmark = $_POST['landmark'];
        $city = $_POST['city'];
        $userid = $_SESSION['fosuid'];
        //genrating order number
        $orderno = mt_rand(100000000, 999999999);
        $query = "update tblorders set OrderNumber='$orderno',IsOrderPlaced='1' where UserId='$userid' and IsOrderPlaced is null;";
        $query .= "insert into tblorderaddresses(UserId,Ordernumber,Flatnobuldngno,StreetName,Area,Landmark,City) values('$userid','$orderno','$fnaobno','$street','$area','$lndmark','$city');";

        $result = mysqli_multi_query($con, $query);
        if ($result) {

            echo '<script>alert("Your order placed successfully. Order number is "+"' . $orderno . '")</script>';
            echo "<script>window.location.href='my-order.php'</script>";

        }
    }

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>

        <title>Cake Bakery System|| cart Page</title>

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

        <!-- Add Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
            rel="stylesheet">

        <style>
            /* Modern Base Styles */
            body {
                font-family: 'Poppins', sans-serif;
                line-height: 1.6;
                background: linear-gradient(135deg, #fff5f5 0%, #fff 100%);
            }

            /* Enhanced Banner Area */
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
            }

            .banner_text h3 {
                font-size: 42px;
                font-weight: 700;
                margin-bottom: 15px;
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            }

            /* Enhanced Cart Table */
            .cart_table_area {
                padding: 50px 0;
            }

            .table {
                background: white;
                border-radius: 15px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
                overflow: hidden;
            }

            .table thead th {
                background: linear-gradient(45deg, #ff6b6b, #ff8e8e);
                color: white;
                border: none;
                padding: 15px;
                font-weight: 500;
                text-transform: uppercase;
                font-size: 14px;
            }

            .table tbody td {
                padding: 20px 15px;
                vertical-align: middle;
                border-bottom: 1px solid #eee;
            }

            .table img {
                border-radius: 10px;
                box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s ease;
            }

            .table img:hover {
                transform: scale(1.05);
            }

            /* Enhanced Cart Total Section */
            .cart_total_inner {
                margin-top: 40px;
            }

            .cart_total_text {
                background: white;
                padding: 30px;
                border-radius: 15px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            }

            .cart_head {
                font-size: 24px;
                font-weight: 600;
                color: #333;
                margin-bottom: 20px;
                padding-bottom: 15px;
                border-bottom: 2px solid #eee;
            }

            .sub_total,
            .total {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 15px;
            }

            .total {
                padding-top: 15px;
                border-top: 2px solid #eee;
            }

            .total h4 {
                font-size: 20px;
                font-weight: 700;
                color: #333;
            }

            .total span {
                color: #ff6b6b;
                font-size: 24px;
                font-weight: 700;
            }

            /* Enhanced Button Styles */
            .pest_btn {
                background: linear-gradient(45deg, #ff6b6b, #ff8e8e);
                border-radius: 25px;
                padding: 12px 30px;
                transition: all 0.3s ease;
                border: none;
                color: white;
                text-transform: uppercase;
                letter-spacing: 1px;
                font-size: 14px;
                font-weight: 500;
                display: inline-block;
                box-shadow: 0 4px 15px rgba(255, 107, 107, 0.2);
            }

            .pest_btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(255, 107, 107, 0.3);
                background: linear-gradient(45deg, #ff8e8e, #ff6b6b);
                color: white;
                text-decoration: none;
            }

            /* Delete Button */
            .fa-delete {
                color: #ff6b6b;
                font-size: 20px;
                transition: all 0.3s ease;
            }

            .fa-delete:hover {
                color: #ff4444;
                transform: scale(1.1);
            }

            /* Empty Cart Message */
            .empty-cart {
                text-align: center;
                padding: 40px 20px;
            }

            .empty-cart h3 {
                color: #666;
                margin-bottom: 20px;
            }

            /* Responsive Improvements */
            @media (max-width: 768px) {
                .table {
                    font-size: 14px;
                }

                .cart_total_text {
                    margin-top: 30px;
                }

                .banner_text h3 {
                    font-size: 32px;
                }
            }
        </style>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>

        <!--================Main Header Area =================-->
        <?php include_once('includes/header.php'); ?>
        <!--================End Main Header Area =================-->

        <!--================End Main Header Area =================-->
        <section class="banner_area">
            <div class="container">
                <div class="banner_text">
                    <h3>Cart</h3>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="cart.php">Cart</a></li>
                    </ul>
                </div>
            </div>
        </section>
        <!--================End Main Header Area =================-->

        <!--================Cart Table Area =================-->
        <section class="cart_table_area p_100">
            <div class="container">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Preview</th>
                                <th scope="col">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col">Weight</th>
                                <th scope="col">Total</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $userid = $_SESSION['fosuid'];
                            $query = mysqli_query($con, "select tblfood.Image,tblfood.ItemName,tblfood.ItemDes,tblfood.Weight,tblfood.ItemPrice,tblfood.ItemQty,tblorders.FoodId,tblorders.ID from tblorders join tblfood on tblfood.ID=tblorders.FoodId where tblorders.UserId='$userid' and tblorders.IsOrderPlaced is null");
                            $num = mysqli_num_rows($query);
                            if ($num > 0) {
                                while ($row = mysqli_fetch_array($query)) {
                                    $itemPrice = $row['ItemPrice'];
                                    $grandtotal += $itemPrice; // Add to total
                                    ?>
                                    <tr>
                                        <td>
                                            <img src="admin/itemimages/<?php echo $row['Image'] ?>" width="100" height="80"
                                                alt="<?php echo $row['ItemName'] ?>">
                                        </td>
                                        <td><?php echo $row['ItemName'] ?></td>
                                        <td>₹<?php echo number_format($itemPrice, 2) ?></td>
                                        <td><?php echo $row['Weight'] ?></td>
                                        <td>₹<?php echo number_format($itemPrice, 2) ?></td>
                                        <td>
                                            <a href="cart.php?delid=<?php echo $row['ID']; ?>"
                                                onclick="return confirm('Do you really want to Delete ?');">
                                                <i class="fa fa-trash fa-delete" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php
                                }
                            }
                            ?>
                        </tbody>
                        <tr>
                            <td>

                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>

                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row cart_total_inner">
                    <div class="col-lg-7"></div>
                    <div class="col-lg-5">
                        <div class="cart_total_text">
                            <div class="cart_head">
                                Cart Total
                            </div>
                            <div class="sub_total">
                                <h5>Sub Total <span>₹<?php echo number_format($grandtotal, 2); ?></span></h5>
                            </div>
                            <div class="total">
                                <h4>Total <span>₹<?php echo number_format($grandtotal, 2); ?></span></h4>
                            </div>
                            <div class="cart_footer">
                                <a class="pest_btn" href="checkout.php">Proceed to Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--================End Cart Table Area =================-->

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
    </body>

    </html><?php } ?>