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
        $empl_query_str = 'select Order_id, Cus_name, salary, commission
                           from Orders';
                           
        $empl_query_stmt = oci_parse($conn, $empl_query_str);

        oci_execute($empl_query_stmt, OCI_DEFAULT);
        ?>

        <table>
            <caption> Employee Information </caption>
            <tr> <th scope="col"> Employee Name </th>
                 <th scope="col"> Hire Date </th>
                 <th scope="col"> Salary </th>
                 <th scope="col"> Commission </th> </tr>

        <?php
            while (oci_fetch($empl_query_stmt))
            {
                $curr_empl_name = oci_result($empl_query_stmt, 'EMPL_LAST_NAME');
                $curr_hiredate = oci_result($empl_query_stmt, 'HIREDATE');
                $curr_salary = oci_result($empl_query_stmt, 'SALARY');
                $curr_commission = oci_result($empl_query_stmt, 'COMMISSION');

                if ($curr_commission === NULL)
                {
                    $curr_commission = "no commission";
                }

                ?>
                <tr> <td> <?= $curr_empl_name ?> </td>
                     <td> <?= $curr_hiredate ?> </td>
                     <td> <?= $curr_salary ?> </td>
                     <td> <?= $curr_commission ?> </td>
                </tr> 
                <?php
            }
            ?>
            </table>

            <?php

            //end the connection
             oci_free_statement($empl_query_stmt);
             oci_close($conn);
    }
    
?>  
    
    <?php
        require_once("footer.html");
    ?>

</body>


</html>