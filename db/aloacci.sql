-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 14, 2024 at 04:41 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

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
-- Table structure for table `admin_user`
--

CREATE TABLE `admin_user` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_user`
--

INSERT INTO `admin_user` (`id`, `image`, `name`, `password`, `role`, `email`, `mobile`, `status`) VALUES
(10, '20220228_204126.jpg', 'Sajjad', 'sajjad125', 'admin', 'sajjadsaleem341@gmail.com', '03176122252', 1),
(12, '20190814_184724.jpg', 'Sahil', 'sahil', 'employee', 'sahil@gmail.com', '03242477248', 1),
(18, 'istockphoto-947269088-612x612.jpg', 'Sameer', 'sameer', 'employee', 'sameer@gmail.com', '03352350927', 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `categories` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `categories`) VALUES
(1, 'Gender'),
(2, 'Range'),
(3, 'Weekly Deals'),
(4, 'Best Sellers'),
(5, 'Perfume Wax'),
(6, 'Body Mist'),
(7, 'Genre'),
(8, 'Type'),
(9, 'Sample Set'),
(10, 'Air Freshners'),
(11, 'Elite Fragrances');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`id`, `name`, `email`, `subject`, `message`, `date`) VALUES
(2, 'Abid', 'abid211@gmail.com', 'Subject', 'Message', '2022-11-02 20:52:48'),
(40, 'Sajjad', 'sajjadsaleem341@gmail.com', 'Test', 'Lorem', '2024-08-24 11:32:58');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `tracking_id` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(50) NOT NULL,
  `area` varchar(255) NOT NULL,
  `pincode` int(11) NOT NULL,
  `comment` text NOT NULL,
  `total_price` float NOT NULL,
  `order_status` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `tracking_id`, `user_id`, `email`, `mobile`, `address`, `city`, `area`, `pincode`, `comment`, `total_price`, `order_status`, `date`) VALUES
(1, '#3111744', 22, 'sajjadsaleem341@gmail.com', '03112656651', '194', 'Karachi', 'Gulshan', 78025, 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Hic consequuntur dolor reiciendis eos. Earum dolorem incidunt totam cumque architecto ab.', 715, 5, '2024-08-25'),
(2, '#8355603', 22, 'sajjadsaleem341@gmail.com', '03112656651', 'karachi sindh', 'Karachi', 'Gulshan', 89, 'lorem', 1050, 1, '2024-08-26');

-- --------------------------------------------------------

--
-- Table structure for table `orders_detail`
--

CREATE TABLE `orders_detail` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders_detail`
--

INSERT INTO `orders_detail` (`id`, `order_id`, `product_id`, `qty`, `price`) VALUES
(1, 1, 1540648, 1, 15),
(2, 1, 1938977, 2, 350),
(3, 2, 1938977, 3, 350);

-- --------------------------------------------------------

--
-- Table structure for table `order_status`
--

CREATE TABLE `order_status` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `image` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `qty` int(11) NOT NULL,
  `description` varchar(5000) NOT NULL,
  `short_description` varchar(2000) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `category_id`, `image`, `name`, `price`, `qty`, `description`, `short_description`, `status`) VALUES
