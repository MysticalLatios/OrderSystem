create or replace procedure deactivateorders(order_in char(8)) is
    begin
        update Orders
        set Order_active := 'N'
        where Order_id = order_in;
    end;
/
show errors