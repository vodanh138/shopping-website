DROP SCHEMA IF EXISTS shopee;
CREATE SCHEMA shopee;

DROP TABLE IF EXISTS shopee.user_table;
CREATE TABLE shopee.user_table (
    uid INT AUTO_INCREMENT,
    username VARCHAR(255),
    email VARCHAR(255),
    password VARCHAR(255),
    ori_username VARCHAR(255),
    role VARCHAR(255),
    PRIMARY KEY (uid)
);

DROP TABLE IF EXISTS shopee.product_table;
CREATE TABLE shopee.product_table (
    pid INT AUTO_INCREMENT,
    pname VARCHAR(255), 
    price INT,
    des VARCHAR(255), 
    image VARCHAR(255), 
    amount INT,
    uid INT,
    view INT DEFAULT '0',
    PRIMARY KEY (pid),
    FOREIGN KEY (uid) REFERENCES user_table(uid) ON DELETE CASCADE
);

DROP TABLE IF EXISTS shopee.cart_table;
CREATE TABLE shopee.cart_table (
    cid INT AUTO_INCREMENT,
    uid INT,
    pid INT,
    buyNumber INT,
    PRIMARY KEY (cid),
    FOREIGN KEY (uid) REFERENCES user_table(uid) ON DELETE CASCADE,
    FOREIGN KEY (pid) REFERENCES product_table(pid) ON DELETE CASCADE
);

DROP TABLE IF EXISTS shopee.order_table;
CREATE TABLE shopee.order_table (
    oid INT AUTO_INCREMENT,
    uid INT,
    pid INT,
    number INT,
    status VARCHAR(255),
    PRIMARY KEY (oid),
    FOREIGN KEY (uid) REFERENCES user_table(uid) ON DELETE CASCADE,
    FOREIGN KEY (pid) REFERENCES product_table(pid) ON DELETE CASCADE
);

INSERT INTO shopee.user_table (username, email, password, ori_username, role) 
VALUES (MD5('1'), '1', MD5('Zxcvbnm1'), 'Admin', 'admin');