(1, 1, '49.jpg', 'Recuerdos Plant', 15, 60, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 1),
(2, 2, '48.png', 'Crocus Plant', 15, 60, 'Crocuses are small, perennial bulbs that burst into bloom early in the spring, often emerging through the snow. They are known for their vibrant colors, including yellow, purple, white, and shades of pink. The flowers are typically cup-shaped with three petals, and they are often fragrant. Crocuses are popular in gardens and containers, adding a splash of color to the landscape.', 'A vibrant spring bulb flower with delicate petals and a cup-like shape.', 1),
(3, 2, '40.png', 'Cactus Flower', 350, 50, 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text', 1),
(4, 2, '43.png', 'Ficus Ginseng Bonsai', 200, 30, 'The Ficus Ginseng Bonsai is a popular houseplant prized for its striking appearance. It features a thick, gnarled trunk that resembles ginseng roots, adding a touch of exotic charm to any space. The tree boasts vibrant green leaves and a compact size, making it ideal for indoor cultivation. With proper care, this bonsai can thrive for years, becoming a beautiful and low-maintenance addition to your home.', 'A unique and captivating bonsai tree known for its distinctive ginseng-like roots.', 1),
(5, 2, '45.png', 'Olive Plant', 150, 20, 'The Olive plant is a symbol of peace and longevity, known for its resilience and ability to thrive in harsh conditions. It features silvery-green leaves, twisted branches, and a gnarled trunk that adds character over time. Olive trees are popular ornamental plants, often used in Mediterranean-style gardens and as bonsai specimens. While they can produce edible olives, they are primarily grown for their aesthetic appeal.', 'A classic Mediterranean plant with silvery-green leaves and twisted branches.', 1),
(6, 3, '47.png', 'Cordyline australis', 50, 40, 'The Cordyline australis, also known as the Red-tipped Cabbage Palm, is a versatile and eye-catching plant native to New Zealand. It\'s characterized by its tall, slender trunk and long, sword-shaped leaves that are typically green with reddish or pinkish tips, though the coloration can vary depending on the cultivar. This plant is a popular choice for both indoor and outdoor gardens, adding a touch of tropical flair to any space. It\'s relatively low-maintenance and can thrive in a variety of conditions.', 'A striking tropical tree with long, sword-like leaves that often have red or pink tips.', 1),
(7, 3, '41.png', 'Tulips', 20, 80, 'Tulips are bulbous perennial plants renowned for their large, showy flowers. They come in a wide variety of colors, including pink, red, yellow, white, purple, and even black. Tulips are popular spring flowers and are often used in bouquets and gardens. Their delicate petals and slender stems create a cheerful and elegant display, making them a beloved choice for floral arrangements and landscape design.', 'Tulips are bulbous perennial plants known for their large, showy flowers. They come in a wide variety of colors, including pink, red, yellow, white, purple, and even black. Tulips are popular spring flowers and are often used in bouquets and gardens.', 1),
(8, 5, '46.png', 'Adenium Obesum', 30, 60, 'The Adenium Obesum, commonly known as the Desert Rose, is a captivating succulent native to Africa and the Arabian Peninsula. It\'s characterized by its thick, swollen trunk and fleshy branches, which store water in arid conditions. The plant produces beautiful, trumpet-shaped flowers in various colors, including red, pink, white, and yellow. Adenium Obesum is a popular choice for indoor and outdoor gardens, adding a touch of exotic beauty to any space.', 'A succulent plant with thick, woody stems and vibrant, trumpet-shaped flowers.', 1),
(9, 5, '44.png', 'Boxwood Topiary', 40, 50, 'The Boxwood Topiary is a popular choice for ornamental gardens and landscaping due to its versatility and low maintenance. Its dense, evergreen foliage can be trained into various shapes, but the classic spherical form is particularly striking. This plant is known for its durability and ability to withstand pruning, making it a popular choice for creating formal hedges, borders, and sculptural features.', 'A spherical plant with dense green foliage. Perfect choice for ornamental gardens and landscaping.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `sub_categories` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `category_id`, `sub_categories`, `status`) VALUES
(1, 1, 'Men', 1),
(2, 1, 'Women', 1),
(3, 2, 'Explorer', 1),
(4, 2, 'Executive', 1),
(5, 2, 'Elite', 1),
(6, 3, 'Inferno', 1),
(7, 3, 'Lady Eve', 1),
(8, 3, 'Dauntless', 1),
(13, 3, 'Saiful Malook', 1);

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
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `mobile`, `date`) VALUES
(1, 'Kashif', 'kashif321@gmail.com', 'kashif321', '32165498700', '2022-11-01 00:18:40'),
(22, 'Sajjad', 'sajjadsaleem341@gmail.com', 'sajjad125', '03112656651', '2022-12-01 01:36:29'),
(23, 'Salman', 'salman321@gmail.com', 'salman321', '65498732112', '2022-12-02 01:09:58'),
(24, 'Amir', 'amir@gmail.com', 'amir', '03115625891', '2024-09-14 04:04:02'),
(25, 'Moiz', 'moiz@gmail.com', 'moiz', '02136589511', '2024-09-14 04:16:21');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_user`
--
ALTER TABLE `admin_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Id` (`id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
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
  ADD KEY `Category_Id` (`category_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_user`
--
ALTER TABLE `admin_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders_detail`
--
ALTER TABLE `orders_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_status`
--
ALTER TABLE `order_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`Id`),
  ADD CONSTRAINT `reviews_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `product` (`Id`);

--
-- Constraints for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD CONSTRAINT `sub_categories_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`Id`),
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
