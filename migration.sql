alter table vehicle add password varchar(20) DEFAULT NULL;
update vehicle set password = '1234';