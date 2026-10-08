<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check that the form was submitted using POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid request.");
}

// Get form values safely
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$website = $_POST['website'] ?? '';
$comment = $_POST['comment'] ?? '';
$gender = $_POST['gender'] ?? '';

// Database configuration
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "FCT";

// Create database connection
$conn = mysqli_connect(
    $servername,
    $username,
    $password,
    $dbname
);

// Check connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Prepared SQL query
$sql = "INSERT INTO users 
        (name, email, website, comment, gender)
        VALUES (?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("SQL preparation failed: " . mysqli_error($conn));
}

// Bind values
mysqli_stmt_bind_param(
    $stmt,
    "sssss",
    $name,
    $email,
    $website,
    $comment,
    $gender
);

// Execute query
$success = mysqli_stmt_execute($stmt);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Registration Result</title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .result-card {
            width: 100%;
            max-width: 550px;
            background: white;
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .success {
            text-align: center;
            color: #198754;
            margin-bottom: 20px;
        }

        .error {
            text-align: center;
            color: #dc3545;
            margin-bottom: 20px;
        }

        .result-card h3 {
            color: #333;
            margin-bottom: 15px;
        }

        .info-list {
            list-style: none;
        }

        .info-list li {
            padding: 12px;
            margin-bottom: 8px;
            background: #f6f7fb;
            border-radius: 8px;
            color: #444;
            word-break: break-word;
        }

        .info-list strong {
            color: #222;
        }

        .back-btn {
            display: block;
            text-align: center;
            margin-top: 25px;
            padding: 13px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            text-decoration: none;
            border-radius: 9px;
            font-weight: bold;
            transition: 0.3s;
        }

        .back-btn:hover {
            transform: translateY(-2px);
        }

        @media (max-width: 500px) {

            .result-card {
                padding: 25px 18px;
            }

        }

    </style>

</head>

<body>

<div class="result-card">

<?php

if ($success) {

    echo "<h2 class='success'>✅ Registration Successful!</h2>";

    echo "<h3>Submitted Information</h3>";

    echo "<ul class='info-list'>";

    echo "<li>
            <strong>Name:</strong> "
            . htmlspecialchars($name) .
          "</li>";

    echo "<li>
            <strong>Email:</strong> "
            . htmlspecialchars($email) .
          "</li>";

    echo "<li>
            <strong>Website:</strong> "
            . htmlspecialchars($website) .
          "</li>";

    echo "<li>
            <strong>Comment:</strong> "
            . htmlspecialchars($comment) .
          "</li>";

    echo "<li>
            <strong>Gender:</strong> "
            . htmlspecialchars($gender) .
          "</li>";

    echo "</ul>";

} else {

    echo "<h2 class='error'>❌ Registration Failed</h2>";

    echo "<p>" .
         htmlspecialchars(mysqli_stmt_error($stmt)) .
         "</p>";
}

?>

<a href="index.html" class="back-btn">
    ← Back to Registration
</a>

</div>

</body>
</html>

<?php

// Close statement and connection
mysqli_stmt_close($stmt);
mysqli_close($conn);

?>
