-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2025 at 06:12 AM
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

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `first_name`, `last_name`, `phone`, `address`, `service_type`, `status`, `subtotal`, `shipping`, `total`, `created_at`) VALUES
(13, 'hehe', 'hay', 'pp', 'aa', 'pickup', 'DONE', 900000, 5000, 905000, '2025-12-01 04:55:56'),
(14, 'hahaha', 'haha', '098778900', 'jl. jojoran 1 no 20', 'pickup', 'PENDING', 2147483647, 5000, 2147483647, '2025-12-04 00:57:11'),
(15, 'Dhefano', 'Seandy', '081335662944', 'Jl. Jojoran 1 no 20', 'delivery', 'ON PROCESS', 27000, 5000, 32000, '2025-12-04 03:27:38');

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
(18, 12, 0, 1, 900000, 900000),
(19, 13, 0, 1, 900000, 900000),
(20, 14, 0, 1, 2147483647, 2147483647),
(21, 15, 0, 1, 27000, 27000);

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
  `ingredients` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `price`, `img`, `description`, `ingredients`) VALUES
(32, 'Beef + Patties', 'Asinan', 27000, 'uploads/1764815813_image.png', 'Roti Bakar Beef + Patties adalah roti tebal yang dibakar hingga renyah di luar namun tetap lembut di dalam, berisi sliced beef gurih dan patty daging sapi yang juicy dengan aroma panggangan yang khas, lalu dipadukan dengan saus creamy seperti mayo atau keju yang meleleh sehingga menghasilkan perpaduan rasa smoky, savory, dan creamy dalam satu gigitan yang bikin kenyang sekaligus nagih.', '[\"uploads/1764815813_ING_2.png\"]'),
(33, 'Choco + Choco', 'Manisan', 15000, 'uploads/1764815890_l.png', 'Roti Bakar Choco + Choco adalah roti manis yang dipanggang hingga permukaannya hangat dan sedikit crispy, lalu diberi kombinasi dua jenis cokelat—biasanya selai cokelat yang creamy dan lelehan cokelat tambahan yang lebih pekat—yang meleleh bersama dan menciptakan rasa manis, rich, dan indulgent, bikin setiap gigitan berasa seperti dessert cokelat yang super memanjakan.', '[\"uploads/1764815890_ING_coco.png\"]');

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
(10, 5, 'enak', '2025-12-04 02:51:23'),
(11, 4, 'enak^2', '2025-12-04 02:51:41'),
(12, 2, 'roti nya keras dikit', '2025-12-04 02:51:59'),
(13, 5, 'enak', '2025-12-04 02:52:08'),
(14, 3, 'enak tapi diare dikit', '2025-12-04 02:52:20'),
(15, 1, 'parkirnya susah', '2025-12-04 02:52:31'),
(16, 5, 'free sweet orange', '2025-12-04 02:53:10'),
(17, 5, 'free sempol sak kresek', '2025-12-04 02:53:19'),
(18, 2, 'sekolah e mambu', '2025-12-04 02:53:31'),
(19, 5, 'enak', '2025-12-04 03:46:26');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
