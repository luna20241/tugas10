<?php
class Auth {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        session_start();
    }

    public function login($username, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $password === $user['password']) { // sederhana tanpa hash
            $_SESSION['username'] = $user['username'];
            $_SESSION['level'] = $user['level'];
            header("Location: dashboard.php");
            exit;
        } else {
            echo "Username atau password salah.";
        }
    }

    public function checkAccess() {
        if (!isset($_SESSION['username'])) {
            header("Location: index.php");
            exit;
        }
    }

    public function logout() {
        session_destroy();
        header("Location: index.php");
    }
}
?>
