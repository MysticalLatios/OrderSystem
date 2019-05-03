create or replace function getordersum return number as
    total_money number;
begin
    select sum(i.Item_price)
    into total_money
    from Orders o, LineItem i
    where o.Order_line_item = i.Item_id;

    return total_money;
end;
/
show errors