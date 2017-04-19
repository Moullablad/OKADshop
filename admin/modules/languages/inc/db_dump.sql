CREATE TABLE IF NOT EXISTS `{languages}` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(64) NOT NULL,
  `locale` varchar(32) NOT NULL,
  `iso_code` varchar(32) UNIQUE NOT NULL,
  `flag` varchar(32) DEFAULT NULL,
  `date_format` varchar(32) NOT NULL DEFAULT 'd/m/Y',
  `datetime_format` varchar(32) NOT NULL DEFAULT 'd/m/Y H:i:s',
  `direction` tinyint(1) NOT NULL DEFAULT 0,
  `default_lang` tinyint(1) NOT NULL DEFAULT 0,
  `active` tinyint(1) DEFAULT 0,
  `cdate` datetime DEFAULT NULL,
  `udate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;