<?php
    session_start();
    
	ini_set('display_startup_errors', 1);
	ini_set('display_errors', 1);
    error_reporting(-1);
    
    require_once("hsu_conn.php");
    require_once("add_order.php");
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

        <button type="button" onclick="location.href='index.php'">Customer Ordering</button>
        <button type="button" onclick="location.href='staff.php'" >Show orders</button>

        <hr />
    </div>

<?php
    // Check if thhe client is not yet in our session logic
    if ( ! array_key_exists("next_state", $_SESSION) )
    {
        // They are not loged in give them the login page
        $_SESSION["next_state"] = "login";
        require_once("login_form.php");
    }
    
    elseif( $_SESSION["next_state"] == "order")
    {
        // Get the connection from the session
        $conn = $_SESSION["oci_con"];

        //Clear the password var becuase we dont need it anymore as we have the connection
        $password = NULL; 

        //get our function
        require_once("add_order.php");

        //Add the order
        add_order($conn, $_POST['firstname'], $_POST['tablenum'], $_POST['item']);

        // Then Give them the order form again for an additional order
        require_once("order_form.php");

    }
        

    //We have oracle login so continue as normal
    elseif($_SESSION["next_state"] == "login")
    {
        // Strip username tags
        $username = strip_tags($_POST['username']);

        // Get password from post into var
        $password = $_POST['password'];

        // Use oci_conect to login in
        hsu_conn($username, $password);

        //Clear the password var becuase we dont need it anymore as we have the connection
        $password = NULL;

        // ACUTAL PAGE DOWN BELOW
        // ACUTAL PAGE DOWN BELOW
        // ACUTAL PAGE DOWN BELOW, we have loged in so lets go!

        // Give them the order form
        $_SESSION["next_state"] = "order";
        require_once("order_form.php");
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
