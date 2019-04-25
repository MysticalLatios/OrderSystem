-- Waiter table
drop table Waiter cascade constraints;
create table Waiter (
    Waiter_id char(8),
    Waiter_name varchar2(32),
    primary key (Waiter_id)
);

-- OTable table
drop table OTable cascade constraints;
create table OTable (
    OTable_id char(8),
    Waiter_id char(8) not null,
    primary key (OTable_id),
    foreign key (Waiter_id) references Waiter(Waiter_id)
);

-- LineItem table
drop table LineItem cascade constraints;
create table LineItem (
    Item_id char(8),
    Item_name varchar2(32),
    Item_price number(8,2),
    primary key (Item_id)
);

-- Orders table
-- Order_active, Y for yes N for no
drop table Orders cascade constraints;
create table Orders (
    Order_id char(8),
    Cus_name varchar2(32),
    Order_date date,
    Order_active char(1),
    Order_table char(8) not null,
    Order_line_item char(8),
    primary key (Order_id),
    foreign key (Order_table) references OTable(OTable_id),
    foreign key (Order_line_item) references LineItem(Item_id)
);