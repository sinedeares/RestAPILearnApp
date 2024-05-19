CREATE DATABASE restapi_learn_db;

CREATE TABLE restapi_user (
                         id INT NOT NULL AUTO_INCREMENT,
                         name VARCHAR(128) NOT NULL,
                         email VARCHAR(128) NOT NULL,
                         password VARCHAR(128) NOT NULL,
                         PRIMARY KEY (id)
);