create or replace procedure deactivateorders() is
    begin
        update Orders
        set Order_active = 'N'
        where Order_date <= TRUNC(SYSDATE) - 1;
    end;
/