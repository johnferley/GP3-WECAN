TYPE=TRIGGERS
triggers='CREATE DEFINER=`root`@`localhost` TRIGGER `Card_BEFORE_INSERT` BEFORE INSERT ON `card` FOR EACH ROW BEGIN\n	SELECT IFNULL(MAX(issueNo), 0) INTO @maxissue FROM card WHERE Competitor_competitorID = NEW.Competitor_competitorID;\n    SET NEW.issueNo = @maxissue + 1;\nEND'
sql_modes=1073741824
definers='root@localhost'
client_cs_names='utf8mb4'
connection_cl_names='utf8mb4_general_ci'
db_cl_names='latin1_swedish_ci'
