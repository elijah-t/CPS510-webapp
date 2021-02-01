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
    <?php
        /* Bank Data */
        $bank = array(
            "BANK",
            array(1, '\'CIBC\''),
            array(2, '\'Toronto Dominion\''),
            array(3, '\'RBC\''),
            array(4, '\'HSBC\''),
            array(5, '\'BMO\'')
        );

        /* Branch Data */
        $branch = array(
            "BRANCH",
            array(1001, '\'111 Main St.\'', 2),
            array(1002, '\'421 Sheppard St.\'', 1),
            array(1003, '\'6654 Yonge St.\'', 4),
            array(1004, '\'312 Yonge St.\'', 3),
            array(1005, '\'631 Steeles Ave.\'', 1),
            array(1006, '\'69420 Garant Cres.\'', 5),
            array(1007, '\'6542 Markham Rd.\'', 3),
            array(1008, '\'1 First St.\'', 1),
            array(1009, '\'2 Second St.\'', 1)
        );

        /* Consumer Data */
        $consumer = array(
            "CONSUMER",
            array(1, '\'John Smith\'', '\'6479934421\'', '\'36 Little Yachty Dr.\'', 1003),
            array(2, '\'Jane Doe\'', '\'9056632314\'', '\'44 Artillery Dr.\'', 1001),
            array(3, '\'Jacob Brown\'', '\'9058123331\'', '\'3123 Middlefield Rd.\'', 1009),
            array(4, '\'Diana Frunk\'', '\'6475512224\'', '\'4432 Yonge St.\'', 1001),
            array(5, '\'Dennis Den\'', '\'6471112341\'', '\'312 McNicoll Ave.\'', 1004),
            array(6, '\'Richard Mills\'', '\'4164417732\'', '\'8831 McNicoll Ave.\'', 1002),
            array(7, '\'Johnathan Foy\'', '\'9055524521\'', '\'123 Silver Star Blvd.\'', 1008),
            array(8, '\'Jason Trell\'', '\'4164424444\'', '\'124 Silver Star Cres.\'', 1006),
            array(9, '\'Daniel Garona\'', '\'6471842351\'', '\'111 Silver Spoon Dr.\'', 1007)
        );

        /* Bank Account Data */
        $bankAccount = array(
            "BANKACCOUNT",
            array(10001, 3, '\'SAV\'', 5, 1001),
            array(10002, 1, '\'CHQ\'', 10023, 1004),
            array(10003, 2, '\'CHQ\'', 1004, 1009),
            array(10004, 6, '\'SAV\'', 103, 1002),
            array(10005, 9, '\'SAV\'', 442, 1001),
            array(10006, 1, '\'CHQ\'', 112, 1007),
            array(10007, 5, '\'SAV\'', 23124, 1008),
            array(10008, 7, '\'SAV\'', 11412, 1005),
            array(10009, 1, '\'CHQ\'', 13132, 1001)
        );

        /* Transaction Data */
        $transaction = array(
            "TRANSACTION",
            array(4441, '\'WTHDWL\'', 'to_date(\'01-JAN-19\', \'DD-MON-RR\')', 10001),
            array(4442, '\'DPST\'', 'to_date(\'05-JAN-19\', \'DD-MON-RR\')', 10008),
            array(4443, '\'SENT\'', 'to_date(\'25-FEB-19\', \'DD-MON-RR\')', 10006),
            array(4444, '\'RECV\'', 'to_date(\'31-OCT-19\', \'DD-MON-RR\')', 10004),
            array(4445, '\'DPST\'', 'to_date(\'21-DEC-19\', \'DD-MON-RR\')', 10002),
            array(4446, '\'DPST\'', 'to_date(\'12-JAN-20\', \'DD-MON-RR\')', 10001),
            array(4447, '\'SENT\'', 'to_date(\'24-MAR-20\', \'DD-MON-RR\')', 10007),
            array(4448, '\'RECV\'', 'to_date(\'07-APR-20\', \'DD-MON-RR\')', 10001),
            array(4449, '\'WTHDWL\'', 'to_date(\'08-AUG-20\', \'DD-MON-RR\')', 10009)
        );

        /* Loan Data */
        $loan = array(
            "LOAN",
            array(2221, 3215, '\'HGINT\'', 1005, 1),
            array(2222, 22314, '\'LWINT\'', 1009, 4),
            array(2223, 4444, '\'LWINT\'', 1006, 2),
            array(2224, 4421, '\'LWINT\'', 1008, 5),
            array(2225, 999999, '\'HGINT\'', 1001, 6),
            array(2226, 8821, '\'LWINT\'', 1003, 9),
            array(2227, 100000, '\'HGINT\'', 1001, 8),
            array(2228, 10000000, '\'HGINT\'', 1004, 7),
            array(2229, 448212, '\'HGINT\'', 1002, 1),
        );

        /* Parse Array function
           This function connects to the database, and inserts the data arrays into their respective tables.
        */
        function parseArray(array $arr){
            $conn = oci_connect('etungul', '06295285', '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(Host=oracle.scs.ryerson.ca)(Port=1521))(CONNECT_DATA=(SID=orcl)))');
        
            if(!$conn) {
                $e = oci_error();
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            }    

            for($i = 1; $i<count($arr); $i++){
                $str = "INSERT INTO " . $arr[0] . " VALUES(";
                for($j = 0; $j<count($arr[$i]); $j++){
                    if($j == count($arr[$i])-1){
                        $str .= $arr[$i][$j] . ")";
                        break;
                    }
                $str .= $arr[$i][$j] . ", ";
                }
                $stid = oci_parse($conn, $str);
                oci_execute($stid);
                oci_free_statement($stid);
            }

            oci_close($conn);
        }

        parseArray($bank);
        parseArray($branch);
        parseArray($consumer);
        parseArray($bankAccount);
        parseArray($transaction);
        parseArray($loan);

    ?>
    <div>
        <p id="main">Tables populated.</p>
        <form action=http://www2.cs.ryerson.ca/~etungul/ribs/menu.php />
            <input type="submit" value="Back to Menu" />
        </form>
    </div>

    </body>
</html>