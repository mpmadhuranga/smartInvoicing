-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 20, 2018 at 07:41 PM
-- Server version: 10.1.33-MariaDB
-- PHP Version: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ipdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `ip_clients`
--

CREATE TABLE `ip_clients` (
  `client_id` int(11) NOT NULL,
  `client_date_created` datetime NOT NULL,
  `client_date_modified` datetime NOT NULL,
  `client_name` text,
  `client_address_1` text,
  `client_address_2` text,
  `client_city` text,
  `client_state` text,
  `client_zip` text,
  `client_country` text,
  `client_phone` text,
  `client_fax` text,
  `client_mobile` text,
  `client_email` text,
  `client_web` text,
  `client_vat_id` text,
  `client_tax_code` text,
  `client_language` varchar(255) DEFAULT 'system',
  `client_active` int(1) NOT NULL DEFAULT '1',
  `client_surname` varchar(255) DEFAULT NULL,
  `client_avs` varchar(16) DEFAULT NULL,
  `client_insurednumber` varchar(30) DEFAULT NULL,
  `client_veka` varchar(30) DEFAULT NULL,
  `client_birthdate` date DEFAULT NULL,
  `client_gender` int(1) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ip_clients`
--

INSERT INTO `ip_clients` (`client_id`, `client_date_created`, `client_date_modified`, `client_name`, `client_address_1`, `client_address_2`, `client_city`, `client_state`, `client_zip`, `client_country`, `client_phone`, `client_fax`, `client_mobile`, `client_email`, `client_web`, `client_vat_id`, `client_tax_code`, `client_language`, `client_active`, `client_surname`, `client_avs`, `client_insurednumber`, `client_veka`, `client_birthdate`, `client_gender`) VALUES
(1, '2018-03-03 09:55:33', '2018-07-19 14:27:40', 'Jaz Swag Pte Ltd', ' 38 Ang Mo Kio', 'Singapore', 'Test', 'Test', '123456', 'SG', '1234567890', '', '', '', '', '', '', 'system', 1, '', NULL, NULL, NULL, '2018-03-02', 0),
(2, '2018-03-03 20:18:25', '2018-03-03 20:18:25', 'Test', '', '', '', '', '', 'SG', '', '', '', '', '', '', '', 'system', 1, '', NULL, NULL, NULL, '0000-00-00', 0),
(3, '2018-03-03 20:43:24', '2018-03-03 20:43:24', 'A', '', '', '', '', '', 'SG', '', '', '', '', '', '', '', 'system', 1, '', NULL, NULL, NULL, '0000-00-00', 0),
(4, '2018-03-03 20:43:37', '2018-03-03 20:43:37', 'B', '', '', '', '', '', 'SG', '', '', '', '', '', '', '', 'system', 1, '', NULL, NULL, NULL, '0000-00-00', 0),
(5, '2018-03-03 20:43:42', '2018-03-03 20:43:42', 'C', '', '', '', '', '', 'SG', '', '', '', '', '', '', '', 'system', 1, '', NULL, NULL, NULL, '0000-00-00', 0),
(6, '2018-03-03 20:43:48', '2018-03-03 20:43:48', 'D', '', '', '', '', '', 'SG', '', '', '', '', '', '', '', 'system', 1, '', NULL, NULL, NULL, '0000-00-00', 0),
(7, '2018-03-03 20:43:53', '2018-03-03 20:43:53', 'E', '', '', '', '', '', 'SG', '', '', '', '', '', '', '', 'system', 1, '', NULL, NULL, NULL, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ip_client_custom`
--

CREATE TABLE `ip_client_custom` (
  `client_custom_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `client_custom_fieldid` int(11) NOT NULL,
  `client_custom_fieldvalue` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ip_client_notes`
--

CREATE TABLE `ip_client_notes` (
  `client_note_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `client_note_date` date NOT NULL,
  `client_note` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ip_client_notes`
--

INSERT INTO `ip_client_notes` (`client_note_id`, `client_id`, `client_note_date`, `client_note`) VALUES
(1, 2, '2018-03-03', 'asd');

-- --------------------------------------------------------

--
-- Table structure for table `ip_custom_fields`
--

CREATE TABLE `ip_custom_fields` (
  `custom_field_id` int(11) NOT NULL,
  `custom_field_table` varchar(50) DEFAULT NULL,
  `custom_field_label` varchar(50) DEFAULT NULL,
  `custom_field_type` varchar(255) NOT NULL DEFAULT 'TEXT',
  `custom_field_location` int(11) DEFAULT '0',
  `custom_field_order` int(11) DEFAULT '999'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ip_custom_fields`
--

INSERT INTO `ip_custom_fields` (`custom_field_id`, `custom_field_table`, `custom_field_label`, `custom_field_type`, `custom_field_location`, `custom_field_order`) VALUES
(1, 'ip_invoice_custom', 'Notes', 'TEXT', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ip_custom_values`
--

CREATE TABLE `ip_custom_values` (
  `custom_values_id` int(11) NOT NULL,
  `custom_values_field` int(11) NOT NULL,
  `custom_values_value` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ip_email_templates`
--

CREATE TABLE `ip_email_templates` (
  `email_template_id` int(11) NOT NULL,
  `email_template_title` text,
  `email_template_type` varchar(255) DEFAULT NULL,
  `email_template_body` longtext NOT NULL,
  `email_template_subject` text,
  `email_template_from_name` text,
  `email_template_from_email` text,
  `email_template_cc` text,
  `email_template_bcc` text,
  `email_template_pdf_template` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ip_families`
--

CREATE TABLE `ip_families` (
  `family_id` int(11) NOT NULL,
  `family_name` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ip_families`
--

INSERT INTO `ip_families` (`family_id`, `family_name`) VALUES
(1, 'Category 1'),
(2, 'Whiskey');

-- --------------------------------------------------------

--
-- Table structure for table `ip_imports`
--

CREATE TABLE `ip_imports` (
  `import_id` int(11) NOT NULL,
  `import_date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ip_import_details`
--

CREATE TABLE `ip_import_details` (
  `import_detail_id` int(11) NOT NULL,
  `import_id` int(11) NOT NULL,
  `import_lang_key` varchar(35) NOT NULL,
  `import_table_name` varchar(35) NOT NULL,
  `import_record_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ip_invoices`
--

CREATE TABLE `ip_invoices` (
  `invoice_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `invoice_group_id` int(11) NOT NULL,
  `invoice_status_id` tinyint(2) NOT NULL DEFAULT '1',
  `is_read_only` tinyint(1) DEFAULT NULL,
  `invoice_password` varchar(90) DEFAULT NULL,
  `invoice_date_created` date NOT NULL,
  `invoice_time_created` time NOT NULL DEFAULT '00:00:00',
  `invoice_date_modified` datetime NOT NULL,
  `invoice_date_due` date NOT NULL,
  `invoice_number` varchar(100) DEFAULT NULL,
  `invoice_discount_amount` decimal(20,2) DEFAULT NULL,
  `invoice_discount_percent` decimal(20,2) DEFAULT NULL,
  `invoice_terms` longtext NOT NULL,
  `invoice_url_key` char(32) NOT NULL,
  `payment_method` int(11) NOT NULL DEFAULT '0',
  `creditinvoice_parent_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ip_invoices`
--

INSERT INTO `ip_invoices` (`invoice_id`, `user_id`, `client_id`, `invoice_group_id`, `invoice_status_id`, `is_read_only`, `invoice_password`, `invoice_date_created`, `invoice_time_created`, `invoice_date_modified`, `invoice_date_due`, `invoice_number`, `invoice_discount_amount`, `invoice_discount_percent`, `invoice_terms`, `invoice_url_key`, `payment_method`, `creditinvoice_parent_id`) VALUES
(1, 1, 1, 3, 4, 1, '', '2018-03-03', '09:56:44', '2018-03-03 10:02:15', '2018-04-02', '1', '50.00', '0.00', '', 'SF9AbxaDGjI17LNUEX0TnZyCwchutKOs', 1, NULL),
(2, 1, 1, 3, 4, 1, '', '2018-03-03', '10:29:13', '2018-03-03 10:31:43', '2018-04-02', '2', '0.00', '0.00', '', 'fwCavM3WSoIAtU1kKHdGLQ2N49sr7TxE', 1, NULL),
(9, 1, 1, 3, 4, 1, '', '2018-03-04', '01:09:27', '2018-03-18 12:52:29', '2018-04-03', '9', '0.00', '0.00', 'dfsdfsd sdsdfdf sdfdsfsdf', 'VdSUWjXlDoZ5Cqmz4nMbkwfBxhKg1T2N', 1, NULL),
(5, 1, 1, 3, 4, 1, '', '2018-03-03', '13:53:34', '2018-03-03 16:02:16', '2018-03-02', '5', '0.00', '0.00', '', 'zwRaHQrINtmZp4Mi6qV19TYJyjEBfU2A', 2, NULL),
(6, 1, 1, 3, 4, 1, '', '2018-03-02', '15:58:25', '2018-03-04 00:53:42', '2018-03-01', '6', '0.00', '0.00', 'tes test etsttt ', '6jd5xsciOELwnJCAIyKb3e18zhtvXZG4', 1, NULL),
(7, 1, 2, 3, 1, NULL, '', '2018-03-03', '20:38:14', '2018-03-03 20:38:22', '2018-04-02', '7', NULL, NULL, '', 'wry8aiGBMDhA4uj6LoO7JHeYXxtbq15k', 0, NULL),
(8, 1, 2, 3, 4, 1, '', '2018-03-03', '21:47:38', '2018-03-03 21:53:05', '2018-04-02', '8', '0.00', '0.00', '', 'mZcYt8olvDfA90h1gGRyaQTuBOnpw2Ue', 1, NULL),
(10, 1, 1, 3, 4, 1, '', '2018-03-18', '16:01:11', '2018-03-18 16:02:31', '2018-04-17', '10', '0.00', '0.00', '', '1oeS5CWbtZuhRyIAvTaxJz3k9KwB4Yqd', 1, NULL),
(11, 1, 1, 3, 4, 1, '', '2018-03-18', '16:05:33', '2018-03-18 16:06:00', '2018-04-17', '11', '0.00', '0.00', '', 'NoTGHSmkyJ2fUr1pQAPE6tXIBcDOw45j', 1, NULL),
(12, 1, 1, 3, 4, 1, '', '2018-03-18', '16:06:05', '2018-03-18 16:06:18', '2018-04-21', '12', '0.00', '0.00', '', 'bZ7til0Qz9T8BVCAdYjMfywuaXmhNPO1', 1, NULL),
(13, 1, 1, 3, 4, 1, '', '2018-03-18', '16:06:26', '2018-03-18 16:06:45', '2018-04-17', '13', '0.00', '0.00', '', 'PdzecQt7Tq3X6Ynwag2frBW5iGHOsklb', 1, NULL),
(14, 1, 1, 3, 4, 1, '', '2018-03-18', '16:06:48', '2018-03-18 16:06:54', '2018-04-17', '14', '0.00', '0.00', '', 'GdtLZPv2r8NW3EDJO5V4kb7YxBRATeyq', 1, NULL),
(15, 1, 1, 3, 4, 1, '', '2018-03-18', '11:16:26', '2018-03-25 11:18:57', '2018-04-17', '15', '0.00', '0.00', '', 'gUdwBuqp9FA5s0IMP2a4QtzljoTk6xim', 0, 14),
(16, 1, 2, 3, 4, 1, '', '2018-03-25', '11:19:29', '2018-03-25 11:20:41', '2018-04-24', '16', '0.00', '0.00', '', 'az59vSwtlVikMZ6Gf0JB723FrnqQbgdm', 1, NULL),
(17, 1, 2, 3, 4, 1, '', '2018-03-25', '11:21:37', '2018-03-25 11:26:25', '2018-04-24', '17', '0.00', '0.00', '', 'ERHI9C5lQNA8a4MoLrqjiuUYnZ7cOGpe', 1, 16),
(18, 1, 6, 3, 4, 1, '', '2018-03-25', '11:31:47', '2018-03-25 11:33:29', '2018-04-24', '18', '0.00', '0.00', '', 'hpEvcLmZSnkrCDM1awfB0sAxHt3eb9JP', 2, NULL),
(19, 1, 6, 3, 4, 1, '', '2018-03-25', '11:34:42', '2018-03-25 13:00:35', '2018-04-24', '19', '0.00', '0.00', '', 'RnlBApruW9M4J2OigGQfzT7H6qywPkNs', 1, 18),
(20, 1, 2, 3, 4, 1, '', '2018-03-25', '13:02:55', '2018-03-25 13:03:38', '2018-04-24', '20', '0.00', '0.00', '', 'uPFr6dcBpADW3LyXsGmEg0TVCqv748JI', 2, NULL),
(21, 1, 2, 3, 4, 1, '', '2018-03-25', '13:05:06', '2018-03-25 13:06:13', '2018-04-24', '21', '0.00', '0.00', '', 'GBFlMtocXmYSRrEWDTH9Oapxv37IVNgP', 1, 20),
(22, 1, 2, 3, 2, 1, '', '2018-05-14', '14:05:57', '2018-07-20 16:13:30', '2018-06-13', '22', '0.00', '0.00', '', '8rAJjNpELfRFblgPv3ZOBhHe4K1Scd2Y', 0, NULL),
(23, 1, 3, 3, 1, NULL, '', '2018-07-08', '14:48:42', '2018-07-20 14:02:15', '2018-08-07', '23', '0.00', '0.00', '', 'Mwa2y0JuNvRIi9qXzTg3bUtCGeO4VkDr', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ip_invoices_recurring`
--

CREATE TABLE `ip_invoices_recurring` (
  `invoice_recurring_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `recur_start_date` date NOT NULL,
  `recur_end_date` date NOT NULL,
  `recur_frequency` varchar(255) NOT NULL,
  `recur_next_date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ip_invoice_amounts`
--

CREATE TABLE `ip_invoice_amounts` (
  `invoice_amount_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `invoice_sign` enum('1','-1') NOT NULL DEFAULT '1',
  `invoice_item_subtotal` decimal(20,2) DEFAULT NULL,
  `invoice_item_tax_total` decimal(20,2) DEFAULT NULL,
  `invoice_tax_total` decimal(20,2) DEFAULT NULL,
  `invoice_total` decimal(20,2) DEFAULT NULL,
  `invoice_paid` decimal(20,2) DEFAULT NULL,
  `invoice_balance` decimal(20,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ip_invoice_amounts`
--

INSERT INTO `ip_invoice_amounts` (`invoice_amount_id`, `invoice_id`, `invoice_sign`, `invoice_item_subtotal`, `invoice_item_tax_total`, `invoice_tax_total`, `invoice_total`, `invoice_paid`, `invoice_balance`) VALUES
(1, 1, '1', '550.00', '0.00', '0.00', '500.00', '500.00', '0.00'),
(2, 2, '1', '500.00', '0.00', '0.00', '500.00', '500.00', '0.00'),
(9, 9, '1', '1100.00', '0.00', '0.00', '1100.00', '1100.00', '0.00'),
(5, 5, '1', '6.00', '0.00', '0.00', '6.00', '6.00', '0.00'),
(6, 6, '1', '10.00', '0.00', '0.00', '10.00', '10.00', '0.00'),
(7, 7, '1', NULL, NULL, NULL, NULL, NULL, NULL),
(8, 8, '1', '290.00', '0.00', '0.00', '290.00', '290.00', '0.00'),
(10, 10, '1', '160.00', '0.00', '0.00', '160.00', '160.00', '0.00'),
(11, 11, '1', '160.00', '0.00', '0.00', '160.00', '160.00', '0.00'),
(12, 12, '1', '160.00', '0.00', '0.00', '160.00', '160.00', '0.00'),
(13, 13, '1', '160.00', '0.00', '0.00', '160.00', '160.00', '0.00'),
(14, 14, '1', '160.00', '0.00', '0.00', '160.00', '160.00', '0.00'),
(15, 15, '-1', '-160.00', '0.00', '0.00', '-160.00', '0.00', '-160.00'),
(16, 16, '1', '270.00', '0.00', '0.00', '270.00', '270.00', '0.00'),
(17, 17, '-1', '-270.00', '0.00', '0.00', '-270.00', '-270.00', '0.00'),
(18, 18, '1', '110.00', '0.00', '0.00', '110.00', '110.00', '0.00'),
(19, 19, '-1', '-110.00', '0.00', '0.00', '-110.00', '-110.00', '0.00'),
(20, 20, '1', '110.00', '0.00', '0.00', '110.00', '0.00', '110.00'),
(21, 21, '-1', '-110.00', '0.00', '0.00', '-110.00', '-110.00', '0.00'),
(22, 22, '1', '550.00', '0.00', '0.00', '550.00', '0.00', '550.00'),
(23, 23, '1', '160.00', '0.00', '0.00', '160.00', '100.00', '60.00');

-- --------------------------------------------------------

--
-- Table structure for table `ip_invoice_custom`
--

CREATE TABLE `ip_invoice_custom` (
  `invoice_custom_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `invoice_custom_fieldid` int(11) NOT NULL,
  `invoice_custom_fieldvalue` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ip_invoice_custom`
--

INSERT INTO `ip_invoice_custom` (`invoice_custom_id`, `invoice_id`, `invoice_custom_fieldid`, `invoice_custom_fieldvalue`) VALUES
(1, 9, 1, NULL),
(2, 10, 1, NULL),
(3, 11, 1, NULL),
(4, 12, 1, NULL),
(5, 13, 1, NULL),
(6, 14, 1, NULL),
(7, 15, 1, NULL),
(8, 16, 1, NULL),
(9, 17, 1, NULL),
(10, 18, 1, NULL),
(11, 19, 1, NULL),
(12, 20, 1, NULL),
(13, 21, 1, NULL),
(14, 22, 1, NULL),
(15, 23, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ip_invoice_groups`
--

CREATE TABLE `ip_invoice_groups` (
  `invoice_group_id` int(11) NOT NULL,
  `invoice_group_name` text,
  `invoice_group_identifier_format` varchar(255) NOT NULL,
  `invoice_group_next_id` int(11) NOT NULL,
  `invoice_group_left_pad` int(2) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ip_invoice_groups`
--

INSERT INTO `ip_invoice_groups` (`invoice_group_id`, `invoice_group_name`, `invoice_group_identifier_format`, `invoice_group_next_id`, `invoice_group_left_pad`) VALUES
(3, 'Invoice Default', '{{{id}}}', 24, 0),
(4, 'Quote Default', 'QUO{{{id}}}', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ip_invoice_items`
--

CREATE TABLE `ip_invoice_items` (
  `item_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `item_tax_rate_id` int(11) NOT NULL DEFAULT '0',
  `item_product_id` int(11) DEFAULT NULL,
  `item_date_added` date NOT NULL,
  `item_task_id` int(11) DEFAULT NULL,
  `item_name` text,
  `item_description` longtext,
  `item_quantity` decimal(10,2) NOT NULL,
  `item_price` decimal(20,2) DEFAULT NULL,
  `item_discount_amount` decimal(20,2) DEFAULT NULL,
  `item_order` int(2) NOT NULL DEFAULT '0',
  `item_is_recurring` tinyint(1) DEFAULT NULL,
  `item_product_unit` varchar(50) DEFAULT NULL,
  `item_product_unit_id` int(11) DEFAULT NULL,
  `item_date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ip_invoice_items`
--

INSERT INTO `ip_invoice_items` (`item_id`, `invoice_id`, `item_tax_rate_id`, `item_product_id`, `item_date_added`, `item_task_id`, `item_name`, `item_description`, `item_quantity`, `item_price`, `item_discount_amount`, `item_order`, `item_is_recurring`, `item_product_unit`, `item_product_unit_id`, `item_date`) VALUES
(1, 1, 0, 1, '2018-03-03', NULL, 'Black label', '1litre', '10.00', '50.00', NULL, 1, NULL, NULL, NULL, NULL),
(2, 1, 0, 1, '2018-03-03', NULL, 'Black label', '1litre', '1.00', '50.00', NULL, 2, NULL, NULL, NULL, NULL),
(3, 2, 0, 1, '2018-03-03', NULL, 'Black label', '1litre', '10.00', '50.00', NULL, 1, NULL, NULL, NULL, NULL),
(13, 9, 0, 9, '2018-03-07', NULL, 'Test QTY', 'QTY', '10.00', '110.00', NULL, 1, NULL, 'Bottles', 1, NULL),
(6, 6, 0, 5, '2018-03-03', NULL, '3', '3', '7.00', '4.00', '3.00', 1, NULL, NULL, NULL, NULL),
(7, 6, 0, 6, '2018-03-03', NULL, '3', '3', '1.00', '3.00', NULL, 2, NULL, 'Bottle', 1, NULL),
(8, 5, 0, 4, '2018-03-03', NULL, '2', '2', '1.00', '2.00', NULL, 1, NULL, NULL, NULL, NULL),
(9, 5, 0, 5, '2018-03-03', NULL, '3', '3', '1.00', '4.00', NULL, 2, NULL, NULL, NULL, NULL),
(10, 8, 0, 1, '2018-03-03', NULL, 'Black label', '1litre', '5.00', '50.00', NULL, 1, NULL, 'Bottles', 1, NULL),
(11, 8, 0, 7, '2018-03-03', NULL, 'e', 'r', '10.00', '4.00', NULL, 2, NULL, NULL, NULL, NULL),
(14, 10, 0, 1, '2018-03-18', NULL, 'Black label', '1litre', '1.00', '50.00', NULL, 1, NULL, 'Bottle', 1, NULL),
(15, 10, 0, 9, '2018-03-18', NULL, 'Test QTY', 'QTY', '1.00', '110.00', NULL, 2, NULL, 'Bottle', 1, NULL),
(16, 11, 0, 1, '2018-03-18', NULL, 'Black label', '1litre', '1.00', '50.00', NULL, 1, NULL, 'Bottle', 1, NULL),
(17, 11, 0, 9, '2018-03-18', NULL, 'Test QTY', 'QTY', '1.00', '110.00', NULL, 2, NULL, 'Bottle', 1, NULL),
(18, 12, 0, 1, '2018-03-18', NULL, 'Black label', '1litre', '1.00', '50.00', NULL, 1, NULL, 'Bottle', 1, NULL),
(19, 12, 0, 9, '2018-03-18', NULL, 'Test QTY', 'QTY', '1.00', '110.00', NULL, 2, NULL, 'Bottle', 1, NULL),
(20, 13, 0, 1, '2018-03-18', NULL, 'Black label', '1litre', '1.00', '50.00', NULL, 1, NULL, 'Bottle', 1, NULL),
(21, 13, 0, 9, '2018-03-18', NULL, 'Test QTY', 'QTY', '1.00', '110.00', NULL, 2, NULL, 'Bottle', 1, NULL),
(22, 14, 0, 1, '2018-03-18', NULL, 'Black label', '1litre', '1.00', '50.00', NULL, 1, NULL, 'Bottle', 1, NULL),
(23, 14, 0, 9, '2018-03-18', NULL, 'Test QTY', 'QTY', '1.00', '110.00', NULL, 2, NULL, 'Bottle', 1, NULL),
(24, 15, 0, 1, '2018-03-25', NULL, 'Black label', '1litre', '-1.00', '50.00', NULL, 1, NULL, 'Bottle', 1, NULL),
(25, 15, 0, 9, '2018-03-25', NULL, 'Test QTY', 'QTY', '-1.00', '110.00', NULL, 2, NULL, 'Bottle', 1, NULL),
(26, 16, 0, 1, '2018-03-25', NULL, 'Black label', '1litre', '1.00', '50.00', NULL, 1, NULL, 'Bottle', 1, NULL),
(27, 16, 0, 9, '2018-03-25', NULL, 'Test QTY', 'QTY', '2.00', '110.00', NULL, 2, NULL, 'Bottles', 1, NULL),
(28, 17, 0, 1, '2018-03-25', NULL, 'Black label', '1litre', '-1.00', '50.00', NULL, 1, NULL, 'Bottle', 1, NULL),
(29, 17, 0, 9, '2018-03-25', NULL, 'Test QTY', 'QTY', '-2.00', '110.00', NULL, 2, NULL, 'Bottle', 1, NULL),
(30, 18, 0, 9, '2018-03-25', NULL, 'Test QTY', 'QTY', '1.00', '110.00', NULL, 1, NULL, 'Bottle', 1, NULL),
(31, 19, 0, 9, '2018-03-25', NULL, 'Test QTY', 'QTY', '-1.00', '110.00', NULL, 1, NULL, 'Bottle', 1, NULL),
(32, 20, 0, 9, '2018-03-25', NULL, 'Test QTY', 'QTY', '1.00', '110.00', NULL, 1, NULL, 'Bottle', 1, NULL),
(33, 21, 0, 9, '2018-03-25', NULL, 'Test QTY', 'QTY', '-1.00', '110.00', NULL, 1, NULL, 'Bottle', 1, NULL),
(34, 22, 0, 9, '2018-05-14', NULL, 'Test QTY', 'QTY', '5.00', '110.00', NULL, 1, NULL, 'Bottles', 1, NULL),
(35, 23, 0, 9, '2018-07-08', NULL, 'Test QTY', 'QTY', '1.00', '110.00', NULL, 1, NULL, 'Bottle', 1, NULL),
(36, 23, 0, 1, '2018-07-08', NULL, 'Black label', '1litre', '1.00', '50.00', NULL, 2, NULL, 'Bottle', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ip_invoice_item_amounts`
--

CREATE TABLE `ip_invoice_item_amounts` (
  `item_amount_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_subtotal` decimal(20,2) DEFAULT NULL,
  `item_tax_total` decimal(20,2) DEFAULT NULL,
  `item_discount` decimal(20,2) DEFAULT NULL,
  `item_total` decimal(20,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ip_invoice_item_amounts`
--

INSERT INTO `ip_invoice_item_amounts` (`item_amount_id`, `item_id`, `item_subtotal`, `item_tax_total`, `item_discount`, `item_total`) VALUES
(1, 1, '500.00', '0.00', '0.00', '500.00'),
(2, 2, '50.00', '0.00', '0.00', '50.00'),
(3, 3, '500.00', '0.00', '0.00', '500.00'),
(13, 13, '1100.00', '0.00', '0.00', '1100.00'),
(6, 6, '28.00', '0.00', '21.00', '7.00'),
(7, 7, '3.00', '0.00', '0.00', '3.00'),
(8, 8, '2.00', '0.00', '0.00', '2.00'),
(9, 9, '4.00', '0.00', '0.00', '4.00'),
(10, 10, '250.00', '0.00', '0.00', '250.00'),
(11, 11, '40.00', '0.00', '0.00', '40.00'),
(14, 14, '50.00', '0.00', '0.00', '50.00'),
(15, 15, '110.00', '0.00', '0.00', '110.00'),
(16, 16, '50.00', '0.00', '0.00', '50.00'),
(17, 17, '110.00', '0.00', '0.00', '110.00'),
(18, 18, '50.00', '0.00', '0.00', '50.00'),
(19, 19, '110.00', '0.00', '0.00', '110.00'),
(20, 20, '50.00', '0.00', '0.00', '50.00'),
(21, 21, '110.00', '0.00', '0.00', '110.00'),
(22, 22, '50.00', '0.00', '0.00', '50.00'),
(23, 23, '110.00', '0.00', '0.00', '110.00'),
(24, 24, '-50.00', '0.00', '0.00', '-50.00'),
(25, 25, '-110.00', '0.00', '0.00', '-110.00'),
(26, 26, '50.00', '0.00', '0.00', '50.00'),
(27, 27, '220.00', '0.00', '0.00', '220.00'),
(28, 28, '-50.00', '0.00', '0.00', '-50.00'),
(29, 29, '-220.00', '0.00', '0.00', '-220.00'),
(30, 30, '110.00', '0.00', '0.00', '110.00'),
(31, 31, '-110.00', '0.00', '0.00', '-110.00'),
(32, 32, '110.00', '0.00', '0.00', '110.00'),
(33, 33, '-110.00', '0.00', '0.00', '-110.00'),
(34, 34, '550.00', '0.00', '0.00', '550.00'),
(35, 35, '110.00', '0.00', '0.00', '110.00'),
(36, 36, '50.00', '0.00', '0.00', '50.00');

-- --------------------------------------------------------

--
-- Table structure for table `ip_invoice_sumex`
--

CREATE TABLE `ip_invoice_sumex` (
  `sumex_id` int(11) NOT NULL,
  `sumex_invoice` int(11) NOT NULL,
  `sumex_reason` int(11) NOT NULL,
  `sumex_diagnosis` varchar(500) NOT NULL,
  `sumex_observations` varchar(500) NOT NULL,
  `sumex_treatmentstart` date NOT NULL,
  `sumex_treatmentend` date NOT NULL,
  `sumex_casedate` date NOT NULL,
  `sumex_casenumber` varchar(35) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ip_invoice_tax_rates`
--

CREATE TABLE `ip_invoice_tax_rates` (
  `invoice_tax_rate_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `tax_rate_id` int(11) NOT NULL,
  `include_item_tax` int(1) NOT NULL DEFAULT '0',
  `invoice_tax_rate_amount` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ip_item_lookups`
--

CREATE TABLE `ip_item_lookups` (
  `item_lookup_id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL DEFAULT '',
  `item_description` longtext NOT NULL,
  `item_price` decimal(10,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ip_merchant_responses`
--

CREATE TABLE `ip_merchant_responses` (
  `merchant_response_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `merchant_response_successful` tinyint(1) DEFAULT '1',
  `merchant_response_date` date NOT NULL,
  `merchant_response_driver` varchar(35) NOT NULL,
  `merchant_response` varchar(255) NOT NULL,
  `merchant_response_reference` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ip_payments`
--

CREATE TABLE `ip_payments` (
  `payment_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `payment_method_id` int(11) NOT NULL DEFAULT '0',
  `payment_date` date NOT NULL,
  `payment_amount` decimal(20,2) DEFAULT NULL,
  `payment_note` longtext NOT NULL,
  `received_manager` varchar(2) NOT NULL,
  `received_admin` varchar(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ip_payments`
--

INSERT INTO `ip_payments` (`payment_id`, `invoice_id`, `payment_method_id`, `payment_date`, `payment_amount`, `payment_note`, `received_manager`, `received_admin`) VALUES
(1, 1, 1, '2018-03-03', '400.00', 'Partial payment', '', ''),
(2, 1, 1, '2018-03-03', '100.00', '', '', ''),
(3, 6, 1, '2018-03-13', '10.00', '', '', ''),
(4, 5, 2, '2018-03-18', '5.00', '', '', ''),
(5, 14, 1, '2018-03-18', '160.00', '', '', ''),
(6, 13, 1, '2018-03-18', '160.00', '', '', ''),
(11, 11, 1, '2018-03-24', '100.00', 'sdasd', '', ''),
(8, 11, 1, '2018-03-18', '60.00', '', '', ''),
(9, 8, 1, '2018-03-24', '290.00', '', '', ''),
(10, 10, 1, '2018-03-24', '160.00', '', '', ''),
(12, 5, 2, '2018-03-24', '1.00', '', '', ''),
(13, 2, 1, '2018-03-24', '500.00', '', '1', '1'),
(14, 9, 1, '2018-03-24', '123.00', '', '1', '1'),
(15, 16, 1, '2018-03-25', '270.00', '', '1', '1'),
(17, 18, 2, '2018-03-25', '110.00', '', '1', '1'),
(18, 19, 1, '2018-03-25', '-110.00', '', '', ''),
(19, 20, 2, '2018-03-25', '0.00', '', '', ''),
(20, 21, 1, '2018-03-25', '-110.00', '', '', ''),
(21, 12, 1, '2018-04-16', '160.00', '', '', ''),
(22, 9, 1, '2018-04-16', '977.00', '', '', ''),
(23, 17, 1, '2018-04-16', '-270.00', '', '', ''),
(24, 23, 1, '2018-07-13', '100.00', '100 $ paid by cash', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `ip_payment_custom`
--

CREATE TABLE `ip_payment_custom` (
  `payment_custom_id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `payment_custom_fieldid` int(11) NOT NULL,
  `payment_custom_fieldvalue` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ip_payment_methods`
--

CREATE TABLE `ip_payment_methods` (
  `payment_method_id` int(11) NOT NULL,
  `payment_method_name` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ip_payment_methods`
--

INSERT INTO `ip_payment_methods` (`payment_method_id`, `payment_method_name`) VALUES
(1, 'Cash'),
(2, 'Cheque');

-- --------------------------------------------------------

--
-- Table structure for table `ip_products`
--

CREATE TABLE `ip_products` (
  `product_id` int(11) NOT NULL,
  `family_id` int(11) DEFAULT NULL,
  `product_sku` text,
  `product_name` text,
  `product_description` longtext NOT NULL,
  `product_price` decimal(20,2) DEFAULT NULL,
  `product_qty` int(50) NOT NULL,
  `purchase_price` decimal(20,2) DEFAULT NULL,
  `provider_name` text,
  `tax_rate_id` int(11) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `product_tariff` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ip_products`
--

INSERT INTO `ip_products` (`product_id`, `family_id`, `product_sku`, `product_name`, `product_description`, `product_price`, `product_qty`, `purchase_price`, `provider_name`, `tax_rate_id`, `unit_id`, `product_tariff`) VALUES
(1, 1, '1234567', 'Black label', '1litre', '50.00', 4, NULL, '', NULL, 1, 0),
(9, 1, '342343', 'Test QTY', 'QTY', '110.00', 11, NULL, '', NULL, 1, 0),
(10, 2, '456789', 'Red Label', '1 litre', '250.00', 0, NULL, '', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ip_products_stock`
--

CREATE TABLE `ip_products_stock` (
  `stock_id` int(11) NOT NULL,
  `stock_product_id` int(11) NOT NULL,
  `stock_open_qty` int(11) NOT NULL,
  `stock_qty` int(11) NOT NULL,
  `stock_suppliers_id` int(11) NOT NULL,
  `stock_create_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ip_products_stock`
--

INSERT INTO `ip_products_stock` (`stock_id`, `stock_product_id`, `stock_open_qty`, `stock_qty`, `stock_suppliers_id`, `stock_create_date`) VALUES
(1, 9, 12, 2, 1, '2018-05-14'),
(2, 9, 25, 50, 1, '2018-05-23');

-- --------------------------------------------------------

--
-- Table structure for table `ip_projects`
--

CREATE TABLE `ip_projects` (
  `project_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `project_name` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ip_projects`
--

INSERT INTO `ip_projects` (`project_id`, `client_id`, `project_name`) VALUES
(1, 1, 'wed'),
(2, 0, 'Electricity');

-- --------------------------------------------------------

--
-- Table structure for table `ip_quotes`
--

CREATE TABLE `ip_quotes` (
  `quote_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `invoice_group_id` int(11) NOT NULL,
  `quote_status_id` tinyint(2) NOT NULL DEFAULT '1',
  `quote_date_created` date NOT NULL,
  `quote_date_modified` datetime NOT NULL,
  `quote_date_expires` date NOT NULL,
  `quote_number` varchar(100) DEFAULT NULL,
  `quote_discount_amount` decimal(20,2) DEFAULT NULL,
  `quote_discount_percent` decimal(20,2) DEFAULT NULL,
  `quote_url_key` char(32) NOT NULL,
  `quote_password` varchar(90) DEFAULT NULL,
  `notes` longtext
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ip_quotes`
--

INSERT INTO `ip_quotes` (`quote_id`, `invoice_id`, `user_id`, `client_id`, `invoice_group_id`, `quote_status_id`, `quote_date_created`, `quote_date_modified`, `quote_date_expires`, `quote_number`, `quote_discount_amount`, `quote_discount_percent`, `quote_url_key`, `quote_password`, `notes`) VALUES
(1, 3, 1, 1, 4, 4, '2018-03-03', '2018-03-03 10:39:52', '2018-03-18', 'QUO1', '0.00', '0.00', 'HdRpDoQyPW06IuNTqjLJl1waetMEAZgb', '', ''),
(2, 0, 1, 2, 4, 2, '2018-03-03', '2018-03-03 20:37:18', '2018-03-18', 'QUO2', '0.00', '0.00', 'fPWhJSogmH1rpqEOFd6jtwkv8ZG0AUCc', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `ip_quote_amounts`
--

CREATE TABLE `ip_quote_amounts` (
  `quote_amount_id` int(11) NOT NULL,
  `quote_id` int(11) NOT NULL,
  `quote_item_subtotal` decimal(20,2) DEFAULT NULL,
  `quote_item_tax_total` decimal(20,2) DEFAULT NULL,
  `quote_tax_total` decimal(20,2) DEFAULT NULL,
  `quote_total` decimal(20,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ip_quote_amounts`
--

INSERT INTO `ip_quote_amounts` (`quote_amount_id`, `quote_id`, `quote_item_subtotal`, `quote_item_tax_total`, `quote_tax_total`, `quote_total`) VALUES
(1, 1, '50.00', '0.00', '0.00', '50.00'),
(2, 2, '10.00', '0.00', '0.00', '10.00');

-- --------------------------------------------------------

--
-- Table structure for table `ip_quote_custom`
--

CREATE TABLE `ip_quote_custom` (
  `quote_custom_id` int(11) NOT NULL,
  `quote_id` int(11) NOT NULL,
  `quote_custom_fieldid` int(11) NOT NULL,
  `quote_custom_fieldvalue` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ip_quote_items`
--

CREATE TABLE `ip_quote_items` (
  `item_id` int(11) NOT NULL,
  `quote_id` int(11) NOT NULL,
  `item_tax_rate_id` int(11) NOT NULL,
  `item_product_id` int(11) DEFAULT NULL,
  `item_date_added` date NOT NULL,
  `item_name` text,
  `item_description` text,
  `item_quantity` decimal(20,2) DEFAULT NULL,
  `item_price` decimal(20,2) DEFAULT NULL,
  `item_discount_amount` decimal(20,2) DEFAULT NULL,
  `item_order` int(2) NOT NULL DEFAULT '0',
  `item_product_unit` varchar(50) DEFAULT NULL,
  `item_product_unit_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ip_quote_items`
--

INSERT INTO `ip_quote_items` (`item_id`, `quote_id`, `item_tax_rate_id`, `item_product_id`, `item_date_added`, `item_name`, `item_description`, `item_quantity`, `item_price`, `item_discount_amount`, `item_order`, `item_product_unit`, `item_product_unit_id`) VALUES
(1, 1, 0, 1, '2018-03-03', 'Black label', '1litre', '1.00', '50.00', NULL, 1, NULL, NULL),
(2, 2, 0, 4, '2018-03-03', '2', '2', '10.00', '2.00', '1.00', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ip_quote_item_amounts`
--

CREATE TABLE `ip_quote_item_amounts` (
  `item_amount_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_subtotal` decimal(20,2) DEFAULT NULL,
  `item_tax_total` decimal(20,2) DEFAULT NULL,
  `item_discount` decimal(20,2) DEFAULT NULL,
  `item_total` decimal(20,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ip_quote_item_amounts`
--

INSERT INTO `ip_quote_item_amounts` (`item_amount_id`, `item_id`, `item_subtotal`, `item_tax_total`, `item_discount`, `item_total`) VALUES
(1, 1, '50.00', '0.00', '0.00', '50.00'),
(2, 2, '20.00', '0.00', '10.00', '10.00');

-- --------------------------------------------------------

--
-- Table structure for table `ip_quote_tax_rates`
--

CREATE TABLE `ip_quote_tax_rates` (
  `quote_tax_rate_id` int(11) NOT NULL,
  `quote_id` int(11) NOT NULL,
  `tax_rate_id` int(11) NOT NULL,
  `include_item_tax` int(1) NOT NULL DEFAULT '0',
  `quote_tax_rate_amount` decimal(20,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ip_sessions`
--

CREATE TABLE `ip_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ip_settings`
--

CREATE TABLE `ip_settings` (
  `setting_id` int(11) NOT NULL,
  `setting_key` varchar(50) NOT NULL,
  `setting_value` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ip_settings`
--

INSERT INTO `ip_settings` (`setting_id`, `setting_key`, `setting_value`) VALUES
(19, 'default_language', 'english'),
(20, 'date_format', 'm/d/Y'),
(21, 'currency_symbol', '$'),
(22, 'currency_symbol_placement', 'before'),
(23, 'currency_code', 'SGD'),
(24, 'invoices_due_after', '30'),
(25, 'quotes_expire_after', '15'),
(26, 'default_invoice_group', '3'),
(27, 'default_quote_group', '4'),
(28, 'thousands_separator', ','),
(29, 'decimal_point', '.'),
(30, 'cron_key', 'eFGgLbvQmxqNpnha'),
(31, 'tax_rate_decimal_places', '2'),
(32, 'pdf_invoice_template', 'InvoicePlane'),
(33, 'pdf_invoice_template_paid', 'InvoicePlane - officecopy'),
(34, 'pdf_invoice_template_overdue', 'InvoicePlane - overdue'),
(35, 'pdf_quote_template', 'InvoicePlane'),
(36, 'public_invoice_template', 'InvoicePlane_Web'),
(37, 'public_quote_template', 'InvoicePlane_Web'),
(38, 'disable_sidebar', '1'),
(39, 'read_only_toggle', '3'),
(40, 'invoice_pre_password', ''),
(41, 'quote_pre_password', ''),
(42, 'email_pdf_attachment', '1'),
(43, 'generate_invoice_number_for_draft', '1'),
(44, 'generate_quote_number_for_draft', '1'),
(45, 'sumex', '0'),
(46, 'sumex_sliptype', '1'),
(47, 'sumex_canton', '0'),
(48, 'system_theme', 'invoiceplane'),
(49, 'default_hourly_rate', '0.00'),
(50, 'projects_enabled', '1'),
(51, 'pdf_quote_footer', ''),
(52, 'enable_permissive_search_clients', '1'),
(53, 'first_day_of_week', '0'),
(54, 'default_country', 'SG'),
(55, 'default_list_limit', '15'),
(56, 'quote_overview_period', 'this-month'),
(57, 'invoice_overview_period', 'this-month'),
(58, 'disable_quickactions', '0'),
(59, 'custom_title', 'Our Times'),
(60, 'monospace_amounts', '0'),
(61, 'reports_in_new_tab', '1'),
(62, 'bcc_mails_to_admin', '0'),
(63, 'default_invoice_terms', ''),
(64, 'invoice_default_payment_method', ''),
(65, 'mark_invoices_sent_pdf', '1'),
(66, 'pdf_watermark', '0'),
(67, 'include_zugferd', '0'),
(68, 'email_invoice_template', ''),
(69, 'email_invoice_template_paid', ''),
(70, 'email_invoice_template_overdue', ''),
(71, 'pdf_invoice_footer', ''),
(72, 'automatic_email_on_recur', '0'),
(73, 'sumex_role', '0'),
(74, 'sumex_place', '0'),
(75, 'mark_quotes_sent_pdf', '0'),
(76, 'default_quote_notes', ''),
(77, 'email_quote_template', ''),
(78, 'default_invoice_tax_rate', ''),
(79, 'default_include_item_tax', ''),
(80, 'default_item_tax_rate', ''),
(81, 'email_send_method', ''),
(82, 'smtp_server_address', ''),
(83, 'smtp_mail_from', ''),
(84, 'smtp_authentication', '0'),
(85, 'smtp_username', ''),
(86, 'smtp_port', ''),
(87, 'smtp_security', ''),
(88, 'smtp_verify_certs', '1'),
(89, 'enable_online_payments', '0'),
(90, 'gateway_authorizenet_aim_enabled', '0'),
(91, 'gateway_authorizenet_aim_apiLoginId', ''),
(92, 'gateway_authorizenet_aim_transactionKey', ''),
(93, 'gateway_authorizenet_aim_testMode', '0'),
(94, 'gateway_authorizenet_aim_developerMode', '0'),
(95, 'gateway_authorizenet_aim_currency', 'ARS'),
(96, 'gateway_authorizenet_aim_payment_method', ''),
(97, 'gateway_authorizenet_sim_enabled', '0'),
(98, 'gateway_authorizenet_sim_apiLoginId', ''),
(99, 'gateway_authorizenet_sim_transactionKey', ''),
(100, 'gateway_authorizenet_sim_testMode', '0'),
(101, 'gateway_authorizenet_sim_developerMode', '0'),
(102, 'gateway_authorizenet_sim_currency', 'ARS'),
(103, 'gateway_authorizenet_sim_payment_method', ''),
(104, 'gateway_buckaroo_ideal_enabled', '0'),
(105, 'gateway_buckaroo_ideal_websiteKey', ''),
(106, 'gateway_buckaroo_ideal_testMode', '0'),
(107, 'gateway_buckaroo_ideal_currency', 'ARS'),
(108, 'gateway_buckaroo_ideal_payment_method', ''),
(109, 'gateway_buckaroo_paypal_enabled', '0'),
(110, 'gateway_buckaroo_paypal_websiteKey', ''),
(111, 'gateway_buckaroo_paypal_testMode', '0'),
(112, 'gateway_buckaroo_paypal_currency', 'ARS'),
(113, 'gateway_buckaroo_paypal_payment_method', ''),
(114, 'gateway_cardsave_enabled', '0'),
(115, 'gateway_cardsave_merchantId', ''),
(116, 'gateway_cardsave_currency', 'ARS'),
(117, 'gateway_cardsave_payment_method', ''),
(118, 'gateway_coinbase_enabled', '0'),
(119, 'gateway_coinbase_apiKey', ''),
(120, 'gateway_coinbase_accountId', ''),
(121, 'gateway_coinbase_currency', 'ARS'),
(122, 'gateway_coinbase_payment_method', ''),
(123, 'gateway_eway_rapid_enabled', '0'),
(124, 'gateway_eway_rapid_apiKey', ''),
(125, 'gateway_eway_rapid_testMode', '0'),
(126, 'gateway_eway_rapid_currency', 'ARS'),
(127, 'gateway_eway_rapid_payment_method', ''),
(128, 'gateway_firstdata_connect_enabled', '0'),
(129, 'gateway_firstdata_connect_storeId', ''),
(130, 'gateway_firstdata_connect_testMode', '0'),
(131, 'gateway_firstdata_connect_currency', 'ARS'),
(132, 'gateway_firstdata_connect_payment_method', ''),
(133, 'gateway_gocardless_enabled', '0'),
(134, 'gateway_gocardless_appId', ''),
(135, 'gateway_gocardless_merchantId', ''),
(136, 'gateway_gocardless_accessToken', ''),
(137, 'gateway_gocardless_testMode', '0'),
(138, 'gateway_gocardless_currency', 'ARS'),
(139, 'gateway_gocardless_payment_method', ''),
(140, 'gateway_migs_threeparty_enabled', '0'),
(141, 'gateway_migs_threeparty_merchantId', ''),
(142, 'gateway_migs_threeparty_merchantAccessCode', ''),
(143, 'gateway_migs_threeparty_secureHash', ''),
(144, 'gateway_migs_threeparty_currency', 'ARS'),
(145, 'gateway_migs_threeparty_payment_method', ''),
(146, 'gateway_migs_twoparty_enabled', '0'),
(147, 'gateway_migs_twoparty_merchantId', ''),
(148, 'gateway_migs_twoparty_merchantAccessCode', ''),
(149, 'gateway_migs_twoparty_secureHash', ''),
(150, 'gateway_migs_twoparty_currency', 'ARS'),
(151, 'gateway_migs_twoparty_payment_method', ''),
(152, 'gateway_mollie_enabled', '0'),
(153, 'gateway_mollie_apiKey', ''),
(154, 'gateway_mollie_currency', 'ARS'),
(155, 'gateway_mollie_payment_method', ''),
(156, 'gateway_multisafepay_enabled', '0'),
(157, 'gateway_multisafepay_accountId', ''),
(158, 'gateway_multisafepay_siteId', ''),
(159, 'gateway_multisafepay_siteCode', ''),
(160, 'gateway_multisafepay_testMode', '0'),
(161, 'gateway_multisafepay_currency', 'ARS'),
(162, 'gateway_multisafepay_payment_method', ''),
(163, 'gateway_netaxept_enabled', '0'),
(164, 'gateway_netaxept_merchantId', ''),
(165, 'gateway_netaxept_testMode', '0'),
(166, 'gateway_netaxept_currency', 'ARS'),
(167, 'gateway_netaxept_payment_method', ''),
(168, 'gateway_netbanx_enabled', '0'),
(169, 'gateway_netbanx_accountNumber', ''),
(170, 'gateway_netbanx_storeId', ''),
(171, 'gateway_netbanx_testMode', '0'),
(172, 'gateway_netbanx_currency', 'ARS'),
(173, 'gateway_netbanx_payment_method', ''),
(174, 'gateway_payfast_enabled', '0'),
(175, 'gateway_payfast_merchantId', ''),
(176, 'gateway_payfast_merchantKey', ''),
(177, 'gateway_payfast_pdtKey', ''),
(178, 'gateway_payfast_testMode', '0'),
(179, 'gateway_payfast_currency', 'ARS'),
(180, 'gateway_payfast_payment_method', ''),
(181, 'gateway_payflow_pro_enabled', '0'),
(182, 'gateway_payflow_pro_username', ''),
(183, 'gateway_payflow_pro_vendor', ''),
(184, 'gateway_payflow_pro_partner', ''),
(185, 'gateway_payflow_pro_testMode', '0'),
(186, 'gateway_payflow_pro_currency', 'ARS'),
(187, 'gateway_payflow_pro_payment_method', ''),
(188, 'gateway_paymentexpress_pxpay_enabled', '0'),
(189, 'gateway_paymentexpress_pxpay_username', ''),
(190, 'gateway_paymentexpress_pxpay_pxPostUsername', ''),
(191, 'gateway_paymentexpress_pxpay_testMode', '0'),
(192, 'gateway_paymentexpress_pxpay_currency', 'ARS'),
(193, 'gateway_paymentexpress_pxpay_payment_method', ''),
(194, 'gateway_paymentexpress_pxpost_enabled', '0'),
(195, 'gateway_paymentexpress_pxpost_username', ''),
(196, 'gateway_paymentexpress_pxpost_testMode', '0'),
(197, 'gateway_paymentexpress_pxpost_currency', 'ARS'),
(198, 'gateway_paymentexpress_pxpost_payment_method', ''),
(199, 'gateway_paypal_express_enabled', '0'),
(200, 'gateway_paypal_express_username', ''),
(201, 'gateway_paypal_express_testMode', '0'),
(202, 'gateway_paypal_express_currency', 'ARS'),
(203, 'gateway_paypal_express_payment_method', ''),
(204, 'gateway_paypal_pro_enabled', '0'),
(205, 'gateway_paypal_pro_username', ''),
(206, 'gateway_paypal_pro_signature', ''),
(207, 'gateway_paypal_pro_testMode', '0'),
(208, 'gateway_paypal_pro_currency', 'ARS'),
(209, 'gateway_paypal_pro_payment_method', ''),
(210, 'gateway_pin_enabled', '0'),
(211, 'gateway_pin_testMode', '0'),
(212, 'gateway_pin_currency', 'ARS'),
(213, 'gateway_pin_payment_method', ''),
(214, 'gateway_sagepay_direct_enabled', '0'),
(215, 'gateway_sagepay_direct_vendor', ''),
(216, 'gateway_sagepay_direct_testMode', '0'),
(217, 'gateway_sagepay_direct_referrerId', ''),
(218, 'gateway_sagepay_direct_currency', 'ARS'),
(219, 'gateway_sagepay_direct_payment_method', ''),
(220, 'gateway_sagepay_server_enabled', '0'),
(221, 'gateway_sagepay_server_vendor', ''),
(222, 'gateway_sagepay_server_testMode', '0'),
(223, 'gateway_sagepay_server_referrerId', ''),
(224, 'gateway_sagepay_server_currency', 'ARS'),
(225, 'gateway_sagepay_server_payment_method', ''),
(226, 'gateway_securepay_directpost_enabled', '0'),
(227, 'gateway_securepay_directpost_merchantId', ''),
(228, 'gateway_securepay_directpost_testMode', '0'),
(229, 'gateway_securepay_directpost_currency', 'ARS'),
(230, 'gateway_securepay_directpost_payment_method', ''),
(231, 'gateway_stripe_enabled', '0'),
(232, 'gateway_stripe_currency', 'ARS'),
(233, 'gateway_stripe_payment_method', ''),
(234, 'gateway_targetpay_directebanking_enabled', '0'),
(235, 'gateway_targetpay_directebanking_subAccountId', ''),
(236, 'gateway_targetpay_directebanking_currency', 'ARS'),
(237, 'gateway_targetpay_directebanking_payment_method', ''),
(238, 'gateway_targetpay_ideal_enabled', '0'),
(239, 'gateway_targetpay_ideal_subAccountId', ''),
(240, 'gateway_targetpay_ideal_currency', 'ARS'),
(241, 'gateway_targetpay_ideal_payment_method', ''),
(242, 'gateway_targetpay_mrcash_enabled', '0'),
(243, 'gateway_targetpay_mrcash_subAccountId', ''),
(244, 'gateway_targetpay_mrcash_currency', 'ARS'),
(245, 'gateway_targetpay_mrcash_payment_method', ''),
(246, 'gateway_twocheckout_enabled', '0'),
(247, 'gateway_twocheckout_accountNumber', ''),
(248, 'gateway_twocheckout_testMode', '0'),
(249, 'gateway_twocheckout_currency', 'ARS'),
(250, 'gateway_twocheckout_payment_method', ''),
(251, 'gateway_worldpay_enabled', '0'),
(252, 'gateway_worldpay_installationId', ''),
(253, 'gateway_worldpay_accountId', ''),
(254, 'gateway_worldpay_testMode', '0'),
(255, 'gateway_worldpay_currency', 'ARS'),
(256, 'gateway_worldpay_payment_method', ''),
(257, 'login_logo', 'logo.jpg'),
(258, 'invoice_logo', 'logo1.jpg'),
(259, 'pdf_invoice_template_customer', 'InvoicePlane - customercopy');

-- --------------------------------------------------------

--
-- Table structure for table `ip_suppliers`
--

CREATE TABLE `ip_suppliers` (
  `supplier_id` int(11) NOT NULL,
  `supplier_date_created` datetime NOT NULL,
  `supplier_date_modified` datetime NOT NULL,
  `supplier_name` text,
  `supplier_address_1` text,
  `supplier_address_2` text,
  `supplier_city` text,
  `supplier_state` text,
  `supplier_zip` text,
  `supplier_country` text,
  `supplier_phone` text,
  `supplier_fax` text,
  `supplier_mobile` text,
  `supplier_email` text,
  `supplier_web` text,
  `supplier_active` int(1) NOT NULL DEFAULT '1',
  `supplier_contact_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ip_suppliers`
--

INSERT INTO `ip_suppliers` (`supplier_id`, `supplier_date_created`, `supplier_date_modified`, `supplier_name`, `supplier_address_1`, `supplier_address_2`, `supplier_city`, `supplier_state`, `supplier_zip`, `supplier_country`, `supplier_phone`, `supplier_fax`, `supplier_mobile`, `supplier_email`, `supplier_web`, `supplier_active`, `supplier_contact_name`) VALUES
(1, '2018-05-14 14:00:14', '2018-05-14 14:00:14', 'Test', 'ewewe', 'wewe', 'wewe', 'wewe', 'wew', 'SG', '', '', '', '', '', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ip_tasks`
--

CREATE TABLE `ip_tasks` (
  `task_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `task_name` text,
  `task_description` longtext NOT NULL,
  `task_price` decimal(20,2) DEFAULT NULL,
  `task_finish_date` date NOT NULL,
  `task_status` tinyint(1) NOT NULL,
  `tax_rate_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ip_tax_rates`
--

CREATE TABLE `ip_tax_rates` (
  `tax_rate_id` int(11) NOT NULL,
  `tax_rate_name` text,
  `tax_rate_percent` decimal(5,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ip_units`
--

CREATE TABLE `ip_units` (
  `unit_id` int(11) NOT NULL,
  `unit_name` varchar(50) DEFAULT NULL,
  `unit_name_plrl` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ip_units`
--

INSERT INTO `ip_units` (`unit_id`, `unit_name`, `unit_name_plrl`) VALUES
(1, 'Bottle', 'Bottles');

-- --------------------------------------------------------

--
-- Table structure for table `ip_uploads`
--

CREATE TABLE `ip_uploads` (
  `upload_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `url_key` char(32) NOT NULL,
  `file_name_original` longtext NOT NULL,
  `file_name_new` longtext NOT NULL,
  `uploaded_date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ip_uploads`
--

INSERT INTO `ip_uploads` (`upload_id`, `client_id`, `url_key`, `file_name_original`, `file_name_new`, `uploaded_date`) VALUES
(1, 1, 'fwCavM3WSoIAtU1kKHdGLQ2N49sr7TxE', 'IMG-20180302-WA0002.jpg', 'fwCavM3WSoIAtU1kKHdGLQ2N49sr7TxE_IMG-20180302-WA0002.jpg', '2018-03-03');

-- --------------------------------------------------------

--
-- Table structure for table `ip_users`
--

CREATE TABLE `ip_users` (
  `user_id` int(11) NOT NULL,
  `user_type` int(1) NOT NULL DEFAULT '0',
  `user_active` tinyint(1) DEFAULT '1',
  `user_date_created` datetime NOT NULL,
  `user_date_modified` datetime NOT NULL,
  `user_language` varchar(255) DEFAULT 'system',
  `user_name` text,
  `user_company` text,
  `user_address_1` text,
  `user_address_2` text,
  `user_city` text,
  `user_state` text,
  `user_zip` text,
  `user_country` text,
  `user_phone` text,
  `user_fax` text,
  `user_mobile` text,
  `user_email` text,
  `user_password` varchar(60) NOT NULL,
  `user_web` text,
  `user_vat_id` text,
  `user_tax_code` text,
  `user_psalt` text,
  `user_all_clients` int(1) NOT NULL DEFAULT '0',
  `user_passwordreset_token` varchar(100) DEFAULT '',
  `user_subscribernumber` varchar(40) DEFAULT NULL,
  `user_iban` varchar(34) DEFAULT NULL,
  `user_gln` bigint(13) DEFAULT NULL,
  `user_rcc` varchar(7) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ip_users`
--

INSERT INTO `ip_users` (`user_id`, `user_type`, `user_active`, `user_date_created`, `user_date_modified`, `user_language`, `user_name`, `user_company`, `user_address_1`, `user_address_2`, `user_city`, `user_state`, `user_zip`, `user_country`, `user_phone`, `user_fax`, `user_mobile`, `user_email`, `user_password`, `user_web`, `user_vat_id`, `user_tax_code`, `user_psalt`, `user_all_clients`, `user_passwordreset_token`, `user_subscribernumber`, `user_iban`, `user_gln`, `user_rcc`) VALUES
(1, 1, 1, '2018-03-01 23:58:12', '2018-03-03 10:59:37', 'system', 'Client', '', '', '', '', '', '', 'SG', '', '', '', 'mpmadhuranga@gmail.com', '$2a$10$cca6917a202598f438cf1uyMITeWL91gpc5llgeu3U1eLRzzCTKQ6', '', '', '', 'cca6917a202598f438cf12', 0, '', '', '', NULL, NULL),
(2, 2, 1, '2018-03-03 11:02:21', '2018-03-03 11:03:18', 'system', 'Test ', 'test', '', '', '', '', '', 'SG', '', '', '', 'test@test.com', '$2a$10$c78bfe64200c034aa1f94Oywu6I57uDmYHKQeHA1a2NO4myjU56gC', '', '', '', 'c78bfe64200c034aa1f94c', 0, '', '', '', NULL, NULL),
(3, 2, 1, '2018-07-11 11:55:50', '2018-07-11 11:58:50', 'system', 'lahiru', 'lahiru', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'wlahirusandaruwan@gmail.com', '$2a$10$c8e54ff6ae387ec595020ez7EbyYcxyO1pzOgQsQNlXwXwQrS.Ona', NULL, NULL, NULL, 'c8e54ff6ae387ec595020e', 0, '41bb6b4a4ab131221ad3c2e90b600055', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ip_user_clients`
--

CREATE TABLE `ip_user_clients` (
  `user_client_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ip_user_clients`
--

INSERT INTO `ip_user_clients` (`user_client_id`, `user_id`, `client_id`) VALUES
(1, 2, 1),
(2, 2, 5),
(3, 2, 4),
(4, 2, 2),
(5, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ip_user_custom`
--

CREATE TABLE `ip_user_custom` (
  `user_custom_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_custom_fieldid` int(11) NOT NULL,
  `user_custom_fieldvalue` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ip_versions`
--

CREATE TABLE `ip_versions` (
  `version_id` int(11) NOT NULL,
  `version_date_applied` varchar(14) NOT NULL,
  `version_file` varchar(45) NOT NULL,
  `version_sql_errors` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ip_versions`
--

INSERT INTO `ip_versions` (`version_id`, `version_date_applied`, `version_file`, `version_sql_errors`) VALUES
(1, '1519919815', '000_1.0.0.sql', 0),
(2, '1519919818', '001_1.0.1.sql', 0),
(3, '1519919818', '002_1.0.2.sql', 0),
(4, '1519919819', '003_1.1.0.sql', 0),
(5, '1519919819', '004_1.1.1.sql', 0),
(6, '1519919819', '005_1.1.2.sql', 0),
(7, '1519919819', '006_1.2.0.sql', 0),
(8, '1519919819', '007_1.2.1.sql', 0),
(9, '1519919819', '008_1.3.0.sql', 0),
(10, '1519919819', '009_1.3.1.sql', 0),
(11, '1519919819', '010_1.3.2.sql', 0),
(12, '1519919819', '011_1.3.3.sql', 0),
(13, '1519919820', '012_1.4.0.sql', 0),
(14, '1519919820', '013_1.4.1.sql', 0),
(15, '1519919820', '014_1.4.2.sql', 0),
(16, '1519919820', '015_1.4.3.sql', 0),
(17, '1519919820', '016_1.4.4.sql', 0),
(18, '1519919820', '017_1.4.5.sql', 0),
(19, '1519919820', '018_1.4.6.sql', 0),
(20, '1519919824', '019_1.4.7.sql', 0),
(21, '1519919827', '020_1.4.8.sql', 0),
(22, '1519919827', '021_1.4.9.sql', 0),
(23, '1519919827', '022_1.4.10.sql', 0),
(24, '1519919828', '023_1.5.0.sql', 0),
(25, '1519919832', '024_1.5.1.sql', 0),
(26, '1519919832', '025_1.5.2.sql', 0),
(27, '1519919832', '026_1.5.3.sql', 0),
(28, '1519919832', '027_1.5.4.sql', 0),
(29, '1519919832', '028_1.5.5.sql', 0),
(30, '1519919832', '029_1.5.6.sql', 0),
(31, '1519919832', '030_1.5.7.sql', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ip_clients`
--
ALTER TABLE `ip_clients`
  ADD PRIMARY KEY (`client_id`),
  ADD KEY `client_active` (`client_active`);

--
-- Indexes for table `ip_client_custom`
--
ALTER TABLE `ip_client_custom`
  ADD PRIMARY KEY (`client_custom_id`),
  ADD UNIQUE KEY `client_id` (`client_id`,`client_custom_fieldid`);

--
-- Indexes for table `ip_client_notes`
--
ALTER TABLE `ip_client_notes`
  ADD PRIMARY KEY (`client_note_id`),
  ADD KEY `client_id` (`client_id`,`client_note_date`);

--
-- Indexes for table `ip_custom_fields`
--
ALTER TABLE `ip_custom_fields`
  ADD PRIMARY KEY (`custom_field_id`),
  ADD UNIQUE KEY `custom_field_table_2` (`custom_field_table`,`custom_field_label`),
  ADD KEY `custom_field_table` (`custom_field_table`);

--
-- Indexes for table `ip_custom_values`
--
ALTER TABLE `ip_custom_values`
  ADD PRIMARY KEY (`custom_values_id`);

--
-- Indexes for table `ip_email_templates`
--
ALTER TABLE `ip_email_templates`
  ADD PRIMARY KEY (`email_template_id`);

--
-- Indexes for table `ip_families`
--
ALTER TABLE `ip_families`
  ADD PRIMARY KEY (`family_id`);

--
-- Indexes for table `ip_imports`
--
ALTER TABLE `ip_imports`
  ADD PRIMARY KEY (`import_id`);

--
-- Indexes for table `ip_import_details`
--
ALTER TABLE `ip_import_details`
  ADD PRIMARY KEY (`import_detail_id`),
  ADD KEY `import_id` (`import_id`,`import_record_id`);

--
-- Indexes for table `ip_invoices`
--
ALTER TABLE `ip_invoices`
  ADD PRIMARY KEY (`invoice_id`),
  ADD UNIQUE KEY `invoice_url_key` (`invoice_url_key`),
  ADD KEY `user_id` (`user_id`,`client_id`,`invoice_group_id`,`invoice_date_created`,`invoice_date_due`,`invoice_number`),
  ADD KEY `invoice_status_id` (`invoice_status_id`);

--
-- Indexes for table `ip_invoices_recurring`
--
ALTER TABLE `ip_invoices_recurring`
  ADD PRIMARY KEY (`invoice_recurring_id`),
  ADD KEY `invoice_id` (`invoice_id`);

--
-- Indexes for table `ip_invoice_amounts`
--
ALTER TABLE `ip_invoice_amounts`
  ADD PRIMARY KEY (`invoice_amount_id`),
  ADD KEY `invoice_id` (`invoice_id`),
  ADD KEY `invoice_paid` (`invoice_paid`,`invoice_balance`);

--
-- Indexes for table `ip_invoice_custom`
--
ALTER TABLE `ip_invoice_custom`
  ADD PRIMARY KEY (`invoice_custom_id`),
  ADD UNIQUE KEY `invoice_id` (`invoice_id`,`invoice_custom_fieldid`);

--
-- Indexes for table `ip_invoice_groups`
--
ALTER TABLE `ip_invoice_groups`
  ADD PRIMARY KEY (`invoice_group_id`),
  ADD KEY `invoice_group_next_id` (`invoice_group_next_id`),
  ADD KEY `invoice_group_left_pad` (`invoice_group_left_pad`);

--
-- Indexes for table `ip_invoice_items`
--
ALTER TABLE `ip_invoice_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `invoice_id` (`invoice_id`,`item_tax_rate_id`,`item_date_added`,`item_order`);

--
-- Indexes for table `ip_invoice_item_amounts`
--
ALTER TABLE `ip_invoice_item_amounts`
  ADD PRIMARY KEY (`item_amount_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `ip_invoice_sumex`
--
ALTER TABLE `ip_invoice_sumex`
  ADD PRIMARY KEY (`sumex_id`);

--
-- Indexes for table `ip_invoice_tax_rates`
--
ALTER TABLE `ip_invoice_tax_rates`
  ADD PRIMARY KEY (`invoice_tax_rate_id`),
  ADD KEY `invoice_id` (`invoice_id`,`tax_rate_id`);

--
-- Indexes for table `ip_item_lookups`
--
ALTER TABLE `ip_item_lookups`
  ADD PRIMARY KEY (`item_lookup_id`);

--
-- Indexes for table `ip_merchant_responses`
--
ALTER TABLE `ip_merchant_responses`
  ADD PRIMARY KEY (`merchant_response_id`),
  ADD KEY `merchant_response_date` (`merchant_response_date`),
  ADD KEY `invoice_id` (`invoice_id`);

--
-- Indexes for table `ip_payments`
--
ALTER TABLE `ip_payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `invoice_id` (`invoice_id`),
  ADD KEY `payment_method_id` (`payment_method_id`),
  ADD KEY `payment_amount` (`payment_amount`);

--
-- Indexes for table `ip_payment_custom`
--
ALTER TABLE `ip_payment_custom`
  ADD PRIMARY KEY (`payment_custom_id`),
  ADD UNIQUE KEY `payment_id` (`payment_id`,`payment_custom_fieldid`);

--
-- Indexes for table `ip_payment_methods`
--
ALTER TABLE `ip_payment_methods`
  ADD PRIMARY KEY (`payment_method_id`);

--
-- Indexes for table `ip_products`
--
ALTER TABLE `ip_products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `ip_products_stock`
--
ALTER TABLE `ip_products_stock`
  ADD PRIMARY KEY (`stock_id`);

--
-- Indexes for table `ip_projects`
--
ALTER TABLE `ip_projects`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `ip_quotes`
--
ALTER TABLE `ip_quotes`
  ADD PRIMARY KEY (`quote_id`),
  ADD KEY `user_id` (`user_id`,`client_id`,`invoice_group_id`,`quote_date_created`,`quote_date_expires`,`quote_number`),
  ADD KEY `invoice_id` (`invoice_id`),
  ADD KEY `quote_status_id` (`quote_status_id`);

--
-- Indexes for table `ip_quote_amounts`
--
ALTER TABLE `ip_quote_amounts`
  ADD PRIMARY KEY (`quote_amount_id`),
  ADD KEY `quote_id` (`quote_id`);

--
-- Indexes for table `ip_quote_custom`
--
ALTER TABLE `ip_quote_custom`
  ADD PRIMARY KEY (`quote_custom_id`),
  ADD UNIQUE KEY `quote_id` (`quote_id`,`quote_custom_fieldid`);

--
-- Indexes for table `ip_quote_items`
--
ALTER TABLE `ip_quote_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `quote_id` (`quote_id`,`item_date_added`,`item_order`),
  ADD KEY `item_tax_rate_id` (`item_tax_rate_id`);

--
-- Indexes for table `ip_quote_item_amounts`
--
ALTER TABLE `ip_quote_item_amounts`
  ADD PRIMARY KEY (`item_amount_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `ip_quote_tax_rates`
--
ALTER TABLE `ip_quote_tax_rates`
  ADD PRIMARY KEY (`quote_tax_rate_id`),
  ADD KEY `quote_id` (`quote_id`),
  ADD KEY `tax_rate_id` (`tax_rate_id`);

--
-- Indexes for table `ip_sessions`
--
ALTER TABLE `ip_sessions`
  ADD KEY `ip_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `ip_settings`
--
ALTER TABLE `ip_settings`
  ADD PRIMARY KEY (`setting_id`),
  ADD KEY `setting_key` (`setting_key`);

--
-- Indexes for table `ip_suppliers`
--
ALTER TABLE `ip_suppliers`
  ADD PRIMARY KEY (`supplier_id`),
  ADD KEY `client_active` (`supplier_active`);

--
-- Indexes for table `ip_tasks`
--
ALTER TABLE `ip_tasks`
  ADD PRIMARY KEY (`task_id`);

--
-- Indexes for table `ip_tax_rates`
--
ALTER TABLE `ip_tax_rates`
  ADD PRIMARY KEY (`tax_rate_id`);

--
-- Indexes for table `ip_units`
--
ALTER TABLE `ip_units`
  ADD PRIMARY KEY (`unit_id`);

--
-- Indexes for table `ip_uploads`
--
ALTER TABLE `ip_uploads`
  ADD PRIMARY KEY (`upload_id`);

--
-- Indexes for table `ip_users`
--
ALTER TABLE `ip_users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `ip_user_clients`
--
ALTER TABLE `ip_user_clients`
  ADD PRIMARY KEY (`user_client_id`),
  ADD KEY `user_id` (`user_id`,`client_id`);

--
-- Indexes for table `ip_user_custom`
--
ALTER TABLE `ip_user_custom`
  ADD PRIMARY KEY (`user_custom_id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`user_custom_fieldid`);

--
-- Indexes for table `ip_versions`
--
ALTER TABLE `ip_versions`
  ADD PRIMARY KEY (`version_id`),
  ADD KEY `version_date_applied` (`version_date_applied`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ip_clients`
--
ALTER TABLE `ip_clients`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ip_client_custom`
--
ALTER TABLE `ip_client_custom`
  MODIFY `client_custom_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ip_client_notes`
--
ALTER TABLE `ip_client_notes`
  MODIFY `client_note_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ip_custom_fields`
--
ALTER TABLE `ip_custom_fields`
  MODIFY `custom_field_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ip_custom_values`
--
ALTER TABLE `ip_custom_values`
  MODIFY `custom_values_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ip_email_templates`
--
ALTER TABLE `ip_email_templates`
  MODIFY `email_template_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ip_families`
--
ALTER TABLE `ip_families`
  MODIFY `family_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ip_imports`
--
ALTER TABLE `ip_imports`
  MODIFY `import_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ip_import_details`
--
ALTER TABLE `ip_import_details`
  MODIFY `import_detail_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ip_invoices`
--
ALTER TABLE `ip_invoices`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `ip_invoices_recurring`
--
ALTER TABLE `ip_invoices_recurring`
  MODIFY `invoice_recurring_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ip_invoice_amounts`
--
ALTER TABLE `ip_invoice_amounts`
  MODIFY `invoice_amount_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `ip_invoice_custom`
--
ALTER TABLE `ip_invoice_custom`
  MODIFY `invoice_custom_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `ip_invoice_groups`
--
ALTER TABLE `ip_invoice_groups`
  MODIFY `invoice_group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ip_invoice_items`
--
ALTER TABLE `ip_invoice_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `ip_invoice_item_amounts`
--
ALTER TABLE `ip_invoice_item_amounts`
  MODIFY `item_amount_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `ip_invoice_sumex`
--
ALTER TABLE `ip_invoice_sumex`
  MODIFY `sumex_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ip_invoice_tax_rates`
--
ALTER TABLE `ip_invoice_tax_rates`
  MODIFY `invoice_tax_rate_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ip_item_lookups`
--
ALTER TABLE `ip_item_lookups`
  MODIFY `item_lookup_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ip_merchant_responses`
--
ALTER TABLE `ip_merchant_responses`
  MODIFY `merchant_response_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ip_payments`
--
ALTER TABLE `ip_payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `ip_payment_custom`
--
ALTER TABLE `ip_payment_custom`
  MODIFY `payment_custom_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ip_payment_methods`
--
ALTER TABLE `ip_payment_methods`
  MODIFY `payment_method_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ip_products`
--
ALTER TABLE `ip_products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ip_products_stock`
--
ALTER TABLE `ip_products_stock`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ip_projects`
--
ALTER TABLE `ip_projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ip_quotes`
--
ALTER TABLE `ip_quotes`
  MODIFY `quote_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ip_quote_amounts`
--
ALTER TABLE `ip_quote_amounts`
  MODIFY `quote_amount_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ip_quote_custom`
--
ALTER TABLE `ip_quote_custom`
  MODIFY `quote_custom_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ip_quote_items`
--
ALTER TABLE `ip_quote_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ip_quote_item_amounts`
--
ALTER TABLE `ip_quote_item_amounts`
  MODIFY `item_amount_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ip_quote_tax_rates`
--
ALTER TABLE `ip_quote_tax_rates`
  MODIFY `quote_tax_rate_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ip_settings`
--
ALTER TABLE `ip_settings`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=261;

--
-- AUTO_INCREMENT for table `ip_suppliers`
--
ALTER TABLE `ip_suppliers`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ip_tasks`
--
ALTER TABLE `ip_tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ip_tax_rates`
--
ALTER TABLE `ip_tax_rates`
  MODIFY `tax_rate_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ip_units`
--
ALTER TABLE `ip_units`
  MODIFY `unit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ip_uploads`
--
ALTER TABLE `ip_uploads`
  MODIFY `upload_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ip_users`
--
ALTER TABLE `ip_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ip_user_clients`
--
ALTER TABLE `ip_user_clients`
  MODIFY `user_client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ip_user_custom`
--
ALTER TABLE `ip_user_custom`
  MODIFY `user_custom_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ip_versions`
--
ALTER TABLE `ip_versions`
  MODIFY `version_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
