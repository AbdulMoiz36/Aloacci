-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 19, 2024 at 09:38 PM
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
-- Database: `aloacci`
--

-- --------------------------------------------------------

--
-- Table structure for table `about`
--

CREATE TABLE `about` (
  `id` int(11) NOT NULL,
  `about` text NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about`
--

INSERT INTO `about` (`id`, `about`, `image`) VALUES
(1, 'Donec porttitor, enim ut dapibus lobortis, lectus sem tincidunt dui, eget ornare lectus ex non\n                        libero. Nam rhoncus diam ultrices porttitor laoreet. Ut mollis fermentum ex, vel viverra lorem\n                        volutpat sodales. In ornare porttitor odio sit amet laoreet. Sed laoreet, nulla a posuere\n                        ultrices, purus nulla tristique turpis, hendrerit rutrum augue quam ut est. Fusce malesuada\n                        posuere libero, vitae dapibus eros facilisis euismod. Sed sed lobortis justo, ut tincidunt\n                        velit. Mauris in maximus eros.', 'Florse.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `admin_role`
--

CREATE TABLE `admin_role` (
  `id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_role`
--

INSERT INTO `admin_role` (`id`, `role`) VALUES
(1, 'Admin'),
(2, 'Employee');

-- --------------------------------------------------------

--
-- Table structure for table `admin_user`
--

CREATE TABLE `admin_user` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role_id` int(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_user`
--

INSERT INTO `admin_user` (`id`, `image`, `name`, `password`, `role_id`, `email`, `mobile`, `status`) VALUES
(1, 'crossmyheart.jpeg', 'Sajjad', 'ce245834f602c2099a87e9f0080157ff', 1, 'sajjadsaleem341@gmail.com', '03176122252', 1),
(2, 'tippingpoint_76_11zon.jpeg', 'Moiz', '2a77d9de907385ebf2b94d6b35fbcdd0', 1, 'amir@gmail.com', '02116549871', 1);

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id`, `image`) VALUES
(2, 'shop-3398039_1920.jpg'),
(4, 'ai-generated-8328480_1920.png');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `categories` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `categories`) VALUES
(1, 'Best Sellers'),
(2, 'Range'),
(3, 'Weekly Deals'),
(4, 'Perfume Wax'),
(5, 'Body Mist'),
(6, 'Sample Set'),
(7, 'Air Freshners'),
(8, 'Elite Fragrances');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `cities` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `cities`) VALUES
(1, 'Karachi'),
(2, 'Lahore'),
(3, 'Islamabad');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gender`
--

CREATE TABLE `gender` (
  `id` int(11) NOT NULL,
  `gender` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gender`
--

INSERT INTO `gender` (`id`, `gender`) VALUES
(1, 'Men'),
(2, 'Women');

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

