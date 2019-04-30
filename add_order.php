<?php
function add_order($order_id, $cus_name, $order_active, $order_table, $order_item)
{
    //Order statment
    $order_input_stmt = 'insert into Orders(Order_id, Cus_name, Order_date, Order_active, Order_table, Order_line_item)
        values(:order_id, :cus_name, SYSDATE, :active, :table, :line_item)';

                           
    $order_input_stmt = oci_parse($conn, $order_input_stmt);

    //Bind all the varribles
    oci_bind_by_name($order_input_stmt, ":order_id", $order_id);
    oci_bind_by_name($order_input_stmt, ":cus_name", $cus_name);
    oci_bind_by_name($order_input_stmt, ":active", $order_active);
    oci_bind_by_name($order_input_stmt, ":table", $order_table);
    oci_bind_by_name($order_input_stmt, ":line_item", $order_item);

    oci_execute($order_input_stmt, OCI_DEFAULT);

    //free the statment
    oci_free_statement($order_input_stmt);
}

?>