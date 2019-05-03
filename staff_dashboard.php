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
    $money_str = 'begin getordersum(); end;';

    //parse the str to be a stmt
    $money_stmt = oci_parse($conn2 , $money_str);

    //Execute the statment
    oci_execute($money_stmt, OCI_DEFAULT);

    //get the result of the statment
    oci_fetch($money_stmt);
    $total_money = oci_result($money_stmt, "SUM(ITEM_PRICE)");

    ?>
        <p>Total Sales: <strong><?= $total_money ?> </strong> rows </p>     
    <?php

    //Add button to clear orders older then a day
    ?>
    <br/>
    <form method="post" action="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>">
        <input type="submit" name="clear_old_orders" value="Clear orders older then a day"/>
    </form>
    <?php
}

