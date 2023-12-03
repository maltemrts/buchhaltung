<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CashFlowCraft</title>
    <link rel="stylesheet" href="styles.css"> <!-- Verlinke deine CSS-Datei hier -->
    <script src="scripts.js"></script> <!-- Verlinke deine JavaScript-Datei hier -->
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <?php
            // Database connection parameters
            $host = "localhost";
            $port = "5432";
            $dbname = "postgres";
            $user = "postgres";
            $password = "your_password";
    
            // Connect to PostgreSQL
            $conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
    ?>
</head>
<body>

    <header>
        <h1>CashFlowCraft</h1>
        <div class="logo"><img height="100px" width="100px" src="/buchhaltung/favicon.v4.png" alt="Ihr Logo"></div>
    </header>
    <main>
    <section class="button-container"> 
            <h2>Willkommen bei CashFlowCraft: Deiner Plattform für einfache und effiziente Buchführung!</h2>
           
            <div class="loginbutton"> <button onclick="openPopup('login')">Einloggen</button></div>
            <div class="registerbutton"><button onclick="openPopup('register')">Registrieren</button></div>
        
        </section> 
    </main>
    <div class="popup-windows-container">
        <span onclick="closePopup()" style="cursor: pointer; float: right;">X</span>
        <div id="loginForm" style="display: none;">
            <h3>Einloggen</h3>
            <form method="post" action="">
                Benutzername/E-Mail: <br><input type="text" name="username_or_email" required><br>
                Passwort: <br><input type="password" name="password" required><br>
                <input type="submit" name="login" value="Login">
                <div class="button-right"><button type="button" onclick="redirectToRegistration()">zur Registrierung</button></div>
            </form>
            <?php
            if (!$conn) {
                die("Connection failed: " . pg_last_error());
            }
    
            // Function to sanitize user input
            function sanitize_input($data) {
                return htmlspecialchars(trim($data));
            }
    
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
                $username_or_email = sanitize_input($_POST["username_or_email"]);
                $password = sanitize_input($_POST["password"]);
    
                // Perform the login logic
                // Use parameterized queries to prevent SQL injection
                $query = "SELECT * FROM \"dt_UserData\" WHERE (\"User_Username\" = $1 OR \"User_Email\" = $1) AND \"User_Password\" = $2";
                $result = pg_query_params($conn, $query, array($username_or_email, $password));
    
                if ($result === false) {
                    die("Query failed: " . pg_last_error());
                }
                
                if ($row = pg_fetch_assoc($result)) {
                    // Authentication successful
                    // Store user information in session for future use
                    session_start();
                    $_SESSION['user_id'] = $row['User_Id'];
                    $_SESSION['username'] = $row['User_Username'];
    
                    // Redirect to the after-login page
                    header("Location: http://localhost/buchhaltung/MainPage.php");
                    exit(); // Ensure that no further code is executed after the redirect
                } else {
                    // Authentication failed
                    echo "<p style='color: red;'>Login gescheitert. Benutername oder Passwort falsch.</p>";
                }
            }
            ?>
        </div>
        <div id="registerForm" style="display: none;">
            <h3 style="font-size: 25px;">Registrierung</h3>
            <form method="post" action="">
                Benutzername: <br><input type="text" name="username" required><br>
                E-Mail: <br><input type="text" name="email" required><br>
                Vorname: <br><input type="text" name="firstname" required><br>
                Nachname: <br><input type="text" name="lastname" required><br>
                Passwort: <br><input type="password" name="password" required><br>
                <input type="submit" name="register" value="Registrieren">  
                <div class="button-right">
                    <button type="button" onclick="redirectToLogin()">zum Login</button>
                </div>
            </form>
            <?php
                if (!$conn) {
                    die("Connection failed: " . pg_last_error());
                }

                if (isset($_POST['register'])) {
                    $email = $_POST['email'];
                    $username = $_POST['username'];
                    $firstname = $_POST['firstname'];
                    $lastname = $_POST['lastname'];
                    $password = $_POST['password'];

                    // Check if username or email is already taken
                    $checkQuery = "SELECT * FROM \"dt_UserData\" WHERE \"User_Username\" = $1 OR \"User_Email\" = $2";
                    $checkResult = pg_query_params($conn, $checkQuery, array($username, $email));

                    if (!$checkResult) {
                        die("Error in SQL query: " . pg_last_error());
                    }

                    if (pg_num_rows($checkResult) > 0) {
                        // Username or email is already taken
                        echo "Benutzername oder E-Mail ist schon vergeben, bitte wähle eine andere.";
                    } else {
                        // Perform registration logic
                        $insertQuery = "INSERT INTO \"dt_UserData\" (\"User_Email\", \"User_Username\", \"User_Firstname\", \"User_Lastname\", \"User_Password\", \"User_RegistrationDate\") VALUES ($1, $2, $3, $4, $5, CURRENT_TIMESTAMP)";
                        $insertResult = pg_query_params($conn, $insertQuery, array($email, $username, $firstname, $lastname, $password));

                        if (!$insertResult) {
                            die("Error in SQL query: " . pg_last_error());
                        }

                        echo "Erfolgreich registriert";
                    }

                    pg_close($conn);
                } else {
                    echo "Form nicht eingereicht!";
                }
            ?>
        </div>
    </div>

    <footer>
        <p>Impressum</p>
        <p1>Kontakt: <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ&pp=ygUXbmV2ZXIgZ29ubmEgZ2l2ZSB5b3UgdXA%3D">cashflowcraft@example.com</a></p1>
    </footer>

</body>
</html>
