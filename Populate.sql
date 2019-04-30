insert into Waiter(Waiter_id, Waiter_name) values('W0000001', 'Steve');
insert into Waiter(Waiter_id, Waiter_name) values('W0000002', 'Bob');
insert into Waiter(Waiter_id, Waiter_name) values('W0000003', 'Michelle ');
select * from Waiter;

insert into OTable(OTable_id, Waiter_id) values('T0000001', 'W0000002');
insert into OTable(OTable_id, Waiter_id) values('T0000002', 'W0000002');
insert into OTable(OTable_id, Waiter_id) values('T0000003', 'W0000001');
insert into OTable(OTable_id, Waiter_id) values('T0000004', 'W0000003');
select * from OTable;