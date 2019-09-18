-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2018 at 12:37 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `openairbooking`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `address_id` int(11) NOT NULL,
  `address_no` int(11) DEFAULT NULL,
  `address_street` varchar(20) DEFAULT NULL,
  `address_city` varchar(20) DEFAULT NULL,
  `address_postcode` varchar(9) DEFAULT NULL,
  `address_country` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`address_id`, `address_no`, `address_street`, `address_city`, `address_postcode`, `address_country`) VALUES
(1, 21, 'Perth Road', 'Dundee', 'DD2 1AW', 'United Kingdom'),
(2, 105, 'Lochee Road', 'Dundee', 'DD1 9ET', 'United Kingdom'),
(3, 208, 'W. 80th Street', 'New York City', 'NY 10024', 'United States'),
(4, 6, 'Wiston Place', 'Dundee', 'DD2 3JR', 'United Kingdom'),
(5, 30, 'Spuistraat', 'Amsterdam', '1012 TS', 'Netherlands');

-- --------------------------------------------------------

--
-- Table structure for table `attractions`
--

CREATE TABLE `attractions` (
  `attract_id` int(11) NOT NULL,
  `attract_location` varchar(280) DEFAULT NULL,
  `attract_type` varchar(60) DEFAULT NULL,
  `attract_image` blob,
  `address_address_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attractions`
--

INSERT INTO `attractions` (`attract_id`, `attract_location`, `attract_type`, `attract_image`, `address_address_id`) VALUES
(1, 'Central Park, New York City', 'Tour', blobidy, 3);
INSERT INTO `attractions` (`attract_id`, `attract_location`, `attract_type`, `attract_image`, `address_address_id`) VALUES
(2, 'Hotelscooters', 'Bike Hire', NULL, 5);

-- --------------------------------------------------------

--
-- Table structure for table `availability`
--

CREATE TABLE `availability` (
  `avail_id` int(11) NOT NULL,
  `avail_start_date` date DEFAULT NULL,
  `avail_end_date` date DEFAULT NULL,
  `avail_restrictions` varchar(280) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `availability`
--

INSERT INTO `availability` (`avail_id`, `avail_start_date`, `avail_end_date`, `avail_restrictions`) VALUES
(1, '2018-11-01', '2019-03-12', 'Total persons must not exceed 3'),
(2, '2018-12-18', '2019-01-28', 'No restrictions!');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `booking_id` int(11) NOT NULL,
  `customers_customer_id` int(11) NOT NULL,
  `branch_branch_id` int(11) NOT NULL,
  `package_pkg_id` int(11) NOT NULL,
  `service_booking_id` int(11) NOT NULL,
  `booking_reference` varchar(20) DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `booking_details` varchar(280) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`booking_id`, `customers_customer_id`, `branch_branch_id`, `package_pkg_id`, `service_booking_id`, `booking_reference`, `booking_date`, `booking_details`) VALUES
(1, 1, 1, 1, 1, 'OAB-NYC-1', '2018-11-12', 'Payment received: 2018-11-12');

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `branch_id` int(11) NOT NULL,
  `branch_name` varchar(30) DEFAULT NULL,
  `branch_phone_number` varchar(12) DEFAULT NULL,
  `branch_email` varchar(20) DEFAULT NULL,
  `address_address_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`branch_id`, `branch_name`, `branch_phone_number`, `branch_email`, `address_address_id`) VALUES
(1, 'OpenAirBooking Dundee', '01382123456', 'dundee@openair.com', 2);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `customer_username` varchar(20) NOT NULL,
  `customer_password` varchar(80) NOT NULL,
  `customer_first_name` varchar(18) DEFAULT NULL,
  `customer_last_name` varchar(18) DEFAULT NULL,
  `customer_phone` varchar(12) DEFAULT NULL,
  `customer_email` varchar(20) DEFAULT NULL,
  `customer_age` int(11) DEFAULT NULL,
  `customer_gender` varchar(6) DEFAULT NULL,
  `customer_nationality` varchar(20) DEFAULT NULL,
  `address_address_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_username`, `customer_password`, `customer_first_name`, `customer_last_name`, `customer_phone`, `customer_email`, `customer_age`, `customer_gender`, `customer_nationality`, `address_address_id`) VALUES
(1, 'mjwilson', 'dorwssap', 'Max', 'Wilson', '07123456789', 'maxw@email.com', 20, 'Male', 'British', 1);

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE `equipment` (
  `equip_id` int(11) NOT NULL,
  `equip_type` varchar(20) DEFAULT NULL,
  `equip_value` decimal(8,2) DEFAULT NULL,
  `equip_description` varchar(280) DEFAULT NULL,
  `equip_insured` char(1) DEFAULT NULL,
  `equip_required_training` char(1) DEFAULT NULL,
  `branch_branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`equip_id`, `equip_type`, `equip_value`, `equip_description`, `equip_insured`, `equip_required_training`, `branch_branch_id`) VALUES
