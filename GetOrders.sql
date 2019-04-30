create or replace procedure getorders (selector out sys_refcursor) is
    begin
        open selector for 
            select o.Order_table, o.Cus_name , o.Order_active, i.Item_name, o.Order_date
            from Orders o, LineItem i
            where o.Order_line_item = i.Item_id;
    end;
/