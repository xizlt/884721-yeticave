
-- внес категории товаров
INSERT INTO categories (name)
VALUE ('Доски и лыжи'),
      ('Крепления'),
      ('Ботинки'),
      ('Одежда'),
      ('Инструменты'),
      ('Разное');

-- внес информацию по лотам
INSERT INTO lots (create_time, name, description, img, start_price, end_time, step, winner_id, user_id, category_id)
VALUE ('2019-02-11 20:47', '2014 Rossignol District Snowboard', 'описание', 'img/lot-1.jpg', '10999', '2019-02-15 20:47', 200, null, 1, 1),
      ('2019-02-11 20:47', 'DC Ply Mens 2016/2017 Snowboard', 'описание', 'img/lot-2.jpg', '159999', '2019-02-15 20:47', 200, null, 2, 1),
      ('2019-02-10 20:47', 'Крепления Union Contact Pro 2015 года размер L/XL', 'описание', 'img/lot-3.jpg', '8000', '2019-02-20 20:47', 200, null, 3, 2),
      ('2019-02-09 20:47', 'Ботинки для сноуборда DC Mutiny Charocal', 'описание', 'img/lot-4.jpg', '10999', '2019-02-21 20:47', 200, null, 4, 3),
      ('2019-02-09 20:47', 'Куртка для сноуборда DC Mutiny Charocal', 'описание', 'img/lot-5.jpg', '7500', '2019-03-14 20:47', 200, null, 2, 4),
      ('2019-02-09 20:47', 'Маска Oakley Canopy', 'описание', 'img/lot-6.jpg', '5400', '2019-02-22 20:47', 200, null, 3, 6);

-- внес ствки на некоторые лоты
INSERT INTO rate (create_time, amount, user_id, lot_id)
VALUE ('2019-02-12 20:47', 160199, 4, 2),
      ('2019-02-12 20:50', 160399, 4, 2),
      ('2019-02-11 20:47', 5400, 3, 6),
      ('2019-02-11 20:47', 11199, 1, 4);


-- внес данные о зарегистрированных пользователей
INSERT INTO users (create_time, email, name, password, avatar, contacts)
VALUE ('2019-01-09 20:47', 'exemple_2@bb.com', 'Берюзюк Юлия', '8585', 'img/avatar.jpg', '8999789545'),
      ('2018-06-19 20:00', 'exemple_3@bb.com', 'Мошин Коля', '9696', 'img/user.png', '89221511232'),
      ('2018-08-16 20:01', 'exemple_4@bb.com', 'Тенева Светлана', '7445', null, '8486622151');

-- получил все категории
SELECT * FROM categories;

-- получил самые новые, открытые лоты. Каждый лот включает название, стартовую цену, ссылку на изображение, цену, название категории;
SELECT l.id, l.name, l.start_price, l.img, c.name, r.amount, r.create_time AS date
FROM lots l
JOIN categories c
ON l.category_id = c.id
JOIN rate r
ON r.lot_id = l.id
ORDER BY date DESC
limit 5;
-- получил лот по его id, а также название категории, к которой принадлежит лот.
SELECT *
FROM lots l
JOIN categories c
ON l.category_id = c.id
WHERE l.id = 4;

-- обновил название лота по его идентификатору;
UPDATE lots
SET name = 'Крепления Union Contact Pro 2015 года размер M'
WHERE id = 3;

-- получил список самых свежих ставок для лота по его идентификатору;
SELECT amount, id
FROM rate
WHERE lot_id = 2
ORDER BY create_time desc;