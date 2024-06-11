<?php

require 'config.php';

$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
    $pdo = new PDO($dsn, $user, $password, $options);

    if ($pdo) {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $query = "SELECT * FROM `users` WHERE username = :username";
            $statement = $pdo->prepare($query);
            $statement->execute([':username' => $username]);

            $user = $statement->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if ('secret123' === $password) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];

                    header("Location: posts.php");
                    exit;
                } else {
                    echo "Invalid password!";
                }
            } else {
                echo "User not found!";
            }
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('https://source.unsplash.com/random/1600x900');
            background-repeat: no-repeat;
            background-position: center center;
            background-attachment: fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 3px solid black;
            border-radius: 6px;
            background-color: rgba(255, 255, 255, 0.8);
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        input[type="text"], input[type="password"], button {
            display: block;
            margin-bottom: 15px;
            border-radius: 6px;
            border: 1px solid black;
            padding: 10px;
            font-size: 16px;
            width: 90%;
        }

        input[type="text"]:focus, input[type="password"]:focus {
            outline: none;
            box-shadow: 0px 0px 2px 1px #007bff;
            
        }

        button {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            text-align: center;
        }

        button:hover {
            background-color: blue;
            color: black;
            border: 1px solid black;
            text-align: center;
        }

        h2 {
            text-align: center;
            margin-bottom: 50px;
            color: black;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Sign Up</h2>
        <form id="loginForm" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <input type="text" name = "username" id="username" placeholder="Enter username" required>
            <input type="password" name = "password" id="password" placeholder="Enter password" required>
            <button id="submit">Login</button>
        </form>
    </div>
</body>
</html>