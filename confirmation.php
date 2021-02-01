<?php
    session_start();
?>
<html>
    <head>
        <title>Select Tables</title>
        <link rel="stylesheet" href="index.css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&family=Roboto&display=swap" rel="stylesheet">
    </head>
    <body>
    <header>
        <h1 id="main">Ryerson International Bank System</h1>
    </header>
    <div>
        <h3 id="main">Are you sure you want to drop tables? (This will delete all tables in the database.)</h3>
        <form action="drop.php">
            <input type="submit" value="Yes" />
        </form>
        <form action="http://www2.cs.ryerson.ca/~etungul/ribs/menu.php">
            <input type="submit" value="No" />
        </form>
    </div>

    </body>
</html>