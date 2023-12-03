<?php
// Database connection parameters
$host = "localhost";
$port = "5432";
$dbname = "your_database_name";
$user = "your_username";
$password = "your_password";

// Connect to PostgreSQL
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

session_start();

if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: http://localhost/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user-specific ledger data
$query = "SELECT * FROM \"dt_Ledger\" WHERE \"Ledger_UserId\" = $1";
$result = pg_query_params($conn, $query, array($user_id));

if ($result === false) {
    die("Query failed: " . pg_last_error());
}

// Display user-specific ledger data
echo "<h2>Ledger Data for User ID: $user_id</h2>";

echo "<table border='1'>
        <tr>
            <th>Ledger ID</th>
            <th>Balance</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Comment</th>
            <th>Action</th>
        </tr>";

while ($row = pg_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>{$row['Ledger_Id']}</td>";
    echo "<td>{$row['Ledger_Balance']}</td>";
    echo "<td>{$row['Ledger_CreatedAt']}</td>";
    echo "<td>{$row['Ledger_UpdatedAt']}</td>";
    echo "<td>{$row['Ledger_Comment']}</td>";
    echo "<td><a href='edit_ledger.php?ledger_Id={$row['Ledger_Id']}'>Edit</a></td>";
    echo "</tr>";
}

echo "</table>";

// Form for adding new ledger entry
echo "<h3>Add New Ledger Entry</h3>";
echo "<form method='post'>
        Balance: <input type='text' name='balance' required><br>
        Comment: <input type='text' name='comment'><br>
        <input type='submit' name='add_entry' value='Add Entry'>
      </form>";

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
    
        // Redirect back to the AfterLogin page
        header("Location: http://localhost/buchhaltung/ledger_test.php");
        exit();
    }

    // Function to sanitize user input
function sanitize_input($data) {
    return htmlspecialchars(trim($data));
}

// Handle edit form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit_entry"])) {
    $edited_balance = sanitize_input($_POST["edited_balance"]);
    $edited_comment = sanitize_input($_POST["edited_comment"]);
    $edited_ledger_id = sanitize_input($_POST["edited_ledger_id"]);

    // Update the ledger entry
    $update_query = "UPDATE \"dt_Ledger\" SET 
                    \"Ledger_Balance\" = $1,
                    \"Ledger_Comment\" = $2,
                    \"Ledger_UpdatedAt\" = NOW()
                    WHERE \"Ledger_Id\" = $3 AND \"Ledger_UserId\" = $4";

    $update_result = pg_query_params($conn, $update_query, array($edited_balance, $edited_comment, $edited_ledger_id, $user_id));

    if ($update_result === false) {
        die("Update query failed: " . pg_last_error());
    }
    header("Location: http://localhost/AfterLogin.phtml");
    exit();
}
?>