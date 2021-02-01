<?php
    session_start();
?>
<html>
    <head>
        <title>Drop Tables</title>
        <link rel="stylesheet" href="index.css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&family=Roboto&display=swap" rel="stylesheet">
    </head>
    <body>
    <header>
        <h1 id="main">Ryerson International Bank System</h1>
    </header>
    <div>
        <?php
            $conn = oci_connect('etungul', '06295285', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(Host=oracle.scs.ryerson.ca)(Port=1521))(CONNECT_DATA=(SID=orcl)))');
        
            if(!$conn) {
                $e = oci_error();
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            }

            /* Drops tables in the correct order */
            $tables = array("LOAN", "TRANSACTION", "BANKACCOUNT", "CONSUMER", "BRANCH", "BANK");
            foreach($tables as $value) {
                $stid = oci_parse($conn, "DROP TABLE " . $value);
                oci_execute($stid);
                oci_free_statement($stid);
            }
            oci_close($conn);
        ?>
        <p id="main">Tables dropped.</p>
        <form action=http://www2.cs.ryerson.ca/~etungul/ribs/menu.php />
            <input type="submit" value="Back to Menu" />
        </form>
    </div>

    </body>
</html>