<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('https://source.unsplash.com/random/1600x900');
            background-repeat: no-repeat;
            background-position: center center;
            background-attachment: fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            position: relative;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .posts-container {
            max-width: 1200px;
            margin: 60px auto;
            padding: 30px;
            border-radius: 15px;
            background-color: rgba(255, 255, 255, 0.95);
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            position: relative;
            z-index: 2;
            overflow: hidden;
        }

        .posts-container h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 0;
            margin: 0;
            list-style-type: none;
        }

        .grid-item {
            padding: 20px;
            border-radius: 10px;
            background-color: #ffffff;
            box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .grid-item:hover {
            transform: translateY(-5px);
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
        }

        .grid-item a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            font-size: 1.1em;
            margin-bottom: 10px;
            flex-grow: 1;
        }

        .grid-item a:hover {
            text-decoration: underline;
            color: #007bff;
        }

        .logout-button {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #ff5252;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px 18px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            font-size: 1em;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .logout-button:hover {
            background-color: #ff2d2d;
            transform: translateY(-2px);
        }

        .logout-button:active {
            background-color: #e01d1d;
        }

        @media (max-width: 768px) {
            .posts-container {
                margin: 20px;
                padding: 20px;
            }

            .posts-container h1 {
                font-size: 2em;
            }

            .logout-button {
                top: 10px;
                right: 10px;
                padding: 10px 14px;
            }
        }
    </style>
</head>
<body>
    <div class="overlay"></div>
    <div class="posts-container">
        <h1>Your Posts</h1>
        <button class="logout-button" onclick="window.location.href='logout.php'">Logout</button>
        <ul class="grid-container" id="postLists">
            <?php
            require 'config.php';

            if (!isset($_SESSION['user_id'])) {
                header("Location: index.php");
                exit;
            }

            $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
            $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

            try {
                $pdo = new PDO($dsn, $user, $password, $options);

                if ($pdo) {
                    $user_id = $_SESSION['user_id'];

                    $query = "SELECT * FROM `posts` WHERE user_id = :id";
                    $statement = $pdo->prepare($query);
                    $statement->execute([':id' => $user_id]);

                    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($rows as $row) {
                        echo '<li class="grid-item"><a href="post.php?id=' . $row['id'] . '">' . $row['title'] . '</a></li>';
                    }
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            ?>
        </ul>
    </div>
</body>
</html>