(1, 'iMac', '1249.00', 'Retina 4K Display, 3.0GHz Processor, 1TB Storage', 'Y', 'N', 1);

-- --------------------------------------------------------

--
-- Table structure for table `marketing`
--

CREATE TABLE `marketing` (
  `pr_id` int(11) NOT NULL,
  `pr_description` varchar(280) DEFAULT NULL,
  `pr_type` varchar(60) DEFAULT NULL,
  `pr_budget` decimal(8,2) DEFAULT NULL,
  `pr_start_date` date DEFAULT NULL,
  `pr_end_date` date DEFAULT NULL,
  `package_pkg_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `marketing`
--

INSERT INTO `marketing` (`pr_id`, `pr_description`, `pr_type`, `pr_budget`, `pr_start_date`, `pr_end_date`, `package_pkg_id`) VALUES
(1, 'Exciting new tour guide experience available in NYC. Online advertising campaign.', 'Online Video Advertising', '8000.00', '2018-11-14', '2018-12-20', 1);

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

CREATE TABLE `package` (
  `pkg_id` int(11) NOT NULL,
  `pkg_price` decimal(8,2) DEFAULT NULL,
  `pkg_location` varchar(60) DEFAULT NULL,
  `pkg_internal_cost` decimal(8,2) DEFAULT NULL,
  `pkg_description` varchar(280) DEFAULT NULL,
  `pkg_image` varchar(280) DEFAULT NULL,
  `pp_id` int(11) NOT NULL,
  `availability_avail_id` int(11) NOT NULL,
  `attractions_attract_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`pkg_id`, `pkg_price`, `pkg_location`, `pkg_internal_cost`, `pkg_description`, `pkg_image`, `pp_id`, `availability_avail_id`, `attractions_attract_id`) VALUES
