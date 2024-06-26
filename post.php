<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Page</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: url(aa.jpg) no-repeat;
            background-position: center;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .post-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #fff;
            border-radius: 20px;
            backdrop-filter: blur(15px); 
        }

        #postDetails {
            font-size: 20px;
        }

        #postDetails h3{
            color: #4da383;
        }

        #postDetails p{
            color: #b9f2dd;
        }

        h1{
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            font-size: 50px;
        }
    </style>
</head>

<body>
    <div class="box">
        <div class="post-container">
            <h1>Post Page</h1>
            <div id="postDetails">
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
                    if (isset($_GET['id'])) {
                        $id = $_GET['id'];

                        $query = "SELECT * FROM `posts` WHERE id = :id";
                        $statement = $pdo->prepare($query);
                        $statement->execute([':id' => $id]); 

                        $post = $statement->fetch(PDO::FETCH_ASSOC);

                        if ($post) {
                            echo '<h3>Title: ' . $post['title'] . '</h3>';
                            echo '<p>Body: ' . $post['body'] . '</p>';
                        } else {
                            echo "No post found with ID $id!";
                        }
                    } else {
                        echo "No post ID provided!";
                    }
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            ?>
        </div>
    </div>
</body>

</html>