CREATE TABLE `genre` (
  `id` int(11) NOT NULL,
  `genre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genre`
--

INSERT INTO `genre` (`id`, `genre`) VALUES
(1, 'Arabic'),
(2, 'French');

-- --------------------------------------------------------

--
-- Table structure for table `lasting`
--

CREATE TABLE `lasting` (
  `id` int(11) NOT NULL,
  `lasting` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lasting`
--

INSERT INTO `lasting` (`id`, `lasting`) VALUES
(1, 7),
(2, 12),
(3, 24);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(50) NOT NULL,
  `shipping` int(11) NOT NULL,
  `total_price` float NOT NULL,
  `order_from` tinyint(4) NOT NULL,
  `order_status` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders_detail`
--

CREATE TABLE `orders_detail` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `format` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_status`
--

CREATE TABLE `order_status` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_status`
--

INSERT INTO `order_status` (`id`, `name`) VALUES
(1, 'Pending'),
(2, 'Processing'),
(3, 'Shipped'),
(4, 'Cancelled'),
(5, 'Complete');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `sub_category_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `image2` varchar(255) NOT NULL,
  `image3` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `gender_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `season_id` int(11) NOT NULL,
  `sillage_id` int(11) NOT NULL,
  `lasting_id` int(11) NOT NULL,
  `description` varchar(5000) NOT NULL,
  `breif` varchar(2000) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `category_id`, `sub_category_id`, `image`, `image2`, `image3`, `name`, `gender_id`, `genre_id`, `type_id`, `season_id`, `sillage_id`, `lasting_id`, `description`, `breif`, `status`) VALUES
(3, 1, 1, 'smashmyhead_69_11zon_79b21c03-b7cf-4277-99a0-2d68f32f8025.jpeg', 'SmashMyHead.jpeg', '', 'Smash My Head', 1, 1, 6, 4, 3, 2, 'Our Top Rated Perfume ⭐', 'Smash My Head is an aromatic fougere fragrance for men. The top notes of this perfume include Bergamot, Calabrian and Pepper, while the  middle notes are Lavender, Sichuan pepper, Pink Pepper, Patchouli, Vetiver, Elemi and Geranium. The base notes are Cedar, Ambroxan and Labdanum. This fragrance is extremely fresh and noble but it simultaneously also has a rawness to it.', 1),
(4, 1, 1, 'tippingpoint_76_11zon.jpeg', 'TippingPoint.jpeg', '', 'Tipping Point', 1, 2, 2, 2, 2, 1, 'Our #1 Office Wear! 👔', 'Tipping Point is a woody aromatic fragrance for men. The primary accords of this perfume are citrus, woody, warm spicy and aromatic. The top notes of this perfume are Grapefruit, Mint, Lemon and Pink Pepper, while the middle notes are Ginger, Jasmine, Nutmeg and Iso E Super. Its base notes include Incense, Cedar, Vetiver, Sandalwood, Labdanum, Patchouli and White Musk. This is a classic men’s fragrance that will be great for any occasion at any time of the year.', 1),
(5, 1, 2, 'florse_25_11zon.jpeg', 'Florse.jpeg', '', 'Florse', 2, 1, 2, 3, 3, 2, 'Our Best Floral Fragrance', 'Florse is a floral fragrance for women. It is an extremely sensual and feminine fragrance. The top notes in this perfume are Pear, Mandarin Orange and Pepper, while the middle notes are Osmanthus, Peony and Rose. The base notes include Patchouli, Cedar, Leather and Musk.', 1),
(6, 4, 13, 'Merryme_webimages.png', 'WhatsAppImage2023-11-10at11.32.21AM.jpeg', '', 'Merry Me Perfume Wax', 2, 1, 5, 1, 1, 3, 'A Premium Fragrance Wax', 'Try Merry Me Perfume Wax for its lovely flower and fruit scents. The smooth wax is easy to apply so you can enjoy smells of passionfruit, pineapple and strawberry all day long. It’s scent will make your day better.', 1),
(10, 3, 10, 'saifulmulook_62_11zon.jpeg', '', '', 'Saiful Malook', 0, 2, 2, 1, 1, 3, 'Most Popular Aquatic Scent!', 'Saiful Malook is an aromatic aquatic fragrance for men. The top notes of this fragrance include mint and green nuances, coriander, lavender and rosemary, while the heart notes include geranium, jasmine, neroli and sandalwood. The base is composed of cedarwood, amber, musk and tobacco.', 1),
(11, 1, 1, 'meltme_46_11zon.jpeg', 'MeltMe.jpeg', '', 'Melt Me', 1, 1, 1, 3, 1, 2, 'The All-Rounder Perfume', 'Melt Me is amber woody fragrance for men. The accords of the perfume are composed excellently to create a unique fragrance. The main accords of this perfume are woody and aromatic.\r\n\r\nThe top notes are very refreshing and contain lavender, lemon and juniper, while the middle notes include spanish labdanum, nutmeg and orange blossom. The base notes are quite aromatic and woody, consisting of musk, dry wood and patchouli. Melt Me is an appealing and pleasant scent, a definite compliment-puller. It is a fall scent exclusively for men.', 1),
(12, 1, 2, 'Florse.jpeg', 'lostsymbol_40_11zon.jpeg', 'MeltMe.jpeg', 'Cross My Heart', 2, 2, 6, 3, 2, 2, 'The Most Noticeable Scent!', 'Cross My Heart is a woody spicy fragrance for men. The top notes of this perfume are Ginger, Lemon, Mint and Lavender, while the middle notes are Juniper, Apple, Guatemalan Geranium and Cardamom. The base notes include Amberwood, Tonka Bean and Haitian Vetiver. This fragrance is made for men who are courageous and driven enough to chase success.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_format`
--

CREATE TABLE `product_format` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `format` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_format`
--

INSERT INTO `product_format` (`id`, `product_id`, `format`, `price`, `qty`) VALUES
(24, 4, '50ml', 1100, 20),
(25, 3, '10ml', 200, 10),
(26, 3, '20ml', 400, 0),
(27, 3, '50ml', 750, 10),
(28, 3, '100ml', 1200, 10),
(29, 3, '120ml', 1670, 10),
(30, 6, '35gm', 850, 22),
(31, 5, '50ml', 1200, 55),
(32, 5, '100ml', 2200, 15),
(33, 10, '50ml', 1350, 15),
(34, 10, '100ml', 2200, 2),
(35, 11, '50ml', 1100, 15),
(36, 11, '100ml', 2200, 20),
(55, 12, '10ml', 850, 25),
(56, 12, '50ml', 2300, 20),
(57, 12, '100ml', 4000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `format` varchar(10) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `season`
--

CREATE TABLE `season` (
  `id` int(11) NOT NULL,
  `season` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `season`
--

INSERT INTO `season` (`id`, `season`) VALUES
(1, 'Summer'),
(2, 'Winter'),
(3, 'Autumn'),
(4, 'Spring');

-- --------------------------------------------------------

--
-- Table structure for table `shipment`
--

CREATE TABLE `shipment` (
  `id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shipment`
--

INSERT INTO `shipment` (`id`, `price`, `status`) VALUES
(1, 3000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sillage`
--

CREATE TABLE `sillage` (
  `id` int(11) NOT NULL,
  `sillage` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sillage`
--

INSERT INTO `sillage` (`id`, `sillage`) VALUES
(1, 'Strong'),
(2, 'Light'),
(3, 'Medium');

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `sub_categories` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `category_id`, `sub_categories`) VALUES
(1, 1, 'Men'),
(2, 1, 'Women'),
(3, 1, 'New Arrival'),
(4, 2, 'Explorer'),
(5, 2, 'Executive'),
(6, 2, 'Elite'),
(7, 3, 'Inferno'),
(8, 3, 'Lady Eve'),
(9, 3, 'Dauntless'),
(10, 3, 'Saiful Malook'),
(11, 3, 'Rain On Me'),
(12, 4, 'Catch 22 Perfume Wax'),
(13, 4, 'Merry Me Perfume Wax'),
(14, 4, 'Saiful Malook Perfume Wax'),
(15, 4, 'Heavenly Vibes Perfume Wax'),
(16, 4, 'Oud War Perfume Wax'),
(17, 4, 'Velvet Smooth Perfume Wax'),
(18, 5, 'Living Floral Body Mist'),
(19, 5, 'Lost Light Body Mist'),
(20, 5, 'Heavenly Vibes Body Mist'),
(21, 6, '5 Samples of Your Choice'),
(22, 6, 'Mr. Ayaz Samoo\'s Choice'),
(23, 6, 'Mr & Mrs Faizan Sheikh\'s Choice'),
(24, 6, 'Top 5 Samples'),
(25, 6, 'Top Rated New Arrival Samples'),
(26, 7, 'Air Freshener'),
(27, 7, 'Car Diffuser'),
(28, 7, 'Reed Diffuser'),
(29, 7, 'Candles'),
(30, 8, 'Catch 22 Gold Edition - For Men'),
(31, 8, 'Farat - For Men'),
(32, 8, 'Qarar - For Men'),
(33, 8, 'Zarf - Unisex'),
(34, 8, 'Rabt - For Men');

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE `type` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `type`
--

INSERT INTO `type` (`id`, `type`) VALUES
(1, 'Citrus'),
(2, 'Floral'),
(3, 'Woody'),
(4, 'Oriental'),
(5, 'Sweet'),
(6, 'Fruity');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(50) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `city` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `mobile`, `city`, `address`, `date`) VALUES
(1, 'Sajjad', 'sajjadsaleem341@gmail.com', 'ce245834f602c2099a87e9f0080157ff', '03176122252', '', 'H#194, St#01, Scheme 33', '2024-10-14 10:44:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about`
--
ALTER TABLE `about`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_role`
--
ALTER TABLE `admin_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_user`
--
ALTER TABLE `admin_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Id` (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gender`
--
ALTER TABLE `gender`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lasting`
--
ALTER TABLE `lasting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders_detail`
--
ALTER TABLE `orders_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Id` (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_format`
--
ALTER TABLE `product_format`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `season`
--
ALTER TABLE `season`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipment`
--
ALTER TABLE `shipment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sillage`
--
ALTER TABLE `sillage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about`
--
ALTER TABLE `about`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_role`
--
ALTER TABLE `admin_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_user`
--
ALTER TABLE `admin_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gender`
--
ALTER TABLE `gender`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `genre`
--
ALTER TABLE `genre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lasting`
--
ALTER TABLE `lasting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders_detail`
--
ALTER TABLE `orders_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_status`
--
ALTER TABLE `order_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `product_format`
--
ALTER TABLE `product_format`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `season`
--
ALTER TABLE `season`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `shipment`
--
ALTER TABLE `shipment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sillage`
--
ALTER TABLE `sillage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `type`
--
ALTER TABLE `type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_format`
--
ALTER TABLE `product_format`
  ADD CONSTRAINT `product_format_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD CONSTRAINT `sub_categories_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
