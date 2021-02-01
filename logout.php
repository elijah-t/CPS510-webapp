<?php
    session_start();
?>
<html>
    <head>
        <title>RIBS Databases</title>
        <link rel="stylesheet" href="index.css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&family=Roboto&display=swap" rel="stylesheet">
    </head>
    <body>
        <header>
            <h1 id="main">Ryerson International Bank System</h1>
        </header>
        <div style="text-align:center;">
            <?php
                //Destroy session and unsets session variables
                session_unset();
                session_destroy();
            ?>
            <p id="main">You have logged out. You can close this window to exit.</p>
            </form>
        </div>

    </body>

</html>