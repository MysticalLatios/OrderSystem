create or replace function getordersum() is
    total_money number;
    begin
        total_money = select sum(i.Item_price)
                    from Orders o, LineItem i
                    where o.Order_line_item = i.Item_id;

        return total_money;
    end;
/