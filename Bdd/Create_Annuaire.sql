CREATE DATABASE IF NOT EXISTS annuaire_horeca DEFAULT COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS annuaire_horeca.users (
    uid INT(6) NOT NULL AUTO_INCREMENT,
    nickname VARCHAR(40) UNIQUE NOT NULL,
    email VARCHAR(40) DEFAULT NULL,
    password VARCHAR(70) DEFAULT NULL,
    entry_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    admin BOOLEAN DEFAULT 0,
    picture_name VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (uid),
    UNIQUE(nickname),
    UNIQUE(email)
);

CREATE TABLE IF NOT EXISTS annuaire_horeca.establishments (
    eid INT(6) NOT NULL AUTO_INCREMENT ,
    ename VARCHAR(40) NOT NULL,
    street VARCHAR(40) NOT NULL,
    house_num VARCHAR(7) NOT NULL,
    zip INT(4) NOT NULL,
    city VARCHAR(20) NOT NULL,
    longitude DOUBLE(15, 7) NOT NULL,
    latitude DOUBLE(15, 7) NOT NULL,
    tel VARCHAR(20) NOT NULL,
    site VARCHAR(60),
    uid INT(6) NOT NULL,
    entry_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    horeca_type ENUM('Restaurant', 'Bar', 'Hotel') NOT NULL,
    PRIMARY KEY (eid),
    FOREIGN KEY (uid) REFERENCES users(uid)
);

CREATE TABLE IF NOT EXISTS annuaire_horeca.restaurants (
    eid INT(6) NOT NULL,
    price_range INT(3) NOT NULL,
    banquet_capacity INT(3) NOT NULL,
    takeaway BOOLEAN DEFAULT 0,
    delivery BOOLEAN DEFAULT 0,
    PRIMARY KEY (eid),
    FOREIGN KEY (eid) REFERENCES establishments(eid)
);

CREATE TABLE IF NOT EXISTS annuaire_horeca.restaurant_closing_days (
    eid INT(6) NOT NULL,
    closing_day ENUM('MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN') NOT NULL,
    hour ENUM('AM', 'PM', 'COMPLETE') NOT NULL,
    FOREIGN KEY (eid) REFERENCES establishments(eid)
);

CREATE TABLE IF NOT EXISTS annuaire_horeca.bars (
    eid INT(6) NOT NULL,
    smoking BOOLEAN DEFAULT 0,
    snack BOOLEAN DEFAULT 0,
    PRIMARY KEY (eid),
    FOREIGN KEY (eid) REFERENCES establishments(eid)
);

CREATE TABLE IF NOT EXISTS annuaire_horeca.hotels (
    eid INT(6) NOT NULL,
    stars INT(1) NOT NULL,
    rooms INT(3) NOT NULL,
    standard_price INT(3) NOT NULL,
    PRIMARY KEY (eid),
    FOREIGN KEY (eid) REFERENCES establishments(eid)
);

CREATE TABLE IF NOT EXISTS annuaire_horeca.comments (
    cid INT(6) NOT NULL AUTO_INCREMENT,
    uid INT(6) NOT NULL,
    eid INT(6) NOT NULL,
    entry_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    score INT(1) NOT NULL,
    likes INT(3) DEFAULT 0,
    text TEXT NOT NULL,
    PRIMARY KEY (cid),
    FOREIGN KEY (uid) REFERENCES users(uid),
    FOREIGN KEY (eid) REFERENCES establishments(eid)
);

CREATE TABLE IF NOT EXISTS annuaire_horeca.comment_likes (
    cid INT(6) NOT NULL,
    uid INT(6) NOT NULL,
    likes BOOLEAN DEFAULT 0,
    FOREIGN KEY (uid) REFERENCES users(uid),
    FOREIGN KEY (cid) REFERENCES comments(cid)
);

CREATE TABLE IF NOT EXISTS annuaire_horeca.tags (
    tid INT(6) NOT NULL AUTO_INCREMENT,
    tname VARCHAR(35) NOT NULL,
    PRIMARY KEY (tid),
    UNIQUE (tname)
);

CREATE TABLE IF NOT EXISTS annuaire_horeca.establishment_tags (
    tid INT(6) NOT NULL,
    eid INT(6) NOT NULL,
    uid INT(6) NOT NULL,
    FOREIGN KEY (tid) REFERENCES tags(tid),
    FOREIGN KEY (uid) REFERENCES users(uid),
    FOREIGN KEY (eid) REFERENCES establishments(eid)
);