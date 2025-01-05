DROP DATABASE image_db;
CREATE DATABASE image_db;
use image_db;
CREATE TABLE images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image_name VARCHAR(255) NOT NULL,
    image LONGBLOB NOT NULL
);

select * from images;