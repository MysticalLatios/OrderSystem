insert into Waiter(Waiter_id, Waiter_name) values('W0000001', 'Steve');
insert into Waiter(Waiter_id, Waiter_name) values('W0000002', 'Bob');
insert into Waiter(Waiter_id, Waiter_name) values('W0000003', 'Michelle ');
select * from Waiter;

insert into OTable(OTable_id, Waiter_id) values('T0000001', 'W0000002');
insert into OTable(OTable_id, Waiter_id) values('T0000002', 'W0000002');
insert into OTable(OTable_id, Waiter_id) values('T0000003', 'W0000001');
insert into OTable(OTable_id, Waiter_id) values('T0000004', 'W0000003');
select * from OTable;

insert into LineItem(Item_id, Item_name, Item_price) values('F0000001', 'Pep pizza', 6.25);
insert into LineItem(Item_id, Item_name, Item_price) values('F0000002', 'Pin pizza', 8.25);
insert into LineItem(Item_id, Item_name, Item_price) values('D0000001', 'Soda', 1.50);
select * from LineItem;



insert into Orders(Order_id, Cus_name, Order_date, Order_active, Order_table, Order_line_item)
    values('O0000001','Zach', SYSDATE, 'N', 'T0000001', 'F0000001');

select * from Orders;

