<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CashFlowCraft</title>
    <link rel="stylesheet" href="styles.css"> <!-- Verlinke deine CSS-Datei hier -->
    <script src="scripts.js"></script> <!-- Verlinke deine JavaScript-Datei hier -->
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>
<body>

    <header>
        <h1>CashFlowCraft</h1>
    </header>
    <!-- <nav> </nav> -->
    <main>
        <h2>Herzlich Wilkommen auf CashFlowCraft</h2>
            <div class="button-container">
                <button onclick="openPopup('login')">Einloggen</button><br>
                <button onclick="openPopup('register')">Registrieren</button>
        </div>
        <div class="article-container content-grid">
            <article>
                Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.<br>
    
                Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<br>
    
                Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.<br>
    
                Nam liber tempor cum soluta nobis eleifend ion congue nihil imperdiet doming id quod mazim placerat facer possim assum. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.
            </article>
    </main>
    
    <div class="popup-windows-container">
        <span onclick="closePopup()" style="cursor: pointer; float: right;">X</span>
    
        <div id="loginForm" style="display: none;">
            <h2>Einloggen</h2>
            <form method="post" action="">
                Benutzername/E-Mail: <br><input type="text" name="username_or_email" required><br>
                Passwort: <br><input type="password" name="password" required><br>
                <input type="submit" name="login" value="Login">
                <div class="button-right"><button type="button" onclick="redirectToRegistration()">zur Registrierung</button></div>
            </form>
            <?php
            // Database connection parameters
            $host = "localhost";
            $port = "5432";
            $dbname = "your_database_name";
            $user = "your_username";
            $password = "your_password";
    
            // Connect to PostgreSQL
            $conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
    
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
                $query = "SELECT * FROM users WHERE (username = $1) AND password = $2";
                $result = pg_query_params($conn, $query, array($username_or_email, $password));
    
                if ($row = pg_fetch_assoc($result)) {
                    // Authentication successful
                    echo "<p style='color: green;'>Login successful. Welcome, {$row['username']}!</p>";
                } else {
                    // Authentication failed
                    echo "<p style='color: red;'>Login failed. Please check your credentials.</p>";
                }
            }
            ?>
        </div>
        <div id="registerForm" style="display: none;">
            <!-- Registrierungsformular hier -->
            <h2>Registrierung</h2>
        </div>
    </div>



    <footer>
        <p>Impressum</p>
        <p1>Kontakt: <a href="mailto:hege@example.com">cashflowcraft@example.com</a></p1>
    </footer>

</body>
</html>
