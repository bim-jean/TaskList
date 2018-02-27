/* Create Database */
CREATE DATABASE myoung;

/* Change Database */
use myoung;

/* Create Services Table */
create table services (
	services_id int not null auto_increment, 
	services_desc varchar(32), 
	services_abbr varchar(10),
	primary key (services_id),
	INDEX (services_abbr)
);

/* Insert into Services Table */
insert into services (services_desc,services_abbr) values ('PHP Tutoring','php');
insert into services (services_desc,services_abbr) values ('C Tutoring','C');
insert into services (services_desc,services_abbr) values ('Python Tutoring','python');
insert into services (services_desc,services_abbr) values ('Database Training','database');
insert into services (services_desc,services_abbr) values ('PC Repair','PC');
insert into services (services_desc,services_abbr) values ('Website Development','web');

/* Create Profile Table */
create table profile (
	profile_id INT NOT NULL AUTO_INCREMENT,
	netid varchar(20),
	first_name varchar(32),
	last_name varchar(32),
	email varchar(32),
	post_date date,
	notification tinyint(1) not null default 0,
	PRIMARY KEY (profile_id)
	) ;

/* Create Availability Table */
	create table availability (
	availability_id int not null auto_increment, 
	availability_desc varchar(32), 
	availability_abbr varchar(3),
	primary key (availability_id),
	INDEX (availability_abbr)
	);
	
/* Insert into Availability Table */
insert into availability (availability_desc, availability_abbr) values ('Monday 8am-12pm','M8');
insert into availability (availability_desc, availability_abbr) values ('Tuesday 8am-12pm','T8');
insert into availability (availability_desc, availability_abbr) values ('Wednesday 8am-12pm','W8');
insert into availability (availability_desc, availability_abbr) values ('Thursday 8am-12pm','Th8');
insert into availability (availability_desc, availability_abbr) values ('Friday 8am-12pm','F8');
insert into availability (availability_desc, availability_abbr) values ('Monday 1pm-5pm','M1');
insert into availability (availability_desc, availability_abbr) values ('Tuesday 1pm-5pm','T1');
insert into availability (availability_desc, availability_abbr) values ('Wednesday 1pm-5pm','W1');
insert into availability (availability_desc, availability_abbr) values ('Thursday 1pm-5pm','Th1');
insert into availability (availability_desc, availability_abbr) values ('Friday 1pm-5pm','F1');
insert into availability (availability_desc, availability_abbr) values ('Monday 6pm-10pm','M6');
insert into availability (availability_desc, availability_abbr) values ('Tuesday 6pm-10pm','T6');
insert into availability (availability_desc, availability_abbr) values ('Wednesday 6pm-10pm','W6');
insert into availability (availability_desc, availability_abbr) values ('Thursday 6pm-10pm','Th6');
insert into availability (availability_desc, availability_abbr) values ('Friday 6pm-10pm','F6');

/* Create Services Offered Table */
CREATE TABLE services_offered (
    services_offered_id INT NOT NULL AUTO_INCREMENT,
    profile_id INT NOT NULL,
    services_id INT NOT NULL,
    PRIMARY KEY(services_offered_id),
    INDEX (services_id, profile_id),
    INDEX (profile_id),
    FOREIGN KEY (services_id)
      REFERENCES services(services_id),
    FOREIGN KEY (profile_id)
      REFERENCES profile(profile_id)
) ;

/* Create Profile Availability */
CREATE TABLE profile_availability (
    profile_availability_id INT NOT NULL AUTO_INCREMENT,
    availability_id INT NOT NULL,
	profile_id INT NOT NULL,
    PRIMARY KEY(profile_availability_id),
    INDEX (availability_id, profile_id),
    INDEX (profile_id),
    FOREIGN KEY (availability_id)
      REFERENCES availability(availability_id),
    FOREIGN KEY (profile_id)
      REFERENCES profile(profile_id)
) ;

/* Create Proxy User */
CREATE USER 'tasklist_user'@'localhost' IDENTIFIED BY 'my*password';

/* Create Grants */
GRANT SELECT, UPDATE, INSERT ON myoung.profile TO 'tasklist_user'@'localhost';
GRANT SELECT, UPDATE, INSERT ON myoung.services_offered TO 'tasklist_user'@'localhost';
GRANT SELECT, UPDATE, INSERT ON myoung.profile_availability TO 'tasklist_user'@'localhost';
GRANT SELECT ON myoung.services to 'tasklist_user'@'localhost';
GRANT SELECT ON myoung.availability to 'tasklist_user'@'localhost';




	

	

	


