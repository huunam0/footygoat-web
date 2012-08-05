-- Database template for soccernet.espn
-- Tran Huu Nam
-- 11/9/2011
-- huunam0@gmail.com
-- version 2 : date 21/11/2011 : add unique key + modify structure for table f_triggers  
-- version 3 : Dec 7, 2011 : add user active
-- Dump by MySQLDumper 1.24 (http://mysqldumper.net)
/*!40101 SET NAMES 'utf8' */;
SET FOREIGN_KEY_CHECKS=0;


--
-- Create Table `f_users`
-- Tran Huu Nam
-- 11/9/2011
DROP TABLE IF EXISTS `f_users`;
CREATE TABLE `f_users` (
	`user_id` int(11) unsigned NOT NULL auto_increment,
	`user_name` varchar(30) NOT NULL,
	`user_password` varchar(128) NOT NULL,
	`user_email` varchar(50) NULL,
	`user_email2` varchar(50) NULL,
	`user_alert` boolean default false,
	`user_reg_date` datetime NULL,
	`user_active` tinyint(1) default 1,
	PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;

-- Modified on Dec 7 2011 by Tran Huu Nam

INSERT INTO `f_users` (`user_id`,`user_name`,`user_password`,`user_email`,`user_alert`,`user_reg_date`) VALUES ('100','admin','21232f297a57a5a743894a0e4a801fc3','admin@footygoat.com',false,NOW());
INSERT INTO `f_users` (`user_id`,`user_name`,`user_password`,`user_email`,`user_alert`,`user_reg_date`) VALUE ('102','thnam','22c0ac24e6869f37c4b17e27cdce357e','thnam@ifi.edu.vn',false,NOW());

--Table teams, recent informations of a team.
DROP TABLE IF EXISTS `f_teams`;
CREATE TABLE `f_teams` (
	`team_id` int(11) unsigned NOT NULL,
	`team_name` varchar(30) NOT NULL,
	`team_group` varchar(2) NULL default 'A',
	`team_league`varchar(20) NULL,
	
	`team_pos` smallint(2) NOT NULL default 0,
	`team_op` smallint(2) NOT NULL default 0,
	
	`team_ow` smallint(2) NOT NULL default 0,
	`team_od` smallint(2) NOT NULL default 0,	
	`team_ol` smallint(2) NOT NULL default 0,
	`team_of` smallint(2) NOT NULL default 0,
	`team_oa` smallint(2) NOT NULL default 0,	

	`team_hw` smallint(2) NOT NULL default 0,	
	`team_hd` smallint(2) NOT NULL default 0,
	`team_hl` smallint(2) NOT NULL default 0,
	`team_hf` smallint(2) NOT NULL default 0,	
	`team_ha` smallint(2) NOT NULL default 0,

	`team_aw` smallint(2) NOT NULL default 0,
	`team_ad` smallint(2) NOT NULL default 0,	
	`team_al` smallint(2) NOT NULL default 0,
	`team_af` smallint(2) NOT NULL default 0,	
	`team_aa` smallint(2) NOT NULL default 0,
	
	`team_gd` smallint(2) NOT NULL default 0,
	`team_pts` smallint(2) NOT NULL default 0,
	`team_date` datetime NULL,
	PRIMARY KEY  (`team_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
--Note
--`team_pos` smallint(2) NOT NULL default 0, -- position of team in group/table
--	`team_op` smallint(2) NOT NULL default 0, -- OVERALL - POSITION
--	`team_ow` smallint(2) NOT NULL default 0, -- OVERALL - WINS	
--	`team_od` smallint(2) NOT NULL default 0, -- OVERALL - DRAWS	
---	`team_ol` smallint(2) NOT NULL default 0, -- OVERALL - LOSSES
--	`team_of` smallint(2) NOT NULL default 0, -- OVERALL - Goals Scored	
--	`team_oa` smallint(2) NOT NULL default 0, -- OVERALL - Goals Against	
--	`team_hp` smallint(2) NOT NULL default 0, -- HOME - POSITION
--	`team_hw` smallint(2) NOT NULL default 0, -- HOME - WINS	
--	`team_hd` smallint(2) NOT NULL default 0, -- HOME - DRAWS	
--	`team_hl` smallint(2) NOT NULL default 0, -- HOME - LOSSES
--	`team_hf` smallint(2) NOT NULL default 0, -- HOME - Goals Scored	
--	`team_ha` smallint(2) NOT NULL default 0, -- HOME - Goals Against
--	`team_ap` smallint(2) NOT NULL default 0, -- AWAY - POSITION
--	`team_aw` smallint(2) NOT NULL default 0, -- AWAY - WINS	
--	`team_ad` smallint(2) NOT NULL default 0, -- AWAY - DRAWS	
--	`team_al` smallint(2) NOT NULL default 0, -- AWAY - LOSSES
--	`team_af` smallint(2) NOT NULL default 0, -- AWAY - Goals Scored	
--	`team_aa` smallint(2) NOT NULL default 0, -- AWAY - Goals Against
--	`team_gd` smallint(2) NOT NULL default 0, -- Goal Difference
--	`team_pts` smallint(2) NOT NULL default 0, --Points
-- team_date : date to update

DROP TABLE IF EXISTS `f_matchs`;
CREATE TABLE `f_matchs` (
	`match_id`				int(11) unsigned NOT NULL auto_increment,
	`league_id`				varchar(40) NOT NULL,
	`hteam`					int(11) unsigned NOT NULL,
	`ateam`					int(11) unsigned NOT NULL,
	`status`				smallint(2) NOT NULL default 0,
	`status_ex`				varchar(20) NULL,
	
	`hgoals`				TINYINT(1) NOT NULL default 0,
	`agoals`				TINYINT(1) NOT NULL default 0,
	`h1goals`				TINYINT(1) NOT NULL default 0,
	`a1goals`				TINYINT(1) NOT NULL default 0,
	`hreds`					TINYINT(1) NOT NULL default 0,
	`areds`					TINYINT(1) NOT NULL default 0,
	`hyellows`				TINYINT(1) NOT NULL default 0,
	`ayellows`				TINYINT(1) NOT NULL default 0,
	`hshots`				smallint(2) NOT NULL default 0,
	`ashots`				smallint(2) NOT NULL default 0,
	`hgshots`				smallint(2) NOT NULL default 0,
	`agshots`				smallint(2) NOT NULL default 0,
	`hcorner`				smallint(2) NOT NULL default 0,
	`acorner`				smallint(2) NOT NULL default 0,	
	`hpossession`			TINYINT(1) NOT NULL default 0,
	`apossession`			TINYINT(1) NOT NULL default 0,
	
	`match_date` 			datetime NULL,
	`match_date_view` 		datetime NULL,
	`mupdate` 				datetime,
	PRIMARY KEY  (`match_id`)
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;

--	`hteam`					int(11) unsigned NOT NULL, -- home team
--	`ateam`					int(11) unsigned NOT NULL, -- away team
--	`status`				smallint(2) NOT NULL default 0, -- status of matchs: 0-No occur yet, 1: first half,2:pause, 3: second half, 4: finished, 5: others
--	`status_ex`				varchar(20) NULL, -- Ex_status: if status=1,3 -> timmer, ex 15:20
--	`hgoals`				TINYINT(1) NOT NULL default 0, -- goals of home team
--	`agoals`				TINYINT(1) NOT NULL default 0, -- goals of away team
--	`h1goals`				TINYINT(1) NOT NULL default 0, -- goals of home team in first  half
--	`a1goals`				TINYINT(1) NOT NULL default 0, -- goals of away team in first  half
--	`hreds`					TINYINT(1) NOT NULL default 0, -- red cards of home team
--	`areds`					TINYINT(1) NOT NULL default 0, -- red cards of away team
--	`hyellows`				TINYINT(1) NOT NULL default 0, -- yellow cards of home team
--	`ayellows`				TINYINT(1) NOT NULL default 0, -- yellow cards of away team
--	`hshots`				smallint(2) NOT NULL default 0, -- Shots of home team
--	`ashots`				smallint(2) NOT NULL default 0, -- Shots of away team	
--	`hgshots`				smallint(2) NOT NULL default 0, -- Shots on goal of home team
--	`agshots`				smallint(2) NOT NULL default 0, -- Shots on goal of away team	
--	`hcorner`				smallint(2) NOT NULL default 0, -- Corner kicks of home team
--	`acorner`				smallint(2) NOT NULL default 0, -- Corner kicks of away team	
--	`hpossession`			TINYINT(1) NOT NULL default 0, -- percent of time possession of home team
--	`apossession`			TINYINT(1) NOT NULL default 0, -- percent of time possession of away team
-- match_date 				date of match
-- match_date 				date can view of match (for matches on next date)
-- mupdate					time of update


DROP TABLE IF EXISTS `f_leagues`;
CREATE TABLE `f_leagues` (
	`league_id`					varchar(40) NOT NULL,
	`league_name`				varchar(150) NOT NULL,
	PRIMARY KEY  (`league_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `f_trigger`;
CREATE TABLE `f_trigger` (
	`trigger_id`				int(11) unsigned NOT NULL auto_increment,
	`groupid`					tinyint(2) unsigned NOT NULL default 1,
	`user_id` 					int(11) unsigned NOT NULL,
	`field_id`					tinyint(2) NOT NULL,
	`operater`					varchar(2) NOT NULL default '',
	`hvalue`					varchar(6) NOT NULL default '',
	`avalue`					varchar(6) NOT NULL default '',
	PRIMARY KEY  (`trigger_id`),
	UNIQUE KEY `userunique` (`groupid`,`user_id`,`field_id`) 
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
--UNIQUE KEY : add Nov 21, 2011


DROP TABLE IF EXISTS `f_fields`;
CREATE TABLE `f_fields` (
	`field_id`					tinyint(2) unsigned NOT NULL auto_increment,
	`field_name`				varchar(20) NOT NULL,
	`field_tag`					varchar(20),
PRIMARY KEY  (`field_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT INTO `f_fields` (`field_id`,`field_name`,`field_tag`)
VALUES
(1,'Goals','goals'),
(2,'% Time of Possession','possession'),
(3,'Shots On Goal','gshots'),
(4,'% Shots On Goal','gshots%'),
(5,'Shots','shots'),
(6,'% Shots','shots%'),
(7,'Corner Kicks','corner'),
(8,'% Corner Kicks','corner%'),
(9,'Red Cards','reds'),
(10,'Yellow Cards','yellows'),
(11,'% Wins','w'),
(12,'% Draws','d'),
(13,'Goals Scored %F','f'),
(14,'Goals Against %A','a');


SET FOREIGN_KEY_CHECKS=1;
-- EOB

