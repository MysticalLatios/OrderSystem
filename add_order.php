<?php
//Adds an order to the database
function add_order($conn, $cus_name, $order_table, $order_item)
{
    //make an id
    $order_id = rand(10000000, 99999999);
    $order_id = strval($order_id);
    $cus_name = strip_tags($cus_name);
    $order_table = strip_tags($order_table);
    $order_item = strip_tags($order_item);

    //Set the order as active
    $order_active = 'Y';

    //Order statment
    $order_input_stmt = 'insert into Orders(Order_id, Cus_name, Order_date, Order_active, Order_table, Order_line_item)
        values(:order_id_in, :cus_name_in, SYSDATE, :active_in, :table_in, :line_item_in)';


                           
    $order_input_stmt = oci_parse($conn, $order_input_stmt);

    //Bind all the varribles
    oci_bind_by_name($order_input_stmt, ":order_id_in", $order_id);
    oci_bind_by_name($order_input_stmt, ":cus_name_in", $cus_name);
    oci_bind_by_name($order_input_stmt, ":active_in", $order_active);
    oci_bind_by_name($order_input_stmt, ":table_in", $order_table);
    oci_bind_by_name($order_input_stmt, ":line_item_in", $order_item);

    /*
    print($order_id);
    print($cus_name);
    print($order_active);
    print($order_table);
    print($order_item);

    print($order_input_stmt);
    */

    oci_execute($order_input_stmt, OCI_DEFAULT);

    $committed = oci_commit($conn);

    if (!$committed) 
    {
        $error = oci_error($conn);
        echo 'Commit failed. Oracle reports: ' . $error['message'];
    }

    //free the statment
    oci_free_statement($order_input_stmt);
}
?>