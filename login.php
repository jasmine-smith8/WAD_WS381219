<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-danger d-flex justify-content-center align-items-center vh-100">

    <main class="p-4 bg-white rounded">
        <h2 class="text-center mb-4">Login Page</h2>
        
        <form id="formLogin">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>

        // Detect the submission of the login form.
        $('#formLogin').submit(function(e) {
            // Prevent a reload of the page
            e.preventDefault();

            // Make AJAX call to auth.php
            $.ajax({
                // URL is where we are sending it
                url: './php/auth.php',

                // Method is how we are sending it
                method: 'POST',

                // Data is the data we are sending
                data: $(this).serialize(),

                success: function(response) {
                    // "true" means that the user was authenticated from auth.php
                    if (response == 'true')
                    {
                        // Redirect to index.php
                        window.location.href = 'index.php';
                    }
                    else
                    {
                        Swal.fire({
                            title: "Something went wrong!",
                            text: response,
                            icon: "error",
                            heightAuto: false
                        });
                    }
                }
            });
        });

    </script>
</body>
</html>