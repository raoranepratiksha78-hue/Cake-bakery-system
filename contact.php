<?php
include('includes/dbconnection.php');
session_start();
error_reporting(0);

if(isset($_POST['submit']))
  {
    $name=$_POST['name'];
    $email=$_POST['email'];
    $message=$_POST['message'];
     
    $query=mysqli_query($con, "insert into tblcontact(Name,Email,Message) value('$name','$email','$message')");
    if ($query) {
   echo "<script>alert('Your message was sent successfully!.');</script>";
echo "<script>window.location.href ='contact.php'</script>";
  }
  else
    {
       echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }

  
}
  ?>
<!DOCTYPE html>
<html lang="en">
    
<head>
        <title>Cake Bakery System|| Contact Us</title>

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
        
        <link href="css/style.css" rel="stylesheet">
        <link href="css/responsive.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Add Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <style>
            /* Modern Base Styles */
            body {
                font-family: 'Poppins', sans-serif;
                line-height: 1.6;
                background: linear-gradient(135deg, #fff5f5 0%, #fff 100%);
            }

            /* Enhanced Banner Area */
            .banner_area {
                background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('img/banner/banner-bg.jpg');
                padding: 100px 0;
                background-size: cover;
                background-position: center;
                margin-bottom: 60px;
            }

            .banner_text {
                text-align: center;
                color: #fff;
                animation: fadeDown 0.8s ease-out;
            }

            .banner_text h3 {
                font-size: 42px;
                font-weight: 700;
                margin-bottom: 15px;
                text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            }

            /* Enhanced Contact Form */
            .contact_form_area {
                padding: 80px 0;
            }

            .main_title {
                text-align: center;
                margin-bottom: 50px;
            }

            .main_title h2 {
                font-size: 36px;
                font-weight: 700;
                margin-bottom: 20px;
                background: linear-gradient(45deg, #333, #666);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }

            .main_title h5 {
                color: #666;
                line-height: 1.8;
                max-width: 700px;
                margin: 0 auto;
            }

            /* Form Styling */
            .contact_us_form {
                background: white;
                padding: 40px;
                border-radius: 15px;
                box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            }

            .form-control {
                border-radius: 8px;
                border: 1px solid #e2e8f0;
                padding: 12px 15px;
                margin-bottom: 20px;
                transition: all 0.3s ease;
            }

            .form-control:focus {
                border-color: #ff6b6b;
                box-shadow: 0 0 0 3px rgba(255,107,107,0.1);
            }

            textarea.form-control {
                min-height: 120px;
                resize: vertical;
            }

            /* Submit Button */
            .order_s_btn {
                background: linear-gradient(45deg, #ff6b6b, #ff8e8e);
                border-radius: 25px;
                padding: 12px 30px;
                color: white;
                font-weight: 500;
                text-transform: uppercase;
                letter-spacing: 1px;
                border: none;
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(255,107,107,0.2);
            }

            .order_s_btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(255,107,107,0.3);
                background: linear-gradient(45deg, #ff8e8e, #ff6b6b);
            }

            /* Contact Details Card */
            .contact_details {
                background: white;
                padding: 40px;
                border-radius: 15px;
                box-shadow: 0 5px 20px rgba(0,0,0,0.08);
                height: 100%;
            }

            .contact_d_item {
                margin-bottom: 30px;
                padding-bottom: 20px;
                border-bottom: 1px solid #eee;
            }

            .contact_d_item:last-child {
                border-bottom: none;
                margin-bottom: 0;
                padding-bottom: 0;
            }

            .contact_d_item h3 {
                font-size: 24px;
                font-weight: 600;
                margin-bottom: 15px;
                color: #333;
            }

            .contact_d_item h5 {
                color: #666;
                margin-bottom: 10px;
                font-size: 16px;
            }

            .contact_d_item p {
                color: #666;
                line-height: 1.8;
            }

            /* Animations */
            @keyframes fadeDown {
                from {
                    opacity: 0;
                    transform: translateY(-20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* Responsive Improvements */
            @media (max-width: 768px) {
                .contact_us_form {
                    padding: 25px;
                }

                .contact_details {
                    margin-top: 30px;
                }

                .banner_text h3 {
                    font-size: 32px;
                }
            }
        </style>
    </head>
    <body>
        
        <!--================Main Header Area =================-->
		<?php include_once('includes/header.php');?>
        <!--================End Main Header Area =================-->
        
        <!--================End Main Header Area =================-->
        <section class="banner_area">
        	<div class="container">
        		<div class="banner_text">
        			<h3>Contact Us</h3>
        			<ul>
        				<li><a href="index.php">Home</a></li>
        				<li><a href="contact.php">Contact Us</a></li>
        			</ul>
        		</div>
        	</div>
        </section>
        <!--================End Main Header Area =================-->
        
        <!--================Contact Form Area =================-->
        <section class="contact_form_area p_100">
        	<div class="container">
        		<div class="main_title">
					<h2>Get In Touch</h2>
					<h5>Do you have anything in your mind to let us know?  Kindly don't delay to connect to us by means of our contact form.</h5>
				</div>
       			<div class="row">
       				<div class="col-lg-7">
       					<form class="row contact_us_form" action="" method="post">
							<div class="form-group col-md-6">
								<input type="text" class="form-control" id="name" name="name" placeholder="Your name">
							</div>
							<div class="form-group col-md-6">
								<input type="email" class="form-control" id="email" name="email" placeholder="Email address">
							</div>
							
							<div class="form-group col-md-12">
								<textarea class="form-control" name="message" id="message" rows="1" placeholder="Wrtie message"></textarea>
							</div>
							<div class="form-group col-md-12">
								<button type="submit" value="submit" name="submit" class="btn order_s_btn form-control">submit now</button>
							</div>
						</form>
       				</div>
       				<div class="col-lg-4 offset-md-1">
       					<div class="contact_details">
       						<?php

$ret=mysqli_query($con,"select * from tblpage where PageType='contactus' ");
$cnt=1;
while ($row=mysqli_fetch_array($ret)) {

?>
       						<div class="contact_d_item">
       							<h3>Address :</h3>
       							<p><?php  echo $row['PageDescription'];?></p>
       						</div>
       						<div class="contact_d_item">
       							<h5>Phone : <?php  echo $row['MobileNumber'];?></h5>
       							<h5>Email : <?php  echo $row['Email'];?></h5>
       						</div>
       						
       					</div>
       				</div><?php } ?>
       			</div>
        	</div>
        </section>
        <!--================End Contact Form Area =================-->
        
        
       
       <?php include_once('includes/footer.php');?>
        
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
        <script src="vendors/datetime-picker/js/moment.min.js"></script>
        <script src="vendors/datetime-picker/js/bootstrap-datetimepicker.min.js"></script>
        <script src="vendors/nice-select/js/jquery.nice-select.min.js"></script>
        <script src="vendors/jquery-ui/jquery-ui.min.js"></script>
        <script src="vendors/lightbox/simpleLightbox.min.js"></script>
        <!--gmaps Js-->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
        <script src="js/gmaps.min.js"></script>
        <script src="js/map-active.js"></script>
        
        <!-- contact js -->
        <script src="js/jquery.form.js"></script>
        <script src="js/jquery.validate.min.js"></script>
        <script src="js/contact.js"></script>
        
        <script src="js/theme.js"></script>
    </body>

</html>