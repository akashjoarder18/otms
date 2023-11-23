-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 23, 2023 at 10:49 AM
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
-- Database: `otms_ict`
--

-- --------------------------------------------------------

--
-- Table structure for table `tms_inspections`
--

CREATE TABLE `tms_inspections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `batch_id` bigint(20) UNSIGNED NOT NULL,
  `class_no` tinyint(4) NOT NULL,
  `lab_size` tinyint(4) NOT NULL,
  `electricity` tinyint(4) NOT NULL,
  `internet` tinyint(4) NOT NULL,
  `lab_bill` tinyint(4) NOT NULL,
  `lab_attendance` tinyint(4) NOT NULL,
  `computer` tinyint(4) NOT NULL,
  `router` tinyint(4) NOT NULL,
  `projector` tinyint(4) NOT NULL,
  `student_laptop` tinyint(4) NOT NULL,
  `lab_security` tinyint(4) NOT NULL,
  `lab_register` tinyint(4) NOT NULL,
  `class_regularity` tinyint(4) NOT NULL,
  `trainer_attituted` tinyint(4) NOT NULL,
  `trainer_tab_attendance` tinyint(4) NOT NULL,
  `upazila_audit` tinyint(4) NOT NULL,
  `upazila_monitoring` tinyint(4) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `asset_list` varchar(300) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tms_inspections`
--
ALTER TABLE `tms_inspections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tms_inspections_created_by_index` (`created_by`),
  ADD KEY `tms_inspections_updated_by_index` (`updated_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tms_inspections`
--
ALTER TABLE `tms_inspections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
