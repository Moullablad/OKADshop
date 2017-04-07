CREATE TABLE IF NOT EXISTS `{lang}` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(32) NOT NULL,
  `short_name` varchar(32) NOT NULL,
  `iso_code` varchar(2) NOT NULL,
  `code` varchar(5) DEFAULT NULL,
  `direction` tinyint(1) NOT NULL DEFAULT '0',
  `date_format` varchar(10) NOT NULL,
  `datetime_format` varchar(12) NOT NULL,
  `default_lang` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) DEFAULT '0',
  `cdate` datetime DEFAULT NULL,
  `udate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;