
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
  create_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  name char NOT NULL,
  description char,
  img text NOT NULL,
  start_price INT NOT NULL,
  end_time TIMESTAMP,
  step INT,
  winner_id int,
  user_id int NOT NULL,
  category_id int NOT NULL
);

create table rate (
  id INT AUTO_INCREMENT PRIMARY KEY,
  create_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  amount INT NOT NULL,
  user_id int NOT NULL,
  lot_id int NOT NULL
);

create table users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  create_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  email char unique NOT NULL,
  name char,
  password char NOT NULL,
  avatar text,
  contacts char unique,
  add_lot_id int NOT NULL,
  rate_id int NOT NULL
);

insert into categories (name) value ('Доски и лыжи'), ('Крепления'), ('Ботинки'), ('Одежда'), ('Инструменты'), ('Разное');