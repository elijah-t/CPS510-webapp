<?php
    session_start();
?>
<!DOCTYPE html>
    <head>
        <title>RIBS Databases</title>
        <link rel="stylesheet" href="index.css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&family=Roboto&display=swap" rel="stylesheet">
    </head>
    <body>
    <?php
        /* Redirect function */
        function redirect($url, $permanent = false) {
            if (headers_sent() === false) header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
            exit();
        }

        /* Checks if user and pass are set, and if they are equal to the given username and password */
        if(isset($_POST["user"]) and isset($_POST["pass"])){
            if($_POST["user"] == 'etungul' and $_POST["pass"] == "1234") {
                $_SESSION["user"] = 'etungul';
                $_SESSION["pass"] = '1234';
            } else {
                session_unset();
                session_destroy();
                redirect("incorrect.html");
            }
        /* Check session variables */
        } elseif($_SESSION["user"] == 'etungul' and $_SESSION["pass"] == '1234') {
            while(true){
                break;
            }
        /* Destroy session if POST or SESSION variables are incorrect */
        } else {
            session_unset();
            session_destroy();
            redirect("incorrect.html");
        }
    ?>
        <header>
            <h1 id="main">Ryerson International Bank System</h1>
        </header>
        <div style="text-align:center;">
            <p id="main" style="color:white">Welcome to the RIBS database, <?php echo $_SESSION["user"]; ?>!</p>
            <p id="main">Please select an option:</p>
            <form action="confirmation.php">
                <input type="submit" value="Drop Tables" />
            </form>
            <br>
            <form action="create.php">
                <input type="submit" value="Create Tables" />
            </form>
            <br>
            <form action="populate.php">
                <input type="submit" value="Populate Tables" />
            </form>
            <br>
            <form action="queries.php">
                <input type="submit" value="Show Queries" />
            </form>
            <br>
            <form action="select.php">
                <input type="submit" value="Select Tables" />
            </form>
            <br>
            <form action="logout.php">
                <input type="submit" value="Log Out" />
            </form>
        </div>

    </body>

</html>

