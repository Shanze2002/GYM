<?php
session_start();

// ✅ Database connection
$conn = new mysqli("localhost", "root", "", "fitgym");

// ❌ Connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ✅ Handle registration form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId    = (int) $_POST['user_id'];
    $firstName = htmlspecialchars($_POST['first_name']);
    $lastName  = htmlspecialchars($_POST['last_name']);
    $email     = htmlspecialchars($_POST['email']);
    $password  = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role      = $_POST['role'];

    // ✅ Check if email already exists
    $check = $conn->prepare("SELECT email FROM reg WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "<script>alert('❌ Email already exists. Please use another one.');</script>";
    } else {
        // ✅ Insert user
        $stmt = $conn->prepare("INSERT INTO reg (userid, firstname, lastname, email, password, role) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $userId, $firstName, $lastName, $email, $password, $role);

        if ($stmt->execute()) {
            echo "<script>
                alert('✅ Registration successful. Now login!');
                window.location='http://localhost/GYM/loging/index.php';
            </script>";
        } else {
            echo "<script>alert('❌ Registration failed.');</script>";
        }
        $stmt->close();
    }
    $check->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - FitZone</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background-image:
                linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
                url('reg.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 15px;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        h2 {
            text-align: center;
            color: #0072ff;
            margin-bottom: 25px;
        }

        .btn-success {
            background-color: #0072ff;
            border: none;
        }

        .btn-success:hover {
            background-color: #005edb;
        }

        .btn-secondary {
            border: none;
            color: white;
            background-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .btn-primary {
            border: none;
            color: white;
            background-color: #0d6efd;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Register to FitZone</h2>
    <form method="POST" action="">
        <div class="mb-3">
            <label>User ID:</label>
            <input type="number" class="form-control" name="user_id" required />
        </div>

        <div class="mb-3">
            <label>First Name:</label>
            <input type="text" class="form-control" name="first_name" required />
        </div>

        <div class="mb-3">
            <label>Last Name:</label>
            <input type="text" class="form-control" name="last_name" required />
        </div>

        <div class="mb-3">
            <label>Email Address:</label>
            <input type="email" class="form-control" name="email" required />
        </div>

        <div class="mb-3">
            <label>Password:</label>
            <input type="password" class="form-control" name="password" required />
        </div>

        <div class="mb-4">
            <label>Select Role:</label>
            <select class="form-select" name="role" required>
                <option value="customer">Customer</option>
                <option value="staff">Gym Staff</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-success">Register</button>
        </div>

        <div class="d-grid mt-2">
            <a href="http://localhost/GYM/loging/index.php" class="btn btn-secondary">Back to Home</a>
        </div>

        <div class="d-grid mt-2">
            <a href="http://localhost/GYM/loging/index.php" class="btn btn-primary">Go to Login Page</a>
        </div>
    </form>
</div>

</body>
</html>

