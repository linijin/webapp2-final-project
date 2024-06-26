<?php

require 'config.php';

$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]; //handle errors
//PDO object/php data object to connect database from application 

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
    echo $e->getMessage("Something Wrong");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: url(images.jpg) no-repeat;
            background-position: center;
            background-size: cover;
            width: 100%;
            backdrop-filter: blur(5px);

        }
        .form {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;            
        }

        .login-container {
            position: relative;
            width: 550px;
            height: 400px;
            border: 2px solid rgba(255, 255, 2550.5);
            border-radius: 20px ;
            backdrop-filter: blur(15px);
            display: flex;
            justify-content: center;
            align-items:center
        }

        .login-container h2 {
            color: #fff;
            text-align: center;
            font-size: 32px;
        }

        .login-container .input-box{
            position: relative;
            margin: 30px 0 ;
            width: 310px;
            border-bottom: 2px solid #fff;
        }

        .login-container .input-box input{
            width: 100%;
            height: 45px;
            background: transparent;
            border: none;
            outline: none;
            padding: 0 20px 0 50px;
            color: #fff;
            font-size: 16px;
        }

        i{
            position: absolute;
            color: #fff;
            top: 13px;
            right: 0;
        }

        input::placeholder{
            color: #fff;
        }

        .btn {
            color: #fff;
            background: rgb(77, 180, 128);
            width: 100%;
            height: 50px;
            border-radius: 5px;
            outline: none;
            font-size: 17px;
            transition: transform 0.2s;
        }

        .btn:active{
            transform: scale(0.95);
        }

        .btn:hover {
            background: rgb(63, 167, 115);
            color: #090909;
            box-shadow: 0 0 20px rgb(63, 167, 115);
        }
        
    </style>
</head>

<body>
    <div class="form"> 
        <div class="login-container">
            <form id="loginForm" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <h2>Login</h2>

                <div class="input-box">
                    <input type="text" id="username" placeholder="Enter Username" name="username" required>
                    <i class='bx bxs-user'></i>
                </div>

                <div class="input-box">    
                    <input type="password" id="password" placeholder="Enter Password" name="password" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>

                <div class="button">
                    <input type="submit" id="submit" class="btn" value="Login">
                </div>
            </form>
        </div>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>
</html>