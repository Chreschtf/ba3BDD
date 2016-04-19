CREATE TABLE users (
    uid INT(6) NOT NULL AUTO_INCREMENT,
    nickname VARCHAR(20) NOT NULL,
    email VARCHAR(20) NOT NULL,
    password VARCHAR(15) NOT NULL,
    entry_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    admin BIT NOT NULL,
    PRIMARY KEY (uid)
);

CREATE TABLE establishments (
    eid INT(6) NOT NULL AUTO_INCREMENT ,
    ename VARCHAR(20) NOT NULL,
    street VARCHAR(20) NOT NULL,
    house_num INT(5) NOT NULL,
    zip INT(4) NOT NULL,
    city VARCHAR(20) NOT NULL,
    longitude INT(5) NOT NULL,
    latitude INT(5) NOT NULL,
    tel VARCHAR(20) NOT NULL,
    site VARCHAR(20) NOT NULL,
    uid INT(6) NOT NULL,
    entry_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (eid),
    FOREIGN KEY (uid) REFERENCES users(uid)
);

CREATE TABLE restaurants (
    eid INT(6) NOT NULL,
    price_range INT(3) NOT NULL,
    banquet_capacity INT(3) NOT NULL,
    takeaway BIT NOT NULL,
    delivery BIT NOT NULL,
    PRIMARY KEY (eid),
    FOREIGN KEY (eid) REFERENCES establishments(eid)
);

CREATE TABLE restaurant_closing_days (
    eid INT(6) NOT NULL,
    closing_day ENUM('MON', 'TUE', 'WEN', 'THU', 'FRI', 'SAT', 'SUN') NOT NULL,
    hour ENUM('AM', 'PM') NOT NULL,
    PRIMARY KEY (eid),
    FOREIGN KEY (eid) REFERENCES establishments(eid)
);

CREATE TABLE bars (
    eid INT(6) NOT NULL,
    smoking BIT NOT NULL,
    snack BIT NOT NULL,
    PRIMARY KEY (eid),
    FOREIGN KEY (eid) REFERENCES establishments(eid)
);

CREATE TABLE hotels (
    eid INT(6) NOT NULL,
    stars INT(1) NOT NULL,
    rooms INT(3) NOT NULL,
    standart_price INT(3) NOT NULL,
    PRIMARY KEY (eid),
    FOREIGN KEY (eid) REFERENCES establishments(eid)
);

CREATE TABLE comments (
    cid INT(6) NOT NULL AUTO_INCREMENT,
    uid INT(6) NOT NULL,
    eid INT(6) NOT NULL,
    entry_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    score INT(1) NOT NULL,
    Text TEXT NOT NULL,
    PRIMARY KEY (cid),
    FOREIGN KEY (uid) REFERENCES users(uid),
    FOREIGN KEY (eid) REFERENCES establishments(eid)
);

CREATE TABLE tags (
    tid INT(6) NOT NULL AUTO_INCREMENT,
    tname VARCHAR(35) NOT NULL,
    PRIMARY KEY (tid)
);

CREATE TABLE establishment_tags (
    tid INT(6) NOT NULL,
    eid INT(6) NOT NULL,
    uid INT(6) NOT NULL,
    PRIMARY KEY (tid),
    FOREIGN KEY (tid) REFERENCES tags(tid),
    FOREIGN KEY (uid) REFERENCES users(uid),
    FOREIGN KEY (eid) REFERENCES establishments(eid)
);