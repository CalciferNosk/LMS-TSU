CREATE SCHEMA `lms-tsu` ;


CREATE TABLE `lms-tsu`.`tblroom` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `Subject` INT NULL,
  `Title` VARCHAR(45) NULL,
  `AssignedTeacher` INT NULL,
  `StudentCount` INT NULL,
  `CreatedDate` VARCHAR(45) NULL,
  `UpdatedDate` DATE NULL,
  `ActiveStatus` INT(1) NULL DEFAULT 1,
  PRIMARY KEY (`id`));
