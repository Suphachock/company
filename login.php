<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" referrerpolicy="no-referrer" />
    <style>
        .logo-circle {
            width: 100px;
            height: 100px;
            background-color: #0d6efd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }

        .logo-circle .fa-user {
            font-size: 4rem;
            color: white;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container-fluid">
        <div class="position-absolute top-50 start-50 translate-middle">
            <div class="card" style="width: 400px;">
                <div class="card-body">
                    <!-- Logo section -->
                    <div class="text-center mt-3">
                        <div class="logo-circle">
                            <span class="fa-solid fa-user"></span>
                        </div>
                    </div>
                    <h3 class="card-title text-center mt-3">Login</h3>
                    <form id="login_submit">
                        <div class="form-group mb-3">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mb-3">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#login_submit').on('submit', function(event) {
                event.preventDefault();
                let formData = new FormData(this);
                $.ajax({
                    url: 'model/auth_login.php', // The URL of your PHP script
                    type: 'POST', // The HTTP method to use (POST)
                    data: formData, // The form data
                    processData: false, // Prevent jQuery from processing the data
                    contentType: false, // Prevent jQuery from setting a default content type
                    success: function(res) {
                        let response = JSON.parse(res);
                        if (response.status === "success") {
                            window.location.replace("admin/index.php");
                        } else {
                            alert(response.message);
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>