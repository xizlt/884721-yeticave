
CREATE DATABASE yeticave
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE yeticave;

create table categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name varchar(255) UNIQUE NOT NULL
);

create table lots (
  id INT AUTO_INCREMENT PRIMARY KEY,
  create_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  name varchar(255) NOT NULL,
  description varchar(255) NOT NULL,
  img varchar(1000) NOT NULL,
  start_price INT NOT NULL,
  end_time TIMESTAMP NULL,
  step INT NOT NULL,
  winner_id INT null,
  user_id INT NOT NULL,
  category_id INT NOT NULL
);
CREATE INDEX winner_id_idx ON lots(winner_id);

CREATE table rate (
  id INT AUTO_INCREMENT PRIMARY KEY,
  create_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  amount INT NOT NULL,
  user_id INT NOT NULL,
  lot_id INT NOT NULL
);

create table users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  create_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  email varchar(320) unique NOT NULL,
  name varchar(255) NOT NULL,
  password varchar(255) NOT NULL,
  avatar varchar(1000),
  contacts varchar(1000) NOT NULL
);
