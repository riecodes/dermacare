-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2024 at 08:26 AM
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
-- Database: `edoc`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `aid` int(11) NOT NULL,
  `aname` varchar(255) NOT NULL,
  `atel` varchar(255) NOT NULL,
  `aaddress` varchar(255) NOT NULL,
  `aemail` varchar(255) NOT NULL,
  `apassword` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`aid`, `aname`, `atel`, `aaddress`, `aemail`, `apassword`) VALUES
(1, 'Tanauan', '', '', 'tanauan@edoc.com', 'tanauan'),
(2, 'Naic Branch', '0912 324 5122', 'Tokyo, Japan', 'naic@edoc.com', '123');

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `appoid` int(11) NOT NULL,
  `pid` int(10) NOT NULL,
  `apponum` int(3) NOT NULL,
  `scheduleid` int(10) NOT NULL,
  `appodate` date NOT NULL,
  `aid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`appoid`, `pid`, `apponum`, `scheduleid`, `appodate`, `aid`) VALUES
(7, 1, 1, 21, '2024-09-27', 0);

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `docid` int(11) NOT NULL,
  `docemail` varchar(255) DEFAULT NULL,
  `docname` varchar(255) DEFAULT NULL,
  `docpassword` varchar(255) DEFAULT NULL,
  `doctel` varchar(15) DEFAULT NULL,
  `specialties` int(2) DEFAULT NULL,
  `aid` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`docid`, `docemail`, `docname`, `docpassword`, `doctel`, `specialties`, `aid`) VALUES
(1, 'therapist@edoc.com', 'Therapist 1', '123', '0110000000', 1, 1),
(2, 'thera2@edoc.com', 'Test Therapist 2', '123', '1000000000', 1, 2),
(4, 'therapist@naic.com', 'Johnny Sins', '123', '011111111111', 2, 2),
(5, 'jimmy@edoc.com', 'Jimmy Pacquiao', '123', '01111111111', 1, 1),
(6, 'show@edoc.com', 'IShowSpeed', '123', '12652151252152', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `madmin`
--

CREATE TABLE `madmin` (
  `mid` int(11) NOT NULL,
  `mname` varchar(255) NOT NULL,
  `memail` varchar(255) NOT NULL,
  `mpassword` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `madmin`
--

INSERT INTO `madmin` (`mid`, `mname`, `memail`, `mpassword`) VALUES
(1, 'Main Administrator', 'main@edoc.com', 'main');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `pid` int(11) NOT NULL,
  `pemail` varchar(255) DEFAULT NULL,
  `pname` varchar(255) DEFAULT NULL,
  `ppassword` varchar(255) DEFAULT NULL,
  `paddress` varchar(255) DEFAULT NULL,
  `pnic` varchar(15) DEFAULT NULL,
  `pdob` date DEFAULT NULL,
  `ptel` varchar(15) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`pid`, `pemail`, `pname`, `ppassword`, `paddress`, `pnic`, `pdob`, `ptel`) VALUES
(1, 'patient@edoc.com', 'Test Patient', '123', 'Sri Lanka', '0000000000', '2000-01-01', '09345678901'),
(4, 'john@edoc.com', 'John  Doe', '123', 'Pilipens', '000000000000', '1932-10-30', '09124242242');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `productid` int(11) NOT NULL,
  `productname` varchar(255) NOT NULL,
  `productdesc` varchar(255) NOT NULL,
  `productquantity` int(11) NOT NULL,
  `productprice` decimal(10,2) DEFAULT NULL,
  `productimage` varchar(255) NOT NULL,
  `aid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productid`, `productname`, `productdesc`, `productquantity`, `productprice`, `productimage`, `aid`) VALUES
(13, 'Luxxe White Glutathione', 'whitens skin', 30, 253.00, 'uploads/fr-luxxewhtegltacps-60.jpg', 1),
(14, 'Kojie San Kojic Soap', 'exfoliating soap', 47, 75.00, 'uploads/kojic.jpg', 1),
(15, 'Computer', 'good for office and gaming', 1, 15000.00, 'uploads/computer.png', 2),
(16, '1', '1', 1, 1.00, 'uploads/fr-luxxewhtegltacps-60.jpg', 2);

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `requestid` int(11) NOT NULL,
  `productid` int(11) DEFAULT NULL,
  `stockid` int(11) DEFAULT NULL,
  `requestquantity` int(11) NOT NULL,
  `requestdate` date NOT NULL,
  `status` enum('Pending','Approved','Denied') DEFAULT NULL,
  `aid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`requestid`, `productid`, `stockid`, `requestquantity`, `requestdate`, `status`, `aid`) VALUES
