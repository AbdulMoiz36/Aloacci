-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 26, 2024 at 10:57 AM
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
(2, 'Welcome to Al-Oacci, where the art of fragrance meets the promise of quality and affordability. Established in 2015 by Muhammad Owais, Al-Oacci is built on a passion for creating luxurious scents that inspire and captivate. What started as a dream has grown into a trusted brand with over 100,000 satisfied customers, each sharing in our journey of elegance and innovation.\r\nwe believe fragrance is more than just a scent – it’s a reflection of personality, a trigger for memories, and a symbol of self-expression. Our mission is to make high-quality, luxury-inspired fragrances accessible to everyone, allowing you to enjoy the essence of premium brands without the premium price tag.', 'hero-sunflower-meanings-720x500.jpg');

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
(19, 'blank-profile-picture-973460_1280.png', 'Moiz', '2a77d9de907385ebf2b94d6b35fbcdd0', 1, 'moiz@gmail.com', '03245633589', 1),
(21, 'blank-profile-picture-973460_1280.png', 'admin', '1cd8d55322116ef112ac5171a375b5ae', 1, 'admin@gmail.com', '123', 1);

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
(2, 'Untitled-2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `bundles`
--

CREATE TABLE `bundles` (
  `id` int(11) NOT NULL,
  `total_amount` int(11) NOT NULL,
  `discount_value` int(11) NOT NULL,
  `discount_type` varchar(20) NOT NULL,
  `discount_amount` int(11) NOT NULL,
  `date` date NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bundle_details`
--

CREATE TABLE `bundle_details` (
  `id` int(11) NOT NULL,
  `bundle_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `format_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bundle_details`
--

INSERT INTO `bundle_details` (`id`, `bundle_id`, `product_id`, `format_id`, `qty`) VALUES
(54, 9, 47, 258, 1),
(55, 9, 46, 255, 2);

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
(9, 'Perfumes'),
(10, 'Home Fragrance'),
(11, 'Gift Box');

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

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`id`, `name`, `email`, `subject`, `message`, `date`) VALUES
(1, '', '', '', '', '2024-12-21 08:09:13'),
(2, '', '', '', '', '2024-12-21 08:09:14');

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
(2, 'Women'),
(3, 'Unisex');

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
(3, 'French');

-- --------------------------------------------------------

--
-- Table structure for table `homepage_data`
--

CREATE TABLE `homepage_data` (
  `id` int(11) NOT NULL,
  `text_input1` varchar(255) NOT NULL,
  `editable_input1` text NOT NULL,
  `image1_path` varchar(255) DEFAULT NULL,
  `image2_path` varchar(255) DEFAULT NULL,
  `text_input2` varchar(255) NOT NULL,
  `editable_input2` text NOT NULL,
  `image3_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `homepage_data`
--

INSERT INTO `homepage_data` (`id`, `text_input1`, `editable_input1`, `image1_path`, `image2_path`, `text_input2`, `editable_input2`, `image3_path`) VALUES
(1, 'Lorem ipsum dolor sit amet.2', '<p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quaerat delectus beatae harum culpa reprehenderit perspiciatis dignissimos suscipit id repellendus repellat exercitationem debitis explicabo, ipsam pariatur ipsum eos doloremque soluta illum.Testing The Feature</p>', '../image/eye race post new2.png', '../image/2 (1).png', 'abc2', '<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus, quo mollitia exercitationem animi atque obcaecati ut consequuntur! Similique voluptas, sit, nulla recusandae deleniti ducimus eos, quia facilis dolores est adipisci ut modi accusantium. Itaque nihil blanditiis aliquam distinctio labore, porro tempora dolore ratione deserunt? Soluta commodi quod consectetur repellat voluptatem ipsa.<span style=\"color: rgb(0, 0, 0);\">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus, quo mollitia exercitationem animi atque obcaecati ut consequuntur! Similique voluptas, sit, nulla recusandae deleniti ducimus eos, quia facilis dolores est adipisci ut modi accusantium. Itaque nihil blanditiis aliquam distinctio labore, porro tempora dolore ratione deserunt? Soluta commodi quod consectetur repellat&nbsp;.Testing the feature</span></p>', '../image/ai-generated-8328480_1920.png');

-- --------------------------------------------------------

--
-- Table structure for table `impressions`
--

CREATE TABLE `impressions` (
  `id` int(11) NOT NULL,
  `original_name` varchar(255) NOT NULL,
  `impression_name` varchar(255) DEFAULT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `impressions`
--

INSERT INTO `impressions` (`id`, `original_name`, `impression_name`, `product_id`) VALUES
(2, 'Test', 'Eye Race For Men', 20);

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

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `email`, `mobile`, `address`, `city`, `shipping`, `total_price`, `order_from`, `order_status`, `date`) VALUES
(4, 0, 'Abdul Moiz', 'saad@gmail.com', '03032708236', 'Number#4', 'Karachi', 180, 1080, 0, 5, '2024-12-10');

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
  `description` varchar(5000) NOT NULL,
  `brief` longtext NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `category_id`, `sub_category_id`, `image`, `image2`, `image3`, `name`, `description`, `brief`, `status`) VALUES
(20, 9, 0, 'Eros Versace Main Bottle Picture.jpg', '', '', 'Eye Race For Men', 'A fiery and passionate fragrance inspired by the power of love and attraction.', '<p><strong>Fragrance Notes</strong>:</p><ul><li><strong>Top Notes</strong>: Mint, Green Apple, Lemon</li><li><strong>Heart Notes</strong>: Tonka Bean, Ambroxan, Geranium</li><li><strong>Base Notes</strong>: Vanilla, Vetiver, Cedar, Oakmoss</li></ul><p><strong>Character</strong>: Eye Race for men is bold, sensual, and magnetic. Its blend of fresh citrus and sweet vanilla creates a captivating scent perfect for evening wear. Ideal for the confident man who embraces his seductive side.</p><p><br></p>', 1),
(21, 1, 2, 'af0d7146-eb7e-4699-a55b-3ed4f5f48870.jpeg', '', '', 'Feb Creation', 'Feb Creation for women is a classic floral fragrance with a modern twist. The citrusy and fresh opening leads to a heart full of beautiful, elegant florals that are both vibrant and timeless. As the fragrance settles, the base becomes warmer, with sandalwood, amber, and musk adding a soft and lasting depth. This creates a sophisticated balance between fresh florals and warm woods, making it versatile and alluring.', 'Feb Creation for Women exudes a sense of grace, romance, and timelessness. It’s designed for a woman who embodies elegance, refinement, and inner strength. The fragrance evokes feelings of enduring love and commitment, making it an ideal scent for someone who values tradition while embracing modern femininity. It’s perfect for women who appreciate a classic, floral perfume that feels both delicate and empowering.', 1),
(22, 1, 3, 'eye race post new2.png', '', '', 'Golden One', 'Golden one fragrance is often described as daring and seductive, making it a popular choice for evening wear or special occasions. It’s perfect for those who want to make a lasting impression.', '', 1),
(23, 9, 0, 'Mr Right Bottle.png', '', '', 'Mr. Right for Men', 'A fresh, daring fragrance with a playful twist on the classic 1 Million.', '<p><strong>Fragrance Notes</strong>:</p><ul><li class=\"ql-indent-1\"><strong>Top Notes</strong>: Plum, Grapefruit, Bergamot</li><li class=\"ql-indent-1\"><strong>Heart Notes</strong>: Hazelnut, Cedarwood, Jasmine</li><li class=\"ql-indent-1\"><strong>Base Notes</strong>: Amber, Patchouli, Vanilla</li></ul><p><strong>Character</strong>: Mr Right for Men is sweet, fruity, and nutty. Its playful mix of fresh fruits with warm, woody undertones creates a fragrance that’s perfect for the man who enjoys a luxurious yet fun scent, ideal for both day and night.</p><p><br></p>', 1),
(24, 9, 0, '212 Men Main Bottle Picture.jpg', '', '', '1993', 'A fresh, energetic fragrance that embodies the vibrancy of city life.', '<p><strong>Fragrance Notes</strong>:</p><ul><li class=\"ql-indent-1\"><strong>Top Notes</strong>: Grapefruit, Ginger, Mandarin Orange</li><li class=\"ql-indent-1\"><strong>Heart Notes</strong>: Green Notes, Sage, Jasmine</li><li class=\"ql-indent-1\"><strong>Base Notes</strong>: Sandalwood, Musk, Guaiac Wood</li></ul><p><strong>Character</strong>: 1993 is urban, fresh, and invigorating. It’s a lively and modern fragrance that embodies the essence of the city, perfect for the man on the go who enjoys a fresh, masculine scent.</p>', 1),
(25, 1, 3, 'eye race post new2.png', '', '', '1994', '1994 Perfume is perfect for evening wear or romantic occasions. The fragrance is both sophisticated and playful, making it ideal for the man who embraces his sensual side while maintaining a sense of elegance.', '', 1),
(26, 1, 3, 'eye race post new2.png', '', '', 'Blue Citrus', 'Blue Citrus Perfume is housed in a sleek, minimalist bottle that reflects its modernity. It’s versatile enough for both casual and formal occasions, making it a great choice for the man who embodies an active lifestyle while appreciating elegance. The fragrance is fresh, sporty, and undeniably captivating.', '', 1),
(27, 1, 3, 'eye race post new2.png', '', '', 'Pointing', 'Pointing perfume captures the spirit of nature and freedom. Its light and airy composition makes it perfect for everyday wear, particularly in warm weather. The fragrance is both refreshing and sophisticated, appealing to those who appreciate a clean and natural scent that evokes the beauty of the ocean and coastal landscapes.', '', 1),
(28, 9, 0, 'Aventus Creed Main Bottle Picture.jpg', '', '', 'Box Boy', 'A bold and sophisticated fragrance that exudes power and elegance.', '<p><strong>Fragrance Notes</strong>:</p><ul><li class=\"ql-indent-1\"><strong>Top Notes</strong>: Pineapple, Bergamot, Black Currant</li><li class=\"ql-indent-1\"><strong>Heart Notes</strong>: Jasmine, Patchouli, Rose</li><li class=\"ql-indent-1\"><strong>Base Notes</strong>: Musk, Oakmoss, Ambergris</li></ul><p><strong>Character</strong>: Box Boy is powerful, elegant, and refined. Its fresh, fruity opening combined with deep, woody and smoky notes creates a fragrance that’s perfect for a confident, modern man. Ideal for both day and night.</p>', 1),
(29, 0, 0, 'My burburry bottle 2.jpg', '', '', 'Silver Horizon For Men', 'A fresh, clean fragrance that’s ideal for everyday wear with a touch of sophistication.', '<p><strong>Fragrance Notes</strong>:</p><ul><li class=\"ql-indent-1\"><strong>Top Notes</strong>: Bergamot, Lemon, Orange</li><li class=\"ql-indent-1\"><strong>Heart Notes</strong>: Jasmine, Ginger, Coriander</li><li class=\"ql-indent-1\"><strong>Base Notes</strong>: Musk, Oakmoss, Cedarwood</li></ul><p><strong>Character</strong>: Silver Horizon is fresh, citrusy, and woody. With its vibrant opening and earthy base, it embodies a sense of cleanliness and elegance, perfect for daily wear or casual outings.</p><p><br></p>', 1),
(30, 0, 0, 'Azzaro Wanted Main Bottle Picture.png', '', '', 'Ring Light', 'Ring Light is a fragrance for men who enjoy living life to the fullest. It\'s fresh, spicy, and woody, offering a balanced composition that suits a man of action—someone who is determined, charming, and undeniably magnetic.Fragrance Profile:Top Notes: Lemon, Ginger, Lavender, MintHeart Notes: Guatemalan Cardamom, Juniper, Apple, GeraniumBase Notes: Tonka Bean, Haitian Vetiver, Amberwood', '<p><br></p>', 1),
(31, 0, 0, 'eye race post new2.png', '', '', 'Charsi Men', 'Charsi Men is an enigmatic, smoky, and resinous fragrance that challenges conventional ideas of perfumery. It’s not for everyone, but for those who enjoy bold, daring scents, it\'s an unforgettable fragrance that truly stands out in the world of niche perfumery. It’s a cult favorite for people who enjoy dark, intoxicating scents with a sense of mystery and rebellion.Fragrance Profile:Top Notes: Cannabis, Green NotesHeart Notes: Resins, Woodsy Notes, Tobacco, CoffeeBase Notes: Incense, Oud, Agarwood (Oud)', '<p><br></p>', 1),
(32, 0, 0, 'Bleu De Chanel Bottle Main Picture.png', '', '', 'Sharp Shasow', 'A sophisticated and aromatic fragrance that’s fresh yet woody.', '<p><strong>Fragrance Notes</strong>:</p><ul><li class=\"ql-indent-1\"><strong>Top Notes</strong>: Lemon, Grapefruit, Mint</li><li class=\"ql-indent-1\"><strong>Heart Notes</strong>: Jasmine, Ginger, Nutmeg</li><li class=\"ql-indent-1\"><strong>Base Notes</strong>: Cedarwood, Sandalwood, Amber</li></ul><p><strong>Character</strong>: Sharp Shadow is refined, fresh, and bold. Its citrus opening combined with spicy and woody undertones makes it an ideal fragrance for the modern man who seeks both elegance and freshness</p>', 1),
(33, 9, 0, 'Bombhshell Bottle Main Picture.png', '', '', 'Love Portion For Women', 'A vibrant, flirtatious fragrance that exudes youthful energy and charm.', '<p><strong>Fragrance Notes</strong>:</p><ul><li class=\"ql-indent-1\"><strong>Top Notes</strong>: Passionfruit, Orange, Strawberry</li><li class=\"ql-indent-1\"><strong>Heart Notes</strong>: Peony, Jasmine, Lily</li><li class=\"ql-indent-1\"><strong>Base Notes</strong>: Vanilla, Musk, Amber</li></ul><p><strong>Character</strong>: Love Portion is playful, sweet, and energetic. Its fruity top notes combined with a floral heart and warm base make it perfect for the young woman who is confident, fun, and loves to stand out.</p>', 1),
(34, 9, 0, 'Inner Soul Bottle Main Picture.png', '', '', 'Inner Soul For Women', 'A sophisticated and fruity fragrance that embodies the spirit of London.', '<p><strong>Fragrance Notes</strong>:</p><ul><li class=\"ql-indent-1\"><strong>Top Notes</strong>: Red Fruits, Cherry, Strawberry</li><li class=\"ql-indent-1\"><strong>Heart Notes</strong>: Violet, Jasmine, Amber</li><li class=\"ql-indent-1\"><strong>Base Notes</strong>: Musk, Cedarwood, Sandalwood</li></ul><p><strong>Character</strong>: Inner Soul is fresh, fruity, and chic. Its mix of berries with floral and woody undertones creates a lively, youthful scent that’s perfect for casual or day-to-day wear, evoking the energy of city life</p>', 1),
(35, 9, 0, 'My burburry bottle 2.jpg', '', '', 'Red Cross For Men', 'Red Cross opens with a distinctive burst of aldehydes', '<p><br></p>', 1),
(36, 9, 0, 'Velvet Rebel bottle Main Picture.png', '', '', 'Velvet Rebel For Men', 'A bold and smoky fragrance that evokes the charm of classic masculinity. Its deep, rich blend is perfect for the man who exudes confidence and sophistication', '<p><strong>Fragrance Notes</strong>:</p><ul><li><strong>Top Notes</strong>: Bergamot, Lemon, Pear, Pineapple</li><li><strong>Heart Notes</strong>: Lavender, Coriander, Jasmine, Bay Leaves</li><li><strong>Base Notes</strong>: Tobacco, Cedarwood, Musk, Amber</li></ul><p><strong>Character</strong>: A deeply masculine and warm fragrance that combines the richness of tobacco and cedarwood with fresh citrusy top notes. The sweet and spicy undertones make it perfect for evening wear, exuding charm and maturity, ideal for the confident and stylish man.</p><p><br></p>', 1),
(37, 9, 0, 'CK One Bottle Main Picture.png', '', '', 'Brown Rang For Men', 'An iconic unisex fragrance that redefines simplicity and modernity', '<p><strong>Fragrance Notes</strong>:</p><ul><li class=\"ql-indent-1\"><strong>Top Notes</strong>: Lemon, Bergamot, Pineapple, Green Tea</li><li class=\"ql-indent-1\"><strong>Heart Notes</strong>: Jasmine, Lily-of-the-Valley, Rose, Nutmeg</li><li class=\"ql-indent-1\"><strong>Base Notes</strong>: Musk, Cedarwood, Amber</li></ul><p><strong>Character</strong>: Clean, fresh, and invigorating, Brown Rang is perfect for those who appreciate minimalistic sophistication. It is ideal for daytime use, offering a versatile, gender-neutral scent that adapts seamlessly to any occasion. A symbol of individuality and connection.</p>', 1),
(38, 0, 0, 'af0d7146-eb7e-4699-a55b-3ed4f5f48870.jpeg', '', '', 'Candy Land For Women', 'A chic and sensual fragrance for the modern woman, combining freshness', '<p><strong>Fragrance Notes</strong>:</p><ul><li class=\"ql-indent-1\"><strong>Top Notes</strong>: Orange, Bergamot, Grapefruit</li><li class=\"ql-indent-1\"><strong>Heart Notes</strong>: Rose, Jasmine, Litchi</li><li class=\"ql-indent-1\"><strong>Base Notes</strong>: Patchouli, Vanilla, Vetiver, Musk</li></ul><p><strong>Character</strong>: Candy Land radiates elegance and charm, making it a favorite among women who embrace their independence. Its citrusy opening gives way to a lush floral heart, while the warm, woody base adds depth and sensuality. Perfect for both day and evening wear, it’s a fragrance of confidence and allure</p>', 1),
(39, 9, 0, 'My burburry bottle 2.jpg', '', '', 'Passion For Men', 'A refreshing aquatic fragrance that captures the essence of oceanic freshness and masculinity.', '<p><strong>Fragrance Notes</strong>:</p><ul><li class=\"ql-indent-1\"><strong>Top Notes</strong>: Mint, Lavender, Coriander, Rosemary</li><li class=\"ql-indent-1\"><strong>Heart Notes</strong>: Jasmine, Neroli, Geranium, Sandalwood</li><li class=\"ql-indent-1\"><strong>Base Notes</strong>: Amber, Musk, Cedar, Tobacco</li></ul><p><strong>Character</strong>: Passion for men is invigorating and crisp, perfect for the active and adventurous man. Its blend of fresh mint and lavender with earthy base notes creates a balanced, long-lasting scent. Ideal for daytime wear, it embodies a sense of freedom and vitality, making it a classic for modern masculinity.</p><p><br></p>', 1),
(40, 0, 0, 'My burburry bottle 2.jpg', '', '', 'Passion For Women', 'A breezy, aquatic fragrance that embodies freshness, femininity, and freedom.', '<p><strong>Fragrance Notes</strong>:</p><ul><li class=\"ql-indent-1\"><strong>Top Notes</strong>: Melon, Pineapple, Citrus, Lotus</li><li class=\"ql-indent-1\"><strong>Heart Notes</strong>: Lily-of-the-Valley, Jasmine, Honey, Rose</li><li class=\"ql-indent-1\"><strong>Base Notes</strong>: Musk, Vanilla, Peach, Sandalwood</li></ul><p><strong>Character</strong>: Passion Women is a celebration of freshness and sensuality, perfect for those who love the outdoors and cherish a light, airy scent. Its fruity and floral notes create an uplifting, feminine profile, while the soft base adds warmth. Ideal for daytime wear and summer adventures, it evokes the essence of water and purity</p>', 1),
(41, 9, 0, 'loui vithon AND BOX.png', '', '', 'After Bath For Unisex', 'A romantic and delicate fragrance that captures the essence of tenderness and passion.', '<p><strong>Fragrance Notes</strong>:</p><ul><li class=\"ql-indent-1\"><strong>Top Notes</strong>: Peach, Pear, Lemon, Mandarin</li><li class=\"ql-indent-1\"><strong>Heart Notes</strong>: Rose, Jasmine, Lily-of-the-Valley</li><li class=\"ql-indent-1\"><strong>Base Notes</strong>: Vanilla, Amber, Musk, Sandalwood</li></ul><p><strong>Character</strong>: After Bath is soft, feminine, and sensual. Its blend of fresh fruits and floral notes creates a warm, inviting scent, perfect for moments of romance and intimacy. Ideal for both day and evening wear, it exudes grace and affection</p>', 1),
(42, 9, 0, 'My burburry bottle 2.jpg', '', '', 'Ever Love For Men', 'A sophisticated and stylish fragrance for the modern man who embodies elegance and charisma.', '<p><strong>Fragrance Notes</strong>:</p><ul><li><strong>Top Notes</strong>: Grapefruit, Pepper, Lemon</li><li><strong>Heart Notes</strong>: Cashmere Wood, Rosemary, Geranium</li><li><strong>Base Notes</strong>: Musk, Patchouli, Mahogany</li></ul><p><strong>Character</strong>: Ever Love For Men is fresh yet woody, ideal for the man who values subtle refinement. Its blend of citrusy freshness and earthy depth makes it versatile, perfect for both professional settings and casual outings.</p>', 1),
(43, 9, 0, 'My burburry bottle 2.jpg', '', '', 'Exis Blue For Men', 'A fresh and aquatic fragrance that represents calmness and serenity.', '<p><strong>Fragrance Notes</strong>:</p><ul><li><strong>Top Notes</strong>: Bergamot, Mandarin, Litchi</li><li><strong>Heart Notes</strong>: Sea Breeze, Orange Blossom, Lotus</li><li><strong>Base Notes</strong>: Tonka Bean, Amber, Musk</li></ul><p><strong>Character</strong>: Exis Blue exudes a relaxed, soothing vibe. Its aquatic freshness paired with warm, musky undertones makes it perfect for daytime wear, especially during warmer months. It’s for the man who seeks balance and harmony.</p>', 1),
(44, 9, 0, 'My burburry bottle 2.jpg', '', '', 'Exis Red For Men', 'An intense and seductive fragrance designed for the man', '<p><strong>Fragrance Notes</strong>:</p><ul><li><strong>Top Notes</strong>: Apple, Neroli, Lemon, Bergamot</li><li><strong>Heart Notes</strong>: Rose, Teakwood, Patchouli</li><li><strong>Base Notes</strong>: Vanilla, Musk, Labdanum</li></ul><p><strong>Character</strong>:</p><p>Exis Red for a Man is bold, warm, and alluring. The fruity freshness of the top notes leads into a heart of romantic florals and woods, while the creamy, musky base adds depth and sensuality. This fragrance is perfect for the confident man who enjoys making a statement, whether at a formal event or during a night out.</p>', 1),
(45, 9, 0, 'af0d7146-eb7e-4699-a55b-3ed4f5f48870.jpeg', '', '', 'Feb Creation For Men', 'A timeless fragrance that captures a balance of strength and tenderness.', '<p><strong>Fragrance Notes</strong>:</p><ul><li class=\"ql-indent-1\"><strong>Top Notes</strong>: Lavender, Lemon, Bergamot</li><li class=\"ql-indent-1\"><strong>Heart Notes</strong>: Sage, Coriander, Geranium, Basil</li><li class=\"ql-indent-1\"><strong>Base Notes</strong>: Vetiver, Sandalwood, Amber, Musk</li></ul><p><strong>Character</strong>: Feb Creation Men is clean, fresh, and enduring. It reflects a man’s commitment to his values and relationships, making it perfect for everyday wear with its balance of fresh and earthy tones.</p><p><br></p>', 1),
(46, 9, 0, 'My burburry bottle 2.jpg', '', '', 'Makes For Men', 'A bold and intense fragrance that blends classic masculinity with an enigmatic edge.', '<p><strong>Fragrance Notes</strong>:</p><ul><li class=\"ql-indent-1\"><strong>Top Notes</strong>: Lavender, Mandarin Orange, Hawthorn</li><li class=\"ql-indent-1\"><strong>Heart Notes</strong>: Nutmeg, Cedar, Violet</li><li class=\"ql-indent-1\"><strong>Base Notes</strong>: Leather, Vetiver, Patchouli, Musk</li></ul><p><strong>Character</strong>: Makes for men is warm, smoky, and intriguing. Its blend of fresh top notes with deep, leathery undertones creates a distinctive and long-lasting scent, perfect for the charismatic man who isn’t afraid to stand out.</p>', 1),
(47, 9, 0, 'Gucci Bloom Bottle Main Picture.png', '', '', 'Bloom For Women', 'A lush and floral fragrance that celebrates femininity and natural beauty.', '<p><strong>Fragrance Notes</strong>:</p><ul><li class=\"ql-indent-1\"><strong>Top Notes</strong>: Jasmine, Rangoon Creeper</li><li class=\"ql-indent-1\"><strong>Heart Notes</strong>: Tuberose</li><li class=\"ql-indent-1\"><strong>Base Notes</strong>: Orris Root, Musk, Sandalwood</li></ul><p><strong>Character</strong>: Bloom is rich, elegant, and romantic, designed for women who embrace their individuality. Its floral intensity is ideal for special occasions or anytime you want to feel radiant and confident.</p>', 1),
(49, 9, 0, 'Gucci Flora Bottle Main Picture.png', '', '', 'Flora for Women', 'A bright and cheerful fragrance that captures the essence of vibrant florals in full bloom.', '<p><strong>Fragrance Notes</strong>:</p><ul><li class=\"ql-indent-1\"><strong>Top Notes</strong>: Citrus, Peony, Mandarin</li><li class=\"ql-indent-1\"><strong>Heart Notes</strong>: Rose, Osmanthus</li><li class=\"ql-indent-1\"><strong>Base Notes</strong>: Patchouli, Sandalwood</li></ul><p><strong>Character</strong>: Flora is fresh, playful, and youthful. Its floral sweetness, combined with a touch of warmth, makes it a perfect fragrance for daytime wear, especially during spring and summer.</p><p><br></p>', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_details`
--

CREATE TABLE `product_details` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `gender_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `season_id` int(11) NOT NULL,
  `sillage_id` int(11) NOT NULL,
  `lasting_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_details`
--

INSERT INTO `product_details` (`id`, `product_id`, `gender_id`, `genre_id`, `type_id`, `season_id`, `sillage_id`, `lasting_id`) VALUES
(88, 21, 2, 0, 0, 0, 0, 0),
(89, 21, 0, 3, 0, 0, 0, 0),
(90, 21, 0, 0, 2, 0, 0, 0),
(91, 21, 0, 0, 0, 1, 0, 0),
(92, 21, 0, 0, 0, 4, 0, 0),
(93, 21, 0, 0, 0, 0, 3, 0),
(94, 21, 0, 0, 0, 0, 0, 2),
(95, 22, 1, 0, 0, 0, 0, 0),
(96, 22, 0, 3, 0, 0, 0, 0),
(97, 22, 0, 0, 1, 0, 0, 0),
(98, 22, 0, 0, 0, 2, 0, 0),
(99, 22, 0, 0, 0, 3, 0, 0),
(100, 22, 0, 0, 0, 0, 3, 0),
(101, 22, 0, 0, 0, 0, 0, 1),
(129, 25, 1, 0, 0, 0, 0, 0),
(130, 25, 0, 3, 0, 0, 0, 0),
(131, 25, 0, 0, 3, 0, 0, 0),
(132, 25, 0, 0, 0, 2, 0, 0),
(133, 25, 0, 0, 0, 3, 0, 0),
(134, 25, 0, 0, 0, 0, 3, 0),
(135, 25, 0, 0, 0, 0, 0, 2),
(136, 26, 1, 0, 0, 0, 0, 0),
(137, 26, 0, 3, 0, 0, 0, 0),
(138, 26, 0, 0, 1, 0, 0, 0),
(139, 26, 0, 0, 5, 0, 0, 0),
(140, 26, 0, 0, 0, 1, 0, 0),
(141, 26, 0, 0, 0, 4, 0, 0),
(142, 26, 0, 0, 0, 0, 3, 0),
(143, 26, 0, 0, 0, 0, 0, 1),
(144, 27, 1, 0, 0, 0, 0, 0),
(145, 27, 0, 3, 0, 0, 0, 0),
(146, 27, 0, 0, 1, 0, 0, 0),
(147, 27, 0, 0, 0, 1, 0, 0),
(148, 27, 0, 0, 0, 4, 0, 0),
(149, 27, 0, 0, 0, 0, 3, 0),
(150, 27, 0, 0, 0, 0, 0, 1),
(375, 35, 1, 0, 0, 0, 0, 0),
(376, 35, 0, 3, 0, 0, 0, 0),
(377, 35, 0, 0, 3, 0, 0, 0),
(378, 35, 0, 0, 26, 0, 0, 0),
(379, 35, 0, 0, 30, 0, 0, 0),
(380, 35, 0, 0, 0, 2, 0, 0),
(381, 35, 0, 0, 0, 3, 0, 0),
(382, 35, 0, 0, 0, 0, 1, 0),
(383, 35, 0, 0, 0, 0, 0, 2),
(499, 38, 2, 0, 0, 0, 0, 0),
(500, 38, 0, 3, 0, 0, 0, 0),
(501, 38, 0, 0, 1, 0, 0, 0),
(502, 38, 0, 0, 3, 0, 0, 0),
(503, 38, 0, 0, 0, 1, 0, 0),
(504, 38, 0, 0, 0, 2, 0, 0),
(505, 38, 0, 0, 0, 4, 0, 0),
(506, 38, 0, 0, 0, 0, 3, 0),
(507, 38, 0, 0, 0, 0, 0, 1),
(514, 39, 1, 0, 0, 0, 0, 0),
(515, 39, 0, 3, 0, 0, 0, 0),
(516, 39, 0, 0, 22, 0, 0, 0),
(517, 39, 0, 0, 31, 0, 0, 0),
(518, 39, 0, 0, 0, 1, 0, 0),
(519, 39, 0, 0, 0, 4, 0, 0),
(520, 39, 0, 0, 0, 0, 3, 0),
(521, 39, 0, 0, 0, 0, 0, 1),
(522, 40, 2, 0, 0, 0, 0, 0),
(523, 40, 0, 3, 0, 0, 0, 0),
(524, 40, 0, 0, 1, 0, 0, 0),
(525, 40, 0, 0, 2, 0, 0, 0),
(526, 40, 0, 0, 0, 1, 0, 0),
(527, 40, 0, 0, 0, 4, 0, 0),
(528, 40, 0, 0, 0, 0, 3, 0),
(529, 40, 0, 0, 0, 0, 0, 1),
(543, 41, 1, 0, 0, 0, 0, 0),
(544, 41, 2, 0, 0, 0, 0, 0),
(545, 41, 3, 0, 0, 0, 0, 0),
(546, 41, 0, 3, 0, 0, 0, 0),
(547, 41, 0, 0, 23, 0, 0, 0),
(548, 41, 0, 0, 26, 0, 0, 0),
(549, 41, 0, 0, 31, 0, 0, 0),
(550, 41, 0, 0, 0, 1, 0, 0),
(551, 41, 0, 0, 0, 2, 0, 0),
(552, 41, 0, 0, 0, 3, 0, 0),
(553, 41, 0, 0, 0, 4, 0, 0),
(554, 41, 0, 0, 0, 0, 3, 0),
(555, 41, 0, 0, 0, 0, 0, 1),
(556, 42, 1, 0, 0, 0, 0, 0),
(557, 42, 0, 3, 0, 0, 0, 0),
(558, 42, 0, 0, 1, 0, 0, 0),
(559, 42, 0, 0, 3, 0, 0, 0),
(560, 42, 0, 0, 23, 0, 0, 0),
(561, 42, 0, 0, 26, 0, 0, 0),
(562, 42, 0, 0, 0, 3, 0, 0),
(563, 42, 0, 0, 0, 4, 0, 0),
(564, 42, 0, 0, 0, 0, 2, 0),
(565, 42, 0, 0, 0, 0, 0, 2),
(566, 43, 1, 0, 0, 0, 0, 0),
(567, 43, 0, 3, 0, 0, 0, 0),
(568, 43, 0, 0, 1, 0, 0, 0),
(569, 43, 0, 0, 26, 0, 0, 0),
(570, 43, 0, 0, 31, 0, 0, 0),
(571, 43, 0, 0, 0, 1, 0, 0),
(572, 43, 0, 0, 0, 4, 0, 0),
(573, 43, 0, 0, 0, 0, 2, 0),
(574, 43, 0, 0, 0, 0, 0, 1),
(575, 44, 1, 0, 0, 0, 0, 0),
(576, 44, 0, 3, 0, 0, 0, 0),
(577, 44, 0, 0, 1, 0, 0, 0),
(578, 44, 0, 0, 6, 0, 0, 0),
(579, 44, 0, 0, 15, 0, 0, 0),
(580, 44, 0, 0, 0, 2, 0, 0),
(581, 44, 0, 0, 0, 3, 0, 0),
(582, 44, 0, 0, 0, 4, 0, 0),
(583, 44, 0, 0, 0, 0, 3, 0),
(584, 44, 0, 0, 0, 0, 0, 1),
(595, 45, 1, 0, 0, 0, 0, 0),
(596, 45, 0, 3, 0, 0, 0, 0),
(597, 45, 0, 0, 1, 0, 0, 0),
(598, 45, 0, 0, 23, 0, 0, 0),
(599, 45, 0, 0, 26, 0, 0, 0),
(600, 45, 0, 0, 31, 0, 0, 0),
(601, 45, 0, 0, 0, 3, 0, 0),
(602, 45, 0, 0, 0, 4, 0, 0),
(603, 45, 0, 0, 0, 0, 3, 0),
(604, 45, 0, 0, 0, 0, 0, 1),
(623, 23, 1, 0, 0, 0, 0, 0),
(624, 23, 0, 3, 0, 0, 0, 0),
(625, 23, 0, 0, 3, 0, 0, 0),
(626, 23, 0, 0, 5, 0, 0, 0),
(627, 23, 0, 0, 0, 2, 0, 0),
(628, 23, 0, 0, 0, 3, 0, 0),
(629, 23, 0, 0, 0, 4, 0, 0),
(630, 23, 0, 0, 0, 0, 3, 0),
(631, 23, 0, 0, 0, 0, 0, 2),
(683, 31, 1, 0, 0, 0, 0, 0),
(684, 31, 0, 1, 0, 0, 0, 0),
(685, 31, 0, 3, 0, 0, 0, 0),
(686, 31, 0, 0, 0, 2, 0, 0),
(687, 31, 0, 0, 0, 3, 0, 0),
(688, 31, 0, 0, 0, 0, 1, 0),
(689, 31, 0, 0, 0, 0, 0, 2),
(795, 20, 1, 0, 0, 0, 0, 0),
(796, 20, 0, 3, 0, 0, 0, 0),
(797, 20, 0, 0, 22, 0, 0, 0),
(798, 20, 0, 0, 31, 0, 0, 0),
(799, 20, 0, 0, 32, 0, 0, 0),
(800, 20, 0, 0, 0, 1, 0, 0),
(801, 20, 0, 0, 0, 3, 0, 0),
(802, 20, 0, 0, 0, 4, 0, 0),
(803, 20, 0, 0, 0, 0, 3, 0),
(804, 20, 0, 0, 0, 0, 0, 2),
(805, 30, 1, 0, 0, 0, 0, 0),
(806, 30, 0, 3, 0, 0, 0, 0),
(807, 30, 0, 0, 0, 2, 0, 0),
(808, 30, 0, 0, 0, 3, 0, 0),
(809, 30, 0, 0, 0, 4, 0, 0),
(810, 30, 0, 0, 0, 0, 1, 0),
(811, 30, 0, 0, 0, 0, 0, 2),
(812, 24, 1, 0, 0, 0, 0, 0),
(813, 24, 0, 3, 0, 0, 0, 0),
(814, 24, 0, 0, 1, 0, 0, 0),
(815, 24, 0, 0, 4, 0, 0, 0),
(816, 24, 0, 0, 0, 1, 0, 0),
(817, 24, 0, 0, 0, 3, 0, 0),
(818, 24, 0, 0, 0, 4, 0, 0),
(819, 24, 0, 0, 0, 0, 1, 0),
(820, 24, 0, 0, 0, 0, 0, 2),
(831, 28, 1, 0, 0, 0, 0, 0),
(832, 28, 0, 3, 0, 0, 0, 0),
(833, 28, 0, 0, 1, 0, 0, 0),
(834, 28, 0, 0, 3, 0, 0, 0),
(835, 28, 0, 0, 6, 0, 0, 0),
(836, 28, 0, 0, 0, 1, 0, 0),
(837, 28, 0, 0, 0, 3, 0, 0),
(838, 28, 0, 0, 0, 4, 0, 0),
(839, 28, 0, 0, 0, 0, 3, 0),
(840, 28, 0, 0, 0, 0, 0, 1),
(850, 29, 1, 0, 0, 0, 0, 0),
(851, 29, 0, 3, 0, 0, 0, 0),
(852, 29, 0, 0, 1, 0, 0, 0),
(853, 29, 0, 0, 2, 0, 0, 0),
(854, 29, 0, 0, 3, 0, 0, 0),
(855, 29, 0, 0, 0, 3, 0, 0),
(856, 29, 0, 0, 0, 4, 0, 0),
(857, 29, 0, 0, 0, 0, 3, 0),
(858, 29, 0, 0, 0, 0, 0, 1),
(859, 32, 1, 0, 0, 0, 0, 0),
(860, 32, 0, 3, 0, 0, 0, 0),
(861, 32, 0, 0, 1, 0, 0, 0),
(862, 32, 0, 0, 3, 0, 0, 0),
(863, 32, 0, 0, 0, 1, 0, 0),
(864, 32, 0, 0, 0, 2, 0, 0),
(865, 32, 0, 0, 0, 3, 0, 0),
(866, 32, 0, 0, 0, 4, 0, 0),
(867, 32, 0, 0, 0, 0, 3, 0),
(868, 32, 0, 0, 0, 0, 0, 1),
(887, 34, 2, 0, 0, 0, 0, 0),
(888, 34, 0, 3, 0, 0, 0, 0),
(889, 34, 0, 0, 3, 0, 0, 0),
(890, 34, 0, 0, 5, 0, 0, 0),
(891, 34, 0, 0, 6, 0, 0, 0),
(892, 34, 0, 0, 0, 1, 0, 0),
(893, 34, 0, 0, 0, 4, 0, 0),
(894, 34, 0, 0, 0, 0, 3, 0),
(895, 34, 0, 0, 0, 0, 0, 1),
(896, 36, 1, 0, 0, 0, 0, 0),
(897, 36, 0, 3, 0, 0, 0, 0),
(898, 36, 0, 0, 3, 0, 0, 0),
(899, 36, 0, 0, 5, 0, 0, 0),
(900, 36, 0, 0, 6, 0, 0, 0),
(901, 36, 0, 0, 0, 2, 0, 0),
(902, 36, 0, 0, 0, 3, 0, 0),
(903, 36, 0, 0, 0, 0, 3, 0),
(904, 36, 0, 0, 0, 0, 0, 1),
(905, 37, 1, 0, 0, 0, 0, 0),
(906, 37, 2, 0, 0, 0, 0, 0),
(907, 37, 3, 0, 0, 0, 0, 0),
(908, 37, 0, 3, 0, 0, 0, 0),
(909, 37, 0, 0, 1, 0, 0, 0),
(910, 37, 0, 0, 3, 0, 0, 0),
(911, 37, 0, 0, 22, 0, 0, 0),
(912, 37, 0, 0, 0, 1, 0, 0),
(913, 37, 0, 0, 0, 4, 0, 0),
(914, 37, 0, 0, 0, 0, 3, 0),
(915, 37, 0, 0, 0, 0, 0, 1),
(931, 49, 2, 0, 0, 0, 0, 0),
(932, 49, 0, 3, 0, 0, 0, 0),
(933, 49, 0, 0, 1, 0, 0, 0),
(934, 49, 0, 0, 2, 0, 0, 0),
(935, 49, 0, 0, 5, 0, 0, 0),
(936, 49, 0, 0, 6, 0, 0, 0),
(937, 49, 0, 0, 0, 1, 0, 0),
(938, 49, 0, 0, 0, 2, 0, 0),
(939, 49, 0, 0, 0, 3, 0, 0),
(940, 49, 0, 0, 0, 4, 0, 0),
(941, 49, 0, 0, 0, 0, 3, 0),
(942, 49, 0, 0, 0, 0, 0, 2),
(963, 46, 1, 0, 0, 0, 0, 0),
(964, 46, 0, 3, 0, 0, 0, 0),
(965, 46, 0, 0, 3, 0, 0, 0),
(966, 46, 0, 0, 26, 0, 0, 0),
(967, 46, 0, 0, 27, 0, 0, 0),
(968, 46, 0, 0, 0, 2, 0, 0),
(969, 46, 0, 0, 0, 3, 0, 0),
(970, 46, 0, 0, 0, 4, 0, 0),
(971, 46, 0, 0, 0, 0, 1, 0),
(972, 46, 0, 0, 0, 0, 0, 1),
(989, 47, 2, 0, 0, 0, 0, 0),
(990, 47, 0, 3, 0, 0, 0, 0),
(991, 47, 0, 0, 2, 0, 0, 0),
(992, 47, 0, 0, 33, 0, 0, 0),
(993, 47, 0, 0, 0, 1, 0, 0),
(994, 47, 0, 0, 0, 4, 0, 0),
(995, 47, 0, 0, 0, 0, 3, 0),
(996, 47, 0, 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_format`
--

CREATE TABLE `product_format` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `format` varchar(50) NOT NULL,
  `unit_of_measure` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `sale_price` int(11) NOT NULL,
  `unit_of_sale` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_format`
--

INSERT INTO `product_format` (`id`, `product_id`, `format`, `unit_of_measure`, `price`, `sale_price`, `unit_of_sale`, `qty`) VALUES
(130, 20, '50', 'ML', 1100, 0, 'Price', 15),
(131, 20, '10', 'ML', 200, 0, 'Price', 0),
(132, 20, '5', 'ML', 120, 0, 'Price', 0),
(133, 21, '50', 'ML', 1250, 0, '', 0),
(134, 21, '10', 'ML', 200, 0, '', 0),
(135, 21, '5', 'ML', 120, 0, '', 0),
(136, 22, '50', 'ML', 1150, 0, '', 0),
(137, 22, '10', 'ML', 200, 0, '', 0),
(138, 22, '5', 'ML', 120, 0, '', 0),
(139, 23, '50', 'ML', 1100, 0, 'Price', 20),
(140, 23, '10', 'ML', 200, 0, 'Price', 10),
(141, 23, '5', 'ML', 120, 0, 'Price', 20),
(145, 24, '50', 'ML', 1250, 0, 'Price', 0),
(146, 24, '10', 'ML', 200, 0, 'Price', 0),
(147, 24, '5', 'ML', 120, 0, 'Price', 0),
(148, 25, '50', 'ML', 1100, 0, '', 0),
(149, 25, '10', 'ML', 200, 0, '', 0),
(150, 25, '5', 'ML', 120, 0, '', 0),
(151, 26, '50', 'ML', 1100, 0, '', 0),
(152, 26, '10', 'ML', 200, 0, '', 0),
(153, 26, '5', 'ML', 120, 0, '', 0),
(154, 27, '50', 'ML', 1050, 0, '', 0),
(155, 27, '10', 'ML', 200, 0, '', 0),
(156, 27, '5', 'ML', 120, 0, '', 0),
(160, 28, '50', 'ML', 1350, 0, 'Price', 0),
(161, 28, '10', 'ML', 200, 0, 'Price', 0),
(162, 28, '5', 'ML', 120, 0, 'Price', 0),
(163, 29, '50', 'ML', 1250, 0, 'Price', 0),
(164, 29, '10', 'ML', 200, 0, 'Price', 0),
(165, 29, '5', 'ML', 120, 0, 'Price', 0),
(169, 31, '50', 'ML', 1550, 0, 'Price', 0),
(170, 31, '10', 'ML', 200, 0, 'Price', 0),
(171, 31, '5', 'ML', 120, 0, 'Price', 0),
(172, 30, '50', 'ML', 1100, 0, 'Price', 0),
(173, 30, '10', 'ML', 200, 0, 'Price', 0),
(174, 30, '5', 'ML', 120, 0, 'Price', 0),
(190, 32, '50', 'ML', 1250, 0, 'Price', 0),
(191, 32, '10', 'ML', 200, 0, 'Price', 0),
(192, 32, '5', 'ML', 120, 0, 'Price', 0),
(217, 33, '50', 'ML', 1100, 0, 'Price', 0),
(218, 34, '50', 'ML', 1100, 0, 'Price', 0),
(219, 34, '10', 'ML', 200, 0, 'Price', 0),
(220, 34, '5', 'ML', 120, 0, 'Price', 0),
(221, 35, '50', 'ML', 1100, 0, 'Price', 0),
(222, 35, '10', 'ML', 200, 0, 'Price', 0),
(223, 35, '5', 'ML', 120, 0, 'Price', 0),
(224, 36, '50', 'ML', 1250, 0, 'Price', 20),
(225, 36, '10', 'ML', 200, 0, 'Price', 20),
(226, 36, '5', 'ML', 120, 0, 'Price', 20),
(227, 37, '50', 'ML', 1100, 0, 'Price', 0),
(228, 37, '10', 'ML', 200, 0, 'Price', 0),
(229, 37, '5', 'ML', 120, 0, 'Price', 0),
(230, 38, '50', 'ML', 1100, 0, 'Price', 0),
(231, 38, '10', 'ML', 200, 0, 'Price', 0),
(232, 38, '5', 'ML', 120, 0, 'Price', 0),
(233, 39, '50', 'ML', 1150, 0, 'Price', 0),
(234, 39, '10', 'ML', 200, 0, 'Price', 0),
(235, 39, '5', 'ML', 120, 0, 'Price', 0),
(236, 40, '50', 'ML', 1150, 0, 'Price', 0),
(237, 40, '10', 'ML', 200, 0, 'Price', 0),
(238, 40, '5', 'ML', 120, 0, 'Price', 0),
(239, 41, '50', 'ML', 1100, 0, 'Price', 0),
(240, 41, '10', 'ML', 200, 0, 'Price', 0),
(241, 41, '5', 'ML', 120, 0, 'Price', 0),
(242, 42, '50', 'ML', 1100, 0, 'Price', 0),
(243, 42, '10', 'ML', 200, 0, 'Price', 0),
(244, 42, '5', 'ML', 120, 0, 'Price', 0),
(245, 43, '50', 'ML', 1150, 0, 'Price', 0),
(246, 43, '10', 'ML', 200, 0, 'Price', 0),
(247, 43, '5', 'ML', 120, 0, 'Price', 0),
(248, 44, '50', 'ML', 1150, 0, 'Price', 0),
(249, 44, '10', 'ML', 200, 0, 'Price', 0),
(250, 44, '5', 'ML', 120, 0, 'Price', 0),
(251, 45, '50', 'ML', 1150, 0, 'Price', 0),
(252, 45, '10', 'ML', 200, 0, 'Price', 0),
(253, 45, '5', 'ML', 120, 0, 'Price', 0),
(254, 46, '50', 'ML', 1150, 0, 'Price', 20),
(257, 47, '50', 'ML', 1100, 0, 'Price', 20),
(258, 47, '10', 'ML', 200, 100, 'Price', 20),
(259, 47, '5', 'ML', 120, 0, 'Price', 20),
(260, 46, '10', 'ML', 200, 0, 'Price', 0),
(261, 46, '5', 'ML', 120, 0, 'Price', 0),
(273, 49, '50', 'ML', 1250, 0, 'Price', 0),
(274, 49, '10', 'ML', 200, 0, 'Price', 0),
(275, 49, '5', 'ML', 120, 0, 'Price', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_path`) VALUES
(91, 23, 'Mr%20Right%20Bottle%20and%20Box.png'),
(104, 20, 'Eros%20Versace%20Box%20and%20Bottle%20Picture.jpg'),
(105, 30, 'Azzaro%20Wanted%20Bottle%20and%20Box.png'),
(106, 24, '212%20Men%20Bottle%20and%20Box.jpg'),
(108, 28, 'Aventus%20Creed%20Bottle%20and%20Box%20Picture.jpg'),
(109, 32, 'Bleu%20De%20Chanel%20Bottle%20and%20Box%20Picture.png'),
(110, 33, 'Bombhshell%20bottle%20and%20Box%20.png'),
(112, 34, 'Inner%20Soul%20Bottle%20And%20Box.png'),
(113, 36, 'Velvet%20Rebel%20bottle%20and%20box.png'),
(114, 37, 'CK%20One%20Bottle%20and%20Box.png'),
(117, 49, 'Gucci%20Flora%20Bottle%20and%20Box.png'),
(120, 47, 'Gucci%20Bloom%20Bottle%20and%20Box.png');

-- --------------------------------------------------------

--
-- Table structure for table `product_stock`
--

CREATE TABLE `product_stock` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `format_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_stock`
--

INSERT INTO `product_stock` (`id`, `product_id`, `format_id`, `qty`, `date`) VALUES
(92, 20, 130, 5, '2024-11-24 22:39:22'),
(93, 20, 130, 10, '2024-11-29 14:50:24'),
(94, 36, 224, 20, '2024-11-29 14:52:11'),
(95, 36, 225, 20, '2024-11-29 14:52:16'),
(96, 36, 226, 20, '2024-11-29 14:52:23'),
(97, 23, 139, 20, '2024-12-03 11:20:06'),
(98, 23, 140, 10, '2024-12-03 11:20:15'),
(99, 23, 141, 20, '2024-12-03 11:20:23'),
(100, 47, 257, 20, '2024-12-03 11:39:53'),
(101, 47, 258, 20, '2024-12-03 11:40:01'),
(102, 47, 259, 20, '2024-12-03 11:40:08'),
(103, 46, 254, 20, '2024-12-03 11:40:17');

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
(36, 10, 'Humidifier'),
(37, 10, 'Bakhoor'),
(38, 10, 'Fragrance Candles'),
(39, 10, 'Electric Burner');

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
(6, 'Fruity'),
(7, 'Lemon'),
(8, 'Bergamot'),
(9, 'Grapefruit'),
(10, 'Orange'),
(11, 'Mandarin'),
(12, 'Apple'),
(13, 'Pineapple'),
(14, 'Melon'),
(15, 'Rose'),
(16, 'Jasmine'),
(17, 'Lavender'),
(18, 'Violet'),
(19, 'Mint'),
(20, 'Basil'),
(21, 'Tonka Bean'),
(22, 'Green'),
(23, 'Spicy'),
(24, 'Powdery'),
(25, 'Musky'),
(26, 'Fresh'),
(27, 'Animalic'),
(28, 'Warm'),
(29, 'Amber'),
(30, 'Aldehydic'),
(31, 'Aromatic'),
(32, 'Vanila'),
(33, 'Tuberose');

-- --------------------------------------------------------

--
-- Table structure for table `units_of_measure`
--

CREATE TABLE `units_of_measure` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `units_of_measure`
--

INSERT INTO `units_of_measure` (`id`, `name`) VALUES
(1, 'ML'),
(2, 'gm');

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
(1, 'Sajjad', 'sajjadsaleem341@gmail.com', 'ce245834f602c2099a87e9f0080157ff', '03176122252', '', '', '2024-10-10 09:45:05'),
(2, 'Moiz', 'moiz@gmail.com', '2a77d9de907385ebf2b94d6b35fbcdd0', '03032708236', '', '', '2024-10-10 09:45:05'),
(4, 'Amir', 'amir@gmail.com', '63eefbd45d89e8c91f24b609f7539942', '03134567876', '', '', '2024-10-14 06:22:04'),
(5, 'm owais', 'ogadit27@gmail.com', '2290d644a14709c5254766b67b768786', '03111262749', '', '', '2024-10-14 11:14:45'),
(6, 'Mrsabdullal', 'abdullahsabah746@gmail.com', '7093a62007121d2e921bbfef639f745f', '03341213597', '', '', '2024-10-14 01:11:00');

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
-- Indexes for table `bundles`
--
ALTER TABLE `bundles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bundle_details`
--
ALTER TABLE `bundle_details`
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
-- Indexes for table `homepage_data`
--
ALTER TABLE `homepage_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `impressions`
--
ALTER TABLE `impressions`
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
-- Indexes for table `product_details`
--
ALTER TABLE `product_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_format`
--
ALTER TABLE `product_format`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_stock`
--
ALTER TABLE `product_stock`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `units_of_measure`
--
ALTER TABLE `units_of_measure`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_role`
--
ALTER TABLE `admin_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_user`
--
ALTER TABLE `admin_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bundles`
--
ALTER TABLE `bundles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bundle_details`
--
ALTER TABLE `bundle_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `gender`
--
ALTER TABLE `gender`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `genre`
--
ALTER TABLE `genre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `homepage_data`
--
ALTER TABLE `homepage_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `impressions`
--
ALTER TABLE `impressions`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders_detail`
--
ALTER TABLE `orders_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_status`
--
ALTER TABLE `order_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `product_details`
--
ALTER TABLE `product_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=997;

--
-- AUTO_INCREMENT for table `product_format`
--
ALTER TABLE `product_format`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=276;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `product_stock`
--
ALTER TABLE `product_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `type`
--
ALTER TABLE `type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `units_of_measure`
--
ALTER TABLE `units_of_measure`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product_format`
--
ALTER TABLE `product_format`
  ADD CONSTRAINT `product_format_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD CONSTRAINT `sub_categories_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
