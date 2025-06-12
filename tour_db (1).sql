-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2025 at 04:21 PM
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
-- Database: `tour_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `email`, `password`) VALUES
(3, 'admin@gmail.com', 'admin1234');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `num_adults` int(11) NOT NULL,
  `num_children` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Confirmed','Canceled') NOT NULL DEFAULT 'Confirmed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`booking_id`, `user_id`, `package_id`, `num_adults`, `num_children`, `total_price`, `booking_date`, `status`) VALUES
(8, 1, 1, 2, 3, 63000.00, '2025-04-20 02:48:27', 'Canceled'),
(9, 1, 2, 2, 0, 50000.00, '2025-04-20 03:54:23', 'Confirmed'),
(10, 1, 5, 2, 1, 175000.00, '2025-04-20 03:56:39', 'Canceled'),
(16, 2, 11, 2, 1, 212500.00, '2025-04-21 05:53:03', 'Confirmed');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `Cat_id` int(11) NOT NULL,
  `Cat_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`Cat_id`, `Cat_name`) VALUES
(1, 'Adventure'),
(2, 'Wildlife'),
(3, 'Spiritual'),
(4, 'Family'),
(5, 'Beach'),
(6, 'Historical'),
(7, 'Luxury'),
(8, 'Mountain'),
(9, 'Eco-Tourism'),
(10, 'Desert');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `contact_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` datetime DEFAULT current_timestamp(),
  `admin_reply` text DEFAULT NULL,
  `reply_date` timestamp NULL DEFAULT NULL,
  `status` enum('Pending','Replied') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`contact_id`, `name`, `email`, `subject`, `message`, `submitted_at`, `admin_reply`, `reply_date`, `status`) VALUES
(2, 'deepika', 'deepi@gmail.com', 'regarding new york package', 'is vegetarian food available for the restaurant i booked?', '2025-04-20 22:47:01', 'Yes, vegetarian food is available.', '2025-04-20 17:28:45', 'Replied'),
(3, 'eswari', 'eswari@gmail.com', 'regarding athens package', 'is tour guide included in this package?', '2025-04-21 11:25:38', 'yes our tour guide will help you throuhgout your trip. Enjoy alot!!!!', '2025-04-21 02:27:23', 'Replied');

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