(49, NULL, 1, 15, '2024-09-13', 'Approved', 1),
(55, 14, NULL, 1, '2024-09-13', 'Approved', 1),
(56, 13, NULL, 7, '2024-09-13', 'Pending', 1),
(57, NULL, 12, 1, '2024-09-13', 'Denied', 1),
(58, NULL, 13, 1, '2024-09-13', 'Pending', 1),
(59, 15, NULL, 5, '2024-09-13', 'Pending', 2),
(60, 15, NULL, 7, '2024-10-11', 'Pending', 2),
(61, NULL, 14, 6, '2024-09-13', 'Pending', 2);

-- --------------------------------------------------------

--
-- Table structure for table `reserve`
--

CREATE TABLE `reserve` (
  `reserveid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `aid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `scheduleid` int(11) NOT NULL,
  `docid` varchar(255) DEFAULT NULL,
  `treatmentid` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `scheduledate` date DEFAULT NULL,
  `scheduletime` time DEFAULT NULL,
  `aid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`scheduleid`, `docid`, `treatmentid`, `title`, `scheduledate`, `scheduletime`, `aid`) VALUES
(14, '1', 20, 'Cinderalla Drip', '2024-09-15', '02:19:00', 1),
(15, '1', 21, 'GAS', '2024-09-25', '02:21:00', 1),
(20, '4', 22, 'BABY', '2024-09-19', '02:48:00', 2),
(19, '2', 22, 'LIKE I WANT YOU', '2024-09-15', '01:31:00', 2),
(21, '4', 22, 'JOHNNUU', '2024-10-04', '22:24:00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `specialties`
--

CREATE TABLE `specialties` (
  `id` int(2) NOT NULL,
  `sname` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `specialties`
--

INSERT INTO `specialties` (`id`, `sname`) VALUES
(1, 'Face'),
(2, 'Body');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `stockid` int(11) NOT NULL,
  `stockname` varchar(255) NOT NULL,
  `stockdesc` varchar(255) NOT NULL,
  `stockquantity` int(11) NOT NULL,
  `stockprice` decimal(10,2) DEFAULT NULL,
  `stockimage` varchar(255) NOT NULL,
  `aid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`stockid`, `stockname`, `stockdesc`, `stockquantity`, `stockprice`, `stockimage`, `aid`) VALUES
(12, 'Machine Oil', 'oil for things', 15, 199.00, 'uploads/oil.png', 1),
(13, 'Sofa', 'comfy', 2, 3999.00, 'uploads/sofa.jpg', 1),
(14, 'SIR YES SIR', 'YES SIR', 10, 52.00, 'uploads/SIR YES SIR.jpg', 2),
(15, '1', '1', 1, 1.00, 'uploads/oil.png', 2);

-- --------------------------------------------------------

--
-- Table structure for table `treatment`
--

