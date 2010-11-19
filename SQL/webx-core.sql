CREATE TABLE `user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `facebook_uid` bigint(20) unsigned NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `user_nick` varchar(50) NOT NULL,
  `image_url` varchar(256) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_nick` (`user_nick`),
  UNIQUE KEY `facebook_uid` (`facebook_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `settings` (
  `user_id` bigint(20) unsigned NOT NULL,
  `content` longtext,
  `time` datetime NOT NULL,
  PRIMARY KEY (`user_id`),
  FOREIGN KEY (`user_id`) REFERENCES `user` (`facebook_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `pastes` (
  `user_id` bigint(20) unsigned NOT NULL,
  `content` longtext,
  `title` varchar(50),
  `description` varchar(256),
  `time` datetime NOT NULL,
  PRIMARY KEY (`user_id`),
  FOREIGN KEY (`user_id`) REFERENCES `user` (`facebook_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `files` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `file_id` varchar(32) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `name` varchar(50) default NULL,
  `type` varchar(30) default NULL,
  `size` int(11) default NULL,
  `time` datetime NOT NULL,
  `content` longblob,
  PRIMARY KEY (`id`),
  UNIQUE KEY `file_id` (`file_id`),
  FOREIGN KEY (`user_id`) REFERENCES `user` (`facebook_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;