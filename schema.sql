
CREATE DATABASE yeticave
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE yeticave;

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) UNIQUE NOT NULL
);

CREATE TABLE lots (
  id INT AUTO_INCREMENT PRIMARY KEY,
  create_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  name VARCHAR(255) NOT NULL,
  description VARCHAR(255) NOT NULL,
  img VARCHAR(1000) NOT NULL,
  start_price INT NOT NULL,
  end_time TIMESTAMP NULL,
  step INT NOT NULL,
  winner_id INT NULL,
  user_id INT NOT NULL,
  category_id INT NOT NULL
);
CREATE INDEX winner_id_idx ON lots(winner_id);
CREATE INDEX user_id_idx ON lots(user_id);
CREATE INDEX category_id_idx ON lots(category_id);
CREATE INDEX name_idx ON lots(name);
CREATE INDEX description_idx ON lots(description);

CREATE TABLE rate (
  id INT AUTO_INCREMENT PRIMARY KEY,
  create_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  amount INT NOT NULL,
  user_id INT NOT NULL,
  lot_id INT NOT NULL
);
CREATE INDEX create_time_idx ON rate(create_time);
CREATE INDEX user_id_idx ON rate(user_id);
CREATE INDEX lot_id_idx ON rate(lot_id);

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  create_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  email VARCHAR(320) UNIQUE NOT NULL,
  name VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  avatar VARCHAR(1000),
  contacts VARCHAR(1000) NOT NULL
);
CREATE INDEX create_time_idx ON users(create_time);
CREATE INDEX name_idx ON users(name);