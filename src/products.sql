-- Active: 1682557258003@@127.0.0.1@3306@sensidia

CREATE TABLE products (
	id int(11) not null auto_increment,
    product_type ENUM('dvd','furniture','book') not null,
    name varchar(255) not null,
    image varchar(255) not null,
    description text not null,
    price decimal(10,2) not null,
    SKU TEXT(11) CHARACTER SET DEFAULT 'concat('PROD-',floor(rand() * 1000000))' AUTO_INCREMENT,
    primary key(id)
);

create table dvd(
	id int(11) not null auto_increment,
    product_id int(11) not null,
    size int not null,
    primary key(id),
    foreign key(product_id) references products(id) on delete cascade
);

create table furniture(
	id int(11) not null auto_increment,
    product_id int(11) not null,
    primary key(id),
    foreign key(product_id) references products(id) on delete cascade
);

create table dimensions(
	id int(11) not null auto_increment,
    furniture_id int(11) not null,
    height decimal(10,2) not null,
    width decimal(10,2) not null,
    length decimal(10,2) not null,
    primary key(id),
    foreign key(furniture_id) references furniture(id) on delete cascade
);
create table book(
	id int(11) not null auto_increment,
    product_id int(11) not null,
    weight float(10,2) not null,
    primary key(id),
    foreign key(product_id) references products(id) on delete cascade
)