(1, '749.99', 'New York City, United States', '602.76', 'New York City comprises 5 boroughs sitting where the Hudson River meets the Atlantic Ocean. At its core is Manhattan, a densely populated borough that\'s among the world\'s major commercial, financial and cultural centers.', 'card2.jpg', 1, 1, 1),
(2, '430.00', 'Amsterdam, Netherlands', '409.12', 'Amsterdam is a pretty nice place, nice to cycle round I hear', 'card1.jpg', 2, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `pay_id` int(11) NOT NULL,
  `pay_date` date DEFAULT NULL,
  `pay_amount` decimal(8,2) DEFAULT NULL,
  `pay_description` varchar(280) DEFAULT NULL,
  `payment_plans_pp_id` int(11) NOT NULL,
  `customers_customer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`pay_id`, `pay_date`, `pay_amount`, `pay_description`, `payment_plans_pp_id`, `customers_customer_id`) VALUES
(1, '2018-11-12', '300.00', 'Initial upfront payment', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment_plans`
--

CREATE TABLE `payment_plans` (
  `pp_id` int(11) NOT NULL,
  `pp_upfront` decimal(8,2) DEFAULT NULL,
  `pp_monthly` decimal(8,2) DEFAULT NULL,
  `pp_no_of_payments` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_plans`
--

INSERT INTO `payment_plans` (`pp_id`, `pp_upfront`, `pp_monthly`, `pp_no_of_payments`) VALUES
(1, '300.00', '50.00', 10),
(2, '190.00', '30.00', 8);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(11) NOT NULL,
  `service_flights` varchar(20) DEFAULT NULL,
  `service_holidays` varchar(20) DEFAULT NULL,
  `service_destinations` varchar(20) DEFAULT NULL,
  `service_accomodation` varchar(20) DEFAULT NULL,
  `service_cost` decimal(8,2) DEFAULT NULL,
  `service_provider_provider_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `service_flights`, `service_holidays`, `service_destinations`, `service_accomodation`, `service_cost`, `service_provider_provider_id`) VALUES
(1, NULL, NULL, NULL, 'New York Hotels', '116.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `service_booking`
--

CREATE TABLE `service_booking` (
  `service_booking_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `branch_branch_id` int(11) NOT NULL,
  `services_service_id` int(11) NOT NULL,
  `service_booking_start_date` date DEFAULT NULL,
  `service_booking_end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `service_booking`
--

INSERT INTO `service_booking` (`service_booking_id`, `booking_id`, `branch_branch_id`, `services_service_id`, `service_booking_start_date`, `service_booking_end_date`) VALUES
(1, 1, 1, 1, '2018-12-10', '2018-12-28');

-- --------------------------------------------------------

--
-- Table structure for table `service_provider`
--

CREATE TABLE `service_provider` (
  `provider_id` int(11) NOT NULL,
  `provider_name` varchar(20) DEFAULT NULL,
  `provider_type` varchar(20) DEFAULT NULL,
  `provider_phone` varchar(12) DEFAULT NULL,
  `provider_email` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `service_provider`
--

INSERT INTO `service_provider` (`provider_id`, `provider_name`, `provider_type`, `provider_phone`, `provider_email`) VALUES
(1, 'NYCAccom', 'Accomodation', '01123456789', 'hotels@nyc.com');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int(11) NOT NULL,
  `staff_first_name` varchar(20) DEFAULT NULL,
  `staff_last_name` varchar(20) DEFAULT NULL,
  `staff_position` varchar(20) DEFAULT NULL,
  `staff_phone` varchar(12) DEFAULT NULL,
  `staff_email` varchar(20) DEFAULT NULL,
  `staff_salary` int(11) DEFAULT NULL,
  `staff_start_date` date DEFAULT NULL,
  `staff_national_insurance` varchar(10) DEFAULT NULL,
  `staff_gender` varchar(6) DEFAULT NULL,
  `branch_branch_id` int(11) NOT NULL,
  `address_address_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `staff_first_name`, `staff_last_name`, `staff_position`, `staff_phone`, `staff_email`, `staff_salary`, `staff_start_date`, `staff_national_insurance`, `staff_gender`, `branch_branch_id`, `address_address_id`) VALUES
(1, 'Olivia', 'Smith', 'Staff', '07122345678', 'veryreal@email.com', 23000, '2017-05-11', 'QQ123456C', 'Female', 1, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`address_id`);

--
-- Indexes for table `attractions`
--
ALTER TABLE `attractions`
  ADD PRIMARY KEY (`attract_id`);

--
-- Indexes for table `availability`
--
ALTER TABLE `availability`
  ADD PRIMARY KEY (`avail_id`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`booking_id`);

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`branch_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`equip_id`);

--
-- Indexes for table `marketing`
--
ALTER TABLE `marketing`
  ADD PRIMARY KEY (`pr_id`);

--
-- Indexes for table `package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`pkg_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`pay_id`);

--
-- Indexes for table `payment_plans`
--
ALTER TABLE `payment_plans`
  ADD PRIMARY KEY (`pp_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `service_booking`
--
ALTER TABLE `service_booking`
  ADD PRIMARY KEY (`service_booking_id`);

--
-- Indexes for table `service_provider`
--
ALTER TABLE `service_provider`
  ADD PRIMARY KEY (`provider_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
