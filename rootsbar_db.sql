-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2025 at 05:51 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rootsbar_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'gacor', 'wenak');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `service_type` enum('delivery','pickup') NOT NULL DEFAULT 'delivery',
  `status` enum('PENDING','ON PROCESS','ON DELIVERY','DONE','CANCELLED') DEFAULT 'PENDING',
  `subtotal` int(11) NOT NULL,
  `shipping` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `qty`, `price`, `subtotal`) VALUES
(1, 1, 0, 1, 99000, 99000),
(2, 1, 0, 1, 900000, 900000),
(3, 2, 0, 1, 99000, 99000),
(4, 2, 0, 1, 16000, 16000),
(5, 2, 0, 2, 900000, 1800000),
(6, 3, 0, 1, 99000, 99000),
(7, 3, 0, 1, 16000, 16000),
(8, 4, 0, 1, 16000, 16000),
(9, 5, 0, 1, 900000, 900000),
(10, 6, 0, 1, 99000, 99000),
(11, 7, 0, 1, 99000, 99000),
(12, 7, 0, 1, 16000, 16000),
(13, 7, 0, 1, 900000, 900000),
(14, 8, 0, 1, 99000, 99000),
(15, 9, 0, 1, 16000, 16000),
(16, 10, 0, 1, 99000, 99000),
(17, 11, 0, 1, 99000, 99000),
(18, 12, 0, 1, 900000, 900000);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `img` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `ingredients` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `price`, `img`, `description`, `ingredients`) VALUES
(6, 'samtingbautcyu', 'Golden Fil', 900000, 'uploads/1763963089_desktop-wallpaper-based-on-the-album-cover-v0-axnmwxmdw7a91.jpeg', 'hahahaha', '[]'),
(7, 'hhh', 'Manisan', 16000, 'uploads/1763963191_IMG_20250625_011142.jpg', 'miss', 'uploads/1763963191_ING_1183C102_001_SR_RT_GLB.png'),
(8, 'hai', 'Asinan', 99000, 'uploads/1763963222_WIN_20250723_07_14_08_Pro.jpg', 'yo', '[]');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `stars` int(11) NOT NULL,
  `review` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `stars`, `review`, `created_at`) VALUES
(1, 5, 'HAI', '2025-11-26 14:29:43'),
(2, 5, 'AKU CINTA KAMU', '2025-11-26 14:29:57'),
(3, 1, 'MMMM', '2025-11-26 14:32:04'),
(4, 5, 'KAKAKA', '2025-11-26 14:32:12'),
(5, 2, 'memeg', '2025-11-26 14:56:01'),
(6, 3, 'haiiii', '2025-11-26 14:56:17'),
(7, 4, 'konkontolno', '2025-11-26 14:56:47'),
(8, 4, 'kon memeg no', '2025-11-26 14:57:08'),
(9, 5, 'aku cinta dia dan hanya dia', '2025-11-30 04:59:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
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
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
