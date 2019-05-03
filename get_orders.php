<?php
function get_your_orders($conn, $name)
{
    // let's set up a SQL SELECT statement and ask the
    $order_query_str = 'select i.Item_name, o.Order_date, i.Item_price
                        from Orders o, LineItem i
                        where o.Order_line_item = i.Item_id AND o.Cus_name = :name_in';

    $order_query_stmt = oci_parse($conn, $order_query_str);

    oci_bind_by_name($order_query_stmt, ":name_in", $name);

    oci_execute($order_query_stmt, OCI_DEFAULT);
    ?>

    <table>
        <caption> Your orders </caption>
        <tr> <th scope="col"> Ordered item </th>
             <th scope="col"> Ordered date </th>
             <th scope="col"> price </th>

    <?php
    //Counter to store total price
    $total_price = 0;

    while (oci_fetch($order_query_stmt))
    {
        $item_name = oci_result($order_query_stmt, 'ITEM_NAME');
        $order_date = oci_result($order_query_stmt, 'ORDER_DATE');
        $Item_price = oci_result($order_query_stmt, 'ITEM_PRICE');

        $total_price = $total_price + $Item_price;

        ?>
        <tr> <td> <?= $item_name ?> </td>
                <td> <?= $order_date ?> </td>
                <td> <?= $Item_price ?> </td>
        </tr> 
        <?php
    }
    ?>
    </table>
    <p> Your total price is: <strong><?=$total_price;?></strong></p>
    <?php

    //end the connection
    oci_free_statement($order_query_stmt);
    oci_close($conn);
}

//Gets all active orders
function get_all_orders($conn)
{
    $order_query_str = 'select o.Order_table, o.Cus_name , o.Order_active, i.Item_name, o.Order_date
                            from Orders o, LineItem i
                            where o.Order_line_item = i.Item_id AND o.Order_active ="Y"';
                           
    $order_query_stmt = oci_parse($conn, $order_query_str);

    oci_execute($order_query_stmt, OCI_DEFAULT);
    ?>

    <table>
        <caption> Active Orders </caption>
        <tr> <th scope="col"> Table </th>
                <th scope="col"> Customer name </th>
                <th scope="col"> Active </th>
                <th scope="col"> Order Item </th>
                <th scope="col"> Order Date </th> </tr>

    <?php
        while (oci_fetch($order_query_stmt))
        {
            $order_table = oci_result($order_query_stmt, 'ORDER_TABLE');
            $order_cus_name = oci_result($order_query_stmt, 'CUS_NAME');
            $order_active = oci_result($order_query_stmt, 'ORDER_ACTIVE');
            $order_item = oci_result($order_query_stmt, 'ITEM_NAME');
            $order_date = oci_result($order_query_stmt, 'ORDER_DATE');


            ?>
            <tr> <td> <?= $order_table ?> </td>
                    <td> <?= $order_cus_name ?> </td>
                    <td> <?= $order_active ?> </td>
                    <td> <?= $order_item ?> </td>
                    <td> <?= $order_date ?> </td>
            </tr> 
            <?php
        }
        ?>
        </table>

        <?php

        //end the connection
            oci_free_statement($order_query_stmt);
            oci_close($conn);
}

