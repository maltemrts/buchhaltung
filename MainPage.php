<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CashFlowCraft</title>
    <link rel="stylesheet" href="MainPageStyle.css"> <!-- Verlinke deine CSS-Datei hier -->
    <script src="scripts.js"></script> <!-- Verlinke deine JavaScript-Datei hier -->
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>
<body>
    
<header>
        <ul>
            <li><h1>CashFlowCraft</h1></li>
            <li><button class="LogOutButton">Log Out</button></li>
        </ul>
</header>

<main>

    <ul class="bookingList">

        <li><h3 class="greet">Wilkommen, Malte</h3></li>

        <li class="bookingEntry bookingButton">
        <button class="incomeButton">Neue Einnahme</button>
        <button class="expenseButton">Neue Ausgabe</button>
        </li>

        <li class="bookingEntry">
            <h1 class="balance">Balance: 1234€</h1>
        </li>

        <li class="bookingEntry typeDec">
            <div class="EntryNode bookingPrice">Betrag:</div>
            <div class="EntryNode bookingType">Art:</div>
            <div class="EntryNode date">Datum:</div>    
        </li>

        <li class="bookingEntry">
        <div class="EntryNode bookingPrice">-1234€</div>
            <div class="EntryNode bookingType">Miete</div>
            <div class="EntryNode date">12.11.23</div>    
        </li>

        <li class="bookingEntry">
        <div class="EntryNode bookingPrice">-1234€</div>
            <div class="EntryNode bookingType">Miete</div>
            <div class="EntryNode date">12.11.23</div>    
        </li>
        <li class="bookingEntry">
        <div class="EntryNode bookingPrice">-1234€</div>
            <div class="EntryNode bookingType">Miete</div>
            <div class="EntryNode date">12.11.23</div>    
        </li>
        <li class="bookingEntry">
        <div class="EntryNode bookingPrice">-1234€</div>
            <div class="EntryNode bookingType">Miete</div>
            <div class="EntryNode date">12.11.23</div>    
        </li>
        
    </ul>
</main>
    <footer>
        <p>Impressum</p>
        <p1>Kontakt: <a href="mailto:hege@example.com">cashflowcraft@example.com</a></p1>
    </footer>

</body>
</html>