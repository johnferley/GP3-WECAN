TYPE=TRIGGERS
triggers='CREATE DEFINER=`root`@`localhost` TRIGGER `card_after_insert` AFTER INSERT ON `card_valid_temp` FOR EACH ROW BEGIN\n	UPDATE card SET cardValid = 0 WHERE Competitor_competitorID = NEW.Competitor_competitorID;\nEND'
sql_modes=1073741824
definers='root@localhost'
client_cs_names='utf8mb4'
connection_cl_names='utf8mb4_general_ci'
db_cl_names='latin1_swedish_ci'
