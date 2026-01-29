-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2026 at 04:17 AM
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
-- Database: `db_shcoolbooks`
--

-- --------------------------------------------------------

--
-- Table structure for table `all_book`
--

CREATE TABLE `all_book` (
  `B_Id` int(3) NOT NULL COMMENT 'รหัสหนังสือ',
  `B_photo` varchar(100) NOT NULL COMMENT 'รูปหนังสือ',
  `B_Name` varchar(100) NOT NULL COMMENT 'ชื่อหนังสือ',
  `category_id` varchar(2) NOT NULL COMMENT 'หมวดหมู่',
  `author` varchar(100) NOT NULL COMMENT 'ผู้แต่ง',
  `publisher` varchar(100) NOT NULL COMMENT 'สำนักพิมพ์',
  `year` year(4) NOT NULL COMMENT 'ปีที่พิมพ์'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(2) NOT NULL COMMENT 'รหัสหมวดหมู่',
  `category_name` varchar(255) NOT NULL COMMENT 'ชื่อหมวดหมู่'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `H_ts` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'วันยืม',
  `S_photo` varchar(100) NOT NULL COMMENT 'รูปนักเรียนพร้อมหนังสือที่ยืม',
  `S_Name` varchar(100) NOT NULL COMMENT 'ชื่อนักเรียน',
  `B_Id` int(11) NOT NULL COMMENT 'รหัสหนังสือ',
  `S_Phone` varchar(15) NOT NULL COMMENT 'เบอร์โทร',
  `Status01` tinyint(1) NOT NULL COMMENT '0=ยังไม่คืน , 1=คืนแล้ว',
  `H_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`H_ts`, `S_photo`, `S_Name`, `B_Id`, `S_Phone`, `Status01`, `H_id`) VALUES
('2026-01-28 09:26:21', 'IMG_3110.jpg', 'โอด', 123123, '21321312', 0, 10),
('2026-01-28 09:26:21', 'IMG_3110.jpg', 'โอด', 213213, '21321312', 0, 11);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `U_Id` int(10) NOT NULL COMMENT 'รหัสประจำตัว',
  `U_Fullname` varchar(100) NOT NULL COMMENT 'ชื่อ-นามสกุล',
  `U_Email` varchar(50) NOT NULL COMMENT 'อีเมล',
  `U_Password` varchar(50) NOT NULL COMMENT 'รหัสผ่าน',
  `U_Phone` varchar(15) NOT NULL COMMENT 'เบอร์โทร',
  `U_Status` tinyint(1) NOT NULL COMMENT '0=แอดมิน,1=ครู'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`U_Id`, `U_Fullname`, `U_Email`, `U_Password`, `U_Phone`, `U_Status`) VALUES
(1, 'non', 'non@gmail.com', '1234', '0830503991', 0),
(2, 'art', 'art@gmail.com', '1234', '0830503992', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `all_book`
--
ALTER TABLE `all_book`
  ADD PRIMARY KEY (`B_Id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`H_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`U_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `all_book`
--
ALTER TABLE `all_book`
  MODIFY `B_Id` int(3) NOT NULL AUTO_INCREMENT COMMENT 'รหัสหนังสือ';

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(2) NOT NULL AUTO_INCREMENT COMMENT 'รหัสหมวดหมู่';

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `H_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `U_Id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'รหัสประจำตัว', AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
