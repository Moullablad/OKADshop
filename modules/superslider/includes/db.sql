CREATE TABLE IF NOT EXISTS {superslider_images} (
  `id` int(11)   NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `file_name` varchar(255) NOT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `udate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;