CREATE TABLE `treatment` (
  `treatmentid` int(11) NOT NULL,
  `treatmentname` varchar(255) NOT NULL,
  `treatmenttype` varchar(255) NOT NULL,
  `treatmentdesc` varchar(255) DEFAULT NULL,
  `treatmentprice` decimal(10,2) DEFAULT NULL,
  `treatmentmax` int(11) NOT NULL,
  `treatmentimage` varchar(255) NOT NULL,
  `aid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `treatment`
--

INSERT INTO `treatment` (`treatmentid`, `treatmentname`, `treatmenttype`, `treatmentdesc`, `treatmentprice`, `treatmentmax`, `treatmentimage`, `aid`) VALUES
(20, 'Cinderella Drip', '', 'basta bobonga skin mo', 888.00, 5, 'uploads/package1.jpg', 1),
(21, 'Ultimate Package', '', 'best skin on the whole world', 15000.00, 3, 'uploads/package9.jpg', 1),
(22, 'Chiropractor', '', 'ayos buto', 3999.00, 15, 'uploads/balikong bike.jpg', 2),
(23, '1', 'Consult', '1', 1.00, 1, 'uploads/cute-cat.jpg', 2);

-- --------------------------------------------------------

--
-- Table structure for table `webuser`
--

CREATE TABLE `webuser` (
  `email` varchar(255) NOT NULL,
  `usertype` char(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `webuser`
--

INSERT INTO `webuser` (`email`, `usertype`) VALUES
('tanauan@edoc.com', 'a'),
('therapist@edoc.com', 'd'),
('patient@edoc.com', 'p'),
('thera2@edoc.com', 'd'),
('naic@edoc.com', 'a'),
('main@edoc.com', 'm'),
('john@edoc.com', 'p'),
('therapist@naic.com', 'd'),
('jimmy@edoc.com', 'd'),
('1ah@ah.com', 'p'),
('show@edoc.com', 'd');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`aid`) USING BTREE;

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`appoid`),
  ADD KEY `pid` (`pid`),
  ADD KEY `scheduleid` (`scheduleid`),
  ADD KEY `fk_admin_aid` (`aid`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`docid`),
  ADD KEY `specialties` (`specialties`),
  ADD KEY `fk_admin_aid` (`aid`);

--
-- Indexes for table `madmin`
--
ALTER TABLE `madmin`
  ADD PRIMARY KEY (`mid`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`productid`),
  ADD KEY `bid` (`aid`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`requestid`),
  ADD KEY `aid` (`aid`) USING BTREE,
  ADD KEY `productid` (`productid`) USING BTREE,
  ADD KEY `stockid` (`stockid`);

--
-- Indexes for table `reserve`
--
ALTER TABLE `reserve`
  ADD KEY `productid` (`productid`) USING BTREE,
  ADD KEY `aid` (`aid`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`scheduleid`),
  ADD KEY `docid` (`docid`),
  ADD KEY `fk_admin_aid` (`aid`),
  ADD KEY `treatmentid` (`treatmentid`);

--
-- Indexes for table `specialties`
--
ALTER TABLE `specialties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`stockid`),
  ADD KEY `aid` (`aid`) USING BTREE;

--
-- Indexes for table `treatment`
--
ALTER TABLE `treatment`
  ADD PRIMARY KEY (`treatmentid`),
  ADD KEY `aid` (`aid`);

--
-- Indexes for table `webuser`
--
ALTER TABLE `webuser`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `appoid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `docid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `madmin`
--
ALTER TABLE `madmin`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `productid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `requestid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `scheduleid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `stockid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `treatment`
--
ALTER TABLE `treatment`
  MODIFY `treatmentid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `request_ibfk_1` FOREIGN KEY (`aid`) REFERENCES `admin` (`aid`) ON DELETE CASCADE,
  ADD CONSTRAINT `request_ibfk_2` FOREIGN KEY (`productid`) REFERENCES `product` (`productid`) ON DELETE CASCADE;

--
-- Constraints for table `treatment`
--
ALTER TABLE `treatment`
  ADD CONSTRAINT `treatment_ibfk_1` FOREIGN KEY (`aid`) REFERENCES `admin` (`aid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
