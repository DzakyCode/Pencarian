<?php
include 'config.php';
session_start();

if(isset($_POST['login'])){
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE username='$username' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) == 1){
        $row = mysqli_fetch_assoc($result);
        $stored = $row['password'];

        // jika stored password tampak bcrypt (mulai dgn $2y$ atau $2a$), gunakan password_verify
        if( (substr($stored,0,4) === '$2y$') || (substr($stored,0,4) === '$2a$') ){
            if(password_verify($password, $stored)){
                $_SESSION['admin'] = $row['username'];
                $_SESSION['admin_id'] = $row['id_admin'];
                header("Location: admin.php");
                exit;
            } else {
                $error = "Username atau Password salah!";
            }
        } else {
            // fallback: plain text comparison (untuk DB lama). Saran: update jadi hashed.
            if($password === $stored){
                $_SESSION['admin'] = $row['username'];
                $_SESSION['admin_id'] = $row['id_admin'];
                header("Location: admin.php");
                exit;
            } else {
                $error = "Username atau Password salah!";
            }
        }
    } else {
        $error = "Username atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-page">

<div class="login-container">
    <h2>Login Admin</h2>
    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit" name="login">Masuk</button>
    </form>
    <a href="index.php" class="back-home">← Kembali</a>
</div>

</body>
</html>
