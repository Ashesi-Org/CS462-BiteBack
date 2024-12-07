<?php
session_start();
require_once '../config/database.php';

class UserLogin {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function login($email, $password) {
        // Sanitize inputs
        $email = $this->db->real_escape_string($email);

        // Prepare SQL statement
        $query = "SELECT user_id, username, email, password, role FROM users WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Login successful
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                // Redirect based on user role
                if ($user['role'] == 'admin') {
                    header("Location: ../admin/index.php");
                } else {
                    header("Location: ../pages/user-profile/index.php");
                }
                exit();
            } else {
                return "Invalid password";
            }
        } else {
            return "User not found";
        }
    }
}

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = new UserLogin();
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $login->login($email, $password);
    if (is_string($result)) {
        $error = $result;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Ecomomentum</title>
</head>
<body>
    <form method="POST" action="">
        <?php if(isset($error)) echo "<p>$error</p>"; ?>
        <input type="email" name="email" required placeholder="Email">
        <input type="password" name="password" required placeholder="Password">
        <button type="submit">Login</button>
    </form>
</body>
</html>