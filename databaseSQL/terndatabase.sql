-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2025 at 02:11 PM
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
-- Database: `terndatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `bg_ternkey_report_schedule`
--
CREATE DATABASE IF NOT EXISTS `TernDatabase` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `TernDatabase`;

CREATE TABLE `bg_ternkey_report_schedule` (
  `id` varchar(50) NOT NULL,
  `insurance_start_date` date NOT NULL,
  `insurance_end_date` date NOT NULL,
  `booking_version_code` varchar(50) NOT NULL,
  `source` varchar(50) NOT NULL,
  `property_id` varchar(50) NOT NULL,
  `full_address` varchar(50) NOT NULL,
  `unit_number` varchar(50) DEFAULT NULL,
  `city` varchar(50) NOT NULL,
  `nov_24` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bg_ternkey_tll_deals`
--

CREATE TABLE `bg_ternkey_tll_deals` (
  `booking_code` varchar(50) DEFAULT NULL,
  `form_created_date` date NOT NULL,
  `contract_sign_date` date NOT NULL,
  `booking_version_code` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bg_ternkey_tll_insurance_data`
--

CREATE TABLE `bg_ternkey_tll_insurance_data` (
  `id` varchar(50) NOT NULL,
  `city_code` varchar(50) NOT NULL,
  `booking_code` varchar(50) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `client_insurance` double NOT NULL,
  `booking_version_code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bg_tl_reports`
--

CREATE TABLE `bg_tl_reports` (
  `id` varchar(50) NOT NULL,
  `property_city` varchar(50) NOT NULL,
  `property_code` varchar(50) NOT NULL,
  `property_building` varchar(50) NOT NULL,
  `property_address_full` varchar(50) NOT NULL,
  `property_address_apartement` varchar(50) DEFAULT NULL,
  `nov_24` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `ClientID` varchar(50) NOT NULL,
  `Name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client_data`
--

CREATE TABLE `client_data` (
  `client_id` varchar(50) NOT NULL,
  `product_type` varchar(50) NOT NULL,
  `product_subtype` varchar(50) NOT NULL,
  `policy_number` varchar(50) NOT NULL,
  `policy_start_date` date NOT NULL,
  `binding_auth` varchar(50) NOT NULL,
  `premium_rate` double NOT NULL,
  `basis` varchar(50) NOT NULL,
  `prorated` tinyint(1) NOT NULL,
  `currency` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mk_occupancy_reports`
--

CREATE TABLE `mk_occupancy_reports` (
  `location_id` varchar(50) NOT NULL,
  `first_date_of_coverage` date NOT NULL,
  `last_date_of_coverage` date NOT NULL,
  `location_address` varchar(50) NOT NULL,
  `location_postal_code` varchar(50) NOT NULL,
  `location_city` varchar(50) NOT NULL,
  `location_province` varchar(50) NOT NULL,
  `number_of_bedrooms` int(11) NOT NULL,
  `number_of_days_occupied` int(11) NOT NULL,
  `currency` varchar(50) NOT NULL,
  `premium_collected` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `os_occupancy_report`
--

CREATE TABLE `os_occupancy_report` (
  `id` varchar(50) NOT NULL,
  `guest_arrival_date` date NOT NULL,
  `guest_depart_date` date NOT NULL,
  `guest_name` varchar(50) NOT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `unit_address` varchar(50) NOT NULL,
  `apt_start_date` date NOT NULL,
  `original_apt_start_date` date NOT NULL,
  `final_apt_start_date` date NOT NULL,
  `domestic_or_international` varchar(50) NOT NULL,
  `metis_id_number` int(11) DEFAULT NULL,
  `days_occupied` int(11) NOT NULL,
  `shletern_oasis_coverage` double DEFAULT NULL,
  `ternkey_tenant_coverage` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `th_gl_report`
--

CREATE TABLE `th_gl_report` (
  `contract_file_name` varchar(50) NOT NULL,
  `contract_start_date` date NOT NULL,
  `contract_end_date` date NOT NULL,
  `monthly_billing_start_date` date NOT NULL,
  `bill_end_date` date NOT NULL,
  `month_end` date NOT NULL,
  `property_name` varchar(50) NOT NULL,
  `unit_address` varchar(50) NOT NULL,
  `unit_number` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `zip` varchar(50) NOT NULL,
  `subtotal_per_unit` double NOT NULL,
  `tax` double NOT NULL,
  `total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `th_tll_report`
--

CREATE TABLE `th_tll_report` (
  `contract_file_name` varchar(50) NOT NULL,
  `contract_start_date` date NOT NULL,
  `contract_end_date` date NOT NULL,
  `monthly_billing_start_date` date NOT NULL,
  `bill_end_date` date NOT NULL,
  `month_end` date NOT NULL,
  `property_name` varchar(50) NOT NULL,
  `unit_address` varchar(50) NOT NULL,
  `unit_number` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `zip` varchar(50) NOT NULL,
  `number_of_bill_days` int(11) NOT NULL,
  `cost` double NOT NULL,
  `tax` double NOT NULL,
  `total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bg_ternkey_report_schedule`
--
ALTER TABLE `bg_ternkey_report_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bg_ternkey_tll_deals`
--
ALTER TABLE `bg_ternkey_tll_deals`
  ADD KEY `booking_code_key` (`booking_code`),
  ADD KEY `booking_code_version_key` (`booking_version_code`);

--
-- Indexes for table `bg_ternkey_tll_insurance_data`
--
ALTER TABLE `bg_ternkey_tll_insurance_data`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `booking_code` (`booking_code`),
  ADD UNIQUE KEY `booking_version_code` (`booking_version_code`);

--
-- Indexes for table `bg_tl_reports`
--
ALTER TABLE `bg_tl_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`ClientID`);

--
-- Indexes for table `client_data`
--
ALTER TABLE `client_data`
  ADD KEY `client_clienData_key` (`client_id`);

--
-- Indexes for table `mk_occupancy_reports`
--
ALTER TABLE `mk_occupancy_reports`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `os_occupancy_report`
--
ALTER TABLE `os_occupancy_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `th_gl_report`
--
ALTER TABLE `th_gl_report`
  ADD PRIMARY KEY (`contract_file_name`);

--
-- Indexes for table `th_tll_report`
--
ALTER TABLE `th_tll_report`
  ADD PRIMARY KEY (`contract_file_name`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bg_ternkey_tll_deals`
--
ALTER TABLE `bg_ternkey_tll_deals`
  ADD CONSTRAINT `booking_code_key` FOREIGN KEY (`booking_code`) REFERENCES `bg_ternkey_tll_insurance_data` (`booking_code`),
  ADD CONSTRAINT `booking_code_version_key` FOREIGN KEY (`booking_version_code`) REFERENCES `bg_ternkey_tll_insurance_data` (`booking_version_code`);

--
-- Constraints for table `client_data`
--
ALTER TABLE `client_data`
  ADD CONSTRAINT `client_clienData_key` FOREIGN KEY (`client_id`) REFERENCES `client` (`ClientID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
