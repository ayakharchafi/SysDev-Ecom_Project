-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2025 at 01:00 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE terndatabase;
USE terndatabase;

-- --------------------------------------------------------

--
-- Table structure for table `bg_gl_insurance_schedule`
--

CREATE TABLE `bg_gl_insurance_schedule` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `property_city_code` varchar(3) NOT NULL,
  `property_code` varchar(8) NOT NULL,
  `property_building` varchar(50) NOT NULL,
  `property_address_full` varchar(120) NOT NULL,
  `property_address_apartment` varchar(10) DEFAULT NULL,
  `premium` DECIMAL(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bg_ternkey_report_schedule`
--

CREATE TABLE `bg_ternkey_report_schedule` (
  `booking_version_code` varchar(12) NOT NULL,
  `insurance_start_date` date NOT NULL,
  `insurance_end_date` date NOT NULL,
  `source` varchar(50) NULL,
  `property_code` varchar(8) NOT NULL,
  `full_address` varchar(120) NOT NULL,
  `unit_number` varchar(10) DEFAULT NULL,
  `city` varchar(3) NOT NULL,
  `premium` DECIMAL(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bg_ternkey_tll_deals`
--

CREATE TABLE `bg_ternkey_tll_deals` (
  `booking_version_code` varchar(12) NOT NULL,
  `booking_code` varchar(9) NOT NULL,
  `form_created_date` date NOT NULL,
  `contract_sign_date` date NOT NULL,
  `city_code` varchar(3) NOT NULL,
  `property_code` varchar(8) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bg_ternkey_tll_insurance_data`
--

CREATE TABLE `bg_ternkey_tll_insurance_data` (
  `booking_version_code` varchar(12) NOT NULL,
  `booking_code` varchar(9) NOT NULL,
  `city_code` varchar(3) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `client_insurance` DECIMAL(10,2) NOT NULL,
  `contract_sign_date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bg_tll_property_facts`
--

CREATE TABLE `bg_tll_property_facts` (
  `property_code` varchar(8) NOT NULL,
  `address_full` varchar(120) NOT NULL,
  `address_apt` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `client_id` varchar(5) NOT NULL,
  `client_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `external_users`
--

CREATE TABLE `external_users` (
  `user_id` INT NOT NULL,
  `client_id` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `internal_users`
--

CREATE TABLE `internal_users` (
  `user_id` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mk_occupancy_reports`
--

CREATE TABLE `mk_occupancy_reports` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `location_id` varchar(5) NOT NULL,
  `first_date_of_coverage` varchar(50) NOT NULL,
  `last_date_of_coverage` varchar(50) NOT NULL,
  `location_address` varchar(120) DEFAULT NULL,
  `location_postal_code` varchar(7) DEFAULT NULL,
  `location_city` varchar(50) NOT NULL,
  `location_province` varchar(50) NOT NULL,
  `number_of_bedrooms` int NOT NULL,
  `number_of_days_occupied` int NOT NULL,
  `currency` varchar(3) NOT NULL,
  `premium_collected` DECIMAL(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `os_occupancy_reports`
--

CREATE TABLE `os_occupancy_reports` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `guest_arrival_date` date NOT NULL,
  `guest_depart_date` date NOT NULL,
  `guest_name` varchar(50) DEFAULT NULL,
  `client_name` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `unit_address` varchar(120) NOT NULL,
  `apt_start_date` date NOT NULL,
  `original_apt_end_date` date NOT NULL,
  `final_apt_end_date` date NOT NULL,
  `domestic_or_international` varchar(50) NOT NULL,
  `days_occupied` int NOT NULL,
  `sheltern_oasis_coverage` DECIMAL(10,2) DEFAULT NULL,
  `ternkey_tenant_coverage` DECIMAL(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `policy_data`
--

CREATE TABLE `policy_data` (
  `policy_number` varchar(14) NOT NULL,
  `client_id` varchar(5) NOT NULL,
  `product_type` varchar(50) NOT NULL,
  `product_subtype` varchar(50),
  `policy_start_date` date NOT NULL,
  `binding_authority` varchar(8) NOT NULL,
  `premium_rate` DECIMAL(10,2) NOT NULL,
  `premium_basis` varchar(10) NOT NULL,
  `premium_prorated` tinyint(1) NOT NULL,
  `premium_currency` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `super_user`
--

CREATE TABLE `super_user` (
  `user_id` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `th_gl_reports`
--

CREATE TABLE `th_gl_reports` (
  `contract_file_name` varchar(12) NOT NULL,
  `contract_creation_date` date NOT NULL,
  `contract_start_date` date NOT NULL,
  `contract_end_date` date NOT NULL,
  `property_id` varchar(50) NOT NULL,
  `property_management_id` varchar(50) NOT NULL,
  `property_name` varchar(50) NOT NULL,
  `unit_address` varchar(50) NOT NULL,
  `unit_number` varchar(10) DEFAULT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(2) NOT NULL,
  `zip` varchar(5) NOT NULL,
  `subtotal_per_unit` DECIMAL(10,2) NOT NULL,
  `tax` DECIMAL(10,2) NOT NULL,
  `total` DECIMAL(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `th_tll_reports`
--

CREATE TABLE `th_tll_reports` (
  `contract_file_name` varchar(50) NOT NULL,
  `contract_start_date` date NOT NULL,
  `contract_end_date` date NOT NULL,
  `monthly_billing_start_date` date NOT NULL,
  `bill_end_date` date NOT NULL,
  `month_end` date NOT NULL,
  `property_id` varchar(50) NOT NULL,
  `property_name` varchar(50) NOT NULL,
  `unit_address` varchar(50) NOT NULL,
  `unit_number` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(2) NOT NULL,
  `zip` varchar(5) NOT NULL,
  `number_of_bill_days` int NOT NULL,
  `cost` DECIMAL(10,2) NOT NULL,
  `tax` DECIMAL(10,2) NOT NULL,
  `total` DECIMAL(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_email` varchar(50) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `password` varchar(120) NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `enabled2FA` TINYINT(1) DEFAULT 0,
  `secret` varchar(120) DEFAULT NULL,
  `expiresAt` DATETIME DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bg_gl_insurance_schedule`
--
ALTER TABLE `bg_gl_insurance_schedule`
  ADD KEY `bg_gl_insurance_schedule_property_code_FK` (`property_code`);

--
-- Indexes for table `bg_ternkey_report_schedule`
--
ALTER TABLE `bg_ternkey_report_schedule`
  ADD PRIMARY KEY (`booking_version_code`),
  ADD KEY `bg_ternkey_report_schedule_property_code_FK` (`property_code`);

--
-- Indexes for table `bg_ternkey_tll_deals`
--
ALTER TABLE `bg_ternkey_tll_deals`
  ADD PRIMARY KEY (`booking_version_code`),
  ADD KEY `booking_code_version_key` (`booking_version_code`),
  ADD KEY `bg_ternkey_tll_deals_property_code_FK` (`property_code`);

--
-- Indexes for table `bg_ternkey_tll_insurance_data`
--
ALTER TABLE `bg_ternkey_tll_insurance_data`
  ADD UNIQUE KEY `booking_version_code` (`booking_version_code`),
  ADD PRIMARY KEY (`booking_version_code`);

--
-- Indexes for table `bg_tll_property_facts`
--
ALTER TABLE `bg_tll_property_facts`
  ADD PRIMARY KEY (`property_code`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`client_id`),
  ADD UNIQUE KEY `Name` (`client_name`);

--
-- Indexes for table `external_users`
--
ALTER TABLE `external_users`
  ADD KEY ` external_users_user_id_FK` (`user_id`),
  ADD KEY ` external_users_client_id_FK` (`client_id`);

--
-- Indexes for table `internal_users`
--
ALTER TABLE `internal_users`
  ADD KEY `internal_users_user_id_FK` (`user_id`);

--
-- Indexes for table `policy_data`
--
ALTER TABLE `policy_data`
  ADD PRIMARY KEY (`client_id`, `product_type`, `premium_currency`),
  ADD KEY `client_clienData_key` (`client_id`);

--
-- Indexes for table `super_user`
--
ALTER TABLE `super_user`
  ADD KEY `super_user_user_id_FK` (`user_id`);

--
-- Indexes for table `th_gl_reports`
--
ALTER TABLE `th_gl_reports`
  ADD PRIMARY KEY (`contract_file_name`);

--
-- Indexes for table `th_tll_reports`
--
ALTER TABLE `th_tll_reports`
  ADD PRIMARY KEY (`contract_file_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bg_gl_insurance_schedule`
--
ALTER TABLE `bg_gl_insurance_schedule`
  ADD CONSTRAINT `bg_gl_insurance_schedule_property_code_FK` FOREIGN KEY (`property_code`) REFERENCES `bg_tll_property_facts` (`property_code`);

--
-- Constraints for table `bg_ternkey_report_schedule`
--
ALTER TABLE `bg_ternkey_report_schedule`
  ADD CONSTRAINT `bg_ternkey_report_schedule_property_code_FK` FOREIGN KEY (`property_code`) REFERENCES `bg_tll_property_facts` (`property_code`);

--
-- Constraints for table `bg_ternkey_tll_deals`
--
ALTER TABLE `bg_ternkey_tll_deals`
  ADD CONSTRAINT `bg_ternkey_tll_deals_booking_code_version_key` FOREIGN KEY (`booking_version_code`) REFERENCES `bg_ternkey_tll_insurance_data` (`booking_version_code`),
  ADD CONSTRAINT `bg_ternkey_tll_deals_property_code_FK` FOREIGN KEY (`property_code`) REFERENCES `bg_tll_property_facts` (`property_code`);

--
-- Constraints for table `external_users`
--
ALTER TABLE `external_users`
  ADD CONSTRAINT ` external_users_client_id_FK` FOREIGN KEY (`client_id`) REFERENCES `client` (`client_id`),
  ADD CONSTRAINT ` external_users_user_id_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `internal_users`
--
ALTER TABLE `internal_users`
  ADD CONSTRAINT `internal_users_user_id_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `policy_data`
--
ALTER TABLE `policy_data`
  ADD CONSTRAINT `client_clienData_key` FOREIGN KEY (`client_id`) REFERENCES `client` (`client_id`);

--
-- Constraints for table `super_user`
--
ALTER TABLE `super_user`
  ADD CONSTRAINT `super_user_user_id_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

--
-- Insert data into tables
--

INSERT INTO client (client_id, client_name) VALUES
('OS', 'OS'),
('BG', 'BG'),
('MK', 'MK'),
('TH', 'TH');

INSERT INTO policy_data (
    client_id, policy_number, product_type, policy_start_date, 
    binding_authority, premium_prorated, premium_rate, 
    premium_basis, premium_currency
) VALUES
('OS', 'ST2301US000004', 'SHELTERN', '2023-01-01', 'NAGN2023', 1, 3.0, 'Monthly', 'USD'),
('OS', 'TK2301US000004', 'TERNKEY', '2023-01-01', 'NAGN2023', 0, 0.8, 'Nightly', 'USD'),
('BG', 'ST2301US000004', 'SHELTERN', '2023-03-03', 'NAGN2023', 0, 3.15, 'Monthly', 'USD'),
('BG', 'TK2301US000005', 'TERNKEY', '2023-03-03', 'NAGN2023', 1, 8.13, 'Monthly', 'USD'),
('MK', 'TK2401CA000006', 'TERNKEY', '2024-07-01', 'NAGN2024', 0, 1.75, 'Nightly', 'CAN'),
('MK', 'TK2401CA000006', 'TERNKEY', '2024-07-01', 'NAGN2024', 0, 1.75, 'Nightly', 'USD'),
('TH', 'TK2301US000005', 'TERNKEY', '2023-03-03', 'NAGN2023', 1, 8.13, 'Monthly', 'USD'),
('TH', 'ST2301US000004', 'SHELTERN', '2023-03-03', 'NAGN2023', 0, 3.15, 'Nightly', 'USD');

UPDATE policy_data
SET product_subtype = 'Canada'
WHERE client_id = 'MK' AND product_type = 'TERNKEY' AND premium_currency = 'CAN';

UPDATE policy_data
SET product_subtype = 'US'
WHERE client_id = 'MK' AND product_type = 'TERNKEY' AND premium_currency = 'USD';

INSERT INTO users (
  user_email, user_name, password, status, enabled2FA
) VALUES
('ian@terngrp.com', 'Ian', '$2y$10$qDHUntbZtrOP5R5Q4GsEqOsbMFSFDAl4Mr8/HBCc94JMiLiTm8m1S', 'TERN', 0), -- password: user1
('cathy@terngrp.com', 'Cathy', '$2y$10$qDHUntbZtrOP5R5Q4GsEqOsbMFSFDAl4Mr8/HBCc94JMiLiTm8m1S', 'TERN', 0), -- password: user1
('melanie.l.swain@gmail.com', 'Melanie', '$2y$10$qDHUntbZtrOP5R5Q4GsEqOsbMFSFDAl4Mr8/HBCc94JMiLiTm8m1S', 'TERN', 1), -- password: user1
('lalinglabrador@gmail.com', 'Ishilia', '$2y$10$qDHUntbZtrOP5R5Q4GsEqOsbMFSFDAl4Mr8/HBCc94JMiLiTm8m1S', 'TERN', 0); -- password: user1

INSERT INTO internal_users (user_id) VALUES (2);
INSERT INTO super_user (user_id) VALUES (1);
INSERT INTO external_users (user_id, client_id) VALUES (3, 'OS');

INSERT INTO bg_tll_property_facts (
  property_code, address_full, address_apt
) VALUES
('SFO-331', '900 Folsom St, San Francisco, CA 94107, USA', '450'),
('ATX-210', '710 3rd St, Austin, TX 78701, USA', '357'),
('NYC-875', '309 5th Ave, New York, NY 10016, USA', '15C'),
('LAX-900', '1620 S Bentley Ave, Los Angeles, CA 90025, USA', 'PH1'),
('LAX-1180', '9417 Charleville Boulevard, Beverly Hills, CA 90212, USA', '1'),
('WDC-658', '2221 I St NW, Washington, DC 20037, USA', '435');

INSERT INTO bg_gl_insurance_schedule (
  property_city_code, property_code, property_building,
  property_address_full, property_address_apartment, premium
) VALUES
('SFO', 'SFO-331', 'Mosso 900', '900 Folsom St, San Francisco, CA 94107, USA', '450', 3.50),
('ATX', 'ATX-210', '3Waller', '710 3rd St, Austin, TX 78701, USA', '357', 3.50),
('NYC', 'NYC-875', 'The Dylan', '309 5th Ave, New York, NY 10016, USA', '15C', 3.50),
('LAX', 'LAX-900', '1620 S. Bentley Ave', '1620 S Bentley Ave, Los Angeles, CA 90025, USA', 'PH1', 3.50),
('LAX', 'LAX-1180', '9417 Charleville Blvd', '9417 Charleville Boulevard, Beverly Hills, CA 90212, USA', '1', 3.50),
('WDC', 'WDC-658', 'Residences on the Avenue', '2221 I St NW, Washington, DC 20037, USA', '435', 3.50);

INSERT INTO bg_ternkey_tll_insurance_data (
  booking_version_code, booking_code, city_code, start_date,
  end_date, client_insurance, contract_sign_date
) VALUES
('SFO-16384-1', 'SFO-16384', 'SFO', '2024-01-25', '2024-02-24', 9.15, 'Tuesday, January 16, 2024'),
('ATX-1637-1', 'ATX-1637', 'ATX', '2023-11-05', '2024-03-02', 9.15, 'Sunday, October 15, 2023'),
('WDC-6605-3', 'WDC-6605', 'WDC', '2024-01-31', '2024-02-29', 9.15, 'Thursday, January 18, 2024'),
('NYC-16109-1', 'NYC-16109', 'NYC', '2024-02-07', '2024-03-08', 9.15, 'Thursday, February 1, 2024'),
('LAX-14875-1', 'LAX-14875', 'LAX', '2024-01-25', '2024-03-27', 9.15, 'Thursday, January 25, 2024'),
('NYC-15373-1', 'NYC-15373', 'NYC', '2023-12-19', '2024-01-31', 9.15, 'Friday, December 15, 2023'),
('LAX-14821-1', 'LAX-14821', 'LAX', '2024-01-22', '2024-02-22', 9.15, 'Friday, January 19, 2024');

INSERT INTO bg_ternkey_report_schedule (
  booking_version_code, insurance_start_date, insurance_end_date, property_code,
  full_address, unit_number, city, premium
) VALUES
('SFO-16384-1', '2024-01-25', '2025-02-24', 'SFO-331', '900 Folsom St, San Francisco, CA 94107, USA', '450', 'SFO', 2.11),
('ATX-1637-1', '2023-11-05', '2024-03-02', 'ATX-210', '710 3rd St, Austin, TX 78701, USA', '357', 'ATX', 9.32),
('NYC-16109-1', '2024-02-03', '2024-03-08', 'NYC-875', '309 5th Ave, New York, NY 10016, USA', '15C', 'NYC', 0.00),
('LAX-14875-1', '2024-01-25', '2024-03-27', 'LAX-900', '1620 S Bentley Ave, Los Angeles, CA 90025, USA', 'PH1', 'LAX', 2.11),
('LAX-14821-1', '2024-01-22', '2024-02-22', 'LAX-1180', '9417 Charleville Boulevard, Beverly Hills, CA 90212, USA', '1', 'LAX', 3.01),
('WDC-6605-3', '2024-01-31', '2024-02-29', 'WDC-658', '2221 I St NW, Washington, DC 20037, USA', '435', 'WDC', 0.30),
('NYC-15373-1', '2023-12-19', '2024-01-31', 'NYC-875', '309 5th Ave, New York, NY 10016, USA', '15C', 'NYC', 9.32);

INSERT INTO bg_ternkey_tll_deals (
  booking_version_code, booking_code, form_created_date,
  contract_sign_date, city_code, property_code,
  start_date, end_date
) VALUES
('SFO-16384-1', 'SFO-16384', '2024-01-12', '2025-01-16', 'SFO', 'SFO-331', '2024-01-25', '2024-02-24'),
('ATX-1637-1', 'ATX-1637', '2023-10-10', '2023-10-15', 'ATX', 'ATX-210', '2023-11-05', '2024-03-03'),
('NYC-16109-1', 'NYC-16109', '2024-01-29', '2024-02-01', 'NYC', 'NYC-875', '2024-02-07', '2024-03-08'),
('LAX-14875-1', 'LAX-14875', '2024-01-25', '2024-01-25', 'LAX', 'LAX-900', '2024-01-25', '2024-03-27'),
('LAX-14821-1', 'LAX-14821', '2024-01-19', '2024-01-19', 'LAX', 'LAX-1180', '2024-01-22', '2024-02-22'),
('WDC-6605-3', 'WDC-6605', '2025-01-19', '2024-01-18', 'WDC', 'WDC-658', '2025-01-31', '2024-02-29'),
('NYC-15373-1', 'NYC-15373', '2023-12-13', '2023-12-14', 'NYC', 'NYC-875', '2023-12-19', '2024-01-31');

INSERT INTO th_gl_reports (
  contract_file_name, contract_creation_date, contract_start_date, contract_end_date, 
  property_id, property_management_id, property_name, unit_address, unit_number, city, 
  state, zip, subtotal_per_unit, tax, total
) VALUES
('PA250315 E-1', '2023-09-08', '2023-10-17', '2024-01-16', 'Shari Niemann', 'Private Individual', 'Shari Niemann', '1 Buford Ave', '', 'Gettysburg', 'PA', '17325', 3.50, 0.13, 3.63),
('GA243987 E-3', '2023-09-22', '2023-11-01', '2024-01-02', 'Residences at St George', 'Napali Residential', 'Residences at St George', '1 Saint George Blvd.', '602', 'Savannah', 'GA', '31419', 3.50, 0.13, 3.63),
('ME254047', '2023-11-14', '2023-11-22', '2024-02-13', 'Tom Miller', 'Private Individual', 'Tom Miller', '10 Weston St', '10', 'Skowhegan', 'ME', '4976', 3.50, 0.13, 3.63),
('VA249439 E-1', '2023-09-07', '2023-10-14', '2024-01-15', 'Elme Alexandria', 'Greystar Corporate Office', 'Elme Alexandria', '100 Century Drive', '7408', 'Alexandria', 'VA', '22304', 3.50, 0.13, 3.63),
('GA242798 E-1', '2023-09-29', '2023-11-19', '2024-09-30', 'The Station at Savannah Quarters', 'Allegient-Carter', 'The Station at Savannah Quarters', '100 Harley Lane', '1319', 'Pooler', 'GA', '31322', 3.50, 0.13, 3.63);

INSERT INTO th_tll_reports (
  contract_file_name, contract_start_date, contract_end_date, monthly_billing_start_date,
  bill_end_date, month_end, property_id, property_name, unit_address, unit_number,
  city, state, zip, number_of_bill_days, cost, tax, total
) VALUES
('AR95188 E-3', '2023-09-02', '2024-01-01', '2024-01-01', '2024-01-01', '2024-02-01', 'Block Real Estate Services', 'The Woods At Johnson Mill', '3936 Abby Lane', '201', 'Springdale', 'AR', '72762', 1, 0.30, 0.01, 0.31),
('WA253229', '2023-10-12', '2024-01-01', '2024-01-01', '2024-01-01', '2024-02-01', 'Carino and Associates', 'The Henry Apartments', '1933 Dock Street', '621', 'Tacoma', 'WA', '98405', 1, 0.30, 0.01, 0.31),
('WA252213 E-2', '2023-12-01', '2024-01-01', '2024-01-01', '2024-01-01', '2024-02-01', 'Corporate Housing Company', 'Lincoln Square Apartments', '618 S 23rd St', '618', 'Tacoma', 'WA', '98405', 1, 0.30, 0.01, 0.31),
('IN252270', '2023-10-01', '2024-01-01', '2024-01-01', '2024-01-01', '2024-02-01', 'Corporate Housing Company', 'Canal Flats', '5705 Peregrine Place', '201', 'Fort Wayne', 'IN', '46804', 1, 0.30, 0.01, 0.31),
('IN252792', '2023-10-01', '2024-01-01', '2024-01-01', '2024-01-01', '2024-02-01', 'Corporate Housing Company', 'Wilt Street Wonder', '1210 Wilt St', '1210', 'Fort Wayne', 'IN', '46802', 1, 0.30, 0.01, 0.31);

INSERT INTO mk_occupancy_reports (
  location_id, first_date_of_coverage, last_date_of_coverage, location_address, 
  location_postal_code, location_city, location_province, number_of_bedrooms,
  number_of_days_occupied, currency, premium_collected
) VALUES
('11997', '2024-01-01', '2024-01-31', '1019 175 Street Southwest', 'T6W 1Z7', 'Edmonton', 'Alberta', 1, 31, 'CAD', 34.41),
('13188', '2024-01-01', '2024-01-31', '6865 Rockford Place', 'V4E 2S5', 'Delta', 'British Columbia', 1, 31, 'CAD', 34.41),
('46763', '2024-01-01', '2024-01-31', '439 Avenue Thérèse-Lavoie-Roux', 'H2V 0B1', 'Montreal', 'Quebec', 1, 31, 'CAD', 34.41),
('22499', '2024-01-01', '2024-01-31', '87 Mondeo Drive', 'M1P 5B6', 'Scarborough', 'Ontario', 1, 31, 'CAD', 34.41),
('14796', '2024-01-01', '2024-01-31', '1207 Cy Williams Boulevard', '28360', 'Lumberton', 'North Carolina', 1, 31, 'USD', 34.41);

INSERT INTO os_occupancy_reports (
  guest_arrival_date, guest_depart_date, guest_name, client_name,
  unit_address, apt_start_date, original_apt_end_date, final_apt_end_date,
  domestic_or_international, days_occupied, ternkey_tenant_coverage
) VALUES
('2024-01-01', '2024-03-01', 'Adrien Aletti', 'Sirva', '28106 Cherry Blossom Ct Lawrence Township, NJ 08648 (#668615)', '2024-01-01', '2024-03-01', '2024-03-01', 'Domestic', 29, 3.00),
('2023-11-01', '2024-02-09', 'Aaron Borgman', 'NUCOMPASS VIA RELOQUEST', '100 Magnolia St. #5214  Jacksonville, FL 32204', '2023-11-01', '2023-12-31', '2024-02-09', 'Domestic', 9, 0.93),
('2024-01-31', '2024-02-29', 'Abby Powell', 'Tommy Bahama', '7255 W Sunset Rd #2092 Las Vegas, NV 89113', '2024-01-31', '2024-03-01', '2024-03-01', 'Domestic', 29, 3.00),
('2024-01-02', '2024-02-05', 'Abdallah A. Abdelrahman', 'BGRS', 'Budapest, Nagy Diófa u. 14, 1072 Hungary', '2024-01-02', '2024-03-01', '2024-02-05', 'International', 5, 0.53),
('2024-01-31', '2024-03-30', 'Abdullah-Safiy Exami', 'Cartus GOUS', 'Voltastrasse 123, 4056 Basel, Switzerland', '2024-01-31', '2024-03-30', '2024-03-30', 'International', 29, 3.00);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
