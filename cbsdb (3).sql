-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 02, 2025 at 11:01 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cbsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `ID` int(11) NOT NULL,
  `AdminName` varchar(45) DEFAULT NULL,
  `UserName` varchar(45) DEFAULT NULL,
  `MobileNumber` bigint(11) DEFAULT NULL,
  `Email` varchar(120) DEFAULT NULL,
  `Password` varchar(120) DEFAULT NULL,
  `AdminRegdate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`ID`, `AdminName`, `UserName`, `MobileNumber`, `Email`, `Password`, `AdminRegdate`) VALUES
(1, 'Admin', 'admin', 7894561238, 'test@gmail.com', 'f925916e2754e5e03f75dd58a5733251', '2019-04-05 07:16:39');

-- --------------------------------------------------------

--
-- Table structure for table `tblcategory`
--

CREATE TABLE `tblcategory` (
  `ID` int(5) NOT NULL,
  `CategoryName` varchar(120) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblcategory`
--

INSERT INTO `tblcategory` (`ID`, `CategoryName`, `CreationDate`) VALUES
(3, 'Eggless Cake', '2019-04-05 10:36:01'),
(4, 'Kids Cake', '2019-04-05 10:36:25'),
(5, 'Photo Cake', '2019-04-05 10:36:35'),
(6, 'Premium Cake', '2019-04-05 10:36:47'),
(7, 'Cup Cake', '2019-04-05 10:43:13'),
(8, 'Birthday Cake', '2019-04-05 10:43:45');

-- --------------------------------------------------------

--
-- Table structure for table `tblcontact`
--