CREATE TABLE `package` (
  `Packid` int(11) NOT NULL,
  `Subcatid` int(11) NOT NULL,
  `Packname` varchar(255) NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `Description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`Packid`, `Subcatid`, `Packname`, `Price`, `Description`, `image`, `latitude`, `longitude`) VALUES
(1, 1, 'Rock Climbing in Yosemite', 18000.00, 'Challenge yourself in Yosemite National Park.', '1.jpg', 37.8651, -119.5383),
(2, 2, 'Paragliding in Interlaken', 25000.00, 'Fly over lakes and mountains in Switzerland.', '2.jpg', 46.6863, 7.8632),
(3, 3, 'City Adventures in Bangkok', 30000.00, 'Explore temples, nightlife, and cuisine in Thailand\'s capital.', '3.jpg', 13.7563, 100.5018),
(4, 4, 'City Getaway in London', 40000.00, 'Explore Big Ben, Buckingham Palace, and the Thames.', '4.jpg', 51.5072, -0.1276),
(5, 5, 'Urban Safari in Nairobi', 70000.00, 'Discover wildlife and culture in Kenya\'s capital city.', '5.jpg', -1.286389, 36.817223),
(6, 6, 'Zen Monastery Tour in Kyoto', 22000.00, 'Visit tranquil temples and gardens in Kyoto.', '6.jpg', 35.0116, 135.7681),
(7, 7, 'Ancient Tour in Rome', 15000.00, 'Walk through the Colosseum, Vatican, and Roman streets.', '7.jpg', 41.9028, 12.4964),
(8, 8, 'Family Adventure in Universal Studios Singapore', 50000.00, 'Enjoy family fun at world-famous attractions.', '8.jpg', 1.254, 103.8238),
(9, 9, 'Cultural Highlights in New York City', 90000.00, 'Statue of Liberty, Times Square, and world-class museums await.', '9.jpg', 40.7128, -74.006),
(10, 10, 'Beach Escape in Waikiki, Hawaii', 45000.00, 'Sun, surf, and sand on Hawaii’s famous beach.', '10.jpg', 21.2767, -157.8275),
(11, 11, 'Greek Marvels in Athens', 85000.00, 'Explore the Acropolis, ancient ruins, and cafes.', '11.jpg', 37.9838, 23.7275),
(12, 12, 'Ancient Egypt Experience in Cairo', 60000.00, 'Pyramids of Giza, Nile cruise, and museums.', '12.jpg', 30.0444, 31.2357),
(13, 13, 'Cultural Walk in Beijing', 30000.00, 'Historic sites, street markets, and ancient temples.', '13.jpg', 39.9042, 116.4074),
(14, 14, 'Beach and Glam in Los Angeles', 110000.00, 'Visit Hollywood, Santa Monica, and famous film spots.', '14.jpg', 34.0522, -118.2437),
(15, 15, 'Mediterranean Escape in Barcelona', 150000.00, 'See Gaudi\'s architecture, beaches, and vibrant culture.', '15.jpg', 41.3851, 2.1734),
(16, 16, 'Skiing Adventure in Zermatt', 65000.00, 'Hit the slopes with breathtaking alpine views.', '16.jpg', 46.0207, 7.7491),
(17, 17, 'Andes Hiking Expedition in Cusco', 35000.00, 'Explore the trails of Peru’s Andes mountains.', '17.jpg', -13.5319, -71.9675),
(18, 18, 'Rainforest Eco Tour in Monteverde, Costa Rica', 38000.00, 'Nature and biodiversity at its finest.', '18.jpg', 10.3, -84.8167),
(19, 19, 'Amazon Eco Tour in Iquitos', 42000.00, 'Travel deep into the Peruvian Amazon.', '19.jpg', -3.7437, -73.2516),
(20, 20, 'Cultural Delight in Istanbul', 32000.00, 'Blue Mosque, Hagia Sophia, and Turkish bazaars.', '20.jpg', 41.0082, 28.9784),
(21, 21, 'Camel Trek in Merzouga', 36000.00, 'Camp under the stars in the vast Sahara dunes.', '21.jpg', 31.1, -3.9833);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `review_text` text NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `package_id`, `review_text`, `rating`, `created_at`) VALUES
(1, 2, 2, 'i really enjoyed a lot!!!!!', 5, '2025-04-19 06:32:19'),
(2, 1, 1, 'perfect for adventurous people i really loved it!!!!!!', 5, '2025-04-20 08:32:21');

-- --------------------------------------------------------

--
-- Table structure for table `subcategory`
--

CREATE TABLE `subcategory` (
  `Subcatid` int(11) NOT NULL,
  `Cat_id` int(11) NOT NULL,
  `Subcat_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subcategory`
--

INSERT INTO `subcategory` (`Subcatid`, `Cat_id`, `Subcat_name`) VALUES
(1, 1, 'Rock Climbing'),
(2, 1, 'Paragliding'),
(3, 1, 'City Tour in Bangkok'),
(4, 2, 'Beach & Culture in Rio'),
(5, 2, 'Wildlife Safari in Nairobi'),
(6, 3, 'Buddhist Monastery Tours'),
(7, 3, 'Historical Tour in Delhi'),
(8, 4, 'Disneyland Family Package'),
(9, 4, 'City Lights NYC'),
(10, 5, 'Bali Beach Holiday'),
(11, 5, 'Historic Athens Walk'),
(12, 6, 'Ancient Egypt - Cairo'),
(13, 6, 'Great Wall of China Trek'),
(14, 7, 'Beaches of Goa'),
(15, 7, 'Barcelona Beach & City'),
(16, 8, 'Swiss Alps Tour'),
(17, 8, 'Andes Mountain Hiking'),
(18, 9, 'Eco-Tourism in Costa Rica'),
(19, 9, 'Amazon Rainforest Trip'),
(20, 10, 'Cultural Tour Istanbul'),
(21, 10, 'Sahara Desert Tour');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `phone`, `address`) VALUES
(1, 'deepika', 'deepi@gmail.com', '$2y$10$8Kpwu1.cfise6MgKfGYDAeWc1mkVUTf2VZwry/IJdcs.UvmYKlrom', '9876543210', 'kumbakonam'),
(2, 'eswari', 'eswari@gmail.com', '$2y$10$HhwSf9R.Pex7PmJbLveGPOn6TLPGnY/HsCOe/WACqpc1uwO.3gsGa', '998877663245', 'mayiladuthurai');

-- --------------------------------------------------------

--
-- Table structure for table `user_selections`
--

CREATE TABLE `user_selections` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `place_name` varchar(255) NOT NULL,
  `place_type` varchar(255) NOT NULL,
  `packname` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_selections`
--

INSERT INTO `user_selections` (`id`, `user_id`, `place_name`, `place_type`, `packname`, `created_at`) VALUES
(1, 1, 'Leura Cascades', 'Attraction', 'Rock Climbing in Yosemite', '2025-04-20 08:30:58'),
(2, 1, 'Former site of Explorers Tree', 'Attraction', 'Rock Climbing in Yosemite', '2025-04-20 08:30:58'),
(3, 1, 'Upper Leura Cascades', 'Attraction', 'Rock Climbing in Yosemite', '2025-04-20 08:30:58'),
(4, 1, 'Street Art Walk', 'Attraction', 'Rock Climbing in Yosemite', '2025-04-20 08:30:58'),
(5, 1, 'Unnamed', 'Attraction', 'Rock Climbing in Yosemite', '2025-04-20 08:30:58'),
(6, 1, 'Anki\'s Indian Restaurant', 'Restaurant', 'Rock Climbing in Yosemite', '2025-04-20 08:30:58'),
(7, 1, 'Katoomba Canton Palace', 'Restaurant', 'Rock Climbing in Yosemite', '2025-04-20 08:30:58'),
(8, 1, 'Pins On Lurline', 'Restaurant', 'Rock Climbing in Yosemite', '2025-04-20 08:30:58'),
(9, 1, 'Elysian Bar & Restaurant', 'Restaurant', 'Rock Climbing in Yosemite', '2025-04-20 08:30:58'),
(10, 1, 'Rustico', 'Restaurant', 'Rock Climbing in Yosemite', '2025-04-20 08:30:58'),
(11, 1, 'The Gearin', 'Hotel', 'Rock Climbing in Yosemite', '2025-04-20 08:30:58'),
(12, 1, 'Modelleisenbahn', 'Attraction', 'Paragliding in Interlaken', '2025-04-20 08:47:35'),
(13, 1, 'Blumenuhr', 'Attraction', 'Paragliding in Interlaken', '2025-04-20 08:47:35'),
(14, 1, 'Nautilus', 'Attraction', 'Paragliding in Interlaken', '2025-04-20 08:47:35'),
(15, 1, 'Shuttle', 'Attraction', 'Paragliding in Interlaken', '2025-04-20 08:47:35'),
(16, 1, 'Unnamed', 'Attraction', 'Paragliding in Interlaken', '2025-04-20 08:47:35'),
(17, 1, 'Lindner Grand Hotel Beau Rivage', 'Hotel', 'Paragliding in Interlaken', '2025-04-20 08:47:35'),
(18, 1, 'Interlaken', 'Hotel', 'Paragliding in Interlaken', '2025-04-20 08:47:35'),
(19, 1, 'Bären Grill-Stübli', 'Restaurant', 'Paragliding in Interlaken', '2025-04-20 08:47:35'),
(20, 1, 'Laterne', 'Restaurant', 'Paragliding in Interlaken', '2025-04-20 08:47:35'),
(21, 1, 'Bamboo', 'Restaurant', 'Paragliding in Interlaken', '2025-04-20 08:47:35'),
(22, 1, 'Hooters', 'Restaurant', 'Paragliding in Interlaken', '2025-04-20 08:47:35'),
(23, 1, 'Hirschen', 'Restaurant', 'Paragliding in Interlaken', '2025-04-20 08:47:35'),
(24, 1, 'Unnamed', 'Attraction', 'Urban Safari in Nairobi', '2025-04-20 09:25:59'),
(25, 1, 'Kariokor Market', 'Attraction', 'Urban Safari in Nairobi', '2025-04-20 09:25:59'),
(26, 1, 'Wood market', 'Attraction', 'Urban Safari in Nairobi', '2025-04-20 09:25:59'),
(27, 1, 'Lazarus', 'Attraction', 'Urban Safari in Nairobi', '2025-04-20 09:25:59'),
(28, 1, 'Good person', 'Attraction', 'Urban Safari in Nairobi', '2025-04-20 09:25:59'),
(29, 1, 'China Plate', 'Restaurant', 'Urban Safari in Nairobi', '2025-04-20 09:25:59'),
(30, 1, 'Habesha II Ethiopian', 'Restaurant', 'Urban Safari in Nairobi', '2025-04-20 09:25:59'),
(31, 1, 'The Apple Munch Restaurant', 'Restaurant', 'Urban Safari in Nairobi', '2025-04-20 09:25:59'),
(32, 1, 'YWCA', 'Restaurant', 'Urban Safari in Nairobi', '2025-04-20 09:25:59'),
(33, 1, 'Savannah Upper Hill', 'Restaurant', 'Urban Safari in Nairobi', '2025-04-20 09:25:59'),
(34, 2, 'Φυλακή του Σωκράτη', 'Attraction', 'Greek Marvels in Athens', '2025-04-21 11:22:17'),
(35, 2, 'Κιμώνεια μνήματα', 'Attraction', 'Greek Marvels in Athens', '2025-04-21 11:22:17'),
(36, 2, 'Ψυρρή', 'Attraction', 'Greek Marvels in Athens', '2025-04-21 11:22:17'),
(37, 2, 'Unnamed', 'Attraction', 'Greek Marvels in Athens', '2025-04-21 11:22:17'),
(38, 2, 'Stanley', 'Hotel', 'Greek Marvels in Athens', '2025-04-21 11:22:17'),
(39, 2, 'Diethnes Hotel', 'Hotel', 'Greek Marvels in Athens', '2025-04-21 11:22:17'),
(40, 2, 'Roma Pizza', 'Restaurant', 'Greek Marvels in Athens', '2025-04-21 11:22:17'),
(41, 2, 'Αγορά', 'Restaurant', 'Greek Marvels in Athens', '2025-04-21 11:22:17'),
(42, 2, 'Πανόρμου Γεύσεις', 'Restaurant', 'Greek Marvels in Athens', '2025-04-21 11:22:17'),
(43, 2, 'Yum Yum', 'Restaurant', 'Greek Marvels in Athens', '2025-04-21 11:22:17'),
(44, 2, 'TGI Fridays', 'Restaurant', 'Greek Marvels in Athens', '2025-04-21 11:22:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`booking_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`Packid`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_selections`
--
ALTER TABLE `user_selections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_selections`
--
ALTER TABLE `user_selections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_selections`
--
ALTER TABLE `user_selections`
  ADD CONSTRAINT `user_selections_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
