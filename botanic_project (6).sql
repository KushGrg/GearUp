-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2023 at 04:29 PM
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
-- Database: `botanic_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `pid` int(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `price` int(200) NOT NULL,
  `quantity` int(200) NOT NULL,
  `image` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `email`, `pid`, `name`, `price`, `quantity`, `image`) VALUES
(8, '', 41, 'rose', 40, 1, 'product5.jpg'),
(29, 'aman@gmail.com', 48, 'lilly', 50, 1, 'product1.jpg'),
(44, 'aman@gmail.com', 49, 'Mango Plant', 55, 10, 'white bouquet.jpg'),
(45, 'aman@gmail.com', 57, 'lamche', 50, 2, 'cat2.jpg'),
(56, 'rohan@gmail.com', 57, 'lamche', 50, 1, 'cat2.jpg'),
(65, 'sujita@gmail.com', 41, 'rose', 40, 1, 'product5.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(100) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `question` varchar(500) NOT NULL,
  `Reply` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `name`, `email`, `question`, `Reply`) VALUES
(30, 'sujita', 'sujita@gmail.com', 'what can?', 'i an super hero i can do anything'),
(31, 'sujita', 'sujita@gmail.com', 'what is computer?', 'computer is computer'),
(32, 'sujita', 'sujita@gmail.com', 'what is  dog?', 'dog is animal'),
(33, 'sujita', 'sujita@gmail.com', 'what is elephant?', NULL),
(34, 'sujita', 'sujita@gmail.com', 'what is frog?', NULL),
(35, 'sujita', 'sujita@gmail.com', 'what is giraffe?', NULL),
(36, 'sujita', 'sujita@gmail.com', 'what is hen?', NULL),
(40, 'Karishma', 'karishma@gmail.com', 'What is your name?', 'Im sujita pandey');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `Full_name` varchar(225) NOT NULL,
  `email` varchar(225) NOT NULL,
  `number` bigint(225) NOT NULL,
  `method` varchar(225) NOT NULL,
  `address` varchar(225) NOT NULL,
  `total_products` varchar(225) DEFAULT NULL,
  `total_price` int(225) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(225) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `Full_name`, `email`, `number`, `method`, `address`, `total_products`, `total_price`, `date`, `status`) VALUES
(19, 'sujita', 'sujita@gmail.com', 9876765765, 'cash on delivery', 'bidur-4 Battar, KTM, nepal', '- rose (5) ', 200, '2023-06-22', 'completed'),
(20, 'sujita', 'sujita@gmail.com', 9837456447, 'cash on delivery', 'bidur-4 Battar, Nuwakot, nepal', '- rose (1) ', 40, '2023-06-23', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `details` varchar(500) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `p_quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `details`, `price`, `image`, `type`, `p_quantity`) VALUES
(41, 'rose', 'zdjhfsdihf fdhfkjaskjxcvnxc sdfyrfhjksrf skfjhgdfgmzndbcvdhf shfiuwryjvjcxvkjdhfv zjdbvhgiufdg', 40, 'product5.jpg', 'flower', 4),
(48, 'lilly', 'lily, (genus Lilium), genus of 80 to 100 species of herbaceous flowering plants of the family Liliaceae, native to temperate areas of the Northern Hemisphere. Many lilies are prized as ornamental plants, and they have been extensively hybridized.\r\n\r\nThe word lily is also used in the common names of many plants of other genera that resemble true lilies. These include the daylily (Hemerocallis) and various species of the family Amaryllidaceae.', 50, 'product1.jpg', 'Aquatic Plants', 0),
(49, 'Mango Plant', 'A mango is an edible stone fruit produced by the tropical tree Mangifera indica. It is believed to have originated between northwestern Myanmar, Bangladesh, and northeastern India. M. indica has been cultivated in South and Southeast Asia since ancient times resulting in two types of modern mango cultivars: the \"Indian type\" and the \"Southeast Asian type\". ', 55, 'white bouquet.jpg', 'Tree', 10),
(52, 'snake Plantt', 'hdfbgdhf  ierhgdfgjfdgb', 30, 'product1.png', 'Tree', 11),
(53, 'putaliFul', 'loremm lreoemkjsnjshuyksgkxhas,cjkcwg adiuhayucgsfghdsg', 69, 'home.png', 'Tree', 16),
(55, 'jasmine', 'akjsdskjdkjsncc', 49, 'banner1.jpg', 'Tree', 17),
(56, 'Dalle', 'sjbdjsdbcjsbdcjsdjcsdjbcsdjbc', 20, 'product2.jpg', 'Seculants', 11),
(57, 'lamche', 'sjdbfsjdfjsdfsdcxjcbxnbsdfsdgc', 50, 'cat2.jpg', 'Herbs', 2),
(58, 'patale', 'ihfsbxcbvudsgferfihdjhsbxjncbxnbvhjxc', 70, 'cat3.jpg', 'Others', 3),
(59, 'Khursani', 'kjwhdkjsdfhsfsdbmnncbx', 60, 'cat4.jpg', 'Others', 5),
(60, 'syau', 'ahjshajsjhsjahsaj syauuuu!!!!', 300, 'product1.png', 'Tree', NULL),
(61, 'baushas', 'owieoiw', 99, 'heroImage.jpg', 'Others', NULL),
(62, 'succulentsss', 'iajidjsa', 55, 'succulents.png', 'Seculants', NULL),
(63, 'hariyo', 'iiquiuqs', 55, 'img2.png', 'Others', NULL),
(64, 'tulsi', 'asjhshcshcgc', 200, 'img2.png', 'Herbs', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `quote`
--

CREATE TABLE `quote` (
  `id` int(11) NOT NULL,
  `quote` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quote`
--

INSERT INTO `quote` (`id`, `quote`) VALUES
(3, 'The largest living organism on Earth is a plant. The giant sequoia trees, found in California, can reach heights of over 300 feet (91 meters) and have a lifespan of thousands of years.'),
(4, 'Plants are the primary producers of food on Earth. Through the process of photosynthesis, they convert sunlight, carbon dioxide, and water into glucose (energy) and oxygen.'),
(5, 'The giant sequoia trees are the largest living organisms on Earth, reaching heights of over 300 feet (91 meters).'),
(6, 'Plants can communicate with each other by releasing chemical signals.'),
(7, 'Plants can communicate with each other by releasing chemical signals.'),
(8, 'Plants can \"hear\" sounds and respond to vibrations.'),
(9, 'Plants can \"hear\" sounds and respond to vibrations.'),
(10, 'plant are sweet'),
(11, 'plant make good mood'),
(12, 'ahkas'),
(13, 'jajh hashjkas'),
(14, 'plant is beautiful');

-- --------------------------------------------------------

--
-- Table structure for table `registered_user`
--

CREATE TABLE `registered_user` (
  `Full_name` varchar(200) NOT NULL,
  `Username` varchar(200) NOT NULL,
  `Email` varchar(200) NOT NULL,
  `Password` varchar(200) NOT NULL,
  `UserType` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `registered_user`
--

INSERT INTO `registered_user` (`Full_name`, `Username`, `Email`, `Password`, `UserType`) VALUES
('Binam', 'Binam999', 'binambasnet310@gmail.com', '$2y$10$tnj4EsGi2RqiE9TtGMJV/e5GeG4/UdK3uRTOWdrDpoPXtWfUb8CrK', 'User'),
('farah', 'farah', 'farah@gmail.com', '$2y$10$J3LlJnbhraJgcyqgbtk4yebG2xicHcA8aT4imNCowGP08I0nS/hXq', 'Admin'),
('Karishma Thapa', 'Karishma', 'karishma@gmail.com', '$2y$10$RUbROkXvm9SHyTbOzZOHjeLqt1G2X6JUL8bEwowYy2q/rBnHJ/qdi', 'User'),
('rohan', 'rohan33', 'rohan@gmail.com', '$2y$10$x.hxZI5kFPolyritqC/0o.B3Ue5N0HitwSGqr7PiCJyBWrVbKUviC', 'User'),
('sujita', 'sujita', 'sujita@gmail.com', '$2y$10$8knWYSO2ia2wLRlOjAt4z.XHSiXS2NOtTVc4qSmSW7gbvj9cHK8nK', 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quote`
--
ALTER TABLE `quote`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registered_user`
--
ALTER TABLE `registered_user`
  ADD PRIMARY KEY (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `quote`
--
ALTER TABLE `quote`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