CREATE TABLE `tblcontact` (
  `ID` int(10) NOT NULL,
  `Name` varchar(200) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `Message` mediumtext DEFAULT NULL,
  `EnquiryDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `IsRead` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcontact`
--

INSERT INTO `tblcontact` (`ID`, `Name`, `Email`, `Message`, `EnquiryDate`, `IsRead`) VALUES
(1, 'Kiran', 'kran@gmail.com', 'cost of volvo place pritampura to dwarka', '2021-07-05 07:26:24', 1),
(2, 'Sarita Pandey', 'sar@gmail.com', 'huiyuihhjjkhkjvhknv iyi tuyvuoiup', '2021-07-09 12:48:40', 1),
(3, 'Test', 'test@gmail.com', 'Want to know price of forest cake', '2021-07-16 12:51:06', 1),
(4, 'Anuj', 'ak330@gmail.com', 'This is for testing.', '2021-07-18 14:35:50', 1),
(5, 'Darsh Patel', 'todarshpatel003@gmail.com', 'dfghyrhjtyjhngh', '2025-01-22 16:00:08', 1),
(6, 'dhiraj', 'shelkedhiraj@gmail.com', '', '2025-02-23 14:48:57', 1),
(7, 'neha', 'nehakale@gmail.com', '', '2025-02-28 16:16:53', 1),
(8, 'mita', 'mita@gmail.com', 'this is for cake delivery', '2025-02-28 16:18:27', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblfood`
--

CREATE TABLE `tblfood` (
  `ID` int(10) NOT NULL,
  `CategoryName` varchar(120) DEFAULT NULL,
  `ItemName` varchar(120) DEFAULT NULL,
  `ItemPrice` varchar(120) DEFAULT NULL,
  `ItemDes` varchar(500) DEFAULT NULL,
  `Image` varchar(120) DEFAULT NULL,
  `ItemQty` varchar(120) DEFAULT NULL,
  `Weight` varchar(100) DEFAULT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblfood`
--

INSERT INTO `tblfood` (`ID`, `CategoryName`, `ItemName`, `ItemPrice`, `ItemDes`, `Image`, `ItemQty`, `Weight`, `CreationDate`) VALUES
(17, 'Eggless Cake', 'Black Forest Eggless Cake', '500', 'Classic chocolate sponge layered with whipped cream and cherries, made without eggs.                                                 	', '9e044ea0ed5817381b189680f392bafejpeg', '1', '500 gm', '2025-03-02 09:06:29'),
(18, 'Eggless Cake', 'Choco Truffle Eggless Cake ', '550', 'Rich and moist chocolate cake filled with smooth truffle ganache.                                                 	', '9633bdc271363bb6674c85b86214771ajpeg', '1', '500 gm', '2025-03-02 09:07:59'),
(19, 'Eggless Cake', 'Irish Coffee Eggless Cake', '600', 'A delightful coffee-flavored cake with a hint of Irish cream essence.                                                 	', '30ab613af6f4a62713c6d98615fec492jpeg', '1', '500 gm', '2025-03-02 09:11:42'),
(20, 'Eggless Cake', 'Red Velvet Eggless Cake', '700', 'Smooth and velvety red sponge layered with cream cheese frosting.                                                 	', '8c9dca43740917e7655964d6c1a3e8adjpeg', '1', '500 gm', '2025-03-02 09:12:32'),
(21, 'Eggless Cake', 'Mango Delight Eggless Cake', '700', 'Fresh mango-flavored sponge topped with mango glaze and chunks.                                                 	', '68d5535b971d558f594f10a5affd0a71jpeg', '1', '500 gm', '2025-03-02 09:13:31'),
(22, 'Kids Cake', 'Tom & Jerry Birthday Cake', '1500', 'A fun and colorful cake featuring Tom &amp; Jerry characters in edible design.                                                 	', 'da02ee6e35896728aed0d7e4a7bbe8fejpeg', '1', '1 kg', '2025-03-02 09:14:35'),
(23, 'Kids Cake', 'Mickey & Minnie Fun Cake', '1600', 'Adorable cake with Mickey &amp; Minnie Mouse theme, perfect for Disney fans.                                                 	', '81d564ceb309712edc4debc435994f9ejpeg', '1', '1 kg', '2025-03-02 09:15:48'),
(24, 'Kids Cake', 'Superhero Theme Cake', '1400', 'Custom superhero cake featuring Spiderman, Batman, or Avengers.', '81e6e31bc70a96be3b8670324c7e134djpeg', '1', '1 kg', '2025-03-02 09:16:43'),
(25, 'Kids Cake', 'Frozen Elsa Theme Cake', '1800', 'A dreamy blue-and-white cake with edible Elsa and snowflake decorations.                                                 	', '129cf53c7e62c2442726173aaed584e0jpeg', '1', '1 kg', '2025-03-02 09:18:03'),
(26, 'Kids Cake', 'Peppa Pig Celebration Cake', '1500', 'Cute Peppa Pig-themed cake for toddlers with edible character prints.                                                 	', 'f159890f1397bdc6f09027d9c3afc206jpeg', '1', '1 kg', '2025-03-02 09:19:26'),
(27, 'Photo Cake', 'Photo Cake for Kids', '1400', 'Personalized cake with a fun edible photo of your child’s favorite character.                                                 	', 'a35de166f3cd110217f42458b23a95cdjpeg', '1', '500 gm', '2025-03-02 09:20:25'),
(29, 'Photo Cake', 'Personalized Birthday Photo Cake', '1300', 'Custom birthday cake featuring an edible image of the birthday person.                                                 	', '86d43c46e8bde981fb3c530dc81cea87jpeg', '1', '1 kg', '2025-03-02 09:32:02'),
(30, 'Photo Cake', 'Heart-Shaped Romantic Photo Cake', '1800', 'Lovely heart-shaped cake with an edible romantic photo and roses.                                                 	', '077690a1b25efdb603548752eb1a1de7jpeg', '1', '1.5 kg', '2025-03-02 09:33:01'),
(31, 'Photo Cake', 'Custom Printed Corporate Cake', '1500', 'Perfect for business events, featuring a company logo or celebration message.                                                 	', '5a215f905c48d4545c49f41829bb8600jpeg', '1', '1.5 kg', '2025-03-02 09:34:13'),
(32, 'Photo Cake', 'Photo Cake for Anniversary', '600', 'Photo Cake for Anniversary', '3ece84917a18f5a641332ace1cfc54b9jpeg', '1', '500 gm', '2025-03-02 09:34:56'),
(33, 'Premium Cake', 'Indulging Pineapple Cake', '900', '                                                    Soft vanilla sponge layered with juicy pineapple chunks and whipped cream                                                 	', 'f49fb1be0b94f12ed312c8f14508a919jpeg', '1', '1 kg', '2025-03-02 09:37:53'),
(34, 'Premium Cake', 'Fantastic Chocolate Cake', '1000', '                                                    Intensely rich chocolate cake with layers of silky chocolate mousse.', '8cead2b53b6c29a1495c6fe23fa1bfc0jpeg', '1', '1 kg', '2025-03-02 09:39:07'),
(35, 'Premium Cake', 'Ferrero Rocher Luxury Cake', '1900', 'Decadent hazelnut and chocolate cake topped with Ferrero Rocher chocolates.                                                 	', '5430bcef5472b3f6a78fbb212409e422jpeg', '1', '1 kg', '2025-03-02 09:40:24'),
(37, 'Premium Cake', 'Hazelnut Praline Cake', '1200', '<span data-start=\"2591\" data-end=\"2650\">Crunchy praline and hazelnut-infused cake for nut lovers</span><em data-start=\"2591\" data-end=\"2650\">.</em>', '55184a78c774798be679190ad371ce54jpeg', '1', '1.5 kg', '2025-03-02 09:42:03'),
(38, 'Premium Cake', 'Raspberry Almond Cake', '1000', 'Delicate almond sponge with tangy raspberry filling and whipped cream.                                                 	', '8a1e0ffbf0ee5f815daf7aa019924b7bjpeg', '1', '1 kg', '2025-03-02 09:42:48'),
(39, 'Cup Cake', 'Chocolate Cupcakes ', '350', 'Soft chocolate cupcakes topped with smooth chocolate frosting.                                                 	', '2f2afe9d11a91e48875b05fc53c3b1c1jpeg', '4', '500 gm', '2025-03-02 09:43:48'),
(40, 'Cup Cake', 'Assorted Box of 6 Cupcakes', '450', 'A mix of vanilla, chocolate, and red velvet cupcakes with creamy toppings.                                                 	', '5b3a2379bfa837e0e467f5e1481a90e8jpeg', '6', '500 gm', '2025-03-02 09:44:41'),
(41, 'Cup Cake', 'Oreo Chocolate Cupcake (Set of 4)', '400', 'Moist chocolate cupcake topped with cookies &amp; cream frosting and Oreo chunks.                                                 	', '32d825c540f1a05c4fc9f7c7d07b29b5jpeg', '4', '500 gm', '2025-03-02 09:46:25'),
(42, 'Cup Cake', 'Nutella Filled Cupcake (Set of 4)', '600', 'Decadent cupcakes with a gooey Nutella center and hazelnut frosting                                                 	', '3c8a22aa8a99a50c5b9695d5b5f934d4jpeg', '1', '1 kg', '2025-03-02 09:47:25'),
(43, 'Birthday Cake', 'Jungle Theme Cake', '1000', 'A vibrant cake with cute animal figures, trees, and edible jungle décor.                                                 	', '0a2a883804a1fa9b3fff55d756ba4148jpeg', '1', '1 kg', '2025-03-02 09:48:18'),
(44, 'Birthday Cake', 'Farm Animal Cake', '1100', '                                                    Cute farm-themed cake with cows, pigs, and chickens in edible designs.                                                 	', '1ec6902df3def7deced72c3efabdddd9jpeg', '1', '1 kg', '2025-03-02 09:49:38'),
(45, 'Birthday Cake', 'Unicorn Birthday Cake', '1250', 'A magical cake with pastel colors, fondant unicorn horn, and rainbow sprinkles.                                                 	', 'f05577ec3c22c3f88384357bf5c3259bjpeg', '1', '1 kg', '2025-03-02 09:50:23'),
(46, 'Birthday Cake', 'Baby Shark Cake', '900', 'Brightly colored cake featuring Baby Shark characters with edible ocean waves.                                                 	', '52ff3ff4e47387b9542372ab6ce4475cjpeg', '1', '1 kg', '2025-03-02 09:51:41'),
(47, 'Birthday Cake', 'Cocomelon Theme Cake', '1200', 'A cheerful cake inspired by the popular kids’ show, Cocomelon.                                                 	', 'a730d84b097c7ddb5a42a68299c23c04jpeg', '1', '1 kg', '2025-03-02 09:52:37');

-- --------------------------------------------------------

--
-- Table structure for table `tblfoodtracking`
--

CREATE TABLE `tblfoodtracking` (
  `ID` int(10) NOT NULL,
  `OrderId` char(50) DEFAULT NULL,
  `remark` varchar(200) DEFAULT NULL,
  `status` char(50) DEFAULT NULL,
  `StatusDate` timestamp NULL DEFAULT current_timestamp(),
  `OrderCanclledByUser` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblfoodtracking`
--

INSERT INTO `tblfoodtracking` (`ID`, `OrderId`, `remark`, `status`, `StatusDate`, `OrderCanclledByUser`) VALUES
(1, '255844784', 'test', 'Cake being Prepared', '2025-01-26 09:53:12', NULL),
(2, '255844784', 'dcds', 'Order Confirmed', '2025-01-26 09:54:18', NULL),
(3, '846733115', 'vv', 'Order Cancelled', '2025-01-26 09:57:38', 1),
(4, '255844784', 'dcds', 'Order Confirmed', '2025-01-26 09:59:05', NULL),
(5, '208481684', 'dfty', 'Order Confirmed', '2025-02-08 09:21:58', NULL),
(6, '208481684', 'gyug', 'Cake being Prepared', '2025-02-08 09:22:32', NULL),
(7, '208481684', 'hghj', 'Cake Pickup', '2025-02-08 09:22:52', NULL),
(8, '899098466', 'cash delevery not', 'Order Cancelled', '2025-02-26 17:29:21', 1),
(9, '255844784', 'name chnage\r\n', 'Order Confirmed', '2025-02-27 14:41:44', NULL),
(10, '984981397', 'i want to order different category', 'Order Cancelled', '2025-03-01 04:14:09', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblorderaddresses`
--

CREATE TABLE `tblorderaddresses` (
  `ID` int(11) NOT NULL,
  `UserId` char(100) DEFAULT NULL,
  `Ordernumber` char(100) DEFAULT NULL,
  `Flatnobuldngno` varchar(255) DEFAULT NULL,
  `StreetName` varchar(255) DEFAULT NULL,
  `Area` varchar(255) DEFAULT NULL,
  `Landmark` varchar(255) DEFAULT NULL,
  `City` varchar(255) DEFAULT NULL,
  `OrderTime` timestamp NOT NULL DEFAULT current_timestamp(),
  `OrderFinalStatus` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblorderaddresses`
--

INSERT INTO `tblorderaddresses` (`ID`, `UserId`, `Ordernumber`, `Flatnobuldngno`, `StreetName`, `Area`, `Landmark`, `City`, `OrderTime`, `OrderFinalStatus`) VALUES
(1, '11', '255844784', 'b01', 'dffg', 'dfgfb', 'bhaji gali', 'Virar west', '2025-01-26 09:48:50', 'Order Confirmed'),
(2, '11', '846733115', 'b01', 'dffg', 'dfgfb', 'bhaji gali', 'Virar', '2025-01-26 09:55:41', 'Order Cancelled'),
(3, '11', '986805838', 'b01', 'dffg', 'dfgfb', 'bhaji gali', 'Virar', '2025-01-26 10:56:15', NULL),
(4, '12', '208481684', '102', 'saidarshan', 'sainath', 'chandansar', 'virara', '2025-02-08 09:14:23', 'Cake Pickup'),
(5, '14', '821366751', '150', 'saidarshan', 'morewadhi', 'chandansar', 'palgar', '2025-02-12 17:26:45', NULL),
(6, '16', '288320775', '103', 'kopari', 'vaishnavi nagar', 'chandansar', 'virar', '2025-02-23 14:56:03', NULL),
(7, '18', '899098466', '201', 'pali', 'rajodhi', 'navapur', 'arnala beach', '2025-02-26 17:26:55', 'Order Cancelled'),
(8, '18', '527521187', '402', 'lavdeep apt', 'dhumaal nagar', 'vasai', 'virar', '2025-02-28 05:24:34', NULL),
(9, '18', '731696364', '105', 'pali', 'morewadhi', 'kadamwadi', 'arnala beach', '2025-02-28 05:27:25', NULL),
(10, '18', '305297093', '150', 'pali', 'morewadhi', 'vasai', 'mumbai', '2025-02-28 05:29:15', NULL),
(11, '20', '345385748', '502', 'narangi', 'nalasopara', 'nagar', 'dhanu', '2025-02-28 09:00:16', NULL),
(12, '21', '643825228', '503', 'naded', 'shiradi', 'nashil', 'salunke ', '2025-02-28 14:13:41', NULL),
(13, '22', '598213086', '602', 'radhanagri', 'kholapur', 'kasal', 'kolhapur', '2025-02-28 14:28:21', NULL),
(14, '23', '678257305', '801', 'mumbai', 'umbarde', 'vaibhawadhi', 'sindhurang', '2025-03-01 00:16:21', NULL),
(15, '24', '406411985', '603', 'mumbai', 'virar', 'hospital', 'virar', '2025-03-01 02:46:45', NULL),
(16, '24', '361537431', '605', 'mumbai', 'sainath', 'navapur', 'rankala', '2025-03-01 03:20:29', NULL),
(17, '25', '984981397', '103', 'mumbai', 'shree ram nagar', 'vasai', 'palgar', '2025-03-01 04:13:16', 'Order Cancelled'),
(18, '26', '791462241', '603', 'saidarshan', 'shree ram nagar', 'nagar', 'arnala beach', '2025-03-01 05:46:59', NULL),
(19, '28', '435496304', '603', 'mumbai', 'sainath', 'chandansar', 'mumbai', '2025-03-01 06:41:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblorders`
--

CREATE TABLE `tblorders` (
  `ID` int(11) NOT NULL,
  `UserId` char(10) DEFAULT NULL,
  `FoodId` char(10) DEFAULT NULL,
  `IsOrderPlaced` int(11) DEFAULT NULL,
  `OrderNumber` char(100) DEFAULT NULL,
  `CashonDelivery` varchar(100) DEFAULT NULL,
  `OrderDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `PaymentType` varchar(50) DEFAULT NULL,
  `PaymentID` varchar(100) DEFAULT NULL,
  `orderId` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblorders`
--

INSERT INTO `tblorders` (`ID`, `UserId`, `FoodId`, `IsOrderPlaced`, `OrderNumber`, `CashonDelivery`, `OrderDate`, `PaymentType`, `PaymentID`, `orderId`) VALUES
(1, '11', '2', 1, '255844784', NULL, '2025-01-26 09:39:00', 'Razorpay', 'pay_Po1nngHQ8qMUrI', 'order_Po1nL1uVv8Ftuy'),
(2, '11', '3', 1, '255844784', NULL, '2025-01-26 09:39:03', 'Razorpay', 'pay_Po1nngHQ8qMUrI', 'order_Po1nL1uVv8Ftuy'),
(3, '11', '2', 1, '846733115', 'Cash on Delivery', '2025-01-26 09:55:17', 'COD', NULL, NULL),
(4, '11', '1', 1, '846733115', 'Cash on Delivery', '2025-01-26 09:55:21', 'COD', NULL, NULL),
(5, '11', '1', 1, '986805838', NULL, '2025-01-26 10:55:19', 'Razorpay', 'pay_Po2wyrbEXmMCx5', 'order_Po2wqdXQOZGP5u'),
(6, '11', '4', 1, '986805838', NULL, '2025-01-26 10:55:23', 'Razorpay', 'pay_Po2wyrbEXmMCx5', 'order_Po2wqdXQOZGP5u'),
(7, '11', '7', 1, '986805838', NULL, '2025-01-26 10:55:26', 'Razorpay', 'pay_Po2wyrbEXmMCx5', 'order_Po2wqdXQOZGP5u'),
(8, '12', '8', 1, '208481684', NULL, '2025-02-08 09:06:25', 'Razorpay', 'pay_PtAA5cKJZ7Fu8C', 'order_PtA8lV65VqO4aP'),
(9, '12', '5', NULL, NULL, NULL, '2025-02-11 07:57:33', NULL, NULL, NULL),
(10, '14', '11', 1, '821366751', NULL, '2025-02-12 17:20:17', 'Razorpay', 'pay_PusgaRqQVrNjIU', 'order_PuscOVnA5O5goD'),
(11, '14', '4', NULL, NULL, NULL, '2025-02-21 16:14:33', NULL, NULL, NULL),
(12, '16', '5', 1, '288320775', NULL, '2025-02-23 14:46:43', 'Razorpay', 'pay_PzBzpNcRy8j2Zt', 'order_PzBwKBzyaNeZf2'),
(13, '16', '3', 1, '288320775', NULL, '2025-02-23 14:50:14', 'Razorpay', 'pay_PzBzpNcRy8j2Zt', 'order_PzBwKBzyaNeZf2'),
(14, '16', '15', 1, '288320775', NULL, '2025-02-23 14:50:31', 'Razorpay', 'pay_PzBzpNcRy8j2Zt', 'order_PzBwKBzyaNeZf2'),
(15, '16', '3', 1, '288320775', NULL, '2025-02-23 14:50:44', 'Razorpay', 'pay_PzBzpNcRy8j2Zt', 'order_PzBwKBzyaNeZf2'),
(16, '16', '12', NULL, NULL, NULL, '2025-02-23 17:23:59', NULL, NULL, NULL),
(18, '16', '7', NULL, NULL, NULL, '2025-02-23 17:24:52', NULL, NULL, NULL),
(19, '17', '15', NULL, NULL, NULL, '2025-02-24 05:03:43', NULL, NULL, NULL),
(20, '14', '4', NULL, NULL, NULL, '2025-02-26 17:01:56', NULL, NULL, NULL),
(22, '18', '5', 1, '899098466', 'Cash on Delivery', '2025-02-26 17:25:16', 'COD', NULL, NULL),
(23, '19', '12', NULL, NULL, NULL, '2025-02-27 14:24:23', NULL, NULL, NULL),
(24, '18', '1', 1, '527521187', 'Cash on Delivery', '2025-02-28 05:21:40', 'COD', NULL, NULL),
(25, '18', '5', 1, '527521187', 'Cash on Delivery', '2025-02-28 05:22:22', 'COD', NULL, NULL),
(26, '18', '4', 1, '731696364', NULL, '2025-02-28 05:24:52', 'Razorpay', 'pay_Q10yFXt2iHYLOq', 'order_Q10wjNBPoHAGdK'),
(27, '18', '10', 1, '305297093', NULL, '2025-02-28 05:27:44', 'Razorpay', 'pay_Q1107TSY6VfeqB', 'order_Q10zp3ukeqHn11'),
(28, '20', '2', 1, '345385748', NULL, '2025-02-28 08:55:15', 'Razorpay', 'pay_Q14bJI9c7KPSL2', 'order_Q14XjaL0BBOeRb'),
(30, '21', '9', 1, '643825228', 'Cash on Delivery', '2025-02-28 14:09:34', 'COD', NULL, NULL),
(31, '21', '9', NULL, NULL, NULL, '2025-02-28 14:15:18', NULL, NULL, NULL),
(32, '22', '15', 1, '598213086', NULL, '2025-02-28 14:25:07', 'Razorpay', 'pay_Q1ABx0WBHMdniL', 'order_Q1ABJ2R1jHw0vr'),
(33, '23', '7', 1, '678257305', NULL, '2025-03-01 00:13:46', 'Razorpay', 'pay_Q1KD381IphIB7P', 'order_Q1KCWx2yHix180'),
(34, '24', '4', 1, '406411985', NULL, '2025-03-01 02:45:13', 'Razorpay', 'pay_Q1MlpkFDVYxGMZ', 'order_Q1MlYMHuCw00dB'),
(35, '24', '10', 1, '361537431', NULL, '2025-03-01 03:18:41', 'Razorpay', 'pay_Q1NLdZDKXfXbcy', 'order_Q1NLALbow1DugF'),
(36, '25', '6', 1, '984981397', 'Cash on Delivery', '2025-03-01 04:11:37', 'COD', NULL, NULL),
(37, '25', '3', NULL, NULL, NULL, '2025-03-01 04:21:05', NULL, NULL, NULL),
(38, '26', '15', 1, '791462241', NULL, '2025-03-01 05:45:18', 'Razorpay', 'pay_Q1PqOjv3761UCM', 'order_Q1PpvpA5yq04lz'),
(39, '26', '3', NULL, NULL, NULL, '2025-03-01 05:48:37', NULL, NULL, NULL),
(41, '28', '7', 1, '435496304', NULL, '2025-03-01 06:38:03', 'Razorpay', 'pay_Q1QldLBgTfxlbZ', 'order_Q1Ql0DNRrcvUUG');

-- --------------------------------------------------------

--
-- Table structure for table `tblpage`
--

CREATE TABLE `tblpage` (
  `ID` int(10) NOT NULL,
  `PageType` varchar(200) DEFAULT NULL,
  `PageTitle` varchar(200) DEFAULT NULL,
  `PageDescription` mediumtext DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `MobileNumber` bigint(10) DEFAULT NULL,
  `UpdationDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblpage`
--

INSERT INTO `tblpage` (`ID`, `PageType`, `PageTitle`, `PageDescription`, `Email`, `MobileNumber`, `UpdationDate`) VALUES
(1, 'aboutus', 'About us', '<p class=\"MsoNormal\"><span style=\"font-size: 11.5pt; line-height: 115%; font-family: Roboto; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">We provide you a trustworthy and convenient platform\r\nto choose best gift for your family, friends etc. for every occasion like\r\nbirthdays, anniversaries, marriage, love, farewell and many more. We offer wide\r\nrange of products in various categories like cakes, egg-less cakes, drawing\r\ncakes, 3D cakes, photo cakes, collectibles, chocolates, bouquet, flowers bunch,\r\nsoft toys, greeting cards, candles, photo frames, handicrafts etc. We also\r\ncustomize gifts according to customer wish.</span></p>', NULL, NULL, '2021-07-16 06:44:44'),
(2, 'contactus', 'Contact Us', '                #890 CFG Apartment, sayali shelke, mumbai-India.', 'cakecreave@gmail.com', 4654789791, '2025-02-28 14:35:54');

-- --------------------------------------------------------

--
-- Table structure for table `tblsubscriber`
--

CREATE TABLE `tblsubscriber` (
  `ID` int(5) NOT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `DateofSub` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblsubscriber`
--

INSERT INTO `tblsubscriber` (`ID`, `Email`, `DateofSub`) VALUES
(1, 'ani@gmail.com', '2021-07-16 07:32:33'),
(2, 'rahul@gmail.com', '2021-07-16 07:32:33'),
(3, 'ak@gmail.com', '2021-07-18 14:35:00'),
(4, 'sdvsdvs', '2025-01-21 16:53:58'),
(5, '', '2025-01-26 09:44:56'),
(6, 'Shelkesayali69@gmaill.com', '2025-02-23 14:42:42'),
(7, 'Shelkesayali69@gamil.com', '2025-02-28 16:15:50');

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE `tbluser` (
  `ID` int(10) NOT NULL,
  `FirstName` varchar(45) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `Email` varchar(120) DEFAULT NULL,
  `MobileNumber` bigint(11) DEFAULT NULL,
  `Password` varchar(120) DEFAULT NULL,
  `RegDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbluser`
--

INSERT INTO `tbluser` (`ID`, `FirstName`, `LastName`, `Email`, `MobileNumber`, `Password`, `RegDate`) VALUES
(1, 'sayali', 'shelke', 'testuser@gmail.com', 7894561236, '202cb962ac59075b964b07152d234b70', '2019-04-08 07:41:22'),
(2, 'neha', 'Chandra', 'rakesh@gmail.com', 7656234589, '202cb962ac59075b964b07152d234b70', '2019-04-08 07:43:28'),
(3, 'Yogesh', 'Chandra', 'y@gmail.com', 8989898989, '202cb962ac59075b964b07152d234b70', '2019-04-24 07:04:02'),
(4, 'Yogesh', 'Shah', 'Test1@gmail.com', 8975895698, '202cb962ac59075b964b07152d234b70', '2019-05-06 09:09:05'),
(5, 'Test demo', 'User', 'testuser123@gmail.com', 1234567890, '7ec66345281b134a33f784bcd06d7ea5', '2019-05-06 16:26:40'),
(6, 'Abir', 'Rajwansh', 'abir@gmail.com', 7987897897, '202cb962ac59075b964b07152d234b70', '2021-07-10 06:58:13'),
(7, 'Devi Nand', 'Shah', 'Devi@gmail.com', 9797987987, '202cb962ac59075b964b07152d234b70', '2021-07-16 08:02:24'),
(8, 'Anuj', 'Kumar', 'ak3330@gmail.com', 1122334455, 'f925916e2754e5e03f75dd58a5733251', '2021-07-18 14:31:30'),
(9, 'darshan', 'Patil', 'test@gmail.com', 4343453545, 'e10adc3949ba59abbe56e057f20f883e', '2024-12-22 08:26:19'),
(10, 'rud', 'Patil', 'todarshpatel003@gmail.com', 7517986796, '36af72130645c7fe73f5843539931c4b', '2025-01-22 15:48:21'),
(11, 'Darsh', 'Patel', 'todarshpatel@gmail.com', 7517986793, '25d55ad283aa400af464c76d713c07ad', '2025-01-22 15:49:41'),
(12, 'Sayali', 'Shelke', 'Shelkesayali69@gmaill.com', 7666747907, 'bdd7ab7ed7238afaba90c77ed2ab5546', '2025-02-08 09:05:26'),
(13, 'richa', 'jha', 'richajha89@gmaill.com', 7698547895, '827ccb0eea8a706c4c34a16891f84e7b', '2025-02-10 13:33:19'),
(14, 'nisha', 'yadhav', 'nishayadhav23@gmaill.com', 1587459654, 'e35cf7b66449df565f93c607d5a81d09', '2025-02-12 17:18:21'),
(15, 'teju', 'barage', 'tejubarage5650@gmail.com', 9325840833, 'e10adc3949ba59abbe56e057f20f883e', '2025-02-21 16:19:35'),
(16, 'sayali', 'Shelke', 'shelkedhiraj@gmail.com', 9850847027, 'e10adc3949ba59abbe56e057f20f883e', '2025-02-23 14:45:21'),
(17, 'richa ', 'jha', 'jha821299@gmail.com', 7559453154, 'eff6d0928cbe993430a322f5c2c5ab2c', '2025-02-24 05:01:21'),
(18, 'neha', 'rathe', 'admin@gmail.com', 4561237890, 'f925916e2754e5e03f75dd58a5733251', '2025-02-26 17:24:45'),
(19, 'neha', 'sathe', 'satheneha@gmail.com', 9325983268, '3fede54cd3cf786471ca20e4d40d9b8c', '2025-02-27 14:21:45'),
(20, 'pooja', 'sing', 'singpooja@1gmail.com', 7756935313, '65cc2c8205a05d7379fa3a6386f710e1', '2025-02-28 08:54:40'),
(21, 'nishita', 'rathod', 'nitasane@5gmail.com', 9404844299, '1cb524b5a3f3f82be4a7d954063c07e2', '2025-02-28 14:05:50'),
(22, 'anoli', 'patil', 'anolipatil@6gmail.com', 8208904629, 'e4a93f0332b2519177ed55741ea4e5e7', '2025-02-28 14:08:42'),
(23, 'sanvi', 'ravrone', 'sanviravrone@9gmail.com', 8605742646, '6687cb56cc090abcaedefca26a8e6606', '2025-03-01 00:11:31'),
(24, 'samrin', 'shek', 'samrinshek@gmail.com', 9322870182, 'cc638784cf213986ec75983a4aa08cdb', '2025-03-01 02:44:56'),
(25, 'sana', 'jha', 'jhasana@2gmail.com', 3698521475, '731309c4bb223491a9f67eac5214fb2e', '2025-03-01 04:10:55'),
(26, 'nita', 'Shelke', 'nita@gmail.com', 3698521473, '0a5c79b1eaf15445da252ada718857e9', '2025-03-01 05:44:51'),
(27, 'tanvi', 'shinde', 'shindetanvi@gmail.com', 9156740956, 'd82d678e9583c1f5f283ec56fbf1abb7', '2025-03-01 05:50:53'),
(28, 'sonali', 's', 'sa@GMAIL.COM', 9876958796, '827ccb0eea8a706c4c34a16891f84e7b', '2025-03-01 06:36:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblcategory`
--
ALTER TABLE `tblcategory`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `CategoryName` (`CategoryName`);

--
-- Indexes for table `tblcontact`
--
ALTER TABLE `tblcontact`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblfood`
--
ALTER TABLE `tblfood`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblfoodtracking`
--
ALTER TABLE `tblfoodtracking`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblorderaddresses`
--
ALTER TABLE `tblorderaddresses`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserId` (`UserId`,`Ordernumber`);

--
-- Indexes for table `tblorders`
--
ALTER TABLE `tblorders`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserId` (`UserId`,`FoodId`,`OrderNumber`);

--
-- Indexes for table `tblpage`
--
ALTER TABLE `tblpage`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblsubscriber`
--
ALTER TABLE `tblsubscriber`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblcategory`
--
ALTER TABLE `tblcategory`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tblcontact`
--
ALTER TABLE `tblcontact`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblfood`
--
ALTER TABLE `tblfood`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `tblfoodtracking`
--
ALTER TABLE `tblfoodtracking`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tblorderaddresses`
--
ALTER TABLE `tblorderaddresses`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tblorders`
--
ALTER TABLE `tblorders`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `tblpage`
--
ALTER TABLE `tblpage`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblsubscriber`
--
ALTER TABLE `tblsubscriber`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
