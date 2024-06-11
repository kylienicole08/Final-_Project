<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Page - View Your Posts</title>
    <meta name="description" content="View the details of your posts in a visually appealing and user-friendly layout.">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-image: url('https://source.unsplash.com/random/1600x900?landscape,nature');
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
            color: #333;
        }

        .post-container {
            max-width: 600px;
            margin: 20px;
            padding: 30px;
            border: none;
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
            backdrop-filter: blur(10px);
        }

        h1, h3 {
            color: #007bff;
        }

        h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
        }

        h3 {
            font-size: 1.8em;
            margin-bottom: 10px;
        }

        p {
            font-size: 1.2em;
            line-height: 1.6em;
            margin-bottom: 20px;
        }

        ul {
            list-style-type: none;
            padding: 0;
            width: 100%;
        }

        li {
            margin-bottom: 10px;
            padding: 15px;
            border-radius: 10px;
            background-color: #f9f9ff;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        li:hover {
            background-color: #e0e0ff;
            transform: translateY(-2px);
        }

        .back-button {
            display: inline-block;
            margin-top: 20px;
            background-color: #007bff;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            font-size: 1em;
            transition: all 0.3s ease;
        }

        .back-button:hover {
            background-color: #0056b3;
            color: #fff;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="post-container">
        <h1>Post Page</h1>
        <div id="postDetails">
            <?php
            require 'config.php';
            
            // Start session to check user authentication
            // session_start();

            // if (!isset($_SESSION['user_id'])) {
            //     header("Location: index.php");
            //     exit;
            // }

            // Set up the database connection using PDO
            $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
            $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

            try {
                $pdo = new PDO($dsn, $user, $password, $options);

                if ($pdo) {
                    if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
                        $id = intval($_GET['id']);

                        // Query the post details
                        $query = "SELECT * FROM `posts` WHERE id = :id";
                        $statement = $pdo->prepare($query);
                        $statement->execute([':id' => $id]);

                        $post = $statement->fetch(PDO::FETCH_ASSOC);

                        if ($post) {
                            echo '<h3>Title: ' . htmlspecialchars($post['title']) . '</h3>';
                            echo '<p>Body: ' . nl2br(htmlspecialchars($post['body'])) . '</p>';
                        } else {
                            echo "<p>No post found with ID $id!</p>";
                        }
                    } else {
                        echo "<p>No valid post ID provided!</p>";
                    }
                }
            } catch (PDOException $e) {
                echo '<p>Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
            }
            ?>
        </div>
        <button class="back-button" onclick="window.history.back()">Back</button>
    </div>
</body>
</html>
