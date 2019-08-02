CREATE DATABASE IF NOT EXISTS `nauhtnn_lms`
	DEFAULT CHARACTER SET='utf8'
	DEFAULT COLLATE='utf8_general_ci';

USE `nauhtnn_lms`;
CREATE TABLE IF NOT EXISTS `lms_test_type` (
	`tp_id` TINYINT PRIMARY KEY,
	`tp_name` VARCHAR(16)
);

INSERT INTO `lms_test_type` VALUES(0, 'En_A'),(1, 'En_B'),(2, 'En_C'),(3, 'IT_A'),(4, 'IT_B'),(5, 'IT_CB'),(6, 'IT_NC');

CREATE TABLE IF NOT EXISTS `lms_test_taker` (
	`tt_testType` TINYINT,
	`tt_testDate` DATE,
	`tt_weakID` SMALLINT,
	`tt_name` VARCHAR(64) CHARACTER SET 'utf8',
	`tt_name_ai` VARCHAR(64) CHARACTER SET 'utf8',
	`tt_birthdate` DATE,
	`tt_birthplace` VARCHAR(64) CHARACTER SET 'utf8',
	PRIMARY KEY(`tt_testType`,`tt_testDate`,`tt_weakID`),
	FOREIGN KEY(`tt_testType`) REFERENCES `lms_test_type`(`tp_id`)
);

CREATE TABLE IF NOT EXISTS `lms_user` (
	`usr_id` VARCHAR(16)  CHARACTER SET `utf8` PRIMARY KEY,
	`usr_name` VARCHAR(64) CHARACTER SET `utf8`,
	`usr_pw` CHAR(64),
	`usr_type` TINYINT
);

INSERT INTO `lms_user` VALUES('thuan', 'Nguyen Ngoc Thuan', SHA2('1234', 256), 1);

CREATE TABLE IF NOT EXISTS `lms_course` (
	`crs_code` SMALLINT PRIMARY KEY,
	`crs_title` VARCHAR(64) CHARACTER SET `utf8`,
	`crs_n_period` SMALLINT
);

CREATE TABLE IF NOT EXISTS `lms_student` (
	`stu_id` INT UNSIGNED PRIMARY KEY,/*crs_code + year + sec_id + #stu = 3 digits + 2 digits + 2 digits + 3 digits*/
	`stu_cur_rev` SMALLINT
);

CREATE TABLE IF NOT EXISTS `lms_stu_content` (
	`stu_id` INT UNSIGNED,
	`stu_revision` SMALLINT,
	`stu_name` VARCHAR(64) CHARACTER SET `utf8`,
	`stu_birdate` DATE,
	`stu_phone` VARCHAR(16),
	`usr_id` SMALLINT,
	`usr_dt` DATETIME,
	`usr_comment` VARCHAR(128),
	PRIMARY KEY(`stu_id`, `stu_revision`),
	FOREIGN KEY(`stu_id`) REFERENCES `lms_student`(`stu_id`),
	FOREIGN KEY(`usr_id`) REFERENCES `lms_user`(`usr_id`)
);

CREATE TABLE IF NOT EXISTS `lms_section` (
	`sec_year` SMALLINT,
	`crs_code` SMALLINT UNSIGNED,
	`sec_id` SMALLINT,
	`sec_cur_rev` SMALLINT,
	PRIMARY KEY(`sec_year`, `crs_code`, `sec_id`)
);

CREATE TABLE IF NOT EXISTS `lms_sec_content` (
	`sec_year` SMALLINT,
	`crs_code` SMALLINT UNSIGNED,
	`sec_id` SMALLINT,
	`sec_revision` SMALLINT,
	`ins_id` SMALLINT,
	`sec_start` DATE,
	`sec_end` DATE,
	`usr_id` SMALLINT,
	`usr_dt` DATETIME,
	`usr_comment` VARCHAR(128),
	PRIMARY KEY(`sec_year`, `crs_code`, `sec_id`, `sec_revision`),
	FOREIGN KEY(`sec_year`, `crs_code`, `sec_id`) REFERENCES `lms_section`(`sec_year`, `crs_code`, `sec_id`),
	FOREIGN KEY(`usr_id`) REFERENCES `lms_user`(`usr_id`),
	FOREIGN KEY(`ins_id`) REFERENCES `lms_user`(`usr_id`)
);

CREATE TABLE IF NOT EXISTS `lms_sec_stu` (
	`sec_year` SMALLINT,
	`crs_code` SMALLINT UNSIGNED,
	`sec_id` SMALLINT,
	`stu_id` INT UNSIGNED,
	`ss_cur_rev` SMALLINT,
	PRIMARY KEY(`sec_year`, `crs_code`, `sec_id`, `stu_id`),
	FOREIGN KEY(`sec_year`, `crs_code`, `sec_id`) REFERENCES `lms_section`(`sec_year`, `crs_code`, `sec_id`),
	FOREIGN KEY(`stu_id`) REFERENCES `lms_student`(`stu_id`)
);

CREATE TABLE IF NOT EXISTS `lms_sec_stu_content` (
	`sec_year` SMALLINT,
	`crs_code` SMALLINT UNSIGNED,
	`sec_id` SMALLINT,
	`stu_id` INT UNSIGNED,
	`ss_revision` SMALLINT,
	`ss_start` DATE,
	`ss_end` DATE,
	`ss_tuition` BOOL,
	`usr_id` SMALLINT,
	`usr_dt` DATETIME,
	`usr_comment` VARCHAR(128),
	PRIMARY KEY(`sec_year`, `crs_code`, `sec_id`, `stu_id`, `ss_revision`),
	FOREIGN KEY(`sec_year`, `crs_code`, `sec_id`, `stu_id`) REFERENCES `lms_sec_stu`(`sec_year`, `crs_code`, `sec_id`, `stu_id`),
	FOREIGN KEY(`usr_id`) REFERENCES `lms_user`(`usr_id`)
);