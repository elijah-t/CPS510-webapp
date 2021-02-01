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

            /* Create Bank Table */
            $bank = "CREATE TABLE bank (
                BankID NUMBER PRIMARY KEY,
                BankName VARCHAR2(30) 
                )";

            $stid = oci_parse($conn, $bank);
            oci_execute($stid);
            oci_free_statement($stid);

            /* Create Branch Table */
            $branch = "CREATE TABLE branch (
                TransitID NUMBER PRIMARY KEY,
                HomeAddress VARCHAR2(30),
                BankID NUMBER NOT NULL,
                CONSTRAINT FK_bankID
                    FOREIGN KEY (BankID)
                    REFERENCES bank(BankID)
                )";

            $stid = oci_parse($conn, $branch);
            oci_execute($stid);
            oci_free_statement($stid);
            
            /* Create Consumer Table */
            $consumer = "CREATE TABLE consumer (
                ConsumerID NUMBER PRIMARY KEY,
                Name VARCHAR2(30),
                PhoneNumber VARCHAR2(10),
                Address VARCHAR2(30),
                UsesBranch NUMBER NOT NULL,
                CONSTRAINT FK_Bank
                    FOREIGN KEY (UsesBranch)
                    REFERENCES branch(TransitID)
                )";

            $stid = oci_parse($conn, $consumer);
            oci_execute($stid);
            oci_free_statement($stid);
            
            /* Create Bank Account Table */
            $bankAccount = "CREATE TABLE bankAccount (
                AccountNumber NUMBER PRIMARY KEY,
                AccountOwner NUMBER NOT NULL,
                AccountType VARCHAR2(10),
                AccountBalance NUMBER,
                AccountBelongsTo NUMBER NOT NULL,
                CONSTRAINT FK_AccountOwner
                    FOREIGN KEY (AccountOwner)
                    REFERENCES consumer(ConsumerID),
                CONSTRAINT FK_AccountBelongsTo
                    FOREIGN KEY (AccountBelongsTo)
                    REFERENCES branch(TransitID)
                )";

            $stid = oci_parse($conn, $bankAccount);
            oci_execute($stid);
            oci_free_statement($stid);
            
            /* Create Transaction Table */
            $transaction = "CREATE TABLE transaction (
                TransactionID NUMBER PRIMARY KEY,
                TransactionType VARCHAR2(10),
                TransactionDate DATE,
                AccountUsed NUMBER NOT NULL,
                CONSTRAINT FK_AccountUsed
                    FOREIGN KEY (AccountUsed)
                    REFERENCES bankAccount(AccountNumber)
                )";

            $stid = oci_parse($conn, $transaction);
            oci_execute($stid);
            oci_free_statement($stid);
            
            /* Create Loan Table */
            $loan = "CREATE TABLE loan (
                LoanID NUMBER PRIMARY KEY,
                LoanAmount NUMBER,
                LoanType VARCHAR2(10),
                LoanOwner NUMBER NOT NULL,
                LoanBelongsTo NUMBER NOT NULL,
                CONSTRAINT FK_LoanOwner
                    FOREIGN KEY (LoanOwner)
                    REFERENCES branch(TransitID),
                CONSTRAINT FK_LoanBelongsTo
                    FOREIGN KEY (LoanBelongsTo)
                    REFERENCES consumer(ConsumerID)
                )";

            $stid = oci_parse($conn, $loan);
            oci_execute($stid);
            oci_free_statement($stid);            

            oci_close($conn);
        ?>
        <p id="main">Tables created.</p>
        <form action=http://www2.cs.ryerson.ca/~etungul/ribs/menu.php />
            <input type="submit" value="Back to Menu" />
        </form>
    </div>

    </body>
</html>