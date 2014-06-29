--
-- Structure for table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `a_date` datetime NOT NULL,
  `a_title` varchar(20) NOT NULL,
  `a_text` varchar(500) NOT NULL,
  `a_filepath` varchar(300) DEFAULT NULL,
  `a_hidden` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Structure for table `at_dict`
--

DROP TABLE IF EXISTS `at_dict`;
CREATE TABLE IF NOT EXISTS `at_dict` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
CREATE TABLE IF NOT EXISTS `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `t_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Data for table `tag`
--

INSERT INTO `tag` (`id`, `t_name`) VALUES
  ('1', 'Спорт'),
  ('2', 'Политота'),
  ('3', 'Спидинфо');