<?php
    session_start();
    
	ini_set('display_startup_errors', 1);
	ini_set('display_errors', 1);
    error_reporting(-1);
    
    require_once("hsu_conn.php");
    require_once("add_order.php");
    require_once("get_orders.php");
?>
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

    <link href="style.css"
        type="text/css" rel="stylesheet" />
</head> 

<body>

    <div id="nav"> 
        <h2> Welcome to our restaurant! </h2>
        <form method="post" action="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>">
            <button type="button" onclick="location.href='index.php'">Customer Ordering</button>
            <button type="button" onclick="location.href='staff.php'" >Show orders</button>
            <input type="submit" name="log_out" value="Log out" />
        </form>

        <hr />
    </div>

<?php
    // Check if thhe client is not yet in our session logic
    if ( ! array_key_exists("next_state", $_SESSION) )
    {
        // They are not loged in give them the login page
        $_SESSION["next_state"] = "table";
        require_once("login_form.php");
    }    
    
    elseif (array_key_exists("log_out", $_POST) )
    {
        //If we press logout, logout
        session_destroy();
        ?>
        <h2>You have loged out</h2>
        <?php
        require_once("footer.html");
        exit;
        
    }  

    //We have oracle login so continue as normal
    elseif($_SESSION["next_state"] == "table")
    {
        // Strip username tags
        $username = strip_tags($_POST['username']);

        // Get password from post into var
        $password = $_POST['password'];

        // Use oci_conect to test the login/pass, it will exit out if the connection fails
        $conn = hsu_conn($username, $password);

        // Store the username and password now that ew know the 
        $_SESSION["user"] = $username;
        $_SESSION["pass"] = $password;


        //Clear the password var becuase we dont need it anymore as we have the connection
        $password = NULL;

        // ACUTAL PAGE DOWN BELOW
        // ACUTAL PAGE DOWN BELOW
        // ACUTAL PAGE DOWN BELOW, we have loged in so lets go!

        // Give them the table/name form
        $_SESSION["next_state"] = "order";
        require_once("table_form.php");
    }

    elseif( $_SESSION["next_state"] == "order")
    {
        //Store name and table in the session
        $_SESSION['firstname'] = $_POST['firstname'];
        $_SESSION['tablenum'] = $_POST['tablenum'];

        //Go to the new order
        $_SESSION["next_state"] = "new_order";

        // Then Give them the order form again for an additional order
        require_once("order_form.php");
    }

    elseif( $_SESSION["next_state"] == "new_order")
    {
        // Get the connection using the 
        $conn = hsu_conn($_SESSION["user"], $_SESSION["pass"]);

        //Add the order
        add_order($conn, $_SESSION['firstname'], $_SESSION['tablenum'], $_POST['item']);

        // Then Give them the order form again for an additional order
        require_once("order_form.php");

        //Show current orders for this person
        get_your_orders($conn, $_SESSION['firstname']);
    }

    else
    {
        ?>
        <p> <strong> WOOPS We are in a state we should never enter </strong> </p>
        <?php

        session_destroy();
    }    
?>  


<?php
    require_once("footer.html");
?>

</body>
</html>
