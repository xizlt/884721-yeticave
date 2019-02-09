
CREATE DATABASE yeticave
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE yeticave;

create table categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name varchar NOT NULL,
);

create table lots (
  id INT AUTO_INCREMENT PRIMARY KEY,
  date_creat TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  name_lot char  NOT NULL,
  description char,
  img text  NOT NULL,
  start_price DECIMAL  NOT NULL,
  date_end TIMESTAMP,
  step DECIMAL,
  winner_id int NOT NULL,
  user_id int NOT NULL,
  category_id int NOT NULL
);

create table rate (
  id INT AUTO_INCREMENT PRIMARY KEY,
  date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  summ DECIMAL  NOT NULL,
  user_id int NOT NULL,
  lot_id int NOT NULL
);

create table users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  date_reg TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  email char unique  NOT NULL,
  name char,
  password char  NOT NULL,
  avatar text,
  contacts char unique,
  add_lot_id int NOT NULL,
  rate_id int NOT NULL
);

insert into categories (name) value ('Доски и лыжи'), ('Крепления'), ('Ботинки'), ('Одежда'), ('Инструменты'), ('Разное');