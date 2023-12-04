<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CashFlowCraft</title>
    <link rel="stylesheet" href="MainPageStyle.css"> <!-- Verlinke deine CSS-Datei hier -->
    <script src="scriptsMainPage.js"> </script>
    <!-- <script src="scripts.js"></script>  Verlinke deine JavaScript-Datei hier -->
    <link rel="icon" href="logo.ico" type="image/x-icon">
    <link rel="shortcut icon" href="logo.ico" type="image/x-icon">

    <?php
        // Database connection parameters
        $host = "localhost";
        $port = "5432";
        $dbname = "postgres";
        $user = "postgres";
        $password = "your_password";

        // Connect to PostgreSQL
        $conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

        session_start();

        if (!isset($_SESSION['user_id'])) {
            // Redirect to the login page if the user is not logged in
            header("Location: http://localhost/buchhaltung/Homepage.php");
            exit();
        }

        $user_id = $_SESSION['user_id'];
        $user_name = $_SESSION['username'];

        // Fetch user-specific ledger data
        $query = "SELECT * FROM \"dt_Ledger\" WHERE \"Ledger_UserId\" = $1";
        $result = pg_query_params($conn, $query, array($user_id));

        if ($result === false) {
            die("Query failed: " . pg_last_error());
        }
    ?>

</head>
<body>
    
<header class="logo">
    <form method="post">
        <ul>
            <li class="icon"><h1>CashFlowCraft</h1>
                <img src="logo.png" alt=“logo“ height="50" width="50">
            </li>
            <li><button class="LogOutButton" name="logout">Log Out</button></li>
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["logout"])) {
                    pg_close($conn);
                    session_unset();
                    session_destroy();
                    header("Location: http://localhost/buchhaltung/Homepage.php");
                    exit();
                }
            ?>
        </ul>
    </form>
        
</header>

<main>

<ul class="bookingList">

    <!-- Display user greeting -->
    <?php
    echo "<li><h3 class=\"greet\">Willkommen, $user_name</h3></li>";
    ?>

    <!-- Modify the button to open the modal -->
    <li class="bookingEntry bookingButton">
    <button class="incomeButton" onclick="openPopup('newEntryModal')">Neue Buchung</button>
</li>

<!-- Das Popup-Formular -->
<div id="newEntryModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <form method="post">
            Balance: <input type="text" name="balance" required><br>
            Comment: <input type="text" name="comment"><br>
            <input type="submit" name="add_entry" value="Add Entry">
        </form>
    </div>
</div>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_entry"])) {
            $user_id = $_SESSION['user_id'];
            $balance = sanitize_input($_POST["balance"]);
            $comment = sanitize_input($_POST["comment"]);

            // Insert new ledger entry
            $insert_query = "INSERT INTO \"dt_Ledger\" (\"Ledger_UserId\", \"Ledger_Balance\", \"Ledger_Comment\", \"Ledger_CreatedAt\", \"Ledger_UpdatedAt\")
                            VALUES ($1, CAST($2 AS bigint), $3, NOW(), NOW())";

            $insert_result = pg_query_params($conn, $insert_query, array($user_id, $balance, $comment));

            if ($insert_result === false) {
                die("Insert query failed: " . pg_last_error());
            }

            // Redirect back to the ledger_test page
            header("Location: http://localhost/buchhaltung/Mainpage.php");
            exit();
        }
        
        // Function to sanitize user input
    function sanitize_input($data) {
    return htmlspecialchars(trim($data));
    }

    ?>

    <!-- Display user balance -->
    <?php
    // Calculate user balance based on ledger entries
   // $balanceQuery = "SELECT SUM(\"Ledger_Balance\") AS total_balance FROM \"dt_Ledger\" WHERE \"Ledger_UserId\" = $1";
    $balanceQuery = "SELECT COALESCE(SUM(\"Ledger_Balance\"), 0) AS total_balance FROM \"dt_Ledger\" WHERE \"Ledger_UserId\" = $1";

    $balanceResult = pg_query_params($conn, $balanceQuery, array($user_id));

    if ($balanceResult === false) {
        die("Balance query failed: " . pg_last_error());
    }

    $balanceRow = pg_fetch_assoc($balanceResult);
    $totalBalance = $balanceRow['total_balance'];
    ?>

    <li class="bookingEntry">
        <h1 class="balance">Balance: <?= number_format($totalBalance, 2) ?>€</h1>
    </li>

    <!-- Display column headers -->
    <li class="bookingEntry typeDec">
        <div class="EntryNode bookingPrice">Betrag:</div>
        <div class="EntryNode bookingType">Art:</div>
        <div class="EntryNode date">Datum:</div>
        <div class="EntryNode bookingType">Aktion:</div>
    </li>

    <!-- Display ledger entries -->
    <?php
        echo "<ul class='bookingList'>"; // Start of the list container

        // Assuming $connection is your PostgreSQL database connection
        $query = "SELECT * FROM \"dt_Ledger\" WHERE \"Ledger_UserId\" = $1 ORDER BY \"Ledger_Id\" DESC";
        $result = pg_query_params($conn, $query, array($user_id));

        while ($row = pg_fetch_assoc($result)) {
            echo "<li class='bookingEntry'>";
            echo "<div class='EntryNode bookingPrice'>" . number_format($row['Ledger_Balance'], 2) . "€</div>";
            echo "<div class='EntryNode bookingType'>{$row['Ledger_Comment']}</div>";
            echo "<div class='EntryNode date'>{$row['Ledger_CreatedAt']}</div>";
            echo "<a class='EntryNode editLink' href='edit_ledger.php?ledger_Id={$row['Ledger_Id']}'>Edit</a>";
            echo "</li>";
        }

        echo "</ul>"; // End of the list container
    ?>

</ul>
</main>

<footer>

        <p>Impressum</p>
        <p1>Kontakt: <a href="mailto:hege@example.com">cashflowcraft@example.com</a></p1>
    </footer>

</body>
</html>
