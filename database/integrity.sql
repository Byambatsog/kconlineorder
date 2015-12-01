insert into orders values(45, 1, 1, sysdate(), 'D', sysdate(), 'Salty', '1246 W PRATT BLVD APT 212', 'Chicago', 'IL', '60626', 'P', sysdate(),3);
insert into orderlines values(NULL, 45, 1, 7.50, 2, 0);
insert into orderlines values(NULL, 45, 6, 4.00, 2, 0);
insert into orderlines values(NULL, 45, 16, 2.00, 2, 0);
insert into payments values(NULL, 45, 27.00, sysdate(),1,'5370463888813020','01','2018');
select * from orders where orderid=45;
select * from orderlines where orderID=45;
select * from payments where orderid=45;