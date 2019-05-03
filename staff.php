<?php
    session_start();
    
	ini_set('display_startup_errors', 1);
	ini_set('display_errors', 1);
    error_reporting(-1);
    
    require_once("hsu_conn.php");
    require_once("add_order.php");
    require_once("get_orders.php");
    require_once("staff_dashboard.php");
    require_once("DeactivateOrders.php");
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
            <button class="nav" type="button" onclick="location.href='index.php'">Customer Ordering</button>
            <button class="nav" type="button" onclick="location.href='staff.php'" >Show orders</button>
            <input class="nav" id="logout" type="submit" name="log_out" value="Log out" />
        </form>
        <hr />
    </div>

<?php
    // Check if thhe client is not yet in our session logic
    if ( ! array_key_exists("next_state", $_SESSION) )
    {
        // They are not loged in give them the login page
        $_SESSION["next_state"] = "admin";
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

    elseif (array_key_exists("deactivate_order", $_POST) )
    {
        deactivate_orders($_POST["deactivate_order"]);

        //Set the next state
        $_SESSION["next_state"] = "admin_refresh";

        staff_dashboard();
    }
    
    //We have oracle login so continue as normal
    elseif($_SESSION["next_state"] == "admin")
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

        //Set the next state
        $_SESSION["next_state"] = "admin_refresh";

        // Give them the staff dashboard
        staff_dashboard();
    }

    elseif($_SESSION["next_state"] == "admin_refresh")
    {
        // Give them the staff dashboard
        staff_dashboard();
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
