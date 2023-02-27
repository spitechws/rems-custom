-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 16, 2022 at 09:06 AM
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
-- Database: `u172594077_cityrealrems`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `activity_id` bigint(20) NOT NULL,
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
  `user_status` int(11) NOT NULL,
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
(1, 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'info@spitech.in', '8269424219', 'user.png', 1, 'admin', '192.168.1.4', '2015-02-07', '04:34:05 PM', '2022-06-20', '08:25:51 PM', '::1');

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
  `advisor_status` int(11) NOT NULL COMMENT 'iF aCTIVE THEN 1 ORHER WISE 0',
  `created_details` text COLLATE latin1_general_ci NOT NULL,
  `edited_details` text COLLATE latin1_general_ci NOT NULL,
  `last_access_details` text COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `advisor_docs`
--

CREATE TABLE `advisor_docs` (
  `doc_id` bigint(20) NOT NULL,
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

-- --------------------------------------------------------

--
-- Table structure for table `advisor_promotion`
--

CREATE TABLE `advisor_promotion` (
  `promotion_id` bigint(20) NOT NULL,
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
  `award_id` bigint(20) NOT NULL,
  `award` text COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `complain`
--

CREATE TABLE `complain` (
  `complain_id` bigint(20) NOT NULL,
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
  `enquiry_id` bigint(20) NOT NULL,
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
(1, 'BILL'),
(2, 'TRANSPORTING');

-- --------------------------------------------------------

--
-- Table structure for table `expense_sub_category`
--

CREATE TABLE `expense_sub_category` (
  `sub_category_id` bigint(20) NOT NULL,
  `category_id` varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT 'Primary Key Of tbl_expense_category',
  `sub_category_name` varchar(50) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `property_booking`
--

CREATE TABLE `property_booking` (
  `booking_id` bigint(20) NOT NULL,
  `booking_type` varchar(25) COLLATE latin1_general_ci NOT NULL COMMENT 'Temporarily/Token or Permanent with Down Payment',
  `booking_commission_status` int(11) NOT NULL COMMENT 'If 1 then Comission Distributed if 0 then not distributed, kept for Next DP/INST',
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

-- --------------------------------------------------------

--
-- Table structure for table `property_booking_cancelled`
--

CREATE TABLE `property_booking_cancelled` (
  `cancel_id` bigint(20) NOT NULL,
  `booking_id` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `booking_type` varchar(25) COLLATE latin1_general_ci NOT NULL COMMENT 'Temporarily/Token or Permanent with Down Payment',
  `booking_commission_status` int(11) NOT NULL,
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
  `booking_commission_status` int(11) NOT NULL,
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

-- --------------------------------------------------------

--
-- Table structure for table `property_booking_payments_doc`
--

CREATE TABLE `property_booking_payments_doc` (
  `doc_id` bigint(20) NOT NULL,
  `payment_id` varchar(18) COLLATE latin1_general_ci NOT NULL,
  `doc_name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `doc` text COLLATE latin1_general_ci NOT NULL,
  `created_details` text COLLATE latin1_general_ci NOT NULL,
  `edited_details` text COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

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
('10', 'admin, admin, 2020-01-02, 11:50:04 AM, 171.61.60.121', 'admin, admin, 2020-01-02, 11:50:04 AM, 171.61.60.121');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` bigint(20) NOT NULL,
  `site_name` text COLLATE latin1_general_ci NOT NULL COMMENT 'Used in Titel Tag',
  `site_heading` text COLLATE latin1_general_ci NOT NULL COMMENT 'Used In Header And Menu',
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

INSERT INTO `site_settings` (`id`, `site_name`, `site_heading`, `site_company_name`, `site_iso`, `site_copyright`, `advisor_title`, `id_prefix`, `email`, `phone`, `mobile`, `address`) VALUES
(1, 'SpiTech Real Estate', 'SpiTech Real Estate', 'SpiTech Real Estate', '', '', 'Advisor', 'AB', ' info@spitech.in', '', '+91-9300000616', 'Bilaspur');

-- --------------------------------------------------------

--
-- Table structure for table `sms_sent`
--

CREATE TABLE `sms_sent` (
  `sms_id` int(11) NOT NULL,
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
  MODIFY `activity_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_user`
--
ALTER TABLE `admin_user`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `advisor`
--
ALTER TABLE `advisor`
  MODIFY `advisor_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `advisor_commission`
--
ALTER TABLE `advisor_commission`
  MODIFY `commission_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `advisor_docs`
--
ALTER TABLE `advisor_docs`
  MODIFY `doc_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `advisor_dvr`
--
ALTER TABLE `advisor_dvr`
  MODIFY `dvr_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `advisor_payment`
--
ALTER TABLE `advisor_payment`
  MODIFY `payment_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `advisor_promotion`
--
ALTER TABLE `advisor_promotion`
  MODIFY `promotion_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `award`
--
ALTER TABLE `award`
  MODIFY `award_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `complain`
--
ALTER TABLE `complain`
  MODIFY `complain_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enquiry`
--
ALTER TABLE `enquiry`
  MODIFY `enquiry_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `expense_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense_category`
--
ALTER TABLE `expense_category`
  MODIFY `category_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `expense_sub_category`
--
ALTER TABLE `expense_sub_category`
  MODIFY `sub_category_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `project_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `property`
--
ALTER TABLE `property`
  MODIFY `property_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `property_booking`
--
ALTER TABLE `property_booking`
  MODIFY `booking_id` bigint(20) NOT NULL AUTO_INCREMENT;

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
  MODIFY `charge_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `property_booking_extra_charge_payment`
--
ALTER TABLE `property_booking_extra_charge_payment`
  MODIFY `payment_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `property_booking_payments`
--
ALTER TABLE `property_booking_payments`
  MODIFY `payment_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `property_booking_payments_doc`
--
ALTER TABLE `property_booking_payments_doc`
  MODIFY `doc_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `property_updates`
--
ALTER TABLE `property_updates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `setting_advisor_level`
--
ALTER TABLE `setting_advisor_level`
  MODIFY `level_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `setting_property_type`
--
ALTER TABLE `setting_property_type`
  MODIFY `property_type_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `sms_sent`
--
ALTER TABLE `sms_sent`
  MODIFY `sms_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `spitech_user`
--
ALTER TABLE `spitech_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
