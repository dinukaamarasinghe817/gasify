-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2023 at 09:02 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gasify`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT 'defaultprofile.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `image`) VALUES
(1, 'defaultprofile.png');

-- --------------------------------------------------------

--
-- Table structure for table `assign_purchase`
--

CREATE TABLE `assign_purchase` (
  `po_id` int(11) NOT NULL,
  `distributor_id` int(11) NOT NULL,
  `vehicle_no` varchar(255) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `time` time NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assign_stock`
--

CREATE TABLE `assign_stock` (
  `distributor_id` int(11) NOT NULL,
  `stock_req_id` int(11) NOT NULL,
  `vehicle_no` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `company_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT 'defaultprofile.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`company_id`, `name`, `city`, `street`, `logo`) VALUES
(77, 'Litro', 'Ratmalana', 'Station Road, Mount Lavinia.', '1683987723litro.png'),
(78, 'Laugfs', 'Ja-Ela', 'Ranmal building, weligampitiya church road', '1683990974laugfs.png');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `city` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT 'defaultprofile.png',
  `contact_no` varchar(10) NOT NULL,
  `ebill_no` varchar(255) NOT NULL,
  `ebill_verification_state` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `city`, `street`, `type`, `image`, `contact_no`, `ebill_no`, `ebill_verification_state`) VALUES
(75, 'Boralesgamuwa', '175/2 ,Abeyrathna Mawatha', 'Domestic', '168398056215.jpeg', '0762113688', '0702638508', 'verified'),
(86, 'Homagama', 'Hospital Road', 'Domestic', '16840100641.jpg', '0710070825', '4614167004', 'verified'),
(91, 'Athurugiriya', 'No 51, Main Street', 'Domestic', '168401749816.jpeg', '0775783445', '4111212107', 'verified');

-- --------------------------------------------------------

--
-- Table structure for table `customer_quota`
--

CREATE TABLE `customer_quota` (
  `customer_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `customer_type` varchar(255) NOT NULL,
  `remaining_amount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_quota`
--

INSERT INTO `customer_quota` (`customer_id`, `company_id`, `customer_type`, `remaining_amount`) VALUES
(75, 77, 'Domestic', 2.3),
(75, 78, 'Domestic', 0),
(86, 77, 'Domestic', 2.3),
(86, 78, 'Domestic', 2.3),
(91, 77, 'Domestic', 2.3),
(91, 78, 'Domestic', 2.3);

-- --------------------------------------------------------

--
-- Table structure for table `customer_support`
--

CREATE TABLE `customer_support` (
  `customer_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `sender` int(11) NOT NULL,
  `reciever` int(11) NOT NULL,
  `description` varchar(700) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dealer`
--

CREATE TABLE `dealer` (
  `dealer_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `company_id` int(11) NOT NULL,
  `distributor_id` int(11) NOT NULL,
  `bank` varchar(255) NOT NULL,
  `branch` varchar(255) DEFAULT NULL,
  `account_no` varchar(20) NOT NULL,
  `merchant_id` int(11) NOT NULL,
  `pub_key` varchar(255) DEFAULT NULL,
  `rest_key` text DEFAULT NULL,
  `contact_no` varchar(10) NOT NULL,
  `image` varchar(255) DEFAULT 'defaultprofile.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dealer`
--

INSERT INTO `dealer` (`dealer_id`, `name`, `city`, `street`, `company_id`, `distributor_id`, `bank`, `branch`, `account_no`, `merchant_id`, `pub_key`, `rest_key`, `contact_no`, `image`) VALUES
(83, 'Lakmina Store', 'Athurugiriya', 'Sudharshana Road, welivita', 78, 82, 'Bank Of Ceylon', 'athurugiriya', '1010456899', 0, 'K8DX2I8fxrDa7xldC0tMz0p2TWlORTlJRGdCcUtRNWdJanFwbXlkSGFqeEQ0SVJKQ0RLMXdYSlNFaGo0TGRVNnRwZmhUOUdXYktvZnZyODJjT3ptL3RWbS91NUdQd0diUzJmN3VHcnB1bmVEcXJTZ3RkVlB0UFZhbnlIRE1zM2xsN3ZVem9VaHpyWVliczBvNnhQZXRpanlRVXgvbzVFbG0zVlRIdz09', 'MVSH9si1mGb2fXkatAaI9SthU3plWXdhUDZtWUpCb0pxWkorNXF2VDhtUDZKVmdvV3lBY0ZCSS94WkIyL1h4a0w0R0lRU2Exc2Z3RlNVUFkyNzFJZ2xtT3R4Q1NVSk5aUFdxQVhScGxSdlEzcU1tREpWQlBZOEdXRUFEck9MMkhxdmJIOSszckQrWHdybFhCY2VxNTJDOHd2SnJtNWlPeExyRVNOdz09', '0715872854', '16839929612.jpg'),
(84, 'Randinu Enterprices', 'Homagama', 'No 43 Godagama Homagama', 77, 80, 'Bank Of Ceylon', 'Meegoda', '101065020930', 0, '7Irr3+caVMVvLZv46rVZikxOT1BCak9wTVNQV0VEZ2NKbGdjQmZTdmNiWTNPOUZZY0QrVUk5R1Jrb05EakpQMzluaWg1c01nNi9HWmhSMWVic2thTDJxcU9HUFpYdTBaNEVBRzlEaGkxVkZwRFRCMW1IVy9za0t2aTlRSE1YcmJTREVIa2FBQTk1cCtmUkVxWGVCTTVoRFFkMzVNU0Z1ayt6SWEzQT09', 'xEo5dRtNmeO3EzBjcLyg+Ud5VzRTS2ZUSE5UTWE1TUxXaGJSMXNTR3ZJRXBVNkFUODY3T2p5TDQ0dGJORjE4T0NLTmlsYlFBUkxHTEpCeXZjSVg5ZVQ5S295TDU0T2EvZHZOUTVRZXlGU0duVlZ0MEsxaTAraHM4S3FDQ0svaHdLb2Q5UTBrMk0xZFMzVWxIMGc0SW1pb01GTXdLOHBxRmI1bGptQT09', '0714872852', '168399315914.jpg'),
(85, 'Risivara Station', 'Homagama', 'wekanda road', 77, 80, 'Bank Of Ceylon', 'Homagama', '077020390361', 0, 'SDaUtOf/LQHhg4RfaMe7nVFBcEN2Vmlyb3k1OHRFaEtTbWFacHlMZTdLSDlPODZ3dW9zUEY3V3RmMWNmZ2l3bnNuZGhtZFVYTmQxdU0vMmFGbUYwRkV4anFPbmRGTzZuUExtdEF2TndOMzdoS0l2WFVnOGVtalVHd01aUGdLN1hJY09DcSs5Q3I4cFJiMjFjRWsvT2FkYXJTTFlWVlMzZkFqVEYvZz09', 'PYlmSjOUuYTyJAn2Qs1uHFQwWG5tbnBWcTFvSFR1Z3RkdlVENlBFcDB5RDdVQTMzZUhmK1hZS2NVdVV1OUpUZ1RaZEI3TG93bk55TjdXTENTSzhETHNBeGRxOHJZSElqOG0rcUtMZzROaUVTS0JZSWJTOTdkNWdKU3BQZ0s3dWROWnBudCtXWWo5QXBBV0x6eHlzaGpHZGE5dlhZRXRlK1lYb2pHQT09', '0714872112', '168399340913.jpg'),
(92, 'Gamunu Gas point', 'Boralesgamuwa', 'No: 125, School Lane', 77, 80, 'Bank Of Ceylon', 'Boralesgamuwa', '1019829283', 0, 'LnOI3oxjijthFEEk0CVTFkc2T2RoRHlMQVQ4NDZmbFBqazZtMkpraUxObzFRUHc2WnJGaytwTng3Zk55YlJsRmh0aGxBUzNnTEtTMGhCK0RVTjVTem04YnoyM0ZPdERRNG05MncxNzgzMFR4dVFGazg3c3VVejdTWS9hT2RadDk5L3FtTTIxTkc3V2JtUDFzSWhjVWwrU0tHRnJlcFNKVWFKcC9yUT09', 'VuwWM/W0Gyeq1eLK6Gw98W1TYkhjOE9Xb1ZBSFZ0T1FCYUJLUDRZdDJGblRubWRMYU80cXNYazcvNm81bjV4SzBSbFp5VDN5YThoblk4SThRZTFhK1YrL2hRVlFNeHpjbWswMEFOekVkM01qaTdNQ2Y5RFdYY3NqL0Q3VUpzdTBjZUQyMEhQeW1LWEVxK2ZRYTI3SVNkRXRHWDA1eno1cmUzSVJRdz09', '0714872877', '168405174218.jpg'),
(93, 'Silva gas Store', 'Boralesgamuwa', 'No 15,Pubudu Mw', 77, 80, 'Bank Of Ceylon', 'Boralesgamuwa', '1026567782', 0, '18RMrIiVCbVsy5tvqoK6J2kwQXMraUR1a0VrREdVdWxuTW52VmNoZ3RsczdTdDVWTUU4eFFrdnpucmgrNEU5NmUxTWFrY1RwVm5jU2UyNXAxekszS01KdzZXN3F1c3o4RnFtMjFDakhEc1ozQVdnVTJ6UWdTTk95QzQvcmppTHhuU0l0Vm55b0xseStkSUZ6Z25CWldvamM4NmpGYWx5S1VNMlB0Zz09', 'umsz89mRnlR9YlrMOw5pNWhWajFkRTM2RHVjQ09NZGdjM2FaU1JuaEg2WFp4K3hvSzU2S0JyWEF0a2Y4UzRpS3ZBU3RjUW92czQzcC9yUWxnVG82NS9mSEN2Q2x3UXBXTldVS1RjbmVLUUlyRS9kVTlmUlkvZHVwNnFWSVRWK0l3dDZNT1dDZmNMRitPYUR1RzVONFZDSDh3cHpnVXE1VThvNmhhQT09', '0715872132', '168405188319.jpeg'),
(94, 'Anjana Stores', 'Boralesgamuwa', 'No 45,First Lane', 77, 80, 'Bank Of Ceylon', 'Boralesgamuwa', '1023322124', 0, '8ApTJNzHe2vBwi1S2mEkFDVPU3NPejlxYjF1WHFyVXdOcm16WmYyUzAwWklMVWFyVk9CRVU5WUZKVlFtWnNETnJwR2pPQ0haL0ZyZTRiZ1lwTy9xMGkzUUdEb0dpSzhXTFhGY0R0aUZEenhTeVRid1lwdGpUUE4yWExyMk5GSnozTEV6dWFsWUV3OGJsRlJBU3BLNVRjYlFXc2FTVnhCOGpHbCtkUT09', 'ZlS7pt7Hf1I0PvewFfT0QFdUMmFabDFWa0c5Uk9xSFYxc2ZabFI4SmJWcCtBaERyM0FsUjVDSWtBcnJHTTdYVm0ydjNHMWt6bkFnSzJWWWdMUFpsNEdpQnhkNWtTc2hQQlpGbCs5NWdyU0RObnlkT3RxV21KMFREUHBGbDE3ZklyZ0pCOXRvcFg3cnBwKzRiZjhxRit5WVl0WGo1QmtvQ01FMVg5dz09', '0711222857', '168405200420.jpeg'),
(96, 'Nimali Stores', 'Boralesgamuwa', 'No 128, Galwala Rd', 78, 95, 'Bank Of Ceylon', 'Boralesgamuwa', '1026567782', 0, '19U2tsHJPJz6KFWuyTc9ejZuZFIxSXhkQXMvb0lad3JRQkJadUg2VUV0bEgvREdHb1paN24rTEQzOU5NVjZHekM5TU53Y3RzRkFaKzFoTEhzTFI3em83cldrcXFUaU15N3lxaHcwVzV6R1VaTXNndmhyOUtXU2N0M2hkOGtjMHp0THg0d2VHWkl3WTRhUUJTTGJUdzNNS2dpTVNBUVRWdFgva1ZaZz09', 'Zi5/jpgaPWBHLWTWf9pSRGlYb0p5VGF5dnV4NFQwZHlDNExhUkR4R2FXTnFNSU00RE9vOGxQODBOamc0SG0rWW0wWm9PYlViOGJLbnhYSTNYV210NUs1cXczUVRBVlhQaXVvZkUrR3doQkN1VVlrdUdWR1grWktDaFc4LzZTZ0ZEbmJuaG1DeTlEOVBYeFNsTWxHYlJRWi9xbS93VGFRc3pSd3VwQT09', '0714872008', '168405243720.jpeg'),
(97, 'Nadun Stores', 'Boralesgamuwa', 'No 118, Dehiwala Rd', 78, 95, 'Bank Of Ceylon', 'Boralesgamuwa', '1000992912', 0, 'cqcsJ2yqQ3JQieFokP+6TmJUeWlWUUEvOGJScGUzcXF1QkVyTVJFcDZubksvREFsQWY1MGwxa3pFS0hNUW1zaDJSNC93ZGNzdHVzSkdsRDZ0WkVuVzJ4ZkFYdFlndnA4aTN5a3lYN2NaeDQyZlNYNUs1U0E1RmNDRWpWQkRqYmdoNlBVVElZcGJYQWw2T0R0T0F1VGplWEhjWGpCMjVISXFMSjR2UT09', 'c5J5+0yARFXRWmX3l39YRUdkdkZWdnB1NzNoc1dwaFhmNGNlSkVUeDFuQ1NiSDVoK1NoSll5UitGcXhmcnFoNUJ3emljM0FRZjhBaHNxMlFobEUrRzNObkFhbFBIdzNJaFZxNEozU3dVUHJ1ZStzbkJXdmFDeGhlV3hHdFFyL0JnN1h3czNoQjBpelQ0MlNmNlNzeG9MOVdVSVFVcTAwZjdHVXJqUT09', '0714872851', 'defaultprofile.png'),
(98, 'Dasun gas Point', 'Boralesgamuwa', 'No 69, Dehiwala Rd', 78, 95, 'Bank Of Ceylon', 'Boralesgamuwa', '6577291957', 0, 'viH4LrQj58WtXOEh1YxUnGhBU1ZabmNhczQ5OG1nR1F5UGtuM1RuenBDejJYNWxLc3JlZUtGUzlUL3hqb3NLWTMvWWJ5S3NndVZLZENJdy80eVRMZ0RZaVAyTFFoUVgybGpNNldOT2EvRXNHMmJwZk9qZ29WaHdLZzFIRmtZbTdkdkNDUGNFUXpETXB3cEVvV0oweXFYbFNoV25taWpxcWxJUmZJUT09', '1D9leMlwGa+4EAEXSocp8kF6RlJSOEtTd0gxNXVWZ09LS2dnWllyOEZQZzAvQ0tWbzNHOGNsZjY5U2ZIZGlHU1Bvb2ZMTU9JcW04emdINUVBTXA4QnhGK0VLZ2R2R2lGM0xKdURCRmh1K2dwSWMxSmdVOExmZ1hvckV4aEZ0OVpNYSttQnFnOUFwbkxKQ2NSNi9ZVDdoaXltbmN2NFk0NnFBNVVNdz09', '0714872850', '168405260521.jpg'),
(99, 'Nimesh gas Point', 'Homagama', 'No 93, Avissawella Rd', 78, 82, 'Bank Of Ceylon', 'Homagama', '5476282291', 0, 'Y2NC0V0RmzxR9cL0bARaE081MmpxYjY2a0RuRlA0aXdNNFlQR1BLZFdkUzdYMjNSbmdmMkdFUU44VXZYYUM0aEN5cU5la1l1SUpzdG44cFNFNWVCejRJNFJoS2Y2cWEzMVhBNTNWYzVvZTM5SjdPVjRFZFhEamZkZHpVTWMvZ2Z0OHc0Q2ZScTdKS1JVUjhQdmoyRXFEVnh2OXpwSEkzQ3Vxd0gvdz09', 'I68BiR3dqaXbIi5IJEjk2VNzdXc1WUtNbTk2RVBHdC9FZGVEM0NicUxyWnU1Q0o3QXdjRXcwekVVNm1CWndGTTdEMUlrb0pZeTNlTFE4ZG9QZFpIMkhEV04zdDJ3NWdHdmQvNHpzMUhGV21rOUFHNXNDWmF0bXlpTDNheklSekZESjNhazkwcHV6WWh2VmdhczVKNk9vbGd3elp5YXcxNWMybitxZz09', '0714872825', '168405268223.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `dealer_capacity`
--

CREATE TABLE `dealer_capacity` (
  `dealer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `capacity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dealer_capacity`
--

INSERT INTO `dealer_capacity` (`dealer_id`, `product_id`, `capacity`) VALUES
(83, 45, 40),
(83, 46, 40),
(83, 47, 45),
(83, 48, 100),
(84, 40, 40),
(84, 41, 42),
(84, 42, 46),
(84, 43, 39),
(84, 44, 150),
(84, 49, 0),
(85, 40, 35),
(85, 41, 35),
(85, 42, 38),
(85, 43, 29),
(85, 44, 100),
(85, 49, 0),
(92, 40, 40),
(92, 41, 42),
(92, 42, 56),
(92, 43, 18),
(92, 44, 120),
(92, 49, 0),
(93, 40, 42),
(93, 41, 38),
(93, 42, 49),
(93, 43, 15),
(93, 44, 107),
(93, 49, 0),
(94, 40, 45),
(94, 41, 38),
(94, 42, 64),
(94, 43, 18),
(94, 44, 145),
(94, 49, 0),
(96, 45, 48),
(96, 46, 48),
(96, 47, 71),
(96, 48, 28),
(97, 45, 41),
(97, 46, 39),
(97, 47, 51),
(97, 48, 111),
(98, 45, 43),
(98, 46, 49),
(98, 47, 62),
(98, 48, 99),
(99, 45, 51),
(99, 46, 56),
(99, 47, 81),
(99, 48, 256);

-- --------------------------------------------------------

--
-- Table structure for table `dealer_keep`
--

CREATE TABLE `dealer_keep` (
  `dealer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `reorder_level` int(11) DEFAULT 0,
  `daily_sale` int(11) DEFAULT 0,
  `total_sale` int(11) DEFAULT 0,
  `lead_time` int(11) DEFAULT 1,
  `po_counter` int(11) DEFAULT 0,
  `reorder_flag` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dealer_keep`
--

INSERT INTO `dealer_keep` (`dealer_id`, `product_id`, `quantity`, `reorder_level`, `daily_sale`, `total_sale`, `lead_time`, `po_counter`, `reorder_flag`) VALUES
(83, 45, 0, 0, 0, 0, 1, 0, 0),
(83, 46, 0, 0, 0, 0, 1, 0, 0),
(83, 47, 0, 0, 0, 0, 1, 0, 0),
(83, 48, 0, 0, 0, 0, 1, 0, 0),
(84, 40, 1, 0, 0, 0, 0, 4, 0),
(84, 41, 12, 0, 0, 0, 0, 3, 0),
(84, 42, 24, 0, 0, 1, 0, 3, 0),
(84, 43, 17, 0, 0, 0, 0, 3, 0),
(84, 44, 50, 0, 0, 0, 0, 4, 0),
(85, 40, 0, 0, 0, 0, 1, 0, 0),
(85, 41, 0, 0, 0, 0, 1, 0, 0),
(85, 42, 0, 0, 0, 0, 1, 0, 0),
(85, 43, 0, 0, 0, 0, 1, 0, 0),
(85, 44, 0, 0, 0, 0, 1, 0, 0),
(92, 40, 38, 0, 0, 0, 0, 1, 0),
(92, 41, 40, 0, 0, 0, 0, 1, 0),
(92, 42, 50, 0, 0, 0, 0, 1, 0),
(92, 43, 17, 0, 0, 0, 0, 1, 0),
(92, 44, 110, 0, 0, 0, 0, 1, 0),
(93, 40, 40, 0, 0, 0, 0, 1, 0),
(93, 41, 35, 0, 0, 0, 0, 1, 0),
(93, 42, 39, 0, 0, 0, 0, 1, 0),
(93, 43, 15, 0, 0, 0, 0, 1, 0),
(93, 44, 100, 0, 0, 0, 0, 1, 0),
(94, 40, 0, 0, 0, 0, 1, 0, 0),
(94, 41, 0, 0, 0, 0, 1, 0, 0),
(94, 42, 0, 0, 0, 0, 1, 0, 0),
(94, 43, 0, 0, 0, 0, 1, 0, 0),
(94, 44, 0, 0, 0, 0, 1, 0, 0),
(96, 45, 40, 0, 0, 0, 0, 1, 0),
(96, 46, 40, 0, 0, 0, 0, 1, 0),
(96, 47, 70, 0, 0, 0, 0, 1, 0),
(96, 48, 25, 0, 0, 0, 0, 1, 0),
(97, 45, 0, 0, 0, 0, 1, 0, 0),
(97, 46, 0, 0, 0, 0, 1, 0, 0),
(97, 47, 0, 0, 0, 0, 1, 0, 0),
(97, 48, 0, 0, 0, 0, 1, 0, 0),
(98, 45, 0, 0, 0, 0, 1, 0, 0),
(98, 46, 0, 0, 0, 0, 1, 0, 0),
(98, 47, 0, 0, 0, 0, 1, 0, 0),
(98, 48, 0, 0, 0, 0, 1, 0, 0),
(99, 45, 0, 0, 0, 0, 1, 0, 0),
(99, 46, 0, 0, 0, 0, 1, 0, 0),
(99, 47, 0, 0, 0, 0, 1, 0, 0),
(99, 48, 0, 0, 0, 0, 1, 0, 0);

--
-- Triggers `dealer_keep`
--
DELIMITER $$
CREATE TRIGGER `dealer_reorder_check` BEFORE UPDATE ON `dealer_keep` FOR EACH ROW BEGIN
    IF NEW.quantity < NEW.reorder_level THEN
    	SET NEW.reorder_flag = 1;
    ELSE
    	SET NEW.reorder_flag = 0;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_daily_sale` BEFORE UPDATE ON `dealer_keep` FOR EACH ROW BEGIN
DECLARE start_date DATE;
DECLARE differ INT;
IF OLD.total_sale < NEW.total_sale THEN
	SELECT date_joined INTO start_date FROM users WHERE user_id = NEW.dealer_id;
    SET differ = DATEDIFF(CURRENT_DATE(),start_date);
    SET NEW.daily_sale = FLOOR(NEW.total_sale/differ);
END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_reorder_level` BEFORE UPDATE ON `dealer_keep` FOR EACH ROW BEGIN
	IF OLD.lead_time <> NEW.lead_time OR OLD.daily_sale <> NEW.daily_sale THEN
		SET NEW.reorder_level = NEW.lead_time*NEW.daily_sale;
	END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_charge`
--

CREATE TABLE `delivery_charge` (
  `min_distance` double NOT NULL,
  `max_distance` double NOT NULL,
  `charge_per_kg` double NOT NULL,
  `admin_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_charge`
--

INSERT INTO `delivery_charge` (`min_distance`, `max_distance`, `charge_per_kg`, `admin_id`) VALUES
(0, 10, 30, 1),
(10, 20, 35, 1),
(20, 30, 40, 1),
(30, 40, 45, 1),
(40, 50, 50, 1),
(50, 100, 60, 1);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_person`
--

CREATE TABLE `delivery_person` (
  `delivery_id` int(11) NOT NULL,
  `contact_no` varchar(10) NOT NULL,
  `city` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT 'defaultprofile.png',
  `vehicle_no` varchar(255) NOT NULL,
  `vehicle_type` varchar(255) NOT NULL,
  `weight_limit` double NOT NULL,
  `cost_per_km` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_person`
--

INSERT INTO `delivery_person` (`delivery_id`, `contact_no`, `city`, `street`, `image`, `vehicle_no`, `vehicle_type`, `weight_limit`, `cost_per_km`) VALUES
(87, '0712872811', 'Homagama', '5th lane, Jayasinghe mawatha, Godagama', '1684012987311482385_1547847432343578_3067069806130539703_n.jpg', 'BEC-2121', 'Bike', 50, 10),
(88, '0714872477', 'Homagama', 'Ranawiru Jayantha Mawatha, Godagama', '16840167339.jpg', 'QL-9904', 'Three', 320, 150),
(90, '0714872101', 'Homagama', 'Station Road, Homagama', '16840170623.jpg', 'CBA-2748', 'Bike', 80, 20);

-- --------------------------------------------------------

--
-- Table structure for table `distributor`
--

CREATE TABLE `distributor` (
  `distributor_id` int(11) NOT NULL,
  `contact_no` varchar(10) NOT NULL,
  `company_id` int(11) NOT NULL,
  `hold_time` int(11) NOT NULL DEFAULT 1,
  `city` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT 'defaultprofile.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `distributor`
--

INSERT INTO `distributor` (`distributor_id`, `contact_no`, `company_id`, `hold_time`, `city`, `street`, `image`) VALUES
(80, '0703966425', 77, 1, 'Homagama', 'diyagama road', '1683991918hashini.jpg'),
(81, '0714872852', 77, 1, 'Kolonnawa', 'Vijaya Road', '168399224912.jpeg'),
(82, '0714872852', 78, 1, 'Athurugiriya', 'Jayanthi Road', '168399262211.jpeg'),
(95, '0714873005', 78, 1, 'Maharagama', 'No 43 Godagama Homagama', '16840523374.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `distributor_capacity`
--

CREATE TABLE `distributor_capacity` (
  `distributor_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `capacity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `distributor_capacity`
--

INSERT INTO `distributor_capacity` (`distributor_id`, `product_id`, `capacity`) VALUES
(80, 40, 200),
(80, 41, 200),
(80, 42, 240),
(80, 43, 250),
(80, 44, 700),
(80, 49, 0),
(81, 40, 210),
(81, 41, 240),
(81, 42, 250),
(81, 43, 180),
(81, 44, 250),
(81, 49, 0),
(82, 45, 215),
(82, 46, 200),
(82, 47, 200),
(82, 48, 300),
(95, 45, 200),
(95, 46, 160),
(95, 47, 174),
(95, 48, 400);

-- --------------------------------------------------------

--
-- Table structure for table `distributor_keep`
--

CREATE TABLE `distributor_keep` (
  `distributor_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `reorder_level` int(11) DEFAULT 0,
  `daily_sale` int(11) DEFAULT 0,
  `total_sale` int(11) DEFAULT 0,
  `lead_time` int(11) DEFAULT 1,
  `po_counter` int(11) DEFAULT 0,
  `reorder_flag` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `distributor_keep`
--

INSERT INTO `distributor_keep` (`distributor_id`, `product_id`, `quantity`, `reorder_level`, `daily_sale`, `total_sale`, `lead_time`, `po_counter`, `reorder_flag`) VALUES
(80, 40, 107, 8, 8, 93, 1, 0, 0),
(80, 41, 111, 8, 8, 90, 1, 0, 0),
(80, 42, 90, 9, 9, 117, 1, 0, 0),
(80, 43, 121, 3, 4, 49, 1, 0, 0),
(80, 44, 392, 22, 21, 262, 1, 0, 0),
(81, 40, 0, 0, 0, 0, 1, 0, 0),
(81, 41, 0, 0, 0, 0, 1, 0, 0),
(81, 42, 0, 0, 0, 0, 1, 0, 0),
(81, 43, 0, 0, 0, 0, 1, 0, 0),
(81, 44, 0, 0, 0, 0, 1, 0, 0),
(82, 45, 0, 0, 0, 0, 1, 0, 0),
(82, 46, 0, 0, 0, 0, 1, 0, 0),
(82, 47, 0, 0, 0, 0, 1, 0, 0),
(82, 48, 0, 0, 0, 0, 1, 0, 0),
(95, 45, 60, 0, NULL, 40, 1, 0, 0),
(95, 46, 7, 0, NULL, 40, 1, 0, 0),
(95, 47, 10, 0, NULL, 70, 1, 0, 0),
(95, 48, 15, 0, NULL, 25, 1, 0, 0);

--
-- Triggers `distributor_keep`
--
DELIMITER $$
CREATE TRIGGER `distributor_reorder_check` BEFORE UPDATE ON `distributor_keep` FOR EACH ROW BEGIN
	IF NEW.quantity <= OLD.reorder_level THEN
    	SET NEW.reorder_flag = 1;
    ELSE
    	SET NEW.reorder_flag = 0;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `distributor_update_reorder_level` BEFORE UPDATE ON `distributor_keep` FOR EACH ROW BEGIN
	IF OLD.lead_time <> NEW.lead_time OR OLD.daily_sale <> NEW.daily_sale THEN
		SET NEW.reorder_level = NEW.lead_time*NEW.daily_sale;
	END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_daily_sale_distributor` BEFORE UPDATE ON `distributor_keep` FOR EACH ROW BEGIN
DECLARE start_date DATE;
DECLARE differ INT;
IF OLD.total_sale < NEW.total_sale THEN
	SELECT date_joined INTO start_date FROM users WHERE user_id = NEW.distributor_id;
    SET differ = DATEDIFF(CURRENT_DATE(),start_date);
    SET NEW.daily_sale = FLOOR(NEW.total_sale/differ);
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `distributor_vehicle`
--

CREATE TABLE `distributor_vehicle` (
  `distributor_id` int(11) NOT NULL,
  `vehicle_no` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `weight_limit` double NOT NULL,
  `fuel_consumption` double NOT NULL,
  `availability` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `distributor_vehicle`
--

INSERT INTO `distributor_vehicle` (`distributor_id`, `vehicle_no`, `type`, `weight_limit`, `fuel_consumption`, `availability`) VALUES
(80, 'NC-1112', '5', 0, 3, 'Yes'),
(80, 'NC-7480', '3', 0, 2, 'Yes'),
(80, 'NC-7880', '3', 0, 2, 'Yes'),
(80, 'ND-4221', '2', 0, 1.5, 'Yes'),
(95, 'ND-8080', '4', 0, 3, 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `distributor_vehicle_capacity`
--

CREATE TABLE `distributor_vehicle_capacity` (
  `distributor_id` int(11) NOT NULL,
  `vehicle_no` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
  `remain_eligibility` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `distributor_vehicle_capacity`
--

INSERT INTO `distributor_vehicle_capacity` (`distributor_id`, `vehicle_no`, `product_id`, `capacity`, `remain_eligibility`) VALUES
(80, 'NC-1112', 40, 280, 280),
(80, 'NC-1112', 41, 280, 280),
(80, 'NC-1112', 42, 200, 200),
(80, 'NC-1112', 43, 150, 150),
(80, 'NC-1112', 44, 500, 500),
(80, 'NC-7480', 40, 120, 120),
(80, 'NC-7480', 41, 80, 80),
(80, 'NC-7480', 42, 60, 60),
(80, 'NC-7480', 43, 40, 40),
(80, 'NC-7480', 44, 300, 300),
(80, 'NC-7880', 40, 60, 60),
(80, 'NC-7880', 41, 45, 45),
(80, 'NC-7880', 42, 32, 32),
(80, 'NC-7880', 43, 16, 16),
(80, 'NC-7880', 44, 250, 250),
(80, 'ND-4221', 40, 40, 40),
(80, 'ND-4221', 41, 26, 26),
(80, 'ND-4221', 42, 16, 16),
(80, 'ND-4221', 43, 7, 7),
(80, 'ND-4221', 44, 80, 80),
(95, 'ND-8080', 45, 200, 200),
(95, 'ND-8080', 46, 200, 200),
(95, 'ND-8080', 47, 180, 180),
(95, 'ND-8080', 48, 600, 600);

--
-- Triggers `distributor_vehicle_capacity`
--
DELIMITER $$
CREATE TRIGGER `set_remain_eligibility` BEFORE INSERT ON `distributor_vehicle_capacity` FOR EACH ROW BEGIN
    SET NEW.remain_eligibility = NEW.capacity;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `time` time NOT NULL DEFAULT current_timestamp(),
  `type` varchar(255) NOT NULL,
  `message` varchar(700) NOT NULL,
  `state` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`user_id`, `date`, `time`, `type`, `message`, `state`) VALUES
(1, '2023-05-14', '02:05:28', 'Payslip Verification', 'You have a new regular payment verification request from User ID: <strong>86</strong> user name <strong>Ravindu Galagedara</strong>', 'read'),
(1, '2023-05-14', '03:32:28', 'Payslip Verification', 'You have a new regular payment verification request from User ID: <strong>75</strong> user name <strong>Sasangi Nayanathara</strong>', 'read'),
(1, '2023-05-14', '04:40:20', 'Payslip Verification', 'You have a new regular payment verification request from User ID: <strong>86</strong> user name <strong>Ravindu Galagedara</strong>', 'read'),
(1, '2023-05-14', '05:09:00', 'Payslip Verification', 'You have a new regular payment verification request from User ID: <strong>91</strong> user name <strong>Neelika Jayasekara</strong>', 'delivered'),
(1, '2023-05-14', '10:18:48', 'Payslip Verification', 'You have a new regular payment verification request from User ID: <strong>75</strong> user name <strong>Sasangi Nayanathara</strong>', 'delivered'),
(75, '2023-05-14', '02:55:17', 'Order Status', 'Hi! Sasangi Nayanathara, Your order with Order ID : <strong>37</strong> was <strong>Dispatched</strong>.', 'read'),
(75, '2023-05-14', '02:57:39', 'Order Status', 'Hi! Sasangi Nayanathara, Your order with Order ID : <strong>37</strong> was <strong>Completed</strong>.', 'read'),
(75, '2023-05-14', '04:49:05', 'Order Status', 'Hi! Sasangi Nayanathara, Your order with Order ID : <strong>39</strong> was <strong>Accepted</strong>.', 'read'),
(75, '2023-05-14', '05:05:56', 'Order Status', 'Hi! Sasangi Nayanathara, Your order with Order ID : <strong>39</strong> was <strong>Delivered</strong>.', 'read'),
(75, '2023-05-14', '10:23:37', 'Order Status', 'Hi! Sasangi Nayanathara, Your order with Order ID : <strong>48</strong> was <strong>Canceled</strong>.', 'read'),
(83, '2023-05-13', '21:19:00', 'Setup Stripe details', 'Hi Lakmina Palihawadana, Before any further processing please setup your stripe public and restricted\r\n        keys on your <strong>Profile -> Bank Details</strong> section.', 'read'),
(84, '2023-05-13', '21:22:00', 'Setup Stripe details', 'Hi Dinuka Amarasinghe, Before any further processing please setup your stripe public and restricted\r\n        keys on your <strong>Profile -> Bank Details</strong> section.', 'read'),
(84, '2023-05-14', '01:43:42', 'Purchase Order Status', 'Hi! Dinuka Amarasinghe, Your purchase order with Order ID : 69 was Pending.', 'read'),
(84, '2023-05-14', '01:46:10', 'Purchase Order Status', 'Hi! Dinuka Amarasinghe, Your purchase order with Order ID : 69 was Completed.', 'read'),
(84, '2023-05-15', '00:25:41', 'Purchase Order Status', 'Hi! Dinuka Amarasinghe, Your purchase order with Order ID : 74 was Completed.', 'delivered'),
(85, '2023-05-13', '21:26:00', 'Setup Stripe details', 'Hi Rusiru Edirisinghe, Before any further processing please setup your stripe public and restricted\r\n        keys on your <strong>Profile -> Bank Details</strong> section.', 'delivered'),
(86, '2023-05-14', '02:23:45', 'Order Status', 'Hi! Ravindu Galagedara, Your order with Order ID : <strong>38</strong> was <strong>Delivered</strong>.', 'read'),
(86, '2023-05-14', '02:25:07', 'Order Status', 'Hi! Ravindu Galagedara, Your order with Order ID : <strong>38</strong> was <strong>Completed</strong>.', 'read'),
(86, '2023-05-14', '04:42:52', 'Order Status', 'Hi! Ravindu Galagedara, Your order with Order ID : <strong>42</strong> was <strong>Canceled</strong>.', 'read'),
(91, '2023-05-14', '04:43:55', 'Order Status', 'Hi! Neelika Jayasekara, Your order with Order ID : <strong>41</strong> was <strong>Dispatched</strong>.', 'delivered'),
(91, '2023-05-14', '10:21:31', 'Order Status', 'Hi! Neelika Jayasekara, Your order with Order ID : <strong>47</strong> was <strong>Canceled</strong>.', 'delivered'),
(92, '2023-05-14', '13:39:00', 'Setup Stripe details', 'Hi Gamunu Perera, Before any further processing please setup your stripe public and restricted\r\n        keys on your <strong>Profile -> Bank Details</strong> section.', 'delivered'),
(92, '2023-05-14', '14:13:33', 'Purchase Order Status', 'Hi! Gamunu Perera, Your purchase order with Order ID : 70 was Completed.', 'delivered'),
(93, '2023-05-14', '13:41:00', 'Setup Stripe details', 'Hi Saman Silva, Before any further processing please setup your stripe public and restricted\r\n        keys on your <strong>Profile -> Bank Details</strong> section.', 'delivered'),
(93, '2023-05-14', '14:18:59', 'Purchase Order Status', 'Hi! Saman Silva, Your purchase order with Order ID : 71 was Completed.', 'delivered'),
(94, '2023-05-14', '13:43:00', 'Setup Stripe details', 'Hi Anjana Perera, Before any further processing please setup your stripe public and restricted\r\n        keys on your <strong>Profile -> Bank Details</strong> section.', 'delivered'),
(96, '2023-05-14', '13:50:00', 'Setup Stripe details', 'Hi Nimali Fonseka, Before any further processing please setup your stripe public and restricted\r\n        keys on your <strong>Profile -> Bank Details</strong> section.', 'delivered'),
(96, '2023-05-14', '14:27:24', 'Purchase Order Status', 'Hi! Nimali Fonseka, Your purchase order with Order ID : 72 was Completed.', 'delivered'),
(97, '2023-05-14', '13:51:00', 'Setup Stripe details', 'Hi Nadun Fonseka, Before any further processing please setup your stripe public and restricted\r\n        keys on your <strong>Profile -> Bank Details</strong> section.', 'delivered'),
(98, '2023-05-14', '13:53:00', 'Setup Stripe details', 'Hi Dasun Perera, Before any further processing please setup your stripe public and restricted\r\n        keys on your <strong>Profile -> Bank Details</strong> section.', 'delivered'),
(99, '2023-05-14', '13:54:00', 'Setup Stripe details', 'Hi Nimesh Fernando, Before any further processing please setup your stripe public and restricted\r\n        keys on your <strong>Profile -> Bank Details</strong> section.', 'delivered');

-- --------------------------------------------------------

--
-- Table structure for table `old_passwords`
--

CREATE TABLE `old_passwords` (
  `user_id` int(11) NOT NULL,
  `old_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `old_passwords`
--

INSERT INTO `old_passwords` (`user_id`, `old_password`) VALUES
(1, '$2y$10$LtaIIVrZlrznl2XQpAoKNus8MFgn2ZZ2Cjrrv2foJieScCiC0S8SG'),
(80, '$2y$10$d0JUNNAydlSMIBZe2O.VOeVs.1or1ToD..6lgsNWPjEvhmiLTPQiW'),
(81, '$2y$10$WOX5dEWa1Ti0QCmZtVdRhOBAZQ10p/mjjcUyYDUqYKtf4wzbGVCSi'),
(82, '$2y$10$2LCvbcG/hZL1hIh7LP3kIeBvnQ.Gc1B6xN6VILxtcmUTiaxY91F2.'),
(83, '$2y$10$b5W4.4RfBtwx/mNnV/7Yg..Hzc8Gbuei5IBOjK9lSKTGOh2kaF4Mi'),
(84, '$2y$10$Cgc5w2BGTUfVb8nlr6wCyeMGUjiXIHQjvNNHK6.2yFHrimilBixoG'),
(85, '$2y$10$wd6FPlC7pEs0P6oOPKuzf.4mrwak4BrOAlplD.xffnqoQ198NiXFm'),
(92, '$2y$10$C.q2t3BhJ45aXFYLTBr8IuPoeu.IDa9cCAiXdHO4NjqYo/uEQ7foq'),
(93, '$2y$10$B3iJXQm0gAhtjYZl3QiX9eGWjASsgtsdaneDjynHfr0XVWyvCNXXu'),
(94, '$2y$10$swC7fltKszqH9k8.IBiwOuMsWzCnpTpTbnxADXAdPabJ1I8OuTE2O'),
(95, '$2y$10$x5hHktpGVX.eizMHlPyS7uL8Z6eKij/BOmu/lk.4WxERG0Mx3Ga6y'),
(96, '$2y$10$NExiY.ffRhemkrjmbP/TSekJXWPrkcO4f4W5l0rX2B90hYz6gTB36'),
(97, '$2y$10$YcLLFWV4LNHHgugE28iSROpE2x0.tXzPLPTb/c8MXfjQ5rNuTF7BG'),
(98, '$2y$10$jX1Ohb2P6HeuEyIlK24C7.7YFbhmOAygCdVre8encjs.VYaMT/HOO'),
(99, '$2y$10$qkIYxqnRQY6rjBV2HqILGOen.WkuvfvRUhpLc5lKtmfLx2MPLJUSa');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `unit_price` double NOT NULL,
  `weight` double NOT NULL,
  `image` varchar(255) DEFAULT 'defaultproduct.png',
  `production_time` int(11) NOT NULL,
  `last_updated_date` date NOT NULL,
  `quantity` int(11) NOT NULL,
  `cylinder_limit` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `company_id`, `name`, `type`, `unit_price`, `weight`, `image`, `production_time`, `last_updated_date`, `quantity`, `cylinder_limit`) VALUES
(40, 77, 'Buddy', 'cylinder', 700, 2.3, '16839883272.3kglitro.png', 0, '2023-05-13', 48087, 18000),
(41, 77, 'Budget', 'cylinder', 1502, 5, '16839883185kglitro.png', 0, '2023-05-13', 43271, 15078),
(42, 77, 'Regular', 'cylinder', 3738, 12.5, '168398840112.5kglitro.png', 0, '2023-05-13', 64531, 24698),
(43, 77, 'Commercial', 'cylinder', 11180, 37.5, '168398848437.5kglitro.png', 0, '2023-05-13', 57642, 21578),
(44, 77, 'Accessory Pack', 'accessory', 1395, 0.3, '1683988635litroaccesorypack.png', 0, '2023-05-13', 33860, 14369),
(45, 78, 'Buddy', 'cylinder', 845, 2, '16839911492kglaugfs.png', 0, '2023-05-13', 57796, 19457),
(46, 78, 'Budget', 'cylinder', 1596, 5, '16839911935kglaugfs.png', 0, '2023-05-13', 52321, 18368),
(47, 78, 'Regular', 'cylinder', 3990, 12.5, '168399123212.5kglaugfs.png', 0, '2023-05-13', 61158, 20145),
(48, 78, 'Accessory Pack', 'accessory', 2150, 0.3, '1683991311laugfsaccesorypack.png', 0, '2023-05-13', 42329, 14356),
(49, 77, 'Regular Max', 'cylinder', 4250, 15, '1684077972gas-cylinder.jpg', 0, '2023-05-14', 700, 1000);

--
-- Triggers `product`
--
DELIMITER $$
CREATE TRIGGER `add_product_capacity` AFTER INSERT ON `product` FOR EACH ROW BEGIN
  -- declare variables
  DECLARE rowdealer_id INT;
  DECLARE rowdistributor_id INT;
  -- Declare NOT FOUND handler
  DECLARE done INT DEFAULT 0;

  -- Get all dealers belonging to the same company as the new product
  DECLARE dealer_ids CURSOR FOR
    SELECT dealer_id FROM dealer WHERE company_id = NEW.company_id;

  -- Get all distributors belonging to the same company as the new product
  DECLARE distributor_ids CURSOR FOR
    SELECT distributor_id FROM distributor WHERE company_id = NEW.company_id;

  DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
  
  -- Insert into dealer_capacity for each dealer of the same company
  OPEN dealer_ids;
  SET done = 0;
  FETCH dealer_ids INTO rowdealer_id;
  WHILE NOT done DO
    INSERT INTO dealer_capacity VALUES (rowdealer_id, NEW.product_id, 0);
    FETCH dealer_ids INTO rowdealer_id;
  END WHILE;
  CLOSE dealer_ids;

  -- Insert into distributor_capacity for each distributor of the same company
  OPEN distributor_ids;
  SET done = 0;
  FETCH distributor_ids INTO rowdistributor_id;
  WHILE NOT done DO
    INSERT INTO distributor_capacity VALUES (rowdistributor_id, NEW.product_id, 0);
    FETCH distributor_ids INTO rowdistributor_id;
  END WHILE;
  CLOSE distributor_ids;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_include`
--

CREATE TABLE `purchase_include` (
  `po_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase_include`
--

INSERT INTO `purchase_include` (`po_id`, `product_id`, `quantity`, `unit_price`) VALUES
(69, 40, 4, 700),
(69, 41, 15, 1502),
(69, 42, 20, 3738),
(69, 43, 9, 11180),
(69, 44, 36, 1395),
(70, 40, 38, 700),
(70, 41, 40, 1502),
(70, 42, 50, 3738),
(70, 43, 17, 11180),
(70, 44, 110, 1395),
(71, 40, 40, 700),
(71, 41, 35, 1502),
(71, 42, 39, 3738),
(71, 43, 15, 11180),
(71, 44, 100, 1395),
(72, 45, 40, 845),
(72, 46, 40, 1596),
(72, 47, 70, 3990),
(72, 48, 25, 2150),
(74, 42, 8, 3738),
(74, 43, 8, 11180),
(74, 44, 16, 1395),
(75, 40, 4, 700),
(75, 41, 4, 1502),
(75, 42, 4, 3738),
(75, 44, 12, 1395),
(76, 40, 3, 700),
(76, 43, 3, 11180);

--
-- Triggers `purchase_include`
--
DELIMITER $$
CREATE TRIGGER `incrementpo_counter` BEFORE INSERT ON `purchase_include` FOR EACH ROW BEGIN
DECLARE po_dealer INT;
SELECT dealer_id INTO po_dealer FROM purchase_order WHERE po_id = NEW.po_id;
UPDATE dealer_keep SET po_counter = po_counter+1 WHERE dealer_id = po_dealer AND product_id = NEW.product_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order`
--

CREATE TABLE `purchase_order` (
  `po_id` int(11) NOT NULL,
  `dealer_id` int(11) NOT NULL,
  `distributor_id` int(11) NOT NULL,
  `po_state` varchar(255) NOT NULL,
  `place_date` date NOT NULL,
  `place_time` time NOT NULL,
  `vehicle_allocated` varchar(255) NOT NULL DEFAULT '',
  `delivered_date` date DEFAULT NULL,
  `delivered_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase_order`
--

INSERT INTO `purchase_order` (`po_id`, `dealer_id`, `distributor_id`, `po_state`, `place_date`, `place_time`, `vehicle_allocated`, `delivered_date`, `delivered_time`) VALUES
(69, 84, 80, 'Completed', '2023-05-13', '21:31:00', '', '2023-05-13', '22:16:10'),
(70, 92, 80, 'Completed', '2023-05-14', '14:11:00', '', '2023-05-14', '10:43:33'),
(71, 93, 80, 'Completed', '2023-05-14', '14:14:00', '', '2023-05-14', '10:48:59'),
(72, 96, 95, 'Completed', '2023-05-14', '14:26:00', '', '2023-05-14', '10:57:24'),
(74, 84, 80, 'Completed', '2023-05-14', '20:19:00', 'NC-1112', '2023-05-14', '20:55:41'),
(75, 84, 80, 'Pending', '2023-05-14', '20:20:00', '', NULL, NULL),
(76, 84, 80, 'Pending', '2023-05-14', '20:33:00', '', NULL, NULL);

--
-- Triggers `purchase_order`
--
DELIMITER $$
CREATE TRIGGER `distributor_update_total_sale` BEFORE UPDATE ON `purchase_order` FOR EACH ROW BEGIN
DECLARE reserved_pid INT;
DECLARE reserved_qty INT;
DECLARE done INT DEFAULT 0;
DECLARE reserved_products CURSOR FOR
	SELECT product_id,quantity FROM purchase_include WHERE po_id = NEW.po_id;

DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

IF OLD.po_state <> NEW.po_state AND NEW.po_state = 'Completed' THEN
	SET done = 0;
	OPEN reserved_products;
    FETCH reserved_products INTO reserved_pid,reserved_qty;
    WHILE NOT done DO
    	UPDATE distributor_keep SET total_sale = total_sale + reserved_qty WHERE distributor_id = NEW.distributor_id AND product_id = reserved_pid;
	FETCH reserved_products INTO reserved_pid,reserved_qty;
    END WHILE;
    CLOSE reserved_products;
END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `notify_dealer` BEFORE UPDATE ON `purchase_order` FOR EACH ROW BEGIN
	DECLARE dealer_name VARCHAR(255);
	IF OLD.po_state <> NEW.po_state THEN
    	SELECT CONCAT(first_name,' ',last_name) INTO dealer_name FROM users WHERE user_id = NEW.dealer_id;
        INSERT INTO notifications VALUES(NEW.dealer_id,DATE_FORMAT(NOW(), '%Y-%m-%d'),DATE_FORMAT(NOW(), '%H:%i:%s'),'Purchase Order Status',CONCAT('Hi! ',dealer_name,', Your purchase order with Order ID : ',NEW.po_id,' was ',NEW.po_state,'.'),'delivered');
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_leadtime` BEFORE UPDATE ON `purchase_order` FOR EACH ROW BEGIN
DECLARE po_include_pid INT;
DECLARE datediff INT;
DECLARE done INT DEFAULT 0;
DECLARE po_includes CURSOR FOR
	SELECT product_id FROM purchase_include WHERE po_id = NEW.po_id;

DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
SET done = 0;
-- TAKE THE DIFFERENCE BETWEEN place_date and delivered_date into datediff
SET datediff = DATEDIFF(NEW.delivered_date,NEW.place_date);

-- UPDATE NEW LEADTIME FOR ALL PRODUCTS IN THE PO AFTER ORDER COMPLETED
IF NEW.po_state <> OLD.po_state AND NEW.po_state = 'Completed' THEN
	OPEN po_includes;
	FETCH po_includes INTO po_include_pid;
	WHILE NOT done DO
		-- UPDATE LEAD TIME
        UPDATE dealer_keep SET lead_time = FLOOR((lead_time*(po_counter-1)+datediff)/po_counter) WHERE dealer_id = NEW.dealer_id AND product_id = po_include_pid;
		FETCH po_includes INTO po_include_pid;
    END WHILE;
	CLOSE po_includes;
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `quota`
--

CREATE TABLE `quota` (
  `company_id` int(11) NOT NULL,
  `customer_type` varchar(255) NOT NULL,
  `monthly_limit` double NOT NULL,
  `state` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quota`
--

INSERT INTO `quota` (`company_id`, `customer_type`, `monthly_limit`, `state`) VALUES
(77, 'Domestic', 2.3, 'OFF'),
(77, 'Large Scale Business', 2.3, 'OFF'),
(77, 'Small Scale Business', 2.3, 'OFF'),
(78, 'Domestic', 2.3, 'OFF'),
(78, 'Large Scale Business', 2.3, 'OFF'),
(78, 'Small Scale Business', 2.3, 'OFF');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_state` varchar(255) NOT NULL,
  `priority` int(11) DEFAULT 0,
  `mailed` int(11) DEFAULT 0,
  `responded_to_mail` int(11) DEFAULT 0,
  `payment_method` varchar(255) NOT NULL,
  `pay_slip` varchar(255) DEFAULT NULL,
  `stock_verification` int(11) DEFAULT NULL,
  `payment_verification` varchar(255) DEFAULT NULL,
  `collecting_method` varchar(255) NOT NULL,
  `place_date` date NOT NULL,
  `place_time` time NOT NULL,
  `accepted_date` date DEFAULT NULL,
  `accepted_time` time DEFAULT NULL,
  `dispatched_date` date DEFAULT NULL,
  `dispatched_time` time DEFAULT NULL,
  `dealer_id` int(11) NOT NULL,
  `bank` varchar(255) DEFAULT NULL,
  `branch` varchar(255) DEFAULT NULL,
  `acc_no` int(11) DEFAULT NULL,
  `refund_date` date DEFAULT NULL,
  `refund_time` time DEFAULT NULL,
  `refund_payslip` varchar(255) DEFAULT NULL,
  `refund_verification` varchar(255) DEFAULT NULL,
  `delivery_id` int(11) DEFAULT NULL,
  `deliver_date` date DEFAULT NULL,
  `deliver_time` time DEFAULT NULL,
  `deliver_city` varchar(255) DEFAULT NULL,
  `deliver_street` varchar(255) DEFAULT NULL,
  `deliver_charge` double DEFAULT NULL,
  `cancel_date` date DEFAULT NULL,
  `cancel_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`order_id`, `customer_id`, `order_state`, `priority`, `mailed`, `responded_to_mail`, `payment_method`, `pay_slip`, `stock_verification`, `payment_verification`, `collecting_method`, `place_date`, `place_time`, `accepted_date`, `accepted_time`, `dispatched_date`, `dispatched_time`, `dealer_id`, `bank`, `branch`, `acc_no`, `refund_date`, `refund_time`, `refund_payslip`, `refund_verification`, `delivery_id`, `deliver_date`, `deliver_time`, `deliver_city`, `deliver_street`, `deliver_charge`, `cancel_date`, `cancel_time`) VALUES
(37, 75, 'Completed', 0, 1, 1, 'Credit card', NULL, 1, 'verified', 'Delivery', '2023-05-14', '01:54:35', '2023-05-14', '01:54:35', '2023-05-14', '02:37:42', 84, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 87, '2023-05-14', '02:57:39', 'Boralesgamuwa', '175', 91, NULL, NULL),
(38, 86, 'Completed', 0, 0, 0, 'Bank Deposit', '16840101301.jpg', 1, 'verified', 'Pickup', '2023-05-14', '02:05:27', '2023-05-14', '02:13:06', NULL, NULL, 84, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(39, 75, 'Delivered', 0, 0, 0, 'Bank Deposit', '16840153502.jpg', 1, 'verified', 'Pickup', '2023-05-14', '03:32:28', '2023-05-14', '04:49:05', NULL, NULL, 84, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(40, 86, 'Accepted', 0, 0, 0, 'Credit card', NULL, 1, 'verified', 'Pickup', '2023-05-14', '03:33:35', '2023-05-14', '03:33:35', NULL, NULL, 84, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(41, 91, 'Dispatched', 0, 0, 0, 'Credit card', NULL, 1, 'verified', 'Delivery', '2023-05-14', '04:38:30', '2023-05-14', '04:38:30', '2023-05-14', '05:14:12', 84, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 87, NULL, NULL, 'Athurugiriya', 'No51,MainStreet', 180, NULL, NULL),
(42, 86, 'Canceled', 0, 0, 0, 'Bank Deposit', '16840194223.jpg', 1, 'pending', 'Pickup', '2023-05-14', '04:40:20', NULL, NULL, NULL, NULL, 84, 'Bank', 'Homagama', 2147483647, NULL, NULL, '16840399131.jpg', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, '2023-05-14', '04:42:52'),
(43, 91, 'Pending', 0, 0, 0, 'Bank Deposit', '16840211423.jpg', 1, 'pending', 'Pickup', '2023-05-14', '05:09:00', NULL, NULL, NULL, NULL, 84, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44, 75, 'Accepted', 1, 1, 1, 'Credit card', NULL, 1, 'verified', 'Delivery', '2023-05-14', '05:10:25', '2023-05-14', '05:10:25', NULL, NULL, 84, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Boralesgamuwa', '175', 4, NULL, NULL),
(45, 91, 'Accepted', 0, 1, 0, 'Credit card', NULL, 1, 'verified', 'Delivery', '2023-05-14', '10:17:19', '2023-05-14', '10:17:19', NULL, NULL, 84, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Athurugiriya', 'No51,MainStreet', 390, NULL, NULL),
(46, 75, 'Pending', 0, 0, 0, 'Bank Deposit', '16840397302.jpg', 1, 'pending', 'Pickup', '2023-05-14', '10:18:48', NULL, NULL, NULL, NULL, 84, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(47, 91, 'Canceled', 0, 0, 0, 'Credit card', NULL, 1, 'verified', 'Delivery', '2023-05-14', '10:20:40', '2023-05-14', '10:20:40', NULL, NULL, 84, 'Commercial', 'Athurugiriya', 2147483647, '2023-05-14', '10:24:59', '16840400553.jpg', 'verified', NULL, NULL, NULL, 'Athurugiriya', 'No51,MainStreet', 390, '2023-05-14', '10:21:31'),
(48, 75, 'Canceled', 0, 0, 0, 'Credit card', NULL, 1, 'verified', 'Pickup', '2023-05-14', '10:22:48', '2023-05-14', '10:22:48', NULL, NULL, 84, 'Bank', 'Homagama', 2147483647, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-05-14', '10:23:37'),
(49, 86, 'Pending', 0, 0, 0, 'Credit card', NULL, 0, 'verified', 'Delivery', '2023-05-15', '00:11:30', NULL, NULL, NULL, NULL, 84, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Homagama', 'HospitalRoad', 150, NULL, NULL);

--
-- Triggers `reservation`
--
DELIMITER $$
CREATE TRIGGER `notify_customer` BEFORE UPDATE ON `reservation` FOR EACH ROW BEGIN
	DECLARE cus_name VARCHAR(255);
	IF OLD.order_state <> NEW.order_state THEN
    	SELECT CONCAT(first_name,' ',last_name) INTO cus_name FROM users WHERE user_id = NEW.customer_id;
        INSERT INTO notifications VALUES(NEW.customer_id,DATE_FORMAT(NOW(), '%Y-%m-%d'),DATE_FORMAT(NOW(), '%H:%i:%s'),'Order Status',CONCAT('Hi! ',cus_name,', Your order with Order ID : <strong>',NEW.order_id,'</strong> was <strong>',NEW.order_state,'</strong>.'),'delivered');
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `notifyadminforpayslip` BEFORE UPDATE ON `reservation` FOR EACH ROW BEGIN
    -- check for regular payments
    DECLARE user_name VARCHAR(255);
    SELECT CONCAT(first_name,' ', last_name) INTO user_name FROM users WHERE user_id = NEW.customer_id;
    IF NEW.payment_verification <> OLD.payment_verification AND NEW.payment_verification = 'pending' THEN
        INSERT INTO notifications VALUES (1, DATE_FORMAT(NOW(), '%Y-%m-%d'), TIME_FORMAT(NOW(), '%H:%i:%s'), "Payslip Verification", CONCAT("You have a new regular payment verification request from User ID: <strong>", NEW.customer_id, "</strong> user name <strong>", user_name,"</strong>"), 'delivered');
    END IF;

    -- check for refund payments
    SELECT CONCAT(first_name,' ', last_name) INTO user_name FROM users WHERE user_id = NEW.dealer_id;
    IF NEW.refund_verification <> OLD.refund_verification AND NEW.refund_verification = 'pending' THEN
        INSERT INTO notifications VALUES (1, DATE_FORMAT(NOW(), '%Y-%m-%d'), TIME_FORMAT(NOW(), '%H:%i:%s'), "Payslip Verification", CONCAT("You have a new refund payment verification request from User ID: <strong>", NEW.dealer_id, "</strong> user name <strong>", user_name,"</strong>"), 'delivered');
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `notifyadminforpayslipinsert` BEFORE INSERT ON `reservation` FOR EACH ROW BEGIN
    -- check for regular payments
    DECLARE user_name VARCHAR(255);
    SELECT CONCAT(first_name,' ', last_name) INTO user_name FROM users WHERE user_id = NEW.customer_id;
    IF NEW.payment_verification = 'pending' THEN
        INSERT INTO notifications VALUES (1, DATE_FORMAT(NOW(), '%Y-%m-%d'), TIME_FORMAT(NOW(), '%H:%i:%s'), "Payslip Verification", CONCAT("You have a new regular payment verification request from User ID: <strong>", NEW.customer_id, "</strong> user name <strong>", user_name,"</strong>"), 'delivered');
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `stockandpaymentflags` BEFORE UPDATE ON `reservation` FOR EACH ROW BEGIN
  IF NEW.order_state = 'Pending' AND NEW.stock_verification = 1 AND NEW.payment_verification = 'verified'  AND (OLD.stock_verification <> NEW.stock_verification OR OLD.payment_verification <> NEW.payment_verification) THEN
    SET NEW.order_state = 'Accepted';
    SET NEW.accepted_date = DATE(NOW());
    SET NEW.accepted_time = TIME(NOW());
  END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `stockandpaymentflags_insert` BEFORE INSERT ON `reservation` FOR EACH ROW BEGIN
  IF NEW.stock_verification = 1 AND NEW.payment_verification = 'verified' THEN
    SET NEW.order_state = 'Accepted';
    SET NEW.accepted_date = DATE(NOW());
    SET NEW.accepted_time = TIME(NOW());
  END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_total_sale` BEFORE UPDATE ON `reservation` FOR EACH ROW BEGIN
DECLARE reserved_pid INT;
DECLARE reserved_qty INT;
DECLARE done INT DEFAULT 0;
DECLARE reserved_products CURSOR FOR
	SELECT product_id,quantity FROM reservation_include WHERE order_id = NEW.order_id;

DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

IF OLD.order_state <> NEW.order_state AND NEW.order_state = 'Delivered' THEN
	SET done = 0;
	OPEN reserved_products;
    FETCH reserved_products INTO reserved_pid,reserved_qty;
    WHILE NOT done DO
    	UPDATE dealer_keep SET total_sale = total_sale + reserved_qty WHERE dealer_id = NEW.dealer_id AND product_id = reserved_pid;
        FETCH reserved_products INTO reserved_pid,reserved_qty;
    END WHILE;
    CLOSE reserved_products;
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `reservation_include`
--

CREATE TABLE `reservation_include` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservation_include`
--

INSERT INTO `reservation_include` (`order_id`, `product_id`, `quantity`, `unit_price`) VALUES
(37, 40, 1, 700),
(37, 44, 1, 1395),
(38, 42, 1, 3738),
(39, 42, 1, 3738),
(40, 40, 1, 700),
(40, 41, 1, 1502),
(41, 41, 1, 1502),
(41, 44, 1, 1395),
(42, 40, 1, 700),
(43, 42, 1, 3738),
(44, 40, 1, 700),
(45, 42, 1, 3738),
(46, 41, 1, 1502),
(47, 42, 1, 3738),
(48, 44, 1, 1395),
(49, 40, 2, 700);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `order_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `message` varchar(255) NOT NULL,
  `review_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`order_id`, `date`, `time`, `message`, `review_type`) VALUES
(37, '2023-05-14', '04:12:51', 'Outstanding LP gas store! Impressive inventory, competitive prices, and knowledgeable staff. A reliable destination for all your LP gas requirements. Highly satisfied with their service.', 'Dealer'),
(37, '2023-05-14', '04:13:46', 'Exceptional LP gas delivery service! The delivery person was punctual, courteous, and professional. They handled the delivery efficiently and with utmost care. Highly recommend their reliable and friendly service.', 'Delivery'),
(38, '2023-05-14', '05:07:59', 'Efficient LP gas delivery service with prompt communication, professional drivers, and adherence to safety protocols. Highly recommended!', 'Dealer');

-- --------------------------------------------------------

--
-- Table structure for table `stock_include`
--

CREATE TABLE `stock_include` (
  `stock_req_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock_include`
--

INSERT INTO `stock_include` (`stock_req_id`, `product_id`, `quantity`, `unit_price`) VALUES
(11, 40, 100, 700),
(11, 41, 106, 1502),
(11, 42, 107, 3738),
(11, 43, 89, 11180),
(11, 44, 200, 1395),
(12, 40, 100, 700),
(12, 41, 110, 1502),
(12, 42, 120, 3738),
(12, 43, 90, 11180),
(12, 44, 500, 1395),
(13, 45, 100, 845),
(13, 46, 47, 1596),
(13, 47, 80, 3990),
(13, 48, 40, 2150),
(14, 40, 10, 700),
(14, 43, 10, 11180),
(14, 44, 20, 1395),
(16, 41, 5, 1502),
(16, 42, 5, 3738),
(16, 44, 10, 1395),
(17, 41, 7, 1502),
(17, 44, 7, 1395);

-- --------------------------------------------------------

--
-- Table structure for table `stock_request`
--

CREATE TABLE `stock_request` (
  `stock_req_id` int(11) NOT NULL,
  `distributor_id` int(11) NOT NULL,
  `stock_req_state` varchar(255) NOT NULL,
  `company_id` int(11) NOT NULL,
  `delay_time` int(11) NOT NULL,
  `place_date` date NOT NULL,
  `place_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock_request`
--

INSERT INTO `stock_request` (`stock_req_id`, `distributor_id`, `stock_req_state`, `company_id`, `delay_time`, `place_date`, `place_time`) VALUES
(11, 80, 'completed', 77, 0, '2023-05-13', '21:38:00'),
(12, 80, 'completed', 77, 0, '2023-05-14', '14:07:00'),
(13, 95, 'completed', 78, 0, '2023-05-14', '14:25:00'),
(14, 80, 'delayed', 77, 0, '2023-05-14', '20:21:00'),
(16, 80, 'pending', 77, 0, '2023-05-14', '20:22:00'),
(17, 80, 'pending', 77, 0, '2023-05-14', '20:23:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `verification_code` varchar(255) DEFAULT NULL,
  `verification_state` varchar(255) DEFAULT NULL,
  `date_joined` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `first_name`, `last_name`, `type`, `verification_code`, `verification_state`, `date_joined`) VALUES
(1, 'admin@gasify.com', '$2y$10$n1TIHKZIwyI.rrNngxIeCOaDjQQUP4AKZzJUEMGSG1Ypn7uG8/s7S', 'Dinuka', 'Amarasinghe', 'admin', '1a45fd94b3cebc5000c69a246d4fdfc0', 'verified', '2023-01-01'),
(75, 'customer1@gasify.com', '$2y$10$2L7G.rpsVFiMMUBX4nAwOOxQf4UsVTiTS9YjRBzE3Zfqll9p1eUG6', 'Sasangi', 'Nayanathara', 'customer', '3a00045209cbc4bb9bd07193232639e9', 'verified', '2023-05-03'),
(77, 'litro@gasify.com', '$2y$10$TNEXAhXRaYr7h7XOftmPROcofkDQ54sQJ/0e4CdUtS8HerSdTcEbq', 'Muditha', 'Peris', 'company', '712b6a52b0b62815b65d49606c90b68b', 'verified', '2023-05-03'),
(78, 'laugfs@gasify.com', '$2y$10$7u79Ke.FT3NqLoxXjSrhKuSEICkA9uwWM7egXEAad/xnt6GiH7L.O', 'Hemachandra', 'Wegapitiya', 'company', '9382c3b2bda056a352512eb5f8ddc749', 'verified', '2023-05-03'),
(80, 'distributor1@gasify.com', '$2y$10$OBwBtKl/n2YWKjIsBtIqqe/qRBjSmo405usbL9hNax8HdUSB733Wa', 'Hashini', 'Thilinika', 'distributor', 'a679f4d5da56eee8a40f21b2b72fadd2', 'verified', '2023-05-03'),
(81, 'distributor2@gasify.com', '$2y$10$9CkmoXdTXx4G3WHALPJbvuLi0ZauWbBaG5rfRnDmiOUs8pRTlFXyq', 'Denuwara', 'Thilakarathne', 'distributor', '13ee7fcf46e30c381cb3857684fb546a', 'verified', '2023-05-03'),
(82, 'distributor3@gasify.com', '$2y$10$ikHPgVuPyWO0Fuge1Li6Culj03.NkZA3vkzro5.sO.ea0AZBjYr9m', 'Nikitha', 'Fernando', 'distributor', 'c4bf9208ac460febbffa9c72c01d5bf9', 'verified', '2023-05-03'),
(83, 'dealer3@gasify.com', '$2y$10$VexJb2svt7P.u5m3hfR3D.SVzJvXVCsKPUitvgePo5JJLeEl75F36', 'Lakmina', 'Palihawadana', 'dealer', '6826c958a11c2e41f99cf443614cb9dc', 'verified', '2023-05-03'),
(84, 'dealer1@gasify.com', '$2y$10$YoeK0IfjkXrHRtlQ0TjL1.jRRa5ZrQ/2YG4HhPfBBfXGXM3oWF1u2', 'Dinuka', 'Amarasinghe', 'dealer', '34d3df55230aab02817661668629c594', 'verified', '2023-05-03'),
(85, 'dealer2@gasify.com', '$2y$10$fe9AMaG2YF9vLrz7XC3aSuiRxH2nh1lWwb63SHbd2bzeWW4jlQAIe', 'Rusiru', 'Edirisinghe', 'dealer', '367f2f564bcb7cbd9a3ab6fbbf9415e9', 'verified', '2023-05-03'),
(86, 'customer2@gasify.com', '$2y$10$5/uwo/6pqyIwxMy8Gv6tyebg.FNk3bZ5fdTaCC4ySkNjVV0EKFnn6', 'Ravindu', 'Galagedara', 'customer', '62c828ae6dddfe085e7be05cff3c2223', 'verified', '2023-05-13'),
(87, 'delivery1@gasify.com', '$2y$10$uz/kIUldoUCTdW4QnuP9c./J4sQChHEZaSUID98uas2sudl6C4MSm', 'Avishka', 'Prabhath', 'delivery', '8741eea4ba468a0a7461566b7f18c4f1', 'verified', '2023-05-13'),
(88, 'delivery2@gasify.com', '$2y$10$B.gSdAQvTfL4OSQfvOff2eeKh98aiBVKZ.BBDiTdGNBmPunx1yoU.', 'Nipun', 'Kalhara', 'delivery', 'c76274c508798f777ad0441f829b9b84', 'verified', '2023-05-14'),
(90, 'delivery3@gasify.com', '$2y$10$8aMF8Q.yMSmqjsF2wXzmz.4Mu60uGTtLoqSLWQCe1COwmpRLgYsr6', 'Sahan', 'Fonseka', 'delivery', '7b8741b1abe322c13733e5fa21d9329b', 'verified', '2023-05-14'),
(91, 'customer3@gasify.com', '$2y$10$dddyzuIL5vhnf9zSO5oGfeeJShQ2ZIJgzhwpCwSoJUz3EA0hq60US', 'Neelika', 'Jayasekara', 'customer', 'de8ff49c8af2e1629debf30cd91ba645', 'verified', '2023-05-14'),
(92, 'dealer4@gasify.com', '$2y$10$enLgY3Ps3Hs6OcsUy/14BuW562Zf4AU0CYpOZFPbIwwToE6sJjLym', 'Gamunu', 'Perera', 'dealer', '4d32aff0acdc0ad194559956d4cb31d9', 'verified', '2023-05-14'),
(93, 'dealer5@gasify.com', '$2y$10$Fnwzi52.IFfcephk1lNYSO6oMw5jooUF4Dj5LE.jqMVBXMtS78T5S', 'Saman', 'Silva', 'dealer', 'bed36b90c1c002e7e00f786d559a60b6', 'verified', '2023-05-14'),
(94, 'dealer6@gasify.com', '$2y$10$JsZZewNsrBS3w4gtbMado.5UBTJ9KboPCd8jgfaPMKpEJcifzC2la', 'Anjana', 'Perera', 'dealer', '673cc559bffbf236bd505c664f056f65', 'verified', '2023-05-14'),
(95, 'distributor4@gasify.com', '$2y$10$C/RVBVq1sTQoFOUnaIeVk.UqoYqNOcah3edLpns1hb/k/1CpYO5w6', 'Nimal', 'Priyankara', 'distributor', 'fa803b8dcca63101de48aa42ee28cd43', 'verified', '2023-05-14'),
(96, 'dealer7@gasify.com', '$2y$10$Stg9qKEw42iowtfQ29xqb.MP7qB/8G67Qtz6nwFiXhskg1qTLabMy', 'Nimali', 'Fonseka', 'dealer', '576d5fdcdacb40777ab242a8e6aeddc8', 'verified', '2023-05-14'),
(97, 'dealer8@gasify.com', '$2y$10$2Txcj3XjjF0Meq8lsEy8de3sSwbRnBrBvYlmmdf2DVH4Oyh635b5C', 'Nadun', 'Fonseka', 'dealer', 'd13314d1f2e188f18c334aaac1e23786', 'verified', '2023-05-14'),
(98, 'dealer9@gasify.com', '$2y$10$S8Q7VaJjaQgAQtU6vevzF.fjGSuXweCqwb8dwA1F8G5UrB1wJm9CW', 'Dasun', 'Perera', 'dealer', '8ba408a92fc47d6d01810a9de16faf94', 'verified', '2023-05-14'),
(99, 'dealer10@gasify.com', '$2y$10$JNqcazkVgqMwEX.4m1eXteZ6gYqaNZXy8OM4DIPaW4HTJfyXCqyVO', 'Nimesh', 'Fernando', 'dealer', 'e77933aa053bf561c6cc8b6953ac1292', 'verified', '2023-05-14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `assign_purchase`
--
ALTER TABLE `assign_purchase`
  ADD PRIMARY KEY (`po_id`,`distributor_id`,`vehicle_no`),
  ADD KEY `distributor_id` (`distributor_id`),
  ADD KEY `vehicle_no` (`vehicle_no`);

--
-- Indexes for table `assign_stock`
--
ALTER TABLE `assign_stock`
  ADD PRIMARY KEY (`distributor_id`,`stock_req_id`,`vehicle_no`),
  ADD KEY `assignstock3` (`stock_req_id`),
  ADD KEY `assignstock2` (`vehicle_no`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `ebill_no` (`ebill_no`);

--
-- Indexes for table `customer_quota`
--
ALTER TABLE `customer_quota`
  ADD PRIMARY KEY (`customer_id`,`company_id`,`customer_type`),
  ADD KEY `customerquota2` (`company_id`),
  ADD KEY `customerquota3` (`customer_type`);

--
-- Indexes for table `customer_support`
--
ALTER TABLE `customer_support`
  ADD PRIMARY KEY (`customer_id`,`admin_id`,`date`,`time`),
  ADD KEY `adminmessage` (`admin_id`);

--
-- Indexes for table `dealer`
--
ALTER TABLE `dealer`
  ADD PRIMARY KEY (`dealer_id`),
  ADD KEY `companyworks` (`company_id`),
  ADD KEY `distributorworks` (`distributor_id`);

--
-- Indexes for table `dealer_capacity`
--
ALTER TABLE `dealer_capacity`
  ADD PRIMARY KEY (`dealer_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `dealer_keep`
--
ALTER TABLE `dealer_keep`
  ADD PRIMARY KEY (`dealer_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `delivery_charge`
--
ALTER TABLE `delivery_charge`
  ADD PRIMARY KEY (`min_distance`,`max_distance`),
  ADD KEY `admindeliverycharge` (`admin_id`),
  ADD KEY `min_distance` (`min_distance`),
  ADD KEY `max_distance` (`max_distance`);

--
-- Indexes for table `delivery_person`
--
ALTER TABLE `delivery_person`
  ADD PRIMARY KEY (`delivery_id`);

--
-- Indexes for table `distributor`
--
ALTER TABLE `distributor`
  ADD PRIMARY KEY (`distributor_id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `distributor_capacity`
--
ALTER TABLE `distributor_capacity`
  ADD PRIMARY KEY (`distributor_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `distributor_keep`
--
ALTER TABLE `distributor_keep`
  ADD PRIMARY KEY (`distributor_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `distributor_vehicle`
--
ALTER TABLE `distributor_vehicle`
  ADD PRIMARY KEY (`distributor_id`,`vehicle_no`),
  ADD UNIQUE KEY `vehicle_no_2` (`vehicle_no`),
  ADD KEY `vehicle_no` (`vehicle_no`);

--
-- Indexes for table `distributor_vehicle_capacity`
--
ALTER TABLE `distributor_vehicle_capacity`
  ADD PRIMARY KEY (`distributor_id`,`vehicle_no`,`product_id`),
  ADD KEY `distributorvehicleid` (`vehicle_no`),
  ADD KEY `productid` (`product_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`user_id`,`date`,`time`);

--
-- Indexes for table `old_passwords`
--
ALTER TABLE `old_passwords`
  ADD PRIMARY KEY (`user_id`,`old_password`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `companyproduceproduct` (`company_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `purchase_include`
--
ALTER TABLE `purchase_include`
  ADD PRIMARY KEY (`po_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `purchase_order`
--
ALTER TABLE `purchase_order`
  ADD PRIMARY KEY (`po_id`),
  ADD KEY `distributortakepurchaseorder` (`distributor_id`),
  ADD KEY `dealer` (`dealer_id`);

--
-- Indexes for table `quota`
--
ALTER TABLE `quota`
  ADD PRIMARY KEY (`company_id`,`customer_type`),
  ADD KEY `customer_type` (`customer_type`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customerplaceorder` (`customer_id`),
  ADD KEY `belongstodealer` (`dealer_id`),
  ADD KEY `orderdelivery` (`delivery_id`);

--
-- Indexes for table `reservation_include`
--
ALTER TABLE `reservation_include`
  ADD PRIMARY KEY (`order_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`order_id`,`date`,`time`);

--
-- Indexes for table `stock_include`
--
ALTER TABLE `stock_include`
  ADD PRIMARY KEY (`stock_req_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `stock_request`
--
ALTER TABLE `stock_request`
  ADD PRIMARY KEY (`stock_req_id`),
  ADD KEY `companytakerequest` (`company_id`),
  ADD KEY `distributor` (`distributor_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `purchase_order`
--
ALTER TABLE `purchase_order`
  MODIFY `po_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `stock_request`
--
ALTER TABLE `stock_request`
  MODIFY `stock_req_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `user1` FOREIGN KEY (`admin_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `assign_purchase`
--
ALTER TABLE `assign_purchase`
  ADD CONSTRAINT `assign_purchase_ibfk_2` FOREIGN KEY (`distributor_id`) REFERENCES `distributor_vehicle` (`distributor_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `assign_purchase_ibfk_3` FOREIGN KEY (`vehicle_no`) REFERENCES `distributor_vehicle` (`vehicle_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `po_id` FOREIGN KEY (`po_id`) REFERENCES `purchase_order` (`po_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `assign_stock`
--
ALTER TABLE `assign_stock`
  ADD CONSTRAINT `assignstock1` FOREIGN KEY (`distributor_id`) REFERENCES `distributor_vehicle` (`distributor_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `assignstock2` FOREIGN KEY (`vehicle_no`) REFERENCES `distributor_vehicle` (`vehicle_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `assignstock3` FOREIGN KEY (`stock_req_id`) REFERENCES `stock_request` (`stock_req_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `company`
--
ALTER TABLE `company`
  ADD CONSTRAINT `user2` FOREIGN KEY (`company_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `user3` FOREIGN KEY (`customer_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `customer_quota`
--
ALTER TABLE `customer_quota`
  ADD CONSTRAINT `customerquota1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `customerquota2` FOREIGN KEY (`company_id`) REFERENCES `quota` (`company_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `customerquota3` FOREIGN KEY (`customer_type`) REFERENCES `quota` (`customer_type`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `customer_support`
--
ALTER TABLE `customer_support`
  ADD CONSTRAINT `adminmessage` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `customermessage` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `dealer`
--
ALTER TABLE `dealer`
  ADD CONSTRAINT `companyworks` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `distributorworks` FOREIGN KEY (`distributor_id`) REFERENCES `distributor` (`distributor_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user4` FOREIGN KEY (`dealer_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dealer_capacity`
--
ALTER TABLE `dealer_capacity`
  ADD CONSTRAINT `dealer_capacity_ibfk_1` FOREIGN KEY (`dealer_id`) REFERENCES `dealer` (`dealer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dealer_capacity_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dealer_keep`
--
ALTER TABLE `dealer_keep`
  ADD CONSTRAINT `dealer_keep_ibfk_1` FOREIGN KEY (`dealer_id`) REFERENCES `dealer` (`dealer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dealer_keep_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `delivery_charge`
--
ALTER TABLE `delivery_charge`
  ADD CONSTRAINT `admindeliverycharge` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`admin_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `delivery_person`
--
ALTER TABLE `delivery_person`
  ADD CONSTRAINT `user5` FOREIGN KEY (`delivery_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `distributor`
--
ALTER TABLE `distributor`
  ADD CONSTRAINT `hascomp` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user6` FOREIGN KEY (`distributor_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `distributor_capacity`
--
ALTER TABLE `distributor_capacity`
  ADD CONSTRAINT `distributor_capacity_ibfk_1` FOREIGN KEY (`distributor_id`) REFERENCES `distributor` (`distributor_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `distributor_capacity_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `distributor_keep`
--
ALTER TABLE `distributor_keep`
  ADD CONSTRAINT `distributor_keep_ibfk_1` FOREIGN KEY (`distributor_id`) REFERENCES `distributor` (`distributor_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `distributor_keep_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `distributor_vehicle`
--
ALTER TABLE `distributor_vehicle`
  ADD CONSTRAINT `distributorownvehicle` FOREIGN KEY (`distributor_id`) REFERENCES `distributor` (`distributor_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `distributor_vehicle_capacity`
--
ALTER TABLE `distributor_vehicle_capacity`
  ADD CONSTRAINT `distributorid` FOREIGN KEY (`distributor_id`) REFERENCES `distributor_vehicle` (`distributor_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `distributorvehicleid` FOREIGN KEY (`vehicle_no`) REFERENCES `distributor_vehicle` (`vehicle_no`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productid` FOREIGN KEY (`product_id`) REFERENCES `distributor_capacity` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `old_passwords`
--
ALTER TABLE `old_passwords`
  ADD CONSTRAINT `user7` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `companyproduceproduct` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase_include`
--
ALTER TABLE `purchase_include`
  ADD CONSTRAINT `po_id8` FOREIGN KEY (`po_id`) REFERENCES `purchase_order` (`po_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchase_include_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `purchase_order`
--
ALTER TABLE `purchase_order`
  ADD CONSTRAINT `dealerperchaseorder` FOREIGN KEY (`dealer_id`) REFERENCES `dealer` (`dealer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `distributortakepurchaseorder` FOREIGN KEY (`distributor_id`) REFERENCES `distributor` (`distributor_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quota`
--
ALTER TABLE `quota`
  ADD CONSTRAINT `companyaddquota` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `belongstodealer` FOREIGN KEY (`dealer_id`) REFERENCES `dealer` (`dealer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `customerplaceorder` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orderdelivery` FOREIGN KEY (`delivery_id`) REFERENCES `delivery_person` (`delivery_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `reservation_include`
--
ALTER TABLE `reservation_include`
  ADD CONSTRAINT `reservation_include_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `reservation` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_include_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `reservation` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stock_include`
--
ALTER TABLE `stock_include`
  ADD CONSTRAINT `stock_include_ibfk_1` FOREIGN KEY (`stock_req_id`) REFERENCES `stock_request` (`stock_req_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stock_include_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stock_request`
--
ALTER TABLE `stock_request`
  ADD CONSTRAINT `companytakerequest` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `distributorrequeststock` FOREIGN KEY (`distributor_id`) REFERENCES `distributor` (`distributor_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
