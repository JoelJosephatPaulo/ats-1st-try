<?php
// Save new quotes
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_quote'])) {
    $newQuote = trim($_POST['new_quote']);
    if ($newQuote !== '') {
        file_put_contents("quotes.txt", $newQuote . PHP_EOL, FILE_APPEND);
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Get all quotes
$quotes = file_exists("quotes.txt")
    ? file("quotes.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)
    : [
        "Believe you can and you're halfway there.",
        "Push yourself, because no one else is going to do it for you.",
        "Success doesn’t just find you. You have to go out and get it.",
    ];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Awesome Quote Generator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #eef;
            text-align: center;
            padding-top: 60px;
        }
        .quote-box {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            width: 50%;
            margin: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }
        button, input[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 8px;
            border: none;
            background: #0066cc;
            color: white;
            cursor: pointer;
        }
        input[type="text"] {
            padding: 8px;
            width: 60%;
            margin-top: 20px;
        }
    </style>
    <script>
        function loadQuote() {
            fetch("quotes.php?ajax=1")
                .then(response => response.text())
                .then(data => {
                    document.getElementById("quote").innerText = data;
                });
        }
    </script>
</head>
<body>

<div class="quote-box">
    <h1>💬 Quote of the Moment</h1>
    <p id="quote">
        <?php echo $quotes[array_rand($quotes)]; ?>
    </p>
    <button onclick="loadQuote()">New Quote 🔁</button>

    <form method="POST" style="margin-top: 30px;">
        <h3>Add Your Own Quote</h3>
        <input type="text" name="new_quote" placeholder="Type your quote here" required>
        <br><br>
        <input type="submit" value="Add Quote ➕">
    </form>
</div>

<?php
// AJAX handler for random quote only
if (isset($_GET['ajax']) && $_GET['ajax'] == 1) {
    echo $quotes[array_rand($quotes)];
    exit;
}
?>

</body>
</html>
