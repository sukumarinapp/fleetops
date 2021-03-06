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


--01/04/2022
alter table driver add DLD2 varchar(20) DEFAULT NULL;
alter table driver_upload add file_name2 varchar(20) DEFAULT NULL;

CREATE TABLE `manager_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `upload_id` int(11) NOT NULL,
  `service_date` date DEFAULT NULL,
   current_mileage varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

alter table driver_upload drop current_mileage;
alter table driver_upload add current_mileage varchar(10) DEFAULT NULL;

alter table driver_upload add inspection int(1) DEFAULT 0;
alter table driver_upload add rejected int(1) DEFAULT 0;

--06/04/2022

CREATE TABLE `handover` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `log_id` int(11) NOT NULL,
  `VNO` varchar(20) DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `photo` varchar(10) DEFAULT NULL,
  `CF01` varchar(10) DEFAULT NULL,
  `CF02` int(1) DEFAULT 0,
  `CF03` int(1) DEFAULT 0,
  `CF04` int(1) DEFAULT 0,
  `CF05` int(1) DEFAULT 0,
  `CF06` int(1) DEFAULT 0,
  `CF07` int(1) DEFAULT 0,
  `CF08` int(1) DEFAULT 0,
  `CF09` int(1) DEFAULT 0,
  `CF10` int(1) DEFAULT 0,
  `CF11` int(1) DEFAULT 0,
  `CF12` int(1) DEFAULT 0,
  `CF13` int(1) DEFAULT 0,
  `CF14` int(1) DEFAULT 0,
  `CF15` int(1) DEFAULT 0,
  `CF16` int(1) DEFAULT 0,
  `CF17` int(1) DEFAULT 0,
  `CF18` varchar(100) DEFAULT NULL,
  `CFP2` varchar(20) DEFAULT NULL,
  `CFP3` varchar(20) DEFAULT NULL,
  `CFP4` varchar(20) DEFAULT NULL,
  `CFP5` varchar(20) DEFAULT NULL,
  `CC01` varchar(50) DEFAULT NULL,
  `CC02` varchar(50) DEFAULT NULL,
  `CC03` varchar(50) DEFAULT NULL,
  `CC04` varchar(50) DEFAULT NULL,
  `CC05` varchar(50) DEFAULT NULL,
  `CC06` varchar(50) DEFAULT NULL,
  `CC07` varchar(50) DEFAULT NULL,
  `CC08` varchar(50) DEFAULT NULL,
  `CC09` varchar(50) DEFAULT NULL,
  `CC10` varchar(50) DEFAULT NULL,
  `CC11` varchar(50) DEFAULT NULL,
  `CC12` varchar(50) DEFAULT NULL,
  `CC13` varchar(50) DEFAULT NULL,
  `CC14` varchar(50) DEFAULT NULL,
  `CC15` varchar(50) DEFAULT NULL,
  `CC16` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `retrieval` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `log_id` int(11) NOT NULL,
  `VNO` varchar(20) DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `CF01` varchar(10) DEFAULT NULL,
  `CF02` int(1) DEFAULT 0,
  `CF03` int(1) DEFAULT 0,
  `CF04` int(1) DEFAULT 0,
  `CF05` int(1) DEFAULT 0,
  `CF06` int(1) DEFAULT 0,
  `CF07` int(1) DEFAULT 0,
  `CF08` int(1) DEFAULT 0,
  `CF09` int(1) DEFAULT 0,
  `CF10` int(1) DEFAULT 0,
  `CF11` int(1) DEFAULT 0,
  `CF12` int(1) DEFAULT 0,
  `CF13` int(1) DEFAULT 0,
  `CF14` int(1) DEFAULT 0,
  `CF15` int(1) DEFAULT 0,
  `CF16` int(1) DEFAULT 0,
  `CF17` int(1) DEFAULT 0,
  `CF18` varchar(100) DEFAULT NULL,
  `CFP2` varchar(20) DEFAULT NULL,
  `CFP3` varchar(20) DEFAULT NULL,
  `CFP4` varchar(20) DEFAULT NULL,
  `CFP5` varchar(20) DEFAULT NULL,
  `CC01` varchar(50) DEFAULT NULL,
  `CC02` varchar(50) DEFAULT NULL,
  `CC03` varchar(50) DEFAULT NULL,
  `CC04` varchar(50) DEFAULT NULL,
  `CC05` varchar(50) DEFAULT NULL,
  `CC06` varchar(50) DEFAULT NULL,
  `CC07` varchar(50) DEFAULT NULL,
  `CC08` varchar(50) DEFAULT NULL,
  `CC09` varchar(50) DEFAULT NULL,
  `CC10` varchar(50) DEFAULT NULL,
  `CC11` varchar(50) DEFAULT NULL,
  `CC12` varchar(50) DEFAULT NULL,
  `CC13` varchar(50) DEFAULT NULL,
  `CC14` varchar(50) DEFAULT NULL,
  `CC15` varchar(50) DEFAULT NULL,
  `CC16` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

alter table vehicle add chassis_no varchar(50) DEFAULT NULL;

alter table vehicle add handover_id int(11) DEFAULT 0;

--8/4/2002
alter table handover add acceptance_code varchar(10) DEFAULT NULL;
alter table handover add accepted int(1) DEFAULT 0;
alter table driver_upload add expiry date DEFAULT NULL;

--16/04/2022

alter table vehicle add status varchar(20) DEFAULT NULL;
update vehicle set status='assigned' where driver_id is not null;

--19/04/2022  
alter table vehicle_service add service_done int(1) DEFAULT 0;
alter table vehicle_inspect add inspect_done int(1) DEFAULT 0;

--23/04/2022
alter table driver_upload add status varchar(50) DEFAULT NULL;
alter table manager_inspect add ISD date DEFAULT NULL;
alter table manager_inspect add ISM int(11) DEFAULT 0;
alter table handover add status varchar(50) DEFAULT NULL;

--25/04/2022
alter table retrieval add handover_id int(11) DEFAULT 0;

--29/04/2022
alter table tbl136 add penalized int(1) DEFAULT 0;
alter table tbl137 add penalty decimal(10,2) DEFAULT 0;

--03/05/2022

CREATE TABLE `movement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CAN` varchar(20) DEFAULT NULL,
  `VNO` varchar(20) DEFAULT NULL,
  `ACC` varchar(10) DEFAULT NULL,
  `SDT` date DEFAULT NULL,
  `EDT` date DEFAULT NULL,
  `STM` varchar(10) DEFAULT NULL,
  `ETM` varchar(10) DEFAULT NULL,
  `DUR` varchar(10) DEFAULT NULL,
  `CML` varchar(10) DEFAULT NULL,
  `CHR` varchar(10) DEFAULT NULL,
  `IDL` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

--06/05/2022
alter table movement add latitude varchar(50) DEFAULT NULL;
alter table movement add longitude varchar(50) DEFAULT NULL;

CREATE TABLE `tracker_command` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `terminal_id` varchar(20) DEFAULT NULL,
  `cmd_date` date DEFAULT NULL,
  `cmd_time` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `action` varchar(20) DEFAULT NULL COMMENT 'block unblock buzon buzoff',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

--17/05/2022
alter table tracker_command add DCR int(11) DEFAULT 0;
-- payment , expiry
alter table tracker_command add context varchar(20) DEFAULT 'payment';
alter table current_location add command varchar(10) DEFAULT NULL;

CREATE TABLE `incommand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cmd_time` datetime DEFAULT NULL,
  `terminal_id` varchar(20) DEFAULT NULL,
  `command` varchar(20) DEFAULT NULL,
  `direction` varchar(10) DEFAULT NULL,
  `state` varchar(10) DEFAULT NULL,
  `data` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

--24/05/2022
alter table handover add accepted_date datetime DEFAULT NULL;

alter table current_location add state varchar(10) DEFAULT NULL;
alter table current_location add ip varchar(50) DEFAULT NULL;

--04/06/2022

INSERT INTO `notification` (`id`, `sms_id`, `sms_text`) VALUES ('15', 'SMSIMC01', 'Hi #{CZN}#, your vehicle with registration no. #{VNO}# has been blocked for expired insurance. 3 reminders were sent earlier on but no action was taken. To restore service, please renew the insurance and upload the new document. Thank you.\r\n');
INSERT INTO `notification` (`id`, `sms_id`, `sms_text`) VALUES ('16', 'SMSIMD01', 'Hi #{DNM}#, your vehicle with registration no. #{VNO}# has been blocked for expired insurance. 3 reminders were sent earlier on but no action was taken. Contact the vehicle owner immediately and follow the process to restore service.Thank you.\r\n');
INSERT INTO `notification` (`id`, `sms_id`, `sms_text`) VALUES ('17', 'SMSRMC02', 'Hi #{CZN}#, your vehicle with registration no. #{VNO}# has been blocked for expired roadworthy certificate. 3 reminders were sent earlier on but no action was taken. To restore service, please renew the roadworthy certificate and upload the new document. Thank you.\r\n');
INSERT INTO `notification` (`id`, `sms_id`, `sms_text`) VALUES ('18', 'SMSRMD02', 'Hi #{DNM}#, your vehicle with registration no. #{VNO}# has been blocked for expired roadworthy certificate. 3 reminders were sent earlier on but no action was taken. Contact the vehicle owner immediately and follow the process to restore service.Thank you.\r\n');
INSERT INTO `notification` (`id`, `sms_id`, `sms_text`) VALUES ('19', 'SMSLMC03', 'Hi #{CZN}#, your vehicle with registration no. #{VNO}# has been blocked for expired drivers license. 3 reminders were sent earlier on but no action was taken. To restore service, please upload the renewed drivers license. Thank you.\r\n');
INSERT INTO `notification` (`id`, `sms_id`, `sms_text`) VALUES ('20', 'SMSLMD03', 'Hi #{DNM}#, your vehicle with registration no. #{VNO}# has been blocked for expired drivers license. 3 reminders were sent earlier on but no action was taken. Please renew your license, contact the vehicle owner immediately and follow the process to restore service. Thank you.\r\n');
INSERT INTO `notification` (`id`, `sms_id`, `sms_text`) VALUES ('21', 'SMSCMC04', 'Hi #{CZN}#, your vehicle with registration no. #{VNO}# has been blocked for expired driver contract. 3 reminders were sent earlier on but no action was taken. To restore service, please upload the renewed drivers contract. Thank you.\r\n');
INSERT INTO `notification` (`id`, `sms_id`, `sms_text`) VALUES ('22', 'SMSCMD04', 'Hi #{DNM}#, your vehicle with registration no. #{VNO}# has been blocked for expired driver contract. 3 reminders were sent earlier on but no action was taken. Contact the vehicle owner immediately and follow the process to restore service. Thank you.\r\n');
INSERT INTO `notification` (`id`, `sms_id`, `sms_text`) VALUES ('23', 'SMSSSC05', 'Hi #{CZN}#, your vehicle with registration no. #{VNO}# is due for maintenance. 3 reminders were sent earlier on. Please carry out the scheduled service. Thank you.\r\n');
INSERT INTO `notification` (`id`, `sms_id`, `sms_text`) VALUES ('24', 'SMSSSD05', 'Hi #{DNM}#, your vehicle with registration no. #{VNO}# is due for maintenance. 3 reminders were sent earlier on. Contact the vehicle owner immediately and follow the process to carry out scheduled service. Thank you.\r\n');
INSERT INTO `notification` (`id`, `sms_id`, `sms_text`) VALUES ('25', 'SMSISC06', 'Hi #{CZN}#, your vehicle with registration no. #{VNO}# is due for inspection. 3 reminders were sent to you earlier on. Please carry out the scheduled inspection. Thank you.\r\n');
INSERT INTO `notification` (`id`, `sms_id`, `sms_text`) VALUES ('26', 'SMSISD06', 'Hi #{DNM}#, your vehicle with registration no. #{VNO}# is due for inspection. 3 reminders were sent earlier on. Contact the vehicle owner immediately and follow the process to carry out scheduled service. Thank you.\r\n');

--08/-6/2022
alter table vehicle add blk_status int(1) DEFAULT 0;
alter table vehicle add buz_status int(1) DEFAULT 0;
alter table vehicle add acc int(1) DEFAULT 0;
alter table vehicle add fpm int(1) DEFAULT 0;



CREATE TABLE `fpm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TID` varchar(20) DEFAULT NULL,
  `VNO` varchar(20) DEFAULT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `movement` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

ALTER TABLE vehicle ADD fpm_enabled int(1) DEFAULT 0 AFTER VNO;

--11/07/2022

CREATE TABLE `mileage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `VNO` varchar(20) DEFAULT NULL,
  `context` varchar(20) DEFAULT NULL,
  `mileage` decimal(10,2) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

