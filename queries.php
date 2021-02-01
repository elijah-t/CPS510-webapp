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
        /* Connect to Oracle */
        $conn = oci_connect('etungul', '06295285', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(Host=oracle.scs.ryerson.ca)(Port=1521))(CONNECT_DATA=(SID=orcl)))');
        
        if(!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        /* Query Title array */
        $queryTitle = array(
            "Account Types of account SAV and belonging to the 111 Main St. branch",
            "Loan amounts greater than 5000",
            "Transaction IDs greater than 4446 and of type DPST",
            "Consumers that use the 111 Main St. branch or the 6654 Yonge St. branch",
            "Bank Table",
            "Addresses registered at CIBC",
            "Loan IDs of type LWINT",
            "Transaction dates"
        );

        /* Query array */
        $queryArr = array(
            "SELECT AccountType FROM bankAccount WHERE (AccountType = 'SAV') AND (AccountBelongsTo = 1001)",
            "SELECT LoanAmount FROM loan WHERE LoanAmount > 5000",
            "SELECT TransactionID FROM transaction WHERE (TransactionID < 4446) AND (TransactionType = 'DPST')",
            "SELECT UsesBranch FROM consumer WHERE (UsesBranch = 1001) OR (UsesBranch = 1003)",
            "SELECT * FROM bank",
            "SELECT HomeAddress FROM branch WHERE BankID = 1",
            "SELECT LoanID FROM loan WHERE LoanTYPE = 'LWINT'",
            "SELECT TransactionDate FROM transaction",
        );
        
        /* The following lines of code parse and execute each line in query array, and it inserts the data into an HTML table.*/
        for($i = 0; $i < count($queryArr); $i++){
            $stid = oci_parse($conn, $queryArr[$i]);
            if(!$stid) {
                $e = oci_error($conn);
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            }

            $r = oci_execute($stid);
            if (!$r) {
                $e = oci_error($stid);
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            }

            echo "<h3 id=\"main\">" . $queryTitle[$i] . "</h3>";
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