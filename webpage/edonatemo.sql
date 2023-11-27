-- Table structure for table `donationapprovallog`
CREATE TABLE `donationapprovallog` (
  `LogID` int(11) NOT NULL,
  `DonationID` int(11) DEFAULT NULL,
  `ApprovedBy` varchar(255) DEFAULT NULL,
  `ApprovalStatus` varchar(10) NOT NULL,
  `ApprovalDate` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`LogID`),
  KEY `fk_donation_approval_log_donation` (`DonationID`),
  CONSTRAINT `donationapprovallog_ibfk_1` FOREIGN KEY (`DonationID`) REFERENCES `donations` (`DonationID`),
  CONSTRAINT `fk_donation_approval_log_donation` FOREIGN KEY (`DonationID`) REFERENCES `donations` (`DonationID`) ON DELETE CASCADE
);

-- Table structure for table `donations`
CREATE TABLE `donations` (
  `DonationID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `DonationType` varchar(10) NOT NULL,
  `Description` text DEFAULT NULL,
  `ImageURL` varchar(255) DEFAULT NULL,
  `ImageReceiptURL` varchar(255) DEFAULT NULL,
  `Status` varchar(20) DEFAULT 'Pending',
  PRIMARY KEY (`DonationID`),
  KEY `UserID` (`UserID`),
  CONSTRAINT `donations_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`)
);

-- Table structure for table `users`
CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `UserName` varchar(255) NOT NULL,
  `PhoneNumber` varchar(15) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Address` varchar(255) NOT NULL,
  PRIMARY KEY (`UserID`)
);

-- Table structure for table `accounts`
CREATE TABLE `accounts` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `ContactNumber` varchar(15) NOT NULL,
  `Address` varchar(255) NOT NULL,
  PRIMARY KEY (`UserID`)
);
