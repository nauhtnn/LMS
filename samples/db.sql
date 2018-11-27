CREATE DATABASE IF NOT EXISTS `lms`;

USE `lms`;

CREATE TABLE IF NOT EXISTS `lms_ttaker` (
	`tt_name` VARCHAR(64) CHARACTER SET `utf8`,
	`tt_birthDt` DATE,
	`tt_birthPlace` VARCHAR(64) CHARACTER SET `utf8`,
	`tt_testDt` DATE,
	`tt_passed` BOOL,
	`tt_testType` TINYINT,
	`tt_id` SMALLINT,
	PRIMARY KEY(`tt_testDt`,`tt_testType`,`tt_id`)
);

CREATE TABLE IF NOT EXISTS `lms_user` (
	`usr_id` SMALLINT AUTO_INCREMENT PRIMARY KEY,
	`usr_name` VARCHAR(64) CHARACTER SET `utf8`,
	`usr_passw` CHAR(64),
	`usr_type` TINYINT
);

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