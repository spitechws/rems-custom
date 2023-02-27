-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 16, 2022 at 12:10 PM
-- Server version: 10.5.15-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u172594077_demoremscore`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `activity_id` bigint(18) NOT NULL,
  `activity` text COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_user`
--

CREATE TABLE `admin_user` (
  `id` bigint(20) NOT NULL,
  `user_id` varchar(50) COLLATE latin1_general_ci NOT NULL COMMENT 'this will be used ad user_name',
  `user_name` varchar(50) COLLATE latin1_general_ci NOT NULL COMMENT 'this will be used ad user_fill_name',
  `user_password` text COLLATE latin1_general_ci NOT NULL,
  `user_category` enum('admin','superadmin','user') COLLATE latin1_general_ci NOT NULL DEFAULT 'admin',
  `user_email_id` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `user_mobile` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `user_photo` text COLLATE latin1_general_ci NOT NULL,
  `user_status` int(1) NOT NULL,
  `user_created_by` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `user_created_by_ip` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `user_created_by_date` date NOT NULL,
  `user_created_by_time` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `user_last_access_date` date NOT NULL,
  `user_last_access_time` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `user_last_access_ip` varchar(25) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `admin_user`
--

INSERT INTO `admin_user` (`id`, `user_id`, `user_name`, `user_password`, `user_category`, `user_email_id`, `user_mobile`, `user_photo`, `user_status`, `user_created_by`, `user_created_by_ip`, `user_created_by_date`, `user_created_by_time`, `user_last_access_date`, `user_last_access_time`, `user_last_access_ip`) VALUES
(1, 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'info@spitech.in', '8269424219', 'user.png', 1, 'admin', '192.168.1.4', '2015-02-07', '04:34:05 PM', '2022-06-19', '11:45:51 PM', '116.72.213.48');

-- --------------------------------------------------------

--
-- Table structure for table `admin_user_action`
--

CREATE TABLE `admin_user_action` (
  `action_id` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `action_name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `action_on` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `action_user_category` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `action_user_name` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `action_user_date` date NOT NULL,
  `action_user_time` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `action_user_ip` varchar(30) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `admin_user_action`
--

INSERT INTO `admin_user_action` (`action_id`, `action_name`, `action_on`, `action_user_category`, `action_user_name`, `action_user_date`, `action_user_time`, `action_user_ip`) VALUES
('202206141801572A43I9PBZNL', 'Login', '', 'admin', 'admin', '2022-06-14', '06:01:57 PM', '116.72.210.184'),
('20220614180745T5CN21KFW6H', 'Log Out', '', 'admin', 'admin', '2022-06-14', '06:07:45 PM', '116.72.210.184'),
('20220614180754FHZ7V9I582P', 'Login', '', 'admin', 'admin', '2022-06-14', '06:07:54 PM', '116.72.210.184'),
('2022061418082909BGLOPJWT5', 'Log Out', '', 'admin', 'admin', '2022-06-14', '06:08:29 PM', '116.72.210.184'),
('202206141822556IPQONLXSA5', 'Login', '', 'admin', 'admin', '2022-06-14', '06:22:55 PM', '182.77.82.19'),
('202206141838505GFW2JBZLIQ', 'Login', '', 'admin', 'admin', '2022-06-14', '06:38:50 PM', '182.77.82.19'),
('20220614185228JSBYAW7XR5U', 'Login', '', 'admin', 'admin', '2022-06-14', '06:52:28 PM', '182.77.82.19'),
('20220616020552PS2LRIKZWXO', 'Login', '', 'admin', 'admin', '2022-06-16', '02:05:52 AM', '2405:204:12ac:74d3:91a2:228a:5'),
('202206161144280Z28QHNTUDR', 'Login', '', 'admin', 'admin', '2022-06-16', '11:44:28 AM', '122.175.164.74'),
('20220616114534BQ15J2IXAWD', 'NEW PROJECT CREATED', 'ID : 1, NAME : SPITECH VILLA', 'admin', 'admin', '2022-06-16', '11:45:34 AM', '122.175.164.74'),
('202206161145599R18S7Y2PIZ', 'NEW PROJECT CREATED', 'ID : 2, NAME : SHYAM CITY', 'admin', 'admin', '2022-06-16', '11:45:59 AM', '122.175.164.74'),
('20220616114642XC8NHWJFBEK', 'PROPERTY ADDED', 'ON PROJECT : 2, NAME : SHYAM CITY, No Of Properties : 5', 'admin', 'admin', '2022-06-16', '11:46:42 AM', '122.175.164.74'),
('20220616115738U1QZ6AC8KWN', 'PROPERTY ADDED', 'ON PROJECT : 1, NAME : SPITECH VILLA, No Of Properties : 5', 'admin', 'admin', '2022-06-16', '11:57:38 AM', '122.175.164.74'),
('20220616115809MZXGT5S4I08', 'Advisor LEVEL CREATED', 'ID : 1, TYPE : COMPANY', 'admin', 'admin', '2022-06-16', '11:58:09 AM', '122.175.164.74'),
('202206161158403STKB6I7CRH', 'Advisor LEVEL CREATED', 'ID : 2, TYPE : LEVEL-1', 'admin', 'admin', '2022-06-16', '11:58:40 AM', '122.175.164.74'),
('202206161159118A2VHD6TQGC', 'Advisor LEVEL CREATED', 'ID : 3, TYPE : LEVEL-2', 'admin', 'admin', '2022-06-16', '11:59:11 AM', '122.175.164.74'),
('20220616115935AJ3GH795486', 'Advisor LEVEL CREATED', 'ID : 4, TYPE : LEVEL-3', 'admin', 'admin', '2022-06-16', '11:59:35 AM', '122.175.164.74'),
('2022061612000080MXYR2V7CA', 'Advisor LEVEL CREATED', 'ID : 5, TYPE : LEVEL-4', 'admin', 'admin', '2022-06-16', '12:00:00 PM', '122.175.164.74'),
('202206161200205GDZUAQRH9P', 'PROPERTY TYPE CREATED', 'ID : 14, TYPE : ROW HOUSE', 'admin', 'admin', '2022-06-16', '12:00:20 PM', '122.175.164.74'),
('20220616120025KGSTAU3J5WP', 'PROPERTY TYPE DELETED', 'ID=14, PROPERTY TYPE : ROW HOUSE', 'admin', 'admin', '2022-06-16', '12:00:25 PM', '122.175.164.74'),
('202206161200370CKVIGRSP9N', 'PROPERTY TYPE WISE RATE SET', '', 'admin', 'admin', '2022-06-16', '12:00:37 PM', '122.175.164.74'),
('20220616120045NE1COR279GB', 'TDS SETTING EDITED', '5%', 'admin', 'admin', '2022-06-16', '12:00:45 PM', '122.175.164.74'),
('20220616120049G3FDBC61S9Q', 'TDS SETTING EDITED', '5%', 'admin', 'admin', '2022-06-16', '12:00:49 PM', '122.175.164.74'),
('20220616120143CM2AJ1ZKBOU', 'NEW Advisor REGISTERED', 'ID : 1, NAME : COMPANY', 'admin', 'admin', '2022-06-16', '12:01:43 PM', '122.175.164.74'),
('20220616120309HB1E2ZXWI5S', 'NEW Advisor REGISTERED', 'ID : 2, NAME : MANISH ANANDANI', 'admin', 'admin', '2022-06-16', '12:03:09 PM', '122.175.164.74'),
('20220616120359UQG0LNW49BV', 'NEW Advisor REGISTERED', 'ID : 3, NAME : RAHUL BAJAJ', 'admin', 'admin', '2022-06-16', '12:03:59 PM', '122.175.164.74'),
('202206161204499KF62THXV0B', 'NEW Advisor REGISTERED', 'ID : 4, NAME : PUNEET', 'admin', 'admin', '2022-06-16', '12:04:49 PM', '122.175.164.74'),
('20220616120540WL7KXFCDGAR', 'NEW Advisor REGISTERED', 'ID : 5, NAME : VINIT', 'admin', 'admin', '2022-06-16', '12:05:40 PM', '122.175.164.74'),
('20220616120625P2W9Q68L15F', 'EXPENSE CATEGORY ADDED', 'NAME : BILL', 'admin', 'admin', '2022-06-16', '12:06:25 PM', '122.175.164.74'),
('20220616120629WA7H1JUDB0Z', 'EXPENSE CATEGORY DELETED', 'NAME : BILL', 'admin', 'admin', '2022-06-16', '12:06:29 PM', '122.175.164.74'),
('20220616120635UOW4TVL9YGE', 'EXPENSE SUB CATEGORY ADDED', 'NEW : CSEB', 'admin', 'admin', '2022-06-16', '12:06:35 PM', '122.175.164.74'),
('20220616120642CV43FBDJK9O', 'EXPENSE SUB CATEGORY ADDED', 'NEW : PHONE', 'admin', 'admin', '2022-06-16', '12:06:42 PM', '122.175.164.74'),
('20220616120724JOPUS1DGZHQ', 'NEW CUSTOMER REGISTERED', 'ID : 1, NAME : RAMESH KUMAR', 'admin', 'admin', '2022-06-16', '12:07:24 PM', '122.175.164.74'),
('202206161208069QXKI0AMJ15', 'NEW CUSTOMER REGISTERED', 'ID : 2, NAME : DEEPAK', 'admin', 'admin', '2022-06-16', '12:08:06 PM', '122.175.164.74'),
('202206161209217I8VNKMZBXJ', 'PROPERTY BOOKED', 'ORDER NO ODR0001, AMOUNT : 100000', 'admin', 'admin', '2022-06-16', '12:09:21 PM', '122.175.164.74'),
('202206161209311Y7NPCBDEGS', 'BOOKING APPROVED', 'ORDER NO : ODR0001', 'admin', 'admin', '2022-06-16', '12:09:31 PM', '122.175.164.74'),
('20220616120934L7XECH39W15', 'BOOKING PAYMENT RECEIVE APPROVED', 'VOUCHER NO : 0001/DP/0001, ORDER NO :', 'admin', 'admin', '2022-06-16', '12:09:34 PM', '122.175.164.74'),
('20220616121024620AQ9LOXBR', 'PROPERTY BOOKED', 'ORDER NO ODR0002, AMOUNT : 150000', 'admin', 'admin', '2022-06-16', '12:10:24 PM', '122.175.164.74'),
('20220616121112MI6RYAXZT0W', 'BOOKING APPROVED', 'ORDER NO : ODR0002', 'admin', 'admin', '2022-06-16', '12:11:12 PM', '122.175.164.74'),
('20220616121114UEWZFRN8SYD', 'BOOKING PAYMENT RECEIVE APPROVED', 'VOUCHER NO : 0002/DP/0002, ORDER NO :', 'admin', 'admin', '2022-06-16', '12:11:14 PM', '122.175.164.74'),
('202206161212209V6830MA24J', 'PAYMENT RECEIVED', 'ORDER NO ODR0001, AMOUNT : 500000', 'admin', 'admin', '2022-06-16', '12:12:20 PM', '122.175.164.74'),
('20220616121227SEIXB8UD4CZ', 'BOOKING PAYMENT RECEIVE APPROVED', 'VOUCHER NO : 0001/INS/0003, ORDER NO :', 'admin', 'admin', '2022-06-16', '12:12:27 PM', '122.175.164.74'),
('20220616121313168S2BIAZWO', 'EXTRA PAYMENT RECEIVED', 'ORDER NO ODR0001, AMOUNT : 10000', 'admin', 'admin', '2022-06-16', '12:13:13 PM', '122.175.164.74'),
('20220616121335X4EW6BGL82O', 'EXTRA PAYMENT RECEIVED', 'ORDER NO ODR0001, AMOUNT : 25000', 'admin', 'admin', '2022-06-16', '12:13:35 PM', '122.175.164.74'),
('2022061612155238RC2TGLAVU', 'Login', '', 'admin', 'admin', '2022-06-16', '12:15:52 PM', '122.175.164.74'),
('202206161216415U1ONVHD69R', 'PAYMENT DOCUMENT UPLOADED', 'DOCS : .', 'admin', 'admin', '2022-06-16', '12:16:41 PM', '122.175.164.74'),
('202206161221503YIDKS6QJN9', 'Associate PAYMENT APPROVED', 'Advisor : MANISH ANANDANI', 'admin', 'admin', '2022-06-16', '12:21:50 PM', '122.175.164.74'),
('20220616122156KTM5G3UAS7I', 'Associate PAYMENT REJECTED', 'Advisor : MANISH ANANDANI', 'admin', 'admin', '2022-06-16', '12:21:56 PM', '122.175.164.74'),
('20220616122330JIBCULQ1FSE', 'CUSTOMER PROFILE EDITED', 'ID : 2, NAME : DEEPAK', 'admin', 'admin', '2022-06-16', '12:23:30 PM', '122.175.164.74'),
('20220616122348QTRBGN1EDJ3', 'EXPENSE ADDED', 'AMOUNT : 1500', 'admin', 'admin', '2022-06-16', '12:23:48 PM', '122.175.164.74'),
('20220616122402PQG2MKDS579', 'EXPENSE ADDED', 'AMOUNT : 2000', 'admin', 'admin', '2022-06-16', '12:24:02 PM', '122.175.164.74'),
('20220616123735WSP026ZQ9GT', 'Login', '', 'admin', 'admin', '2022-06-16', '12:37:35 PM', '122.175.164.74'),
('20220616150306TW0B1IP8A6Y', 'Login', '', 'admin', 'admin', '2022-06-16', '03:03:06 PM', '2409:4043:4d00:33ff:906e:a72f:'),
('202206192339286RCLTV1QYM8', 'Login', '', 'admin', 'admin', '2022-06-19', '11:39:28 PM', '116.72.213.48'),
('202206202250081REP4SVAGX2', 'Login', '', '', '', '2022-06-20', '10:50:08 PM', '116.72.213.48'),
('2022062411510368MW9HS27OC', 'Login', '', 'admin', 'admin', '2022-06-24', '11:51:03 AM', '2405:204:33a0:f621:95c7:3c20:3'),
('20220624115112OWPA4NQUZJS', 'Log Out', '', 'admin', 'admin', '2022-06-24', '11:51:12 AM', '2405:204:33a0:f621:95c7:3c20:3'),
('20220627115150U6BMI7WGO1C', 'Login', '', 'admin', 'admin', '2022-06-27', '11:51:50 AM', '116.72.212.51'),
('20220627115154PLR21AVEK0U', 'Log Out', '', 'admin', 'admin', '2022-06-27', '11:51:54 AM', '116.72.212.51'),
('20220701154823YPCF19I6QVB', 'Login', '', 'admin', 'admin', '2022-07-01', '03:48:23 PM', '116.72.210.184'),
('20220701154848IG7F9XLM6NR', 'Log Out', '', 'admin', 'admin', '2022-07-01', '03:48:48 PM', '116.72.210.184');

-- --------------------------------------------------------

--
-- Table structure for table `advisor`
--

CREATE TABLE `advisor` (
  `advisor_id` bigint(20) NOT NULL,
  `advisor_code` varchar(25) COLLATE latin1_general_ci NOT NULL COMMENT 'ID NO',
  `advisor_password` text COLLATE latin1_general_ci NOT NULL,
  `advisor_sponsor` varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT 'Introducer Or Parent',
  `advisor_level_id` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `advisor_title` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `advisor_name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `advisor_fname` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `advisor_sex` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `advisor_address` text COLLATE latin1_general_ci NOT NULL,
  `advisor_mobile` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `advisor_phone` varchar(12) COLLATE latin1_general_ci NOT NULL,
  `advisor_email` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `advisor_whatsapp_no` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `advisor_marital_status` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `advisor_bg` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `advisor_dob` date NOT NULL,
  `advisor_anniversary_date` date NOT NULL,
  `advisor_hire_date` date NOT NULL,
  `advisor_qualification` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `advisor_occupation` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `advisor_pan_no` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `advisor_photo` text COLLATE latin1_general_ci NOT NULL,
  `advisor_status` int(1) NOT NULL COMMENT 'iF aCTIVE THEN 1 ORHER WISE 0',
  `created_details` text COLLATE latin1_general_ci NOT NULL,
  `edited_details` text COLLATE latin1_general_ci NOT NULL,
  `last_access_details` text COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `advisor`
--

INSERT INTO `advisor` (`advisor_id`, `advisor_code`, `advisor_password`, `advisor_sponsor`, `advisor_level_id`, `advisor_title`, `advisor_name`, `advisor_fname`, `advisor_sex`, `advisor_address`, `advisor_mobile`, `advisor_phone`, `advisor_email`, `advisor_whatsapp_no`, `advisor_marital_status`, `advisor_bg`, `advisor_dob`, `advisor_anniversary_date`, `advisor_hire_date`, `advisor_qualification`, `advisor_occupation`, `advisor_pan_no`, `advisor_photo`, `advisor_status`, `created_details`, `edited_details`, `last_access_details`) VALUES
(1, 'AB001', '193434907637b5a77f67ad5c36e26c3b', '', '1', 'MR.', 'COMPANY', '..', 'MALE', '2', '9827174279', '', 'COMPANY@GMAIL.COM', '', 'Unmarried', '', '1900-01-01', '1900-01-01', '2020-06-16', '123', '123', '123', '', 1, 'admin, admin, 2022-06-16, 12:01:43 PM, 122.175.164.74', 'admin, admin, 2022-06-16, 12:01:43 PM, 122.175.164.74', ''),
(2, 'AB002', '61ace63e90159fbd856f36d7b2a4d6a0', '1', '2', 'MR.', 'MANISH ANANDANI', 'LATE. MR. K.L. ANANDANI', 'MALE', 'bsp', '9770085144', '', 'manish@gmail.com', '', 'Unmarried', '', '1900-01-01', '1900-01-01', '2020-07-16', '123', '123', '123', '', 1, 'admin, admin, 2022-06-16, 12:03:09 PM, 122.175.164.74', 'admin, admin, 2022-06-16, 12:03:09 PM, 122.175.164.74', ''),
(3, 'AB003', 'ec86321ef02cdcf807ec8b4051a2e7f9', '2', '2', 'MR.', 'RAHUL BAJAJ', 'MR. P.N BAJAJ', 'MALE', 'BSP', '9770106455', '', 'rahul@gmail.com', '', 'Unmarried', '', '1900-01-01', '1900-01-01', '2020-08-16', '222', '222', '252', '', 1, 'admin, admin, 2022-06-16, 12:03:59 PM, 122.175.164.74', 'admin, admin, 2022-06-16, 12:03:59 PM, 122.175.164.74', ''),
(4, 'AB004', 'e98636b497ed0e0864910b3897932d78', '2', '5', 'MR.', 'PUNEET', '..', 'MALE', 'BSP', '9770097700', '', 'PUNEET@GMAIL.COM', '', 'Unmarried', '', '1900-01-01', '1900-01-01', '2020-08-19', '22', '22', '22', '', 1, 'admin, admin, 2022-06-16, 12:04:49 PM, 122.175.164.74', 'admin, admin, 2022-06-16, 12:04:49 PM, 122.175.164.74', ''),
(5, 'AB005', '40a618a52209cee2c146f9b4d2b781cd', '1', '4', 'MR.', 'VINIT', '..', 'MALE', 'BSP', '9770106464', '', 'VINIT@GMAIL.COM', '', 'Unmarried', '', '1900-01-01', '1900-01-01', '2020-10-16', '22', '22', '22', '', 1, 'admin, admin, 2022-06-16, 12:05:40 PM, 122.175.164.74', 'admin, admin, 2022-06-16, 12:05:40 PM, 122.175.164.74', '');

-- --------------------------------------------------------

--
-- Table structure for table `advisor_action`
--

CREATE TABLE `advisor_action` (
  `action_id` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `action_name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `action_on` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `action_user_id` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `action_user_date` date NOT NULL,
  `action_user_time` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `action_user_ip` varchar(30) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `advisor_commission`
--

CREATE TABLE `advisor_commission` (
  `commission_id` bigint(20) NOT NULL,
  `commission_order_no` varchar(25) COLLATE latin1_general_ci NOT NULL COMMENT 'Order No From Booking Table',
  `commission_voucher_no` varchar(50) COLLATE latin1_general_ci NOT NULL COMMENT 'Unique No From Booking Or Payment',
  `commission_project_id` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `commission_property_id` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `commission_property_type` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `commission_particular` varchar(25) COLLATE latin1_general_ci NOT NULL COMMENT 'Toke, Down Payment Or Installment',
  `commission_date` date NOT NULL,
  `commission_voucher_date` date NOT NULL,
  `commission_customer_id` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `commission_advisor_id` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `commission_advisor_level_id` varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT 'At The Time Of Booking Level Of Advisor According To which Commission Will Be Distributed',
  `commission_advisor_current_level_id` varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT 'At The Time Of Commission Generation Level Of Getting Advisor',
  `commission_advisor_level_percent` varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT 'Level Percent at The Time Of Booking',
  `commission_advisor_level_diff_percent` varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT 'According Which Commission Will Be Generated',
  `commission_amount` varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT 'Distributed Commission Of Advisor',
  `commission_tds_percent` varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT 'TDS Percent From tbl_setting_tds',
  `commission_tds_amount` varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT 'TDS Amount',
  `commission_nett_amount` varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT 'Commission After TDS Cut Off',
  `commission_voucher_amount` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `commission_by_advisor_id` varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT 'Advisor Who Booked The Property',
  `commission_by` varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT 'Self Or Reference',
  `approved` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `advisor_commission`
--

INSERT INTO `advisor_commission` (`commission_id`, `commission_order_no`, `commission_voucher_no`, `commission_project_id`, `commission_property_id`, `commission_property_type`, `commission_particular`, `commission_date`, `commission_voucher_date`, `commission_customer_id`, `commission_advisor_id`, `commission_advisor_level_id`, `commission_advisor_current_level_id`, `commission_advisor_level_percent`, `commission_advisor_level_diff_percent`, `commission_amount`, `commission_tds_percent`, `commission_tds_amount`, `commission_nett_amount`, `commission_voucher_amount`, `commission_by_advisor_id`, `commission_by`, `approved`) VALUES
(1, 'ODR0001', '0001/DP/0001', '1', '6', '1', 'DOWN PAYMENT', '2020-06-16', '2020-06-16', '2', '2', '2', '2', '10', '10', '10000', '5', '500', '9500', '100000', '2', 'SELF', 1),
(2, 'ODR0001', '0001/DP/0001', '1', '6', '1', 'DOWN PAYMENT', '2020-06-16', '2020-06-16', '2', '1', '1', '1', '100', '90', '90000', '5', '4500', '85500', '100000', '2', 'REF', 1),
(3, 'ODR0002', '0002/DP/0002', '2', '1', '1', 'DOWN PAYMENT', '2021-06-16', '2021-06-16', '1', '4', '5', '5', '4', '4', '6000', '5', '300', '5700', '150000', '4', 'SELF', 1),
(4, 'ODR0002', '0002/DP/0002', '2', '1', '1', 'DOWN PAYMENT', '2021-06-16', '2021-06-16', '1', '2', '2', '2', '10', '6', '9000', '5', '450', '8550', '150000', '4', 'REF', 1),
(5, 'ODR0002', '0002/DP/0002', '2', '1', '1', 'DOWN PAYMENT', '2021-06-16', '2021-06-16', '1', '1', '1', '1', '100', '90', '135000', '5', '6750', '128250', '150000', '4', 'REF', 1),
(6, 'ODR0001', '0001/INS/0003', '1', '6', '1', 'INSTALLMENT', '2020-07-16', '2020-07-16', '2', '2', '2', '2', '10', '10', '50000', '5', '2500', '47500', '500000', '2', 'SELF', 1),
(7, 'ODR0001', '0001/INS/0003', '1', '6', '1', 'INSTALLMENT', '2020-07-16', '2020-07-16', '2', '1', '1', '1', '100', '90', '450000', '5', '22500', '427500', '500000', '2', 'REF', 1);

-- --------------------------------------------------------

--
-- Table structure for table `advisor_docs`
--

CREATE TABLE `advisor_docs` (
  `doc_id` bigint(18) NOT NULL,
  `advisor_id` varchar(18) COLLATE latin1_general_ci NOT NULL,
  `doc_name` text COLLATE latin1_general_ci NOT NULL,
  `doc` text COLLATE latin1_general_ci NOT NULL,
  `created_details` text COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `advisor_dvr`
--

CREATE TABLE `advisor_dvr` (
  `dvr_id` bigint(20) NOT NULL,
  `advisor_id` bigint(20) NOT NULL,
  `project_id` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `property_id` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `customer_name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `mobile_no` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `occupation` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `city` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `address` text COLLATE latin1_general_ci NOT NULL,
  `response1` text COLLATE latin1_general_ci NOT NULL,
  `response2` text COLLATE latin1_general_ci NOT NULL,
  `response3` text COLLATE latin1_general_ci NOT NULL,
  `response4` text COLLATE latin1_general_ci NOT NULL,
  `response5` text COLLATE latin1_general_ci NOT NULL,
  `remarks` text COLLATE latin1_general_ci NOT NULL,
  `status` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `dvr_date` date NOT NULL,
  `remind_date` date NOT NULL,
  `created_details` text COLLATE latin1_general_ci NOT NULL,
  `edited_details` text COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `advisor_payment`
--

CREATE TABLE `advisor_payment` (
  `payment_id` bigint(20) NOT NULL,
  `payment_advisor_id` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `payment_amount` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `payment_date` date NOT NULL,
  `payment_mode` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `payment_mode_no` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `payment_mode_bank` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `payment_mode_date` date NOT NULL,
  `payment_remark` text COLLATE latin1_general_ci NOT NULL,
  `approved` tinyint(1) NOT NULL COMMENT '0 for pending 1 for approved',
  `created_details` text COLLATE latin1_general_ci NOT NULL,
  `edited_details` text COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `advisor_payment`
--

INSERT INTO `advisor_payment` (`payment_id`, `payment_advisor_id`, `payment_amount`, `payment_date`, `payment_mode`, `payment_mode_no`, `payment_mode_bank`, `payment_mode_date`, `payment_remark`, `approved`, `created_details`, `edited_details`) VALUES
(1, '2', '10000', '2020-07-16', 'CASH', '', '', '2022-06-16', '', 1, 'admin, admin, 2022-06-16, 12:18:03 PM, 122.175.164.74', 'admin, admin, 2022-06-16, 12:18:03 PM, 122.175.164.74');

-- --------------------------------------------------------

--
-- Table structure for table `advisor_promotion`
--

CREATE TABLE `advisor_promotion` (
  `promotion_id` bigint(18) NOT NULL,
  `advisor_id` varchar(18) COLLATE latin1_general_ci NOT NULL,
  `prev_level_id` varchar(18) COLLATE latin1_general_ci NOT NULL,
  `promoted_level_id` varchar(18) COLLATE latin1_general_ci NOT NULL,
  `promotion_date` date NOT NULL,
  `promotion_time` time NOT NULL,
  `created_details` text COLLATE latin1_general_ci NOT NULL,
  `edited_details` text COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `award`
--

CREATE TABLE `award` (
  `award_id` bigint(18) NOT NULL,
  `award` text COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `complain`
--

CREATE TABLE `complain` (
  `complain_id` bigint(18) NOT NULL,
  `complain` text COLLATE latin1_general_ci NOT NULL,
  `advisor_id` varchar(18) COLLATE latin1_general_ci NOT NULL,
  `complain_from` varchar(50) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` bigint(20) NOT NULL,
  `customer_code` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `customer_password` text COLLATE latin1_general_ci NOT NULL,
  `customer_title` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `customer_name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `customer_fname` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `customer_mobile` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `customer_phone` varchar(12) COLLATE latin1_general_ci NOT NULL,
  `customer_email` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `customer_whatsapp_no` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `customer_marital_status` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `customer_sex` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `customer_bg` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `customer_dob` date NOT NULL,
  `customer_anniversary_date` date NOT NULL,
  `customer_reg_date` date NOT NULL,
  `customer_pan` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `customer_address` text COLLATE latin1_general_ci NOT NULL,
  `customer_city` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `customer_photo` text COLLATE latin1_general_ci NOT NULL,
  `customer_occupation` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `customer_designation` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `customer_anual_income` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `customer_nominee_name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `customer_nominee_dob` date NOT NULL,
  `customer_relation_with_nominee` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `customer_nominee_mobile` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `customer_nominee_phone` varchar(12) COLLATE latin1_general_ci NOT NULL,
  `customer_nominee_address` text COLLATE latin1_general_ci NOT NULL,
  `customer_status` tinyint(1) NOT NULL,
  `created_details` text COLLATE latin1_general_ci NOT NULL,
  `edited_details` text COLLATE latin1_general_ci NOT NULL,
  `last_access_details` text COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_code`, `customer_password`, `customer_title`, `customer_name`, `customer_fname`, `customer_mobile`, `customer_phone`, `customer_email`, `customer_whatsapp_no`, `customer_marital_status`, `customer_sex`, `customer_bg`, `customer_dob`, `customer_anniversary_date`, `customer_reg_date`, `customer_pan`, `customer_address`, `customer_city`, `customer_photo`, `customer_occupation`, `customer_designation`, `customer_anual_income`, `customer_nominee_name`, `customer_nominee_dob`, `customer_relation_with_nominee`, `customer_nominee_mobile`, `customer_nominee_phone`, `customer_nominee_address`, `customer_status`, `created_details`, `edited_details`, `last_access_details`) VALUES
(1, 'ABC001', '7577ceffa8bcf5a35d399494eb758cdd', 'MR.', 'RAMESH KUMAR', '..', '0000000000', '', 'RAMESH@GMAIL.COM', '', 'Unmarried', 'MALE', '', '1900-01-01', '1900-01-01', '2020-06-16', '2', '2', '2', '', '2', '2', '2', 'RAMESH', '1900-01-01', '..', '00', '00', '00', 1, 'admin, admin, 2022-06-16, 12:07:24 PM, 122.175.164.74', 'admin, admin, 2022-06-16, 12:07:24 PM, 122.175.164.74', ''),
(2, 'ABC002', '796a386d1aac3a86bd845a4b1dd74d2d', 'MR.', 'DEEPAK', '..', '9827174279', '', 'DEEPAK@GMAIL.COM', '', 'Unmarried', 'MALE', '', '1900-01-01', '1900-01-01', '2020-08-16', '..', '..', '..', '', '..', '..', '..', '..', '1900-01-01', '..', '000', '00', '00', 1, 'admin, admin, 2022-06-16, 12:08:06 PM, 122.175.164.74', 'admin, admin, 2022-06-16, 12:23:30 PM, 122.175.164.74', '');

-- --------------------------------------------------------

--
-- Table structure for table `customer_action`
--

CREATE TABLE `customer_action` (
  `action_id` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `action_name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `action_on` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `action_user_id` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `action_user_date` date NOT NULL,
  `action_user_time` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `action_user_ip` varchar(30) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enquiry`
--

CREATE TABLE `enquiry` (
  `enquiry_id` bigint(18) NOT NULL,
  `project_id` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `property_id` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `customer_name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `mobile_no` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `occupation` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `city` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `address` text COLLATE latin1_general_ci NOT NULL,
  `response1` text COLLATE latin1_general_ci NOT NULL,
  `response2` text COLLATE latin1_general_ci NOT NULL,
  `response3` text COLLATE latin1_general_ci NOT NULL,
  `response4` text COLLATE latin1_general_ci NOT NULL,
  `response5` text COLLATE latin1_general_ci NOT NULL,
  `remarks` text COLLATE latin1_general_ci NOT NULL,
  `status` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `enquiry_date` date NOT NULL,
  `remind_date` date NOT NULL,
  `created_details` text COLLATE latin1_general_ci NOT NULL,
  `edited_details` text COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `expense_id` bigint(20) NOT NULL,
  `expense_category_id` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `expense_sub_category_id` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `expense_party` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `expense_credit_debit` varchar(10) COLLATE latin1_general_ci NOT NULL COMMENT 'Credit Or Debit',
  `expense_amount` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `expense_date` date NOT NULL,
  `payment_mode` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `payment_no` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `payment_bank` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `payment_mode_date` date NOT NULL,
  `expense_note` text COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `expense`
--

INSERT INTO `expense` (`expense_id`, `expense_category_id`, `expense_sub_category_id`, `expense_party`, `expense_credit_debit`, `expense_amount`, `expense_date`, `payment_mode`, `payment_no`, `payment_bank`, `payment_mode_date`, `expense_note`) VALUES
(1, '1', '3', 'BILL', 'Debit', '1500', '2020-06-16', 'CASH', '', '', '2022-06-16', ''),
(2, '1', '4', 'BILL', 'Debit', '2000', '2020-06-16', 'CASH', '', '', '2022-06-16', '');

-- --------------------------------------------------------

--
-- Table structure for table `expense_category`
--

CREATE TABLE `expense_category` (
  `category_id` bigint(20) NOT NULL,
  `category_name` varchar(50) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `expense_category`
--

INSERT INTO `expense_category` (`category_id`, `category_name`) VALUES
(1, 'BILL');

-- --------------------------------------------------------

--
-- Table structure for table `expense_sub_category`
--

CREATE TABLE `expense_sub_category` (
  `sub_category_id` bigint(20) NOT NULL,
  `category_id` varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT 'Primary Key Of tbl_expense_category',
  `sub_category_name` varchar(50) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `expense_sub_category`
--

INSERT INTO `expense_sub_category` (`sub_category_id`, `category_id`, `sub_category_name`) VALUES
(3, '1', 'CSEB'),
(4, '1', 'PHONE');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `project_id` bigint(20) NOT NULL,
  `project_name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `project_address` text COLLATE latin1_general_ci NOT NULL,
  `project_photo` text COLLATE latin1_general_ci NOT NULL,
  `project_mouza` text COLLATE latin1_general_ci NOT NULL,
  `project_ph_no` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `extra_charge_1` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `extra_charge_2` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `extra_charge_3` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `extra_charge_4` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `extra_charge_5` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `extra_charge_6` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `extra_charge_amount_1` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `extra_charge_amount_2` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `extra_charge_amount_3` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `extra_charge_amount_4` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `extra_charge_amount_5` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `extra_charge_amount_6` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `created_details` text COLLATE latin1_general_ci NOT NULL,
  `edited_details` text COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`project_id`, `project_name`, `project_address`, `project_photo`, `project_mouza`, `project_ph_no`, `extra_charge_1`, `extra_charge_2`, `extra_charge_3`, `extra_charge_4`, `extra_charge_5`, `extra_charge_6`, `extra_charge_amount_1`, `extra_charge_amount_2`, `extra_charge_amount_3`, `extra_charge_amount_4`, `extra_charge_amount_5`, `extra_charge_amount_6`, `created_details`, `edited_details`) VALUES
(1, 'SPITECH VILLA', 'BSP', '', ',,', ',,', '', '', '', '', '', '', '', '', '', '', '', '', 'admin, admin, 2022-06-16, 11:45:34 AM, 122.175.164.74', 'admin, admin, 2022-06-16, 11:45:34 AM, 122.175.164.74'),
(2, 'SHYAM CITY', 'BSP', '', '..', '..', '', '', '', '', '', '', '', '', '', '', '', '', 'admin, admin, 2022-06-16, 11:45:59 AM, 122.175.164.74', 'admin, admin, 2022-06-16, 11:45:59 AM, 122.175.164.74');

-- --------------------------------------------------------

--
-- Table structure for table `project_details`
--

CREATE TABLE `project_details` (
  `project_id` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `project_property_type_id` varchar(25) COLLATE latin1_general_ci NOT NULL COMMENT 'Primary Key Of tbl_setting_property_type',
  `project_standard_amount_percent` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `project_no_of_date_to_tokent_expiry` varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT 'numeric or float'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `project_details`
--

INSERT INTO `project_details` (`project_id`, `project_property_type_id`, `project_standard_amount_percent`, `project_no_of_date_to_tokent_expiry`) VALUES
('1', '1', '51000', '30'),
('2', '1', '51000', '45');

-- --------------------------------------------------------

--
-- Table structure for table `project_property_type_rate`
--

CREATE TABLE `project_property_type_rate` (
  `project_id` varchar(18) COLLATE latin1_general_ci NOT NULL,
  `property_type_id` varchar(18) COLLATE latin1_general_ci NOT NULL,
  `plot_area_rate` varchar(18) COLLATE latin1_general_ci NOT NULL,
  `built_up_area_rate` varchar(18) COLLATE latin1_general_ci NOT NULL,
  `super_built_up_area_rate` varchar(18) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `project_property_type_rate`
--

INSERT INTO `project_property_type_rate` (`project_id`, `property_type_id`, `plot_area_rate`, `built_up_area_rate`, `super_built_up_area_rate`) VALUES
('2', '1', '1500', '', ''),
('1', '1', '1200', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `property`
--

CREATE TABLE `property` (
  `property_id` bigint(20) NOT NULL,
  `property_project_id` varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT 'Primary key of tbl_project',
  `property_type_id` varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT 'Primary key of tbl_setting_property_type',
  `property_no` varchar(25) COLLATE latin1_general_ci NOT NULL COMMENT 'Display Name In Every Where',
  `property_status` varchar(25) COLLATE latin1_general_ci NOT NULL COMMENT 'Available, Booked Or TempBooked',
  `property_plot_area` varchar(25) COLLATE latin1_general_ci NOT NULL COMMENT 'Total Plot Area',
  `property_built_up_area` varchar(25) COLLATE latin1_general_ci NOT NULL COMMENT 'if Property Type not like Plots',
  `property_super_built_up_area` varchar(25) COLLATE latin1_general_ci NOT NULL COMMENT 'if Property Type not like Plots',
  `property_khasra_no` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `property_remarks` text COLLATE latin1_general_ci NOT NULL,
  `property_photo` text COLLATE latin1_general_ci NOT NULL,
  `created_details` text COLLATE latin1_general_ci NOT NULL,
  `edited_details` text COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `property`
--

INSERT INTO `property` (`property_id`, `property_project_id`, `property_type_id`, `property_no`, `property_status`, `property_plot_area`, `property_built_up_area`, `property_super_built_up_area`, `property_khasra_no`, `property_remarks`, `property_photo`, `created_details`, `edited_details`) VALUES
(1, '2', '1', '01', 'Booked', '1200', '0', '0', '', '', '', 'admin, admin, 2022-06-16, 11:46:42 AM, 122.175.164.74', 'admin, admin, 2022-06-16, 11:46:42 AM, 122.175.164.74'),
(2, '2', '1', '02', 'Available', '1400', '0', '0', '', '', '', 'admin, admin, 2022-06-16, 11:46:42 AM, 122.175.164.74', 'admin, admin, 2022-06-16, 11:46:42 AM, 122.175.164.74'),
(3, '2', '1', '03', 'Available', '1500', '0', '0', '', '', '', 'admin, admin, 2022-06-16, 11:46:42 AM, 122.175.164.74', 'admin, admin, 2022-06-16, 11:46:42 AM, 122.175.164.74'),
(4, '2', '1', '04', 'Available', '1500', '0', '0', '', '', '', 'admin, admin, 2022-06-16, 11:46:42 AM, 122.175.164.74', 'admin, admin, 2022-06-16, 11:46:42 AM, 122.175.164.74'),
(5, '2', '1', '05', 'Available', '1600', '0', '0', '', '', '', 'admin, admin, 2022-06-16, 11:46:42 AM, 122.175.164.74', 'admin, admin, 2022-06-16, 11:46:42 AM, 122.175.164.74'),
(6, '1', '1', '01', 'Booked', '1200', '0', '0', '', '', '', 'admin, admin, 2022-06-16, 11:57:38 AM, 122.175.164.74', 'admin, admin, 2022-06-16, 11:57:38 AM, 122.175.164.74'),
(7, '1', '1', '02', 'Available', '1000', '0', '0', '', '', '', 'admin, admin, 2022-06-16, 11:57:38 AM, 122.175.164.74', 'admin, admin, 2022-06-16, 11:57:38 AM, 122.175.164.74'),
(8, '1', '1', '03', 'Available', '1000', '0', '0', '', '', '', 'admin, admin, 2022-06-16, 11:57:38 AM, 122.175.164.74', 'admin, admin, 2022-06-16, 11:57:38 AM, 122.175.164.74'),
(9, '1', '1', '04', 'Available', '1200', '0', '0', '', '', '', 'admin, admin, 2022-06-16, 11:57:38 AM, 122.175.164.74', 'admin, admin, 2022-06-16, 11:57:38 AM, 122.175.164.74'),
(10, '1', '1', '05', 'Available', '1200', '0', '0', '', '', '', 'admin, admin, 2022-06-16, 11:57:38 AM, 122.175.164.74', 'admin, admin, 2022-06-16, 11:57:38 AM, 122.175.164.74');

-- --------------------------------------------------------

--
-- Table structure for table `property_booking`
--

CREATE TABLE `property_booking` (
  `booking_id` bigint(20) NOT NULL,
  `booking_type` varchar(25) COLLATE latin1_general_ci NOT NULL COMMENT 'Temporarily/Token or Permanent with Down Payment',
  `booking_commission_status` int(1) NOT NULL COMMENT 'If 1 then Comission Distributed if 0 then not distributed, kept for Next DP/INST',
  `booking_particular` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `booking_voucher_no` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `booking_date` date NOT NULL,
  `booking_token_exp_date` date NOT NULL COMMENT 'If Temporarily Booked By Token',
  `booking_project_id` varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT 'Primary Key Of tbl_project',
  `booking_property_id` varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT 'Primary Key Of tbl_property',
  `booking_order_no` varchar(25) COLLATE latin1_general_ci NOT NULL COMMENT 'Booking Auto Number',
  `booking_customer_id` varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT 'Primary Key Of tbl_customer',
  `booking_executive_type` varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT 'Advisor Or Sales Executive',
  `booking_advisor_id` varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT 'Primary Key Of tbl_advisor',
  `booking_advisor_level` varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT 'Level Of Advisor at the time of booking',
  `booking_advisor_level_percent` varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT 'Level Percent  Of Booked By Advisor At The Time Of Booking',
  `booking_advisor_team` text COLLATE latin1_general_ci NOT NULL COMMENT 'Array of Sponsors Sepatated by , (At The Time Of Booking)',
  `booking_advisor_team_level` text COLLATE latin1_general_ci NOT NULL COMMENT 'Array of Sponsors Level Sepatated by ,(At The Time Of Booking)',
  `booking_advisor_team_level_percent` varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT 'Level Percent Of Advisor Sponsor''s Team At The Time Of Booking',
  `booking_advisor_team_level_percent_diff` varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT 'According to this Commission Will Be Generated',
  `booking_property_plot_area` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_property_plot_area_rate` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_property_built_up_area` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_property_built_up_area_rate` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_property_super_built_up_area` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_property_super_built_up_rate` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_property_plot_price` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_property_construction_build_up_price` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_property_construction_super_build_up_price` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_property_construction_price` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_property_mrp` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_property_discount` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_property_discount_amount` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_property_discounted_mrp` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `fixed_mrp` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `govt_rate` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `fixed_rate` tinyint(1) NOT NULL,
  `booking_remark` text COLLATE latin1_general_ci NOT NULL,
  `booking_cancel_status` varchar(10) COLLATE latin1_general_ci NOT NULL COMMENT 'Is Booking Canceled : Yes or NULL',
  `booking_cancel_details` text COLLATE latin1_general_ci NOT NULL COMMENT 'Details Of Cancelled If Canceled Done',
  `booking_payment_mode` varchar(25) COLLATE latin1_general_ci NOT NULL COMMENT 'Bank Loan, Self ',
  `booking_payment_mode_bank` varchar(50) COLLATE latin1_general_ci NOT NULL COMMENT 'If Booking By Bank Loan',
  `booking_registry_status` varchar(25) COLLATE latin1_general_ci NOT NULL COMMENT 'Registry Done Or Not (Yes, null)',
  `registry_doc` text COLLATE latin1_general_ci NOT NULL,
  `registry_receiver` text COLLATE latin1_general_ci NOT NULL,
  `registry_dispached` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `registry_dispached_by` text COLLATE latin1_general_ci NOT NULL,
  `registry_remarks` text COLLATE latin1_general_ci NOT NULL,
  `registry_date` date NOT NULL,
  `registry_dispached_date` date NOT NULL,
  `booking_mutation_status` varchar(25) COLLATE latin1_general_ci NOT NULL COMMENT 'Is Mutation Done (Yes,Null)',
  `approved` tinyint(1) NOT NULL,
  `next_payment_date` date NOT NULL,
  `created_details` text COLLATE latin1_general_ci NOT NULL,
  `edited_details` text COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `property_booking`
--

INSERT INTO `property_booking` (`booking_id`, `booking_type`, `booking_commission_status`, `booking_particular`, `booking_voucher_no`, `booking_date`, `booking_token_exp_date`, `booking_project_id`, `booking_property_id`, `booking_order_no`, `booking_customer_id`, `booking_executive_type`, `booking_advisor_id`, `booking_advisor_level`, `booking_advisor_level_percent`, `booking_advisor_team`, `booking_advisor_team_level`, `booking_advisor_team_level_percent`, `booking_advisor_team_level_percent_diff`, `booking_property_plot_area`, `booking_property_plot_area_rate`, `booking_property_built_up_area`, `booking_property_built_up_area_rate`, `booking_property_super_built_up_area`, `booking_property_super_built_up_rate`, `booking_property_plot_price`, `booking_property_construction_build_up_price`, `booking_property_construction_super_build_up_price`, `booking_property_construction_price`, `booking_property_mrp`, `booking_property_discount`, `booking_property_discount_amount`, `booking_property_discounted_mrp`, `fixed_mrp`, `govt_rate`, `fixed_rate`, `booking_remark`, `booking_cancel_status`, `booking_cancel_details`, `booking_payment_mode`, `booking_payment_mode_bank`, `booking_registry_status`, `registry_doc`, `registry_receiver`, `registry_dispached`, `registry_dispached_by`, `registry_remarks`, `registry_date`, `registry_dispached_date`, `booking_mutation_status`, `approved`, `next_payment_date`, `created_details`, `edited_details`) VALUES
(1, 'Permanent', 1, 'DOWN PAYMENT', '0001/DP/0001', '2020-06-16', '2020-07-16', '1', '6', 'ODR0001', '2', 'ADVISOR', '2', '2', '10', '1', '1', '100', '90', '1200', '1250', '0', '0', '0', '0', '1500000.00', '0.00', '0.00', '0', '1500000.00', '1%', '15000.00', '1485000.00', '0', '1440000', 0, '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '', 1, '2020-07-16', 'admin, admin, 2022-06-16, 12:09:21 PM, 122.175.164.74', 'admin, admin, 2022-06-16, 12:09:21 PM, 122.175.164.74'),
(2, 'Permanent', 1, 'DOWN PAYMENT', '0002/DP/0002', '2021-06-16', '2021-07-31', '2', '1', 'ODR0002', '1', 'ADVISOR', '4', '5', '4', '2,1', '2,1', '10,100', '6,90', '1200', '1400', '0', '0', '0', '0', '1680000.00', '0.00', '0.00', '0', '1680000.00', '51000', '51000.00', '1629000.00', '1800000', '1800000', 0, '', '', '', '', '', '', '', '', '', '', '', '0000-00-00', '0000-00-00', '', 1, '2021-07-16', 'admin, admin, 2022-06-16, 12:10:24 PM, 122.175.164.74', 'admin, admin, 2022-06-16, 12:10:24 PM, 122.175.164.74');

-- --------------------------------------------------------

--
-- Table structure for table `property_booking_cancelled`
--

CREATE TABLE `property_booking_cancelled` (
  `cancel_id` bigint(20) NOT NULL,
  `booking_id` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_type` varchar(25) COLLATE latin1_general_ci NOT NULL COMMENT 'Temporarily/Token or Permanent with Down Payment',
  `booking_commission_status` int(1) NOT NULL,
  `booking_particular` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `booking_voucher_no` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `booking_date` date NOT NULL,
  `booking_token_exp_date` date NOT NULL COMMENT 'If Temporarily Booked By Token',
  `booking_project_id` varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT 'Primary Key Of tbl_project',
  `booking_property_id` varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT 'Primary Key Of tbl_property',
  `booking_order_no` varchar(25) COLLATE latin1_general_ci NOT NULL COMMENT 'Booking Auto Number',
  `booking_customer_id` varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT 'Primary Key Of tbl_customer',
  `booking_executive_type` varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT 'Advisor Or Sales Executive',
  `booking_advisor_id` varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT 'Primary Key Of tbl_advisor',
  `booking_advisor_level` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_advisor_level_percent` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_advisor_team_level_percent` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_advisor_team_level_percent_diff` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_advisor_team` text COLLATE latin1_general_ci NOT NULL COMMENT 'Array of Sponsors Sepatated by , (At The Time Of Booking)',
  `booking_advisor_team_level` text COLLATE latin1_general_ci NOT NULL COMMENT 'Array of Sponsors Level Sepatated by ,(At The Time Of Booking)',
  `booking_property_plot_area` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_property_plot_area_rate` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_property_built_up_area` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_property_built_up_area_rate` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_property_super_built_up_area` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_property_super_built_up_rate` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_property_plot_price` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_property_construction_build_up_price` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_property_construction_super_build_up_price` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_property_construction_price` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_property_mrp` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_property_discount` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_property_discount_amount` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_property_discounted_mrp` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `fixed_mrp` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `govt_rate` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `fixed_rate` tinyint(1) NOT NULL,
  `booking_remark` text COLLATE latin1_general_ci NOT NULL,
  `booking_cancel_status` varchar(10) COLLATE latin1_general_ci NOT NULL COMMENT 'Is Booking Canceled : Yes or NULL',
  `booking_cancel_details` text COLLATE latin1_general_ci NOT NULL COMMENT 'Details Of Cancelled If Canceled Done',
  `booking_payment_mode` varchar(25) COLLATE latin1_general_ci NOT NULL COMMENT 'Bank Loan, Self ',
  `booking_payment_mode_bank` varchar(50) COLLATE latin1_general_ci NOT NULL COMMENT 'If Booking By Bank Loan',
  `booking_registry_status` varchar(25) COLLATE latin1_general_ci NOT NULL COMMENT 'Registry Done Or Not (Yes, null)',
  `registry_doc` text COLLATE latin1_general_ci NOT NULL,
  `registry_receiver` text COLLATE latin1_general_ci NOT NULL,
  `registry_dispached` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `registry_dispached_by` text COLLATE latin1_general_ci NOT NULL,
  `registry_remarks` text COLLATE latin1_general_ci NOT NULL,
  `registry_date` date NOT NULL,
  `registry_dispached_date` date NOT NULL,
  `booking_mutation_status` varchar(25) COLLATE latin1_general_ci NOT NULL COMMENT 'Is Mutation Done (Yes,Null)',
  `created_details` text COLLATE latin1_general_ci NOT NULL,
  `edited_details` text COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `property_booking_deleted`
--

CREATE TABLE `property_booking_deleted` (
  `deleted_id` bigint(20) NOT NULL,
  `booking_id` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_type` varchar(25) COLLATE latin1_general_ci NOT NULL COMMENT 'Temporarily/Token or Permanent with Down Payment',
  `booking_commission_status` int(1) NOT NULL,
  `booking_particular` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `booking_voucher_no` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `booking_date` date NOT NULL,
  `booking_token_exp_date` date NOT NULL COMMENT 'If Temporarily Booked By Token',
  `booking_project_id` varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT 'Primary Key Of tbl_project',
  `booking_property_id` varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT 'Primary Key Of tbl_property',
  `booking_order_no` varchar(25) COLLATE latin1_general_ci NOT NULL COMMENT 'Booking Auto Number',
  `booking_customer_id` varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT 'Primary Key Of tbl_customer',
  `booking_executive_type` varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT 'Advisor Or Sales Executive',
  `booking_advisor_id` varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT 'Primary Key Of tbl_advisor',
  `booking_advisor_level` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_advisor_level_percent` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_advisor_team` text COLLATE latin1_general_ci NOT NULL COMMENT 'Array of Sponsors Sepatated by , (At The Time Of Booking)',
  `booking_advisor_team_level` text COLLATE latin1_general_ci NOT NULL COMMENT 'Array of Sponsors Level Sepatated by ,(At The Time Of Booking)',
  `booking_advisor_team_level_percent` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_advisor_team_level_percent_diff` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_property_plot_area` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_property_plot_area_rate` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_property_built_up_area` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_property_built_up_area_rate` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_property_super_built_up_area` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_property_super_built_up_rate` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_property_plot_price` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_property_construction_build_up_price` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_property_construction_super_build_up_price` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_property_construction_price` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_property_mrp` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_property_discount` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_property_discount_amount` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_property_discounted_mrp` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `fixed_mrp` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `govt_rate` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `fixed_rate` tinyint(1) NOT NULL,
  `booking_total_payment_received` varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT 'Sum of All Payment Received in this booking',
  `booking_remark` text COLLATE latin1_general_ci NOT NULL,
  `booking_cancel_status` varchar(10) COLLATE latin1_general_ci NOT NULL COMMENT 'Is Booking Canceled : Yes or NULL',
  `booking_cancel_details` text COLLATE latin1_general_ci NOT NULL COMMENT 'Details Of Cancelled If Canceled Done',
  `booking_payment_mode` varchar(25) COLLATE latin1_general_ci NOT NULL COMMENT 'Bank Loan, Self ',
  `booking_payment_mode_bank` varchar(50) COLLATE latin1_general_ci NOT NULL COMMENT 'If Booking By Bank Loan',
  `booking_registry_status` varchar(25) COLLATE latin1_general_ci NOT NULL COMMENT 'Registry Done Or Not (Yes, null)',
  `registry_doc` text COLLATE latin1_general_ci NOT NULL,
  `registry_receiver` text COLLATE latin1_general_ci NOT NULL,
  `registry_dispached` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `registry_dispached_by` text COLLATE latin1_general_ci NOT NULL,
  `registry_remarks` text COLLATE latin1_general_ci NOT NULL,
  `registry_date` date NOT NULL,
  `registry_dispached_date` date NOT NULL,
  `booking_mutation_status` varchar(25) COLLATE latin1_general_ci NOT NULL COMMENT 'Is Mutation Done (Yes,Null)',
  `created_details` text COLLATE latin1_general_ci NOT NULL,
  `edited_details` text COLLATE latin1_general_ci NOT NULL,
  `deleted_details` text COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `property_booking_extra_charge`
--

CREATE TABLE `property_booking_extra_charge` (
  `charge_id` bigint(20) NOT NULL,
  `booking_id` bigint(20) NOT NULL,
  `charge_particular` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `charge_amount` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `charge_paid` varchar(20) COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `property_booking_extra_charge`
--

INSERT INTO `property_booking_extra_charge` (`charge_id`, `booking_id`, `charge_particular`, `charge_amount`, `charge_paid`) VALUES
(1, 1, 'CSEB', '10000', '10000'),
(2, 1, 'MAINTAIN', '25000', '25000'),
(3, 2, 'CSEB', '20000', '0'),
(4, 2, 'MAINTAIN', '25000', '0');

-- --------------------------------------------------------

--
-- Table structure for table `property_booking_extra_charge_payment`
--

CREATE TABLE `property_booking_extra_charge_payment` (
  `payment_id` bigint(20) NOT NULL,
  `booking_id` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `charge_id` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `voucher_no` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `payment_amount` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `payment_date` date NOT NULL,
  `payment_mode` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `payment_mode_no` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `payment_mode_bank` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `payment_mode_date` date NOT NULL,
  `payment_notes` text COLLATE latin1_general_ci NOT NULL,
  `created_details` text COLLATE latin1_general_ci NOT NULL,
  `edited_details` text COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `property_booking_extra_charge_payment`
--

INSERT INTO `property_booking_extra_charge_payment` (`payment_id`, `booking_id`, `charge_id`, `voucher_no`, `payment_amount`, `payment_date`, `payment_mode`, `payment_mode_no`, `payment_mode_bank`, `payment_mode_date`, `payment_notes`, `created_details`, `edited_details`) VALUES
(1, '1', '1', '0001/X/0001', '10000', '2020-06-16', 'CASH', '', '', '2022-06-16', '', 'admin, admin, 2022-06-16, 12:13:13 PM, 122.175.164.74', 'admin, admin, 2022-06-16, 12:13:13 PM, 122.175.164.74'),
(2, '1', '2', '0001/X/0002', '25000', '2020-07-16', 'CASH', '', '', '2022-06-16', '', 'admin, admin, 2022-06-16, 12:13:35 PM, 122.175.164.74', 'admin, admin, 2022-06-16, 12:13:35 PM, 122.175.164.74');

-- --------------------------------------------------------

--
-- Table structure for table `property_booking_payments`
--

CREATE TABLE `property_booking_payments` (
  `payment_id` bigint(20) NOT NULL,
  `payment_booking_id` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `payment_order_no` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `payment_voucher_no` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `payment_heading` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `payment_project_id` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `payment_property_id` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `payment_customer_id` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `payment_installment_no` varchar(22) COLLATE latin1_general_ci NOT NULL,
  `payment_amount` varchar(22) COLLATE latin1_general_ci NOT NULL,
  `payment_date` date NOT NULL,
  `payment_booking_executive_type` varchar(15) COLLATE latin1_general_ci NOT NULL,
  `payment_advisor_id` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `payment_mode` varchar(25) COLLATE latin1_general_ci NOT NULL COMMENT 'DD, Cheque, Fund Transffer, Cash etc',
  `payment_mode_no` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `payment_mode_bank` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `payment_mode_date` date NOT NULL,
  `payment_remarks` text COLLATE latin1_general_ci NOT NULL,
  `created_details` text COLLATE latin1_general_ci NOT NULL,
  `edited_details` text COLLATE latin1_general_ci NOT NULL,
  `payment_first_payment` varchar(1) COLLATE latin1_general_ci NOT NULL COMMENT 'Payment During Booking (First Payment Or Not If First then 1 else null)',
  `approved` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `property_booking_payments`
--

INSERT INTO `property_booking_payments` (`payment_id`, `payment_booking_id`, `payment_order_no`, `payment_voucher_no`, `payment_heading`, `payment_project_id`, `payment_property_id`, `payment_customer_id`, `payment_installment_no`, `payment_amount`, `payment_date`, `payment_booking_executive_type`, `payment_advisor_id`, `payment_mode`, `payment_mode_no`, `payment_mode_bank`, `payment_mode_date`, `payment_remarks`, `created_details`, `edited_details`, `payment_first_payment`, `approved`) VALUES
(1, '1', 'ODR0001', '0001/DP/0001', 'DOWN PAYMENT', '1', '6', '2', '1', '100000', '2020-06-16', 'ADVISOR', '2', 'CASH', '', '', '2022-06-16', '', 'admin, admin, 2022-06-16, 12:09:21 PM, 122.175.164.74', 'admin, admin, 2022-06-16, 12:09:21 PM, 122.175.164.74', '1', 1),
(2, '2', 'ODR0002', '0002/DP/0002', 'DOWN PAYMENT', '2', '1', '1', '1', '150000', '2021-06-16', 'ADVISOR', '4', 'CASH', '', '', '2022-06-16', '', 'admin, admin, 2022-06-16, 12:10:24 PM, 122.175.164.74', 'admin, admin, 2022-06-16, 12:10:24 PM, 122.175.164.74', '1', 1),
(3, '1', 'ODR0001', '0001/INS/0003', 'INSTALLMENT', '1', '6', '2', '2', '500000', '2020-07-16', 'ADVISOR', '2', 'CHEQUE', '123', 'SBI', '2020-06-16', '', 'admin, admin, 2022-06-16, 12:12:20 PM, 122.175.164.74', 'admin, admin, 2022-06-16, 12:12:20 PM, 122.175.164.74', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `property_booking_payments_doc`
--

CREATE TABLE `property_booking_payments_doc` (
  `doc_id` bigint(18) NOT NULL,
  `payment_id` varchar(18) COLLATE latin1_general_ci NOT NULL,
  `doc_name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `doc` text COLLATE latin1_general_ci NOT NULL,
  `created_details` text COLLATE latin1_general_ci NOT NULL,
  `edited_details` text COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `property_booking_payments_doc`
--

INSERT INTO `property_booking_payments_doc` (`doc_id`, `payment_id`, `doc_name`, `doc`, `created_details`, `edited_details`) VALUES
(1, '3', '.', '20220616_12164100banner_25_copy.jpg', 'admin, admin, 2022-06-16, 12:16:41 PM, 122.175.164.74', 'admin, admin, 2022-06-16, 12:16:41 PM, 122.175.164.74');

-- --------------------------------------------------------

--
-- Table structure for table `property_updates`
--

CREATE TABLE `property_updates` (
  `id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `image` text NOT NULL,
  `remark` text NOT NULL,
  `created_details` text NOT NULL,
  `edited_details` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `setting_advisor_level`
--

CREATE TABLE `setting_advisor_level` (
  `level_id` bigint(20) NOT NULL,
  `level_name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `level_unit_sale` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `level_active_member` varchar(2) COLLATE latin1_general_ci NOT NULL,
  `level_last_month` varchar(2) COLLATE latin1_general_ci NOT NULL,
  `level_target` varchar(18) COLLATE latin1_general_ci NOT NULL COMMENT 'Taraget To Next Level',
  `created_details` text COLLATE latin1_general_ci NOT NULL COMMENT 'By Which User Created ',
  `edited_details` text COLLATE latin1_general_ci NOT NULL COMMENT 'By Which User Edited'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `setting_advisor_level`
--

INSERT INTO `setting_advisor_level` (`level_id`, `level_name`, `level_unit_sale`, `level_active_member`, `level_last_month`, `level_target`, `created_details`, `edited_details`) VALUES
(1, 'COMPANY', '1000000000', '10', '', '100000000000000000', 'admin, admin, 2022-06-16, 11:58:09 AM, 122.175.164.74', 'admin, admin, 2022-06-16, 11:58:09 AM, 122.175.164.74'),
(2, 'LEVEL-1', '50', '1', '', '10000000', 'admin, admin, 2022-06-16, 11:58:40 AM, 122.175.164.74', 'admin, admin, 2022-06-16, 11:58:40 AM, 122.175.164.74'),
(3, 'LEVEL-2', '40', '1', '', '8000000', 'admin, admin, 2022-06-16, 11:59:11 AM, 122.175.164.74', 'admin, admin, 2022-06-16, 11:59:11 AM, 122.175.164.74'),
(4, 'LEVEL-3', '30', '1', '', '7000000', 'admin, admin, 2022-06-16, 11:59:35 AM, 122.175.164.74', 'admin, admin, 2022-06-16, 11:59:35 AM, 122.175.164.74'),
(5, 'LEVEL-4', '20', '1', '', '5000000', 'admin, admin, 2022-06-16, 12:00:00 PM, 122.175.164.74', 'admin, admin, 2022-06-16, 12:00:00 PM, 122.175.164.74');

-- --------------------------------------------------------

--
-- Table structure for table `setting_advisor_level_with_property_type`
--

CREATE TABLE `setting_advisor_level_with_property_type` (
  `level_id` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `property_type_id` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `commission_percent` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `project_id` varchar(20) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `setting_advisor_level_with_property_type`
--

INSERT INTO `setting_advisor_level_with_property_type` (`level_id`, `property_type_id`, `commission_percent`, `project_id`) VALUES
('1', '1', '100', '2'),
('1', '2', '100', '2'),
('1', '7', '100', '2'),
('1', '8', '100', '2'),
('1', '9', '100', '2'),
('1', '10', '100', '2'),
('1', '11', '100', '2'),
('1', '12', '100', '2'),
('1', '13', '100', '2'),
('1', '1', '100', '1'),
('1', '2', '100', '1'),
('1', '7', '100', '1'),
('1', '8', '100', '1'),
('1', '9', '100', '1'),
('1', '10', '100', '1'),
('1', '11', '100', '1'),
('1', '12', '100', '1'),
('1', '13', '100', '1'),
('2', '1', '10', '2'),
('2', '2', '5', '2'),
('2', '7', '5', '2'),
('2', '8', '5', '2'),
('2', '9', '5', '2'),
('2', '10', '5', '2'),
('2', '11', '5', '2'),
('2', '12', '5', '2'),
('2', '13', '5', '2'),
('2', '1', '10', '1'),
('2', '2', '5', '1'),
('2', '7', '5', '1'),
('2', '8', '5', '1'),
('2', '9', '5', '1'),
('2', '10', '5', '1'),
('2', '11', '5', '1'),
('2', '12', '5', '1'),
('2', '13', '5', '1'),
('3', '1', '8', '2'),
('3', '2', '4', '2'),
('3', '7', '4', '2'),
('3', '8', '4', '2'),
('3', '9', '4', '2'),
('3', '10', '4', '2'),
('3', '11', '4', '2'),
('3', '12', '4', '2'),
('3', '13', '4', '2'),
('3', '1', '8', '1'),
('3', '2', '4', '1'),
('3', '7', '4', '1'),
('3', '8', '4', '1'),
('3', '9', '4', '1'),
('3', '10', '4', '1'),
('3', '11', '4', '1'),
('3', '12', '4', '1'),
('3', '13', '4', '1'),
('4', '1', '6', '2'),
('4', '2', '3', '2'),
('4', '7', '3', '2'),
('4', '8', '3', '2'),
('4', '9', '3', '2'),
('4', '10', '3', '2'),
('4', '11', '3', '2'),
('4', '12', '3', '2'),
('4', '13', '3', '2'),
('4', '1', '6', '1'),
('4', '2', '3', '1'),
('4', '7', '3', '1'),
('4', '8', '3', '1'),
('4', '9', '3', '1'),
('4', '10', '3', '1'),
('4', '11', '3', '1'),
('4', '12', '3', '1'),
('4', '13', '3', '1'),
('5', '1', '4', '2'),
('5', '2', '2', '2'),
('5', '7', '2', '2'),
('5', '8', '2', '2'),
('5', '9', '2', '2'),
('5', '10', '2', '2'),
('5', '11', '2', '2'),
('5', '12', '2', '2'),
('5', '13', '2', '2'),
('5', '1', '4', '1'),
('5', '2', '2', '1'),
('5', '7', '2', '1'),
('5', '8', '2', '1'),
('5', '9', '2', '1'),
('5', '10', '2', '1'),
('5', '11', '2', '1'),
('5', '12', '2', '1'),
('5', '13', '2', '1');

-- --------------------------------------------------------

--
-- Table structure for table `setting_property_type`
--

CREATE TABLE `setting_property_type` (
  `property_type_id` bigint(20) NOT NULL,
  `property_type` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `created_details` text COLLATE latin1_general_ci NOT NULL,
  `edited_details` text COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `setting_property_type`
--

INSERT INTO `setting_property_type` (`property_type_id`, `property_type`, `created_details`, `edited_details`) VALUES
(1, 'PLOTS', 'admin, admin, 2017-07-22, 04:12:27 PM, 47.247.8.175', 'admin, admin, 2017-07-22, 04:12:27 PM, 47.247.8.175'),
(2, 'FLAT', 'admin, admin, 2014-04-17, 11:03:41 AM, 122.168.189.38', 'admin, admin, 2014-04-17, 11:03:41 AM, 122.168.189.38'),
(7, 'HOUSE', 'admin, admin, 2016-09-18, 06:47:48 PM, 110.224.219.65', 'admin, admin, 2016-09-18, 06:47:48 PM, 110.224.219.65'),
(8, 'BANGLOW', 'admin, admin, 2020-01-02, 05:50:53 PM, 171.61.60.121', 'admin, admin, 2020-01-02, 05:50:53 PM, 171.61.60.121'),
(9, 'RO HOUSE', 'admin, admin, 2020-01-02, 05:51:13 PM, 171.61.60.121', 'admin, admin, 2020-01-02, 05:51:13 PM, 171.61.60.121'),
(10, 'SINGLEX HOUSE', 'admin, admin, 2020-01-02, 05:51:47 PM, 171.61.60.121', 'admin, admin, 2020-01-02, 05:51:47 PM, 171.61.60.121'),
(11, 'DUPLEX HOUSE', 'admin, admin, 2020-01-02, 05:52:17 PM, 171.61.60.121', 'admin, admin, 2020-01-02, 05:52:17 PM, 171.61.60.121'),
(12, 'FARM HOUSE', 'admin, admin, 2020-01-02, 05:52:41 PM, 171.61.60.121', 'admin, admin, 2020-01-02, 05:52:41 PM, 171.61.60.121'),
(13, 'SHOPS', 'admin, admin, 2020-02-27, 11:51:59 AM, 171.60.160.212', 'admin, admin, 2020-02-27, 11:51:59 AM, 171.60.160.212');

-- --------------------------------------------------------

--
-- Table structure for table `setting_tds`
--

CREATE TABLE `setting_tds` (
  `tds` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `created_details` text COLLATE latin1_general_ci NOT NULL,
  `edited_details` text COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `setting_tds`
--

INSERT INTO `setting_tds` (`tds`, `created_details`, `edited_details`) VALUES
('5', 'admin, admin, 2022-06-16, 12:00:49 PM, 122.175.164.74', 'admin, admin, 2022-06-16, 12:00:49 PM, 122.175.164.74');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` bigint(20) NOT NULL,
  `site_name` text COLLATE latin1_general_ci NOT NULL COMMENT 'Used in Titel Tag',
  `site_heading` text COLLATE latin1_general_ci NOT NULL COMMENT 'Used In Header And Menu',
  `site_website` varchar(100) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `site_company_name` text COLLATE latin1_general_ci NOT NULL COMMENT 'Full Name Of Company',
  `site_iso` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `site_copyright` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `advisor_title` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `id_prefix` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `email` text COLLATE latin1_general_ci NOT NULL,
  `phone` text COLLATE latin1_general_ci NOT NULL,
  `mobile` text COLLATE latin1_general_ci NOT NULL,
  `address` text COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `site_name`, `site_heading`, `site_website`, `site_company_name`, `site_iso`, `site_copyright`, `advisor_title`, `id_prefix`, `email`, `phone`, `mobile`, `address`) VALUES
(1, 'Demo Site', 'Demo Site', '', 'Aasma Builders', '', '', 'Advisor', 'AB', 'info@aasmabuilders.com', '', '+91-9424143229', 'Opposite Hanuman Mandir, Mungeli Road,Bilaspur, Chhattisgarh-495001');

-- --------------------------------------------------------

--
-- Table structure for table `sms_sent`
--

CREATE TABLE `sms_sent` (
  `sms_id` int(10) NOT NULL,
  `sms_birthday` date NOT NULL,
  `sms_anniversary` date NOT NULL,
  `sms_token_expiry_pre` date NOT NULL,
  `sms_token_expiry_current` date NOT NULL,
  `sms_token_expiry_after` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `spitech_sms_server`
--

CREATE TABLE `spitech_sms_server` (
  `sms` tinyint(1) NOT NULL,
  `sms_url` text COLLATE latin1_general_ci NOT NULL,
  `mobile_parameter` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `message_parameter` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `mobile_prefix` varchar(5) COLLATE latin1_general_ci NOT NULL,
  `parameter1` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `value1` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `parameter2` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `value2` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `parameter3` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `value3` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `parameter4` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `value4` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `parameter5` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `value5` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `balance_url` text COLLATE latin1_general_ci NOT NULL,
  `bparameter1` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `bvalue1` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `bparameter2` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `bvalue2` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `bparameter3` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `bvalue3` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `bparameter4` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `bvalue4` varchar(25) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `spitech_sms_server`
--

INSERT INTO `spitech_sms_server` (`sms`, `sms_url`, `mobile_parameter`, `message_parameter`, `mobile_prefix`, `parameter1`, `value1`, `parameter2`, `value2`, `parameter3`, `value3`, `parameter4`, `value4`, `parameter5`, `value5`, `balance_url`, `bparameter1`, `bvalue1`, `bparameter2`, `bvalue2`, `bparameter3`, `bvalue3`, `bparameter4`, `bvalue4`) VALUES
(1, 'http://sendsms.spitechwebservices.com/api/sendmsg.php', 'phone', 'text', '', 'user', 'SIDDHIBUILD', 'pass', 'SIDDHIBUILD', 'sender', 'SIDDHI', 'priority', 'ndnd', 'stype', 'normal', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `spitech_user`
--

CREATE TABLE `spitech_user` (
  `id` int(11) NOT NULL,
  `user_id` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `user_name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `user_password` text COLLATE latin1_general_ci NOT NULL,
  `user_email_id` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `user_mobile` varchar(10) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `spitech_user`
--

INSERT INTO `spitech_user` (`id`, `user_id`, `user_name`, `user_password`, `user_email_id`, `user_mobile`) VALUES
(1, 'contact@spitech.in', 'Super Admin', '1ab7bc8a726cd0f7137d190e474cdde7', 'contact@spitech.in', '7828796979');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`activity_id`);

--
-- Indexes for table `admin_user`
--
ALTER TABLE `admin_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_user_action`
--
ALTER TABLE `admin_user_action`
  ADD PRIMARY KEY (`action_id`);

--
-- Indexes for table `advisor`
--
ALTER TABLE `advisor`
  ADD PRIMARY KEY (`advisor_id`);

--
-- Indexes for table `advisor_action`
--
ALTER TABLE `advisor_action`
  ADD PRIMARY KEY (`action_id`);

--
-- Indexes for table `advisor_commission`
--
ALTER TABLE `advisor_commission`
  ADD PRIMARY KEY (`commission_id`);

--
-- Indexes for table `advisor_docs`
--
ALTER TABLE `advisor_docs`
  ADD PRIMARY KEY (`doc_id`);

--
-- Indexes for table `advisor_dvr`
--
ALTER TABLE `advisor_dvr`
  ADD PRIMARY KEY (`dvr_id`);

--
-- Indexes for table `advisor_payment`
--
ALTER TABLE `advisor_payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `advisor_promotion`
--
ALTER TABLE `advisor_promotion`
  ADD PRIMARY KEY (`promotion_id`);

--
-- Indexes for table `award`
--
ALTER TABLE `award`
  ADD PRIMARY KEY (`award_id`);

--
-- Indexes for table `complain`
--
ALTER TABLE `complain`
  ADD PRIMARY KEY (`complain_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `customer_action`
--
ALTER TABLE `customer_action`
  ADD PRIMARY KEY (`action_id`);

--
-- Indexes for table `enquiry`
--
ALTER TABLE `enquiry`
  ADD PRIMARY KEY (`enquiry_id`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`expense_id`);

--
-- Indexes for table `expense_category`
--
ALTER TABLE `expense_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `expense_sub_category`
--
ALTER TABLE `expense_sub_category`
  ADD PRIMARY KEY (`sub_category_id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `property`
--
ALTER TABLE `property`
  ADD PRIMARY KEY (`property_id`);

--
-- Indexes for table `property_booking`
--
ALTER TABLE `property_booking`
  ADD PRIMARY KEY (`booking_id`);

--
-- Indexes for table `property_booking_cancelled`
--
ALTER TABLE `property_booking_cancelled`
  ADD PRIMARY KEY (`cancel_id`);

--
-- Indexes for table `property_booking_deleted`
--
ALTER TABLE `property_booking_deleted`
  ADD PRIMARY KEY (`deleted_id`);

--
-- Indexes for table `property_booking_extra_charge`
--
ALTER TABLE `property_booking_extra_charge`
  ADD PRIMARY KEY (`charge_id`);

--
-- Indexes for table `property_booking_extra_charge_payment`
--
ALTER TABLE `property_booking_extra_charge_payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `property_booking_payments`
--
ALTER TABLE `property_booking_payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `property_booking_payments_doc`
--
ALTER TABLE `property_booking_payments_doc`
  ADD PRIMARY KEY (`doc_id`);

--
-- Indexes for table `property_updates`
--
ALTER TABLE `property_updates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting_advisor_level`
--
ALTER TABLE `setting_advisor_level`
  ADD PRIMARY KEY (`level_id`);

--
-- Indexes for table `setting_property_type`
--
ALTER TABLE `setting_property_type`
  ADD PRIMARY KEY (`property_type_id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_sent`
--
ALTER TABLE `sms_sent`
  ADD PRIMARY KEY (`sms_id`);

--
-- Indexes for table `spitech_user`
--
ALTER TABLE `spitech_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `activity_id` bigint(18) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_user`
--
ALTER TABLE `admin_user`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `advisor`
--
ALTER TABLE `advisor`
  MODIFY `advisor_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `advisor_commission`
--
ALTER TABLE `advisor_commission`
  MODIFY `commission_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `advisor_docs`
--
ALTER TABLE `advisor_docs`
  MODIFY `doc_id` bigint(18) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `advisor_dvr`
--
ALTER TABLE `advisor_dvr`
  MODIFY `dvr_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `advisor_payment`
--
ALTER TABLE `advisor_payment`
  MODIFY `payment_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `advisor_promotion`
--
ALTER TABLE `advisor_promotion`
  MODIFY `promotion_id` bigint(18) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `award`
--
ALTER TABLE `award`
  MODIFY `award_id` bigint(18) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `complain`
--
ALTER TABLE `complain`
  MODIFY `complain_id` bigint(18) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `enquiry`
--
ALTER TABLE `enquiry`
  MODIFY `enquiry_id` bigint(18) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `expense_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `expense_category`
--
ALTER TABLE `expense_category`
  MODIFY `category_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `expense_sub_category`
--
ALTER TABLE `expense_sub_category`
  MODIFY `sub_category_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `project_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `property`
--
ALTER TABLE `property`
  MODIFY `property_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `property_booking`
--
ALTER TABLE `property_booking`
  MODIFY `booking_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `property_booking_cancelled`
--
ALTER TABLE `property_booking_cancelled`
  MODIFY `cancel_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `property_booking_deleted`
--
ALTER TABLE `property_booking_deleted`
  MODIFY `deleted_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `property_booking_extra_charge`
--
ALTER TABLE `property_booking_extra_charge`
  MODIFY `charge_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `property_booking_extra_charge_payment`
--
ALTER TABLE `property_booking_extra_charge_payment`
  MODIFY `payment_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `property_booking_payments`
--
ALTER TABLE `property_booking_payments`
  MODIFY `payment_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `property_booking_payments_doc`
--
ALTER TABLE `property_booking_payments_doc`
  MODIFY `doc_id` bigint(18) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `property_updates`
--
ALTER TABLE `property_updates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `setting_advisor_level`
--
ALTER TABLE `setting_advisor_level`
  MODIFY `level_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `setting_property_type`
--
ALTER TABLE `setting_property_type`
  MODIFY `property_type_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sms_sent`
--
ALTER TABLE `sms_sent`
  MODIFY `sms_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `spitech_user`
--
ALTER TABLE `spitech_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
