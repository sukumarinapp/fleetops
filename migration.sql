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
