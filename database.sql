-- Database Creation Script for CuraConnect
-- Reverse engineered from PHP codebase

CREATE DATABASE IF NOT EXISTS `curaconnect`;
USE `curaconnect`;

-- Table: users
CREATE TABLE IF NOT EXISTS `users` (
  `email` varchar(255) NOT NULL,
  `type` char(1) NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: admin
CREATE TABLE IF NOT EXISTS `admin` (
  `aemail` varchar(255) NOT NULL,
  `apassword` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`aemail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default admin account
INSERT IGNORE INTO `admin` (`aemail`, `apassword`) VALUES ('admin@curaconnect.com', '123');
INSERT IGNORE INTO `users` (`email`, `type`) VALUES ('admin@curaconnect.com', 'a');

-- Table: patient
CREATE TABLE IF NOT EXISTS `patient` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `pemail` varchar(255) DEFAULT NULL,
  `pname` varchar(255) DEFAULT NULL,
  `ppassword` varchar(255) DEFAULT NULL,
  `paddress` varchar(255) DEFAULT NULL,
  `pdob` date DEFAULT NULL,
  `ptel` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: specialties
CREATE TABLE IF NOT EXISTS `specialties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sname` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default specialties
INSERT IGNORE INTO `specialties` (`id`, `sname`) VALUES
(1, 'General Surgery'),
(2, 'Cardiology'),
(3, 'Neurology'),
(4, 'Pediatrics'),
(5, 'Orthopedics'),
(6, 'Dermatology'),
(7, 'Ophthalmology'),
(8, 'Psychiatry');

-- Table: doctor
CREATE TABLE IF NOT EXISTS `doctor` (
  `docid` int(11) NOT NULL AUTO_INCREMENT,
  `docemail` varchar(255) DEFAULT NULL,
  `docname` varchar(255) DEFAULT NULL,
  `docpassword` varchar(255) DEFAULT NULL,
  `doctel` varchar(15) DEFAULT NULL,
  `specialties` int(11) DEFAULT NULL,
  PRIMARY KEY (`docid`),
  KEY `specialties` (`specialties`),
  CONSTRAINT `doctor_ibfk_1` FOREIGN KEY (`specialties`) REFERENCES `specialties` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: schedule
CREATE TABLE IF NOT EXISTS `schedule` (
  `scheduleid` int(11) NOT NULL AUTO_INCREMENT,
  `docid` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `scheduledate` date DEFAULT NULL,
  `scheduletime` time DEFAULT NULL,
  `nop` int(11) DEFAULT NULL,
  PRIMARY KEY (`scheduleid`),
  KEY `docid` (`docid`),
  CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`docid`) REFERENCES `doctor` (`docid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: appointment
CREATE TABLE IF NOT EXISTS `appointment` (
  `appoid` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) DEFAULT NULL,
  `apponum` int(11) DEFAULT NULL,
  `scheduleid` int(11) DEFAULT NULL,
  `appodate` date DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`appoid`),
  KEY `pid` (`pid`),
  KEY `scheduleid` (`scheduleid`),
  CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `patient` (`pid`) ON DELETE CASCADE,
  CONSTRAINT `appointment_ibfk_2` FOREIGN KEY (`scheduleid`) REFERENCES `schedule` (`scheduleid`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: payments
CREATE TABLE IF NOT EXISTS `payments` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_id` varchar(255) DEFAULT NULL,
  `scheduleid` int(11) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `scheduleid` (`scheduleid`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`scheduleid`) REFERENCES `schedule` (`scheduleid`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
