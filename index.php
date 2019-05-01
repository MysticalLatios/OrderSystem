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

	<?php
	ini_set('display_startup_errors',1);
	ini_set('display_errors',1);
    error_reporting(-1);
    
    require_once("hsu_conn.php");
    require_once("add_order.php");
    ?>
</head> 

<body>

    <div id="nav"> 
        <h2> Welcome to our restaurant! </h2>

        <button type="button" onclick="location.href='index.php'">Customer Ordering</button>
        <button type="button" onclick="location.href='staff.php'" >Show orders</button>

        <hr />
    </div>

<?php
    // Check if they have loged in from the oracle stuff
    if ( ! array_key_exists("username", $_POST) )
    {
        // If they are not loged in give them the login page
        require_once("login_form.php");
    }
    
    elseif( array_key_exists("firstname", $_POST))
    {
        //The user already submited an order so do stuff with it
        // Strip username tags
        $username = strip_tags($_POST['username']);

        // Get password from post into var
        $password = $_POST['password'];

        // Use oci_conect to login in
        $conn = hsu_conn($username, $password);

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
    else
    {
        // Strip username tags
        $username = strip_tags($_POST['username']);

        // Get password from post into var
        $password = $_POST['password'];

        // Use oci_conect to login in
        $conn = hsu_conn($username, $password);

        //Clear the password var becuase we dont need it anymore as we have the connection
        $password = NULL; 

        // ACUTAL PAGE DOWN BELOW
        // ACUTAL PAGE DOWN BELOW
        // ACUTAL PAGE DOWN BELOW, we have loged in so lets go!

        // Give them the order form
        require_once("order_form.php");
    }
    
?>  
    
    <?php
        require_once("footer.html");
    ?>

</body>


</html>
