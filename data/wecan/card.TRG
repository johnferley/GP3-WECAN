TYPE=TRIGGERS
triggers='CREATE DEFINER=`root`@`localhost` TRIGGER `WECAN`.`Card_BEFORE_INSERT` BEFORE INSERT ON `Card` FOR EACH ROW\nBEGIN\n	SELECT count(*) INTO @cardcount FROM card WHERE Competitor_competitorID = NEW.Competitor_competitorID;\n    SET NEW.issueNo = @cardcount + 1;\nEND'
sql_modes=1608515584
definers='root@localhost'
client_cs_names='utf8mb4'
connection_cl_names='utf8mb4_general_ci'
db_cl_names='latin1_swedish_ci'
