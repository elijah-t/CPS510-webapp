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
    <?php
        $conn = oci_connect('etungul', '06295285', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(Host=oracle.scs.ryerson.ca)(Port=1521))(CONNECT_DATA=(SID=orcl)))');
        
        if(!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        
        /* Table array */
        $tables = array("BANK", "BANKACCOUNT", "BRANCH", "CONSUMER", "LOAN", "TRANSACTION");

        /* Takes each value in tables and runs a select statement query, and it inserts the data into an HTML table. */
        foreach($tables as $value) {
            $stid = oci_parse($conn, 'SELECT * FROM ' . $value);
            if (!$stid) {
                $e = oci_error($conn);
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            }
    
            $r = oci_execute($stid);
            if (!$r) {
                $e = oci_error($stid);
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            }
            
            echo "<h3 id=\"main\">" . $value . " Table" . "</h3>";
            echo "<table border='1'>\n";
            while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
                echo "<tr>\n";
                foreach ($row as $item) {
                    echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
                }
                echo "</tr>\n";
            }
            echo "</table>\n";
            echo "<br>";    
        }

        oci_free_statement($stid);
        oci_close($conn);
    ?>

    <form action="http://www2.cs.ryerson.ca/~etungul/ribs/menu.php">
        <input type="submit" value="Back to Menu" />
    </form>
    </div>
    </body>
</html>