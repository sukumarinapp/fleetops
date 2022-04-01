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

alter table driver_upload add contract_accepted int(1) DEFAULT 0;  

--17/03/2022
alter table driver_upload add current_mileage varchar(10) DEFAULT 0;

--29/03/2022
--employee/contractor
alter table driver add driver_status varchar(50) DEFAULT NULL;
--fixed/performance
alter table driver add earning_type varchar(20) DEFAULT NULL;
alter table driver add FPE decimal(10,2) DEFAULT 0;
alter table driver add PPE decimal(10,2) DEFAULT 0;
--sales/earning
alter table driver add PPE_TYPE varchar(20) DEFAULT NULL;
alter table driver add bonus int(1) DEFAULT 0;
--sales/earning
alter table driver add bonus_type varchar(20) DEFAULT NULL;
alter table driver add PBT decimal(10,2) DEFAULT 0;
alter table driver add PBP decimal(10,2) DEFAULT 0;
--Daily/Weekly/Monthly
alter table driver add EPF varchar(20) DEFAULT NULL;

CREATE TABLE `manager_inspect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `upload_id` int(11) NOT NULL,
  `VI01` int(1) DEFAULT 0,
  `VI02` int(1) DEFAULT 0,
  `VI03` int(1) DEFAULT 0,
  `VI04` int(1) DEFAULT 0,
  `VI05` int(1) DEFAULT 0,
  `VI06` int(1) DEFAULT 0,
  `VI07` int(1) DEFAULT 0,
  `VI08` int(1) DEFAULT 0,
  `VI09` int(1) DEFAULT 0,
  `VI10` int(1) DEFAULT 0,
  `VI11` int(1) DEFAULT 0,
  `VI12` int(1) DEFAULT 0,
  `VI13` int(1) DEFAULT 0,
  `VI14` int(1) DEFAULT 0,
  `VI15` int(1) DEFAULT 0,
  `VI16` int(1) DEFAULT 0,
  `VI17` int(1) DEFAULT 0,
  `VI18` int(1) DEFAULT 0,
  `VI19` int(1) DEFAULT 0,
  `VI20` int(1) DEFAULT 0,
  `VI21` int(1) DEFAULT 0,
  `VI22` int(1) DEFAULT 0,
  `VI23` int(1) DEFAULT 0,
  `VI24` int(1) DEFAULT 0,
  CI01 varchar(100) DEFAULT NULL,
  CI02 varchar(100) DEFAULT NULL,
  CI03 varchar(100) DEFAULT NULL,
  CI04 varchar(100) DEFAULT NULL,
  CI05 varchar(100) DEFAULT NULL,
  CI06 varchar(100) DEFAULT NULL,
  CI07 varchar(100) DEFAULT NULL,
  CI08 varchar(100) DEFAULT NULL,
  CI09 varchar(100) DEFAULT NULL,
  CI10 varchar(100) DEFAULT NULL,
  CI11 varchar(100) DEFAULT NULL,
  CI12 varchar(100) DEFAULT NULL,
  CI13 varchar(100) DEFAULT NULL,
  CI14 varchar(100) DEFAULT NULL,
  CI15 varchar(100) DEFAULT NULL,
  CI16 varchar(100) DEFAULT NULL,
  CI17 varchar(100) DEFAULT NULL,
  CI18 varchar(100) DEFAULT NULL,
  CI19 varchar(100) DEFAULT NULL,
  CI20 varchar(100) DEFAULT NULL,
  CI21 varchar(100) DEFAULT NULL,
  CI22 varchar(100) DEFAULT NULL,
  CI23 varchar(100) DEFAULT NULL,
  CI24 varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `manager_inspect_photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `upload_id` int(11) NOT NULL,
  `filename` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

--31/03/2022

alter table vehicle_service add SVE varchar(50) DEFAULT NULL;
alter table vehicle_inspect add IVE varchar(50) DEFAULT NULL;

alter table driver_upload add venue varchar(50) DEFAULT NULL;

alter table driver add DLD2 varchar(20) DEFAULT NULL;
alter table driver_upload add file_name2 varchar(20) DEFAULT NULL;

CREATE TABLE `manager_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `upload_id` int(11) NOT NULL,
  `service_date` date DEFAULT NULL,
   current_mileage varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;