drop database if exists webshop;

create database webshop
	DEFAULT CHARACTER SET utf8
	DEFAULT COLLATE utf8_general_ci;
    
use webshop;

create table termek(
	id int primary key auto_increment,
	nev nvarchar(13),
    	ar int not null,
	darabszam int not null,
    	gyarto nvarchar(55),
    	leiras nvarchar(100)
);

insert into termek (nev, ar, darabszam, gyarto, leiras) values ('Iphone XE', 192000, 2, 'Apple', 'Visszater a legpraktikusabb iphone');
insert into termek (nev, ar, darabszam, gyarto, leiras) values ('Samsung S10', 212000, 1, 'Samsung', 'Nem apple');
insert into termek (nev, ar, darabszam, gyarto, leiras) values ('CISCO 3650x', 2200000, 1, 'Cisco', 'Szakembereknek');
insert into termek (nev, ar, darabszam, gyarto, leiras) values ('Iphone SE', 10000, 1, 'Apple', 'regi,alig hasznalt');


create table vevo(
    id int  primary key auto_increment,
    vezeteknev nvarchar(55) not null,
    keresztnev nvarchar(55) not null,
    lakcim nvarchar(45),
    kartyaszam nvarchar(45)
);

insert into vevo (vezeteknev, keresztnev, lakcim, kartyaszam) values ('Attila', 'Szigeti', 'Jutas utca 127 Budapest', '111111111111111');
insert into vevo (vezeteknev, keresztnev, lakcim, kartyaszam) values ('Bela', 'Admin', 'BME Q', '1010100101010');
insert into vevo (vezeteknev, keresztnev, lakcim, kartyaszam) values ('Pokoli', 'Operátor', 'ELTE északi', '00000000000');

create table megvasarolt(
	id int primary key auto_increment,
	vevoid int not null,
    	termekid int not null,
    	vasarlasidatum date not null,
    
    	foreign key (vevoid) references vevo(id),
    	foreign key (termekid) references termek(id)
);

insert into megvasarolt (vevoid, termekid, vasarlasidatum) values (1, 1, subdate(curdate(), 50)); 
insert into megvasarolt (vevoid, termekid, vasarlasidatum) values (1, 2, subdate(curdate(), 50)); 
insert into megvasarolt (vevoid, termekid, vasarlasidatum) values (1, 3, subdate(curdate(), 50));  
insert into megvasarolt (vevoid, termekid, vasarlasidatum) values (2, 2, subdate(curdate(), 50)); 
insert into megvasarolt (vevoid, termekid, vasarlasidatum) values (2, 1, subdate(curdate(), 50)); 
