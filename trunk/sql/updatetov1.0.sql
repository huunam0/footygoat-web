-- Database template for soccernet.espn
-- Tran Huu Nam
-- 11 March 2012
-- huunam0@gmail.com

CREATE TABLE `f_params` (
	`p_name` varchar(20) NOT NULL,
	`p_value` varchar(255) NOT NULL,
	PRIMARY KEY  (`p_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

Insert into f_params (p_name,p_value) value ('dbversion','1.0');

ALTER TABLE `f_users` ADD COLUMN `user_newsletter` TINYINT(1) NOT NULL DEFAULT '1' ;
ALTER TABLE `f_users` ADD COLUMN `user_twitter` VARCHAR(20) NOT NULL DEFAULT '' ;

-- EOB

