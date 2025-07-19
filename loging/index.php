<?php
session_start();

// ✅ Database connection
$conn = new mysqli("localhost", "root", "", "fitgym");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    // ✅ Query to fetch user by email and role
    $stmt = $conn->prepare("SELECT userid, firstname, lastname, password, role FROM reg WHERE email = ? AND role = ?");
    $stmt->bind_param("ss", $email, $role);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($userid, $firstname, $lastname, $hashedPassword, $dbRole);
        $stmt->fetch();

        // ✅ Verify the hashed password
        if (password_verify($password, $hashedPassword)) {
            $_SESSION['userid'] = $userid;
            $_SESSION['firstname'] = $firstname;
            $_SESSION['lastname'] = $lastname;
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $dbRole;

            // ✅ Redirect to main page
            header("Location: http://localhost/GYM/main/index.html");
            exit;
        } else {
            $error = "Incorrect password!";
        }
    } else {
        $error = "No user found with this email and role.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>FitZone Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-image:
                linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)),
                url('log.jpg'); /* Add your image path */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: Arial, sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .login-box {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 450px;
        }

        .btn-login {
            background-color: #0072ff;
            color: white;
            font-weight: bold;
        }

        .btn-register {
            margin-top: 15px;
        }

        .error-msg {
            color: red;
            margin-bottom: 15px;
            font-weight: 600;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2 class="text-center mb-4">Login to FitZone</h2>

    <?php if (!empty($error)): ?>
        <div class="error-msg"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label>Email address</label>
            <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" />
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required />
        </div>

        <div class="mb-4">
            <label>Select Role</label>
            <select class="form-select" name="role" required>
                <option value="customer" <?= (($_POST['role'] ?? '') === 'customer') ? 'selected' : '' ?>>Customer</option>
                <option value="staff" <?= (($_POST['role'] ?? '') === 'staff') ? 'selected' : '' ?>>Gym Staff</option>
                <option value="admin" <?= (($_POST['role'] ?? '') === 'admin') ? 'selected' : '' ?>>Admin</option>
            </select>
        </div>

        <button type="submit" class="btn btn-login w-100">Login</button>
    </form>

    <div class="text-center btn-register">
        <a href="http://localhost/GYM/registration.php" class="btn btn-outline-primary w-100">Don't have an account? Register</a>
    </div>
</div>

</body>
</html>
