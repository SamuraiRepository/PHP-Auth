CREATE TABLE tmp_users (  
  id int NOT NULL primary key AUTO_INCREMENT,
  username VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(1000) NOT NULL
) default charset utf8;