<?php
// Enable error reporting
ini_set('display_errors', 1);

session_start();

// Check the user role and redirect to the appropriate dashboard
if (isset($_SESSION['userRole'])) {
    $userRole = $_SESSION['userRole'];
    if ($userRole == 'admin') {
        // Redirect to the admin dashboard
        header("Location: adminDashboard.php");
    } else {
        // Redirect to the user dashboard
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
    <link rel="stylesheet" href="/pages/styles/loginStyles.css">
    <link rel="shortcut icon" href="/pages/img/fire.png" type="image/x-icon">
</head>
<header>
    <nav class="navbar">
        <a class="navbar-brand">HateHire</a>
    </nav>
</header>
<body class="container">
    <main class="login-form-container">
        <h2 class="login-title">Login Page</h2>
        <!-- Calls handleLogin function from JS-->
        <form class="login-form" onsubmit="handleLogin(event)">
            <div>
                <label for="email">Email:</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    required
                    aria-required="true"
                />
            </div>
            <div>
                <label for="password">Password:</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    aria-required="true"
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
                        // this function is defined in loginAlert.js - it shows a success alert
                        showAlert('Login successful!', 'success');
                        sessionStorage.setItem('userID', response.userID);
                        window.location.href = 'index.php';
                    } else {
                        // this function is defined in loginAlert.js - it shows an error alert
                        showAlert('Invalid credentials, please try again.', 'error', response);
                    }
                }
            });
        }
    </script>
</body>
</html>