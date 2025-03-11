<?php
session_start();
if (isset($_SESSION['userRole'])) {
    $userRole = $_SESSION['userRole'];
    if ($userRole == 'admin') {
        header("Location: adminDashboard.php");
    } else {
        header("Location: userDashboard.php");
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="/pages/styles/login-styles.css">
    <link rel="shortcut icon" href="/pages/img/fire.png" type="image/x-icon">
</head>
<body class="container">
    <main class="login-form-container">
        <h2 class="login-title">Login Page</h2>
        <form class="login-form" onsubmit="handleLogin(event)">
            <div>
                <label>Email:</label>
                <input
                    type="email"
                    name="email"
                    required
                />
            </div>
            <div>
                <label>Password:</label>
                <input
                    type="password"
                    name="password"
                    required
                />
            </div>
            <button type="submit">Login</button>
        </form>
    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="/pages/components/scripts/loginAlert.js"></script>
    <script>
        function handleLogin(event) {
            event.preventDefault();
            var form = event.target;
            $.ajax({
                url: './php/auth.php',
                method: 'POST',
                data: $(form).serialize(),
                success: function(response) {
                    if (response == 'true') {
                        window.location.href = 'index.php';
                    } else {
                        showAlert("An error occurred: " + response);
                    }
                }
            });
        }
    </script>
</body>
</html>