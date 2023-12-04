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
    header("Location: http://localhost/buchhaltung/HomePage.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["ledger_Id"])) {
    $user_id = $_SESSION['user_id'];
    $ledger_id = $_GET["ledger_Id"];

    // Delete ledger entry
    $delete_query = "DELETE FROM \"dt_Ledger\" WHERE \"Ledger_UserId\" = $1 AND \"Ledger_Id\" = $2";
    $delete_result = pg_query_params($conn, $delete_query, array($user_id, $ledger_id));

    if ($delete_result === false) {
        die("Delete query failed: " . pg_last_error());
    }

    // Redirect back to the ledger page
    header("Location: http://localhost/buchhaltung/MainPage.php");
    exit();
} else {
    // Handle invalid requests or direct access to the script
    header("Location: http://localhost/buchhaltung/HomePage.php");
    exit();
}
?>