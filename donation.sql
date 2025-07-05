-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2025 at 03:43 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `donation`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`) VALUES
(1, 'admindonation123@gmail.com', 'admin@12345');

-- --------------------------------------------------------

--
-- Table structure for table `billing_address`
--

CREATE TABLE `billing_address` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(500) NOT NULL,
  `zip` int(6) NOT NULL,
  `contact` int(10) NOT NULL,
  `state` text NOT NULL,
  `city` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `billing_address`
--

INSERT INTO `billing_address` (`id`, `name`, `email`, `address`, `zip`, `contact`, `state`, `city`) VALUES
(1, 'Jasvir singh', 'jasvishal123@gmail.com', 'Attlalgarh', 144211, 1234567890, 'PUNJAB', 'Hoshiarpur');

-- --------------------------------------------------------

--
-- Table structure for table `cart_item`
--

CREATE TABLE `cart_item` (
  `id` int(11) NOT NULL,
  `item_name` text NOT NULL,
  `Category` text NOT NULL,
  `Description` varchar(2000) NOT NULL,
  `image` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `delivery_person` varchar(200) DEFAULT NULL,
  `delivery_contact` int(11) DEFAULT NULL,
  `payment` varchar(200) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_item`
--

INSERT INTO `cart_item` (`id`, `item_name`, `Category`, `Description`, `image`, `email`, `quantity`, `price`, `total_price`, `status`, `delivery_person`, `delivery_contact`, `payment`, `product_id`, `order_id`) VALUES
(1, 'HP laptop bag 28 lt', 'Bag', 'Protect your laptop with a padded laptop compartment. This backpack is comfortable, durable, yet delightfully lightweight letting you take your entire setup wherever you want to work.', 'A1KwlpA8pTL._SL1500_.jpg', 'jasvishal123@gmail.com', 2, 700, 1500, NULL, NULL, NULL, 'successful', 2, 24);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `message`) VALUES
(2, 'Hello', 'Hellobroo@gmail.com', 'Hello how are you what are you doing here.'),
(3, 'Jasvir singh', 'jasvirsingh@gmail.com', 'this is my msgg');

-- --------------------------------------------------------

--
-- Table structure for table `donarinfo`
--

CREATE TABLE `donarinfo` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `gender` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(1000) NOT NULL,
  `contact` int(10) NOT NULL,
  `pincode` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donarinfo`
--

INSERT INTO `donarinfo` (`id`, `name`, `gender`, `email`, `address`, `contact`, `pincode`) VALUES
(1, 'Rapid fire', 'Male', 'rapidfire3535@gmail.com', 'Attlalgarh', 1234567890, 144211),
(2, 'vishal', 'Male', 'jbd783345@gmail.com', 'Mukerian', 1234567890, 144211),
(3, 'Arshpreet', 'Male', 'moviesub098765@gmail.com', 'Attlalgarh', 1234567890, 144211);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `pname` text NOT NULL,
  `description` varchar(2000) NOT NULL,
  `category` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `donarmail` varchar(255) NOT NULL,
  `status` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `pname`, `description`, `category`, `image`, `price`, `donarmail`, `status`) VALUES
(1, 'Data structure', 'ork smart, master Algorithms quickly and secure your dream FAANGMULA job.This book \"Data Structures and Algorithms: Coding Cheatsheet: The DSA Takeover Edition\" is the only book you need to master Data Structures and Algorithms coding problems.', 'Books', '610iEfff1KL._SY466_.jpg', 300, 'rapidfire3535@gmail.com', 'Approved'),
(2, 'HP laptop bag 28 lt', 'Protect your laptop with a padded laptop compartment. This backpack is comfortable, durable, yet delightfully lightweight letting you take your entire setup wherever you want to work.', 'Bag', 'A1KwlpA8pTL._SL1500_.jpg', 700, 'rapidfire3535@gmail.com', 'Approved'),
(3, 'Metal Folding Bed Single Size', 'Sturdy Bed Frame: Made of a premium quality steel, this folding bed comes with reinforced construction which is durable enough for long-term usage, providing you with adequate stability and support.', 'Furniture', 'bed.webp', 7500, 'rapidfire3535@gmail.com', 'Approved'),
(4, 'Staedtler 550 60 S8 Geometry Set', 'Precision compass for the first circle-drawing exercises at school\r\nBig size protractor & set squares\r\nMaximum circle diameter approximately 300 mm', 'Stationery', 'geometry.jpg', 500, 'rapidfire3535@gmail.com', 'Approved'),
(5, 'KOTTY Men\'s Loose-Fit Stretch Denim Jeans', 'These all-denim jeans are made for the man who loves minimalism, sharp looks, and undeniable confidence. Wear them anywhere, anytime.\r\nMade with a cotton-rich blend, these jeans are soft, breathable, and sweat-resistant for all-day wear\r\nPerfect for casual outings, office wear, biker rides, and hip-hop street fashion—pairs well with sneakers & boots.', 'Clothes', '61CRuoHPqVL._SY879_.jpg', 700, 'rapidfire3535@gmail.com', 'Approved'),
(6, 'TAGDO Men\'s Regular Fit Casual Shirt', 'Fabric: Polyester, Designed to withstand daily wear and maintain its shape and color over time.\r\nVersatile design : Ideal for casual outings, everyday wear for a stylish', 'Clothes', '61aMzeopdYL._SY741_.jpg', 350, 'jbd783345@gmail.com', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `total_amount` int(10) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `email`, `total_amount`, `order_date`) VALUES
(24, 'jasvishal123@gmail.com', 1500, '2025-05-04 10:12:52');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `method` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `paid_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `cardholder` varchar(50) NOT NULL,
  `card_no` int(16) NOT NULL,
  `exp_date` varchar(255) NOT NULL,
  `cvv` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `order_id`, `method`, `status`, `paid_at`, `cardholder`, `card_no`, `exp_date`, `cvv`) VALUES
(1, 24, 'card', 'Success', '2025-05-04 10:12:52', 'jasvir', 456454556, '2025-12', 789);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`) VALUES
(1, 'Jasvir singh', 'jasvishal123@gmail.com', '123456');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `billing_address`
--
ALTER TABLE `billing_address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart_item`
--
ALTER TABLE `cart_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donarinfo`
--
ALTER TABLE `donarinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `billing_address`
--
ALTER TABLE `billing_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart_item`
--
ALTER TABLE `cart_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `donarinfo`
--
ALTER TABLE `donarinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_item`
--
ALTER TABLE `cart_item`
  ADD CONSTRAINT `cart_item_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
