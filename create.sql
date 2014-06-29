CREATE TABLE `honeypy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `date_time` datetime DEFAULT NULL,
  `millisecond` int(11) DEFAULT NULL,
  `level` varchar(45) DEFAULT NULL,
  `event` varchar(45) DEFAULT NULL,
  `local_host` varchar(45) DEFAULT NULL,
  `local_port` varchar(45) DEFAULT NULL,
  `service` varchar(45) DEFAULT NULL,
  `remote_host` varchar(45) DEFAULT NULL,
  `remote_port` varchar(45) DEFAULT NULL,
  `data` text,
  `bytes` int(11) DEFAULT NULL,
  `data_hash` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sensor` (`local_host`)
);

