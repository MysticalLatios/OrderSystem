<?php
function staff_dashboard()
{
    // Use hsu_conn to login in
    $conn = hsu_conn($_SESSION["user"], $_SESSION["pass"]);
    //Display all the orders for them
    get_all_orders($conn);

    //Get another connection via hsu_conn
    $conn2 = hsu_conn($_SESSION["user"], $_SESSION["pass"]);

    //Set up prosidure
    $money_str = 'begin :bind_out := getordersum; end;';

    //parse the str to be a stmt
    $money_stmt = oci_parse($conn2 , $money_str);

    oci_bind_by_name($money_stmt,':bind_out', $money_total, 8);

    //Execute the statment
    oci_execute($money_stmt, OCI_DEFAULT);

    oci_free_statement($money_stmt);
    oci_close($conn2);

    ?>
        <p>Total Sales: <strong><?= $money_total ?> </strong></p>   
    <?php

    

}

