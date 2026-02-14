-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 14, 2026 at 07:03 AM
-- Server version: 8.0.17
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
  `B_Name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'ชื่อหนังสือ',
  `category_id` int(2) NOT NULL COMMENT 'หมวดหมู่',
  `author` varchar(100) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'ผู้แต่ง',
  `publisher` varchar(100) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'สำนักพิมพ์',
  `year` year(4) NOT NULL COMMENT 'ปีที่พิมพ์'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `all_book`
--

INSERT INTO `all_book` (`B_Id`, `B_Name`, `category_id`, `author`, `publisher`, `year`) VALUES
(101, 'ภาษาไทย', 8, 'สมชาย', 'เล่มละหน้า', 0000),
(102, 'ภาษา C พื้นฐาน', 1, 'สมหญิง', 'abc', 0000),
(103, 'คณิตศาสตร์ ป.2', 12, 'สมหมาย', 'กขค', 2000),
(104, 'หลักสูตรการสอน 2580', 24, 'สมศรี', 'php', 0000),
(108, 'ggez', 1, 'Max', 'Max', 1999);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(2) NOT NULL COMMENT 'รหัสหมวดหมู่',
  `category_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'ชื่อหมวดหมู่'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'เทคโนโลยีสารสนเทศ'),
(2, 'การบัญชี'),
(3, 'การตลาด'),
(4, 'บริหารธุรกิจ'),
(5, 'โลจิสติกส์'),
(6, 'การท่องเที่ยวและการบริการ'),
(7, 'ภาษาอังกฤษ'),
(8, 'ภาษาไทย'),
(9, 'นวนิยาย'),
(10, 'วรรณกรรม'),
(11, 'วิทยาศาสตร์'),
(12, 'คณิตศาสตร์'),
(13, 'สังคมศึกษา'),
(14, 'ประวัติศาสตร์'),
(15, 'การออกแบบกราฟิก'),
(16, 'มนุษย์ศาสตร์'),
(17, 'จิตวิทยา'),
(18, 'การศึกษา'),
(19, 'สุขภาพ'),
(20, 'กฎหมายเบื้องต้น'),
(21, 'การเงินส่วนบุคคล'),
(22, 'คู่มือนักศึกษา'),
(23, 'คู่มืออาจารย์'),
(24, 'เอกสารหลักสูตร'),
(25, 'เอกสารกิจกรรม');

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `H_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'วันยืม',
  `S_photo` varchar(100) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'รูปนักเรียนพร้อมหนังสือที่ยืม',
  `B_Name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'ชื่อหนังสือ	',
  `S_Name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'ชื่อนักเรียน',
  `B_Id` int(11) NOT NULL COMMENT 'รหัสหนังสือ',
  `S_Phone` varchar(15) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'เบอร์โทร',
  `Status01` tinyint(1) NOT NULL COMMENT '0=ยังไม่คืน , 1=คืนแล้ว',
  `H_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`S_photo`, `B_Name`, `S_Name`, `B_Id`, `S_Phone`, `Status01`, `H_id`) VALUES
('img_698f4c94378b4.jpg', 'คณิตศาสตร์ ป.2', '2222', 103, '2131312', 1, 53),
('img_698f5228b7e42.jpeg', 'ภาษา C พื้นฐาน', 'Max', 102, '2131312', 0, 54),
('img_698f5291e5e4e.jpg', 'ggez', '111', 108, 'ๅ-ๅ/-ๅ', 1, 55),
('img_698f5228b7e42.jpeg', 'ภาษา C พื้นฐาน', 'Max', 102, '2131312', 1, 56);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `U_Id` int(10) NOT NULL COMMENT 'รหัสประจำตัว',
  `U_Fullname` varchar(100) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'ชื่อ-นามสกุล',
  `U_Email` varchar(50) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'อีเมล',
  `U_Password` varchar(50) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'รหัสผ่าน',
  `U_Phone` varchar(15) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'เบอร์โทร',
  `U_Status` tinyint(1) NOT NULL COMMENT '0=แอดมิน,1=ครู'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`U_Id`, `U_Fullname`, `U_Email`, `U_Password`, `U_Phone`, `U_Status`) VALUES
(2, 'art', 'art@gmail.com', '1234', '0830503992', 1),
(3, 'admin', 'admin@gmail.com', 'admin', 'admin', 0);

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
  MODIFY `B_Id` int(3) NOT NULL AUTO_INCREMENT COMMENT 'รหัสหนังสือ', AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(2) NOT NULL AUTO_INCREMENT COMMENT 'รหัสหมวดหมู่', AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `H_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `U_Id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'รหัสประจำตัว', AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
