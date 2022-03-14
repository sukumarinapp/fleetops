alter table vehicle add password varchar(20) DEFAULT NULL;
update vehicle set password = '1234';

CREATE TABLE `driver_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `VNO` varchar(20) DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `login_time` datetime DEFAULT NULL,
  `otp` varchar(20) DEFAULT NULL,
  `otp_verified` int(0) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

alter table vehicle add IEX date DEFAULT NULL;	
alter table vehicle add REX date DEFAULT NULL; 
alter table vehicle add AVI int(1) DEFAULT 0; 
alter table vehicle add AVR int(1) DEFAULT 0; 

--24/02/2022

alter table driver add AVL int(1) DEFAULT 0;
alter table driver add AVC int(1) DEFAULT 0;
alter table driver add VPL varchar(50) DEFAULT NULL;
alter table driver add DVE int(1) DEFAULT 0;
alter table driver add EPD int(1) DEFAULT 0;
alter table driver add NOD int(11) DEFAULT 0;
alter table driver add PAM decimal(10,2) DEFAULT 0;
alter table driver add NODB int(1) DEFAULT 0;
alter table driver add PAT varchar(10) DEFAULT NULL;

CREATE TABLE `vehicle_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `VID` int(11) NOT NULL,
  `SSD` date DEFAULT NULL,
  `SSM` int(11) NOT NULL,
  `RSS` int(1) DEFAULT 0,
  `SMF` int(11) DEFAULT NULL,
  `SSF` varchar(20) DEFAULT NULL,
  `SSFP` int(11) DEFAULT NULL,
  `SSFD` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `vehicle_inspect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `VID` int(11) NOT NULL,
  `ISD` date DEFAULT NULL,
  `ISM` int(11) NOT NULL,
  `RIS` int(1) DEFAULT 0,
  `IMF` int(11) DEFAULT NULL,
  `ISF` varchar(20) DEFAULT NULL,
  `ISFP` int(11) DEFAULT NULL,
  `ISFD` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

alter table vehicle add MSH int(1) DEFAULT 0; 

alter table driver add PPR decimal(10,2) DEFAULT 0;
alter table driver add PDP decimal(10,2) DEFAULT 0;
alter table driver add SDP decimal(10,2) DEFAULT 0;

CREATE TABLE `driver_upload` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `VNO` varchar(20) DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `expired_date` date DEFAULT NULL,
  `upload_time` datetime DEFAULT NULL,
  `doc_type` varchar(20) DEFAULT NULL,
  `file_name` varchar(20) DEFAULT NULL,
  `doc_expiry` date DEFAULT NULL,
   acceptance_code varchar(10) DEFAULT NULL,
  `approved` int(0) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;





