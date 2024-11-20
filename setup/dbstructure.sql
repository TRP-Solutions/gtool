CREATE TABLE `msgid` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`msgid` varchar(50) NOT NULL,
	`usage` text NOT NULL DEFAULT '',
	PRIMARY KEY (`id`),
	UNIQUE KEY `msgid` (`msgid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

CREATE TABLE `msgstr` (
	`msgid_id` int(10) unsigned NOT NULL,
	`locale` varchar(5) NOT NULL,
	`str` text NOT NULL,
	PRIMARY KEY (`msgid_id`,`locale`),
	FOREIGN KEY (`msgid_id`) REFERENCES `msgid` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
