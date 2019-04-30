<!DOCTYPE html>
<html  xmlns="http://www.w3.org/1999/xhtml">

<!--
    Made by: Joshua Alpert
    adapted from try-oracle from Sharon Tuttle
-->

<head>
    <title> OrderSystem! </title>
    <meta charset="utf-8" />

    <link href="http://users.humboldt.edu/smtuttle/styles/normalize.css"
          type="text/css" rel="stylesheet" />

	<?php
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
	error_reporting(-1);
    ?>
</head> 

<body>

    <div id="nav"> 
        <h2> Staff site for our restruant: </h2>

        <button type="button" onclick="location.href='index.php'">Customer Ordering</button>
        <button type="button" onclick="location.href='staff.php'" >Show orders</button>

        <hr />
    </div>

<?php
    // Check if they have loged in from the oracle stuff
    if ( ! array_key_exists("username", $_POST) )
    {
        // If theyare not give them the login page
        ?>
        <form method="post" 
              action="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>">
        <fieldset>
            <legend> Please enter HSU Oracle username/password: </legend>

            <label for="username"> Username: </label>
            <input type="text" name="username" id="username" /> 

            <label for="password"> Password: </label>
            <input type="password" name="password" 
                   id="password" />

            <div class="submit">
                <input type="submit" value="Log in" />
            </div>
        </fieldset>
        </form>
    <?php
    }      

    //We have oracle login so continue as normal
    else
    {
        // Strip username tags
        $username = strip_tags($_POST['username']);

        // Get password from post into var
        $password = $_POST['password'];

        // Connection str
        $db_conn_str =
            "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)
                                    (HOST = cedar.humboldt.edu)
                                    (PORT = 1521))
                                    (CONNECT_DATA = (SID = STUDENT)))";

        // Use oci_conect to login in
        $conn = oci_connect($username, $password, $db_conn_str);

        // exiting if connection/log in failed

        if (! $conn)
        {
            ?>
            <p> Could not log into Oracle, sorry </p>

            <?php
            require_once("footer.html");
            ?>
</body>
</html>
            <?php
            exit;
        }
        // ACUTAL PAGE DOWN BELOW
        // ACUTAL PAGE DOWN BELOW
        // ACUTAL PAGE DOWN BELOW, we have loged in so lets go!

        ?>
            
        <?php

        
        //Clear the password var becuase we dont need it anymore as we have the connection
        $password = NULL; 

        // let's set up a SQL SELECT statement and ask the
        //     data tier to execute it for us

        //Test querry
        $order_query_str = 'select o.Order_table, o.Cus_name , o.Order_active, i.Item_name, o.Order_date
                            from Orders o, LineItem i
                            where o.Order_line_item = i.Item_id';
                           
        $order_query_stmt = oci_parse($conn, $order_query_str);

        oci_execute($order_query_stmt, OCI_DEFAULT);
        ?>

        <table>
            <caption> Orders </caption>
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
    
?>  
    
    <?php
        require_once("footer.html");
    ?>

</body>


</html>
