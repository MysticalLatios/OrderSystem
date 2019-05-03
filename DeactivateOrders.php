<?php
function deactivate_orders($order_in)
{
    //Get another connection via hsu_conn
    $conn = hsu_conn($_SESSION["user"], $_SESSION["pass"]);

    //Set up prosidure
    $order_str = 'begin deactivateorders(:order_in); end;';

    //parse the str to be a stmt
    $order_stmt = oci_parse($conn , $order_str);

    oci_bind_by_name($order_stmt, ":order_in", $order_in);

    //Execute the statment
    oci_execute($order_stmt, OCI_DEFAULT);

    $committed = oci_commit($conn);

    if (!$committed) 
    {
        $error = oci_error($conn);
        echo 'Commit failed. Oracle reports: ' . $error['message'];
    }

    oci_free_statement($order_stmt);
    oci_close($conn);

    //Add button to clear orders older then a day
    ?>
    <br/>
    <form method="post" action="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>">
        <input type="submit" name="clear_old_orders" value="Clear orders older then a day"/>
    </form>
    <?php
}