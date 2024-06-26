<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts Page</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: url(ee.jpg) no-repeat;
            background-size: cover;
        }

        .posts-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #fff;
            border-radius: 20px;
            background-color: #58ad93;
            backdrop-filter: blur(50px);
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 15px;
            padding: 13px;
            border-radius: 10px;
            background-color: #ffffff;
            cursor: pointer;
        }

        li a {
            text-decoration:none;
            color: 	#585858;
        }
        

        li:hover {
            background-color: #68d6b5;
        }

        h1{
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }
    </style>

</head>

<body>
    <div class="posts-container">
        <h1>Posts Page</h1>
        <ul id="postLists">
            <?php

            require 'config.php';

            if (!isset($_SESSION['user_id'])) {
                header("Location: index.php");
                exit; // stop execution
            }

            $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
            $options =  [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

            try {
                $pdo = new PDO($dsn, $user, $password, $options);

                if ($pdo) {
                    $user_id = $_SESSION['user_id'];

                    $query = "SELECT * FROM `posts` WHERE user_id = :id";
                    $statement = $pdo->prepare($query);
                    $statement->execute([':id' => $user_id]);

                    $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

                    //using fetchAll and foreach loop
                    foreach ($rows as $row) {
                        echo '<li><a href="post.php?id=' . $row['id'] . '">' . $row['title'] . '</li>'; //execute logic
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