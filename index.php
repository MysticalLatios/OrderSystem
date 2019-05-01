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
        $conn = hsu_conn($username, $password);

        // ACUTAL PAGE DOWN BELOW
        // ACUTAL PAGE DOWN BELOW
        // ACUTAL PAGE DOWN BELOW, we have loged in so lets go!

        //Clear the password var becuase we dont need it anymore as we have the connection
        $password = NULL; 
    }
    
?>  
    
    <?php
        require_once("footer.html");
    ?>

</body>


</html>