insert into mileage (VNO,context,mileage) values ('GT4298-18','inspection','0');
insert into mileage (VNO,context,mileage) values ('GN7122-17','inspection','0');
insert into mileage (VNO,context,mileage) values ('GN7119-17','inspection','0');
insert into mileage (VNO,context,mileage) values ('GT6014-17','inspection','0');
insert into mileage (VNO,context,mileage) values ('GN7128-17','inspection','0');
insert into mileage (VNO,context,mileage) values ('GN8488-17','inspection','0');
insert into mileage (VNO,context,mileage) values ('GT9323-17','inspection','0');
insert into mileage (VNO,context,mileage) values ('GN7121-17','inspection','0');
insert into mileage (VNO,context,mileage) values ('GT8283-17','inspection','0');
insert into mileage (VNO,context,mileage) values ('GT9324-17','inspection','0');
insert into mileage (VNO,context,mileage) values ('GE609-17 ','inspection','0');
insert into mileage (VNO,context,mileage) values ('GS2231-22','inspection','0');
insert into mileage (VNO,context,mileage) values ('GS2259-22','inspection','0');

insert into mileage (VNO,context,mileage) values ('GT4298-18','service','0');
insert into mileage (VNO,context,mileage) values ('GN7122-17','service','0');
insert into mileage (VNO,context,mileage) values ('GN7119-17','service','0');
insert into mileage (VNO,context,mileage) values ('GT6014-17','service','0');
insert into mileage (VNO,context,mileage) values ('GN7128-17','service','0');
insert into mileage (VNO,context,mileage) values ('GN8488-17','service','0');
insert into mileage (VNO,context,mileage) values ('GT9323-17','service','0');
insert into mileage (VNO,context,mileage) values ('GN7121-17','service','0');
insert into mileage (VNO,context,mileage) values ('GT8283-17','service','0');
insert into mileage (VNO,context,mileage) values ('GT9324-17','service','0');
insert into mileage (VNO,context,mileage) values ('GE609-17 ','service','0');
insert into mileage (VNO,context,mileage) values ('GS2231-22','service','0');
insert into mileage (VNO,context,mileage) values ('GS2259-22','service','0'); 

CREATE TABLE `flag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `VNO` varchar(20) DEFAULT NULL,
  `flg_date` date DEFAULT NULL,
  `flg_type` varchar(10) DEFAULT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

ALTER TABLE flag ADD latitude varchar(10) DEFAULT NULL;
ALTER TABLE flag ADD longitude varchar(10) DEFAULT NULL;

ALTER TABLE vehicle ADD cmd_state varchar(20) DEFAULT NULL;
ALTER TABLE tracker_command ADD data_packet varchar(255) DEFAULT NULL;

