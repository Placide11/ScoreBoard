<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


require_once 'config/db.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $display_name = trim($_POST['display_name']);

    if (!empty($username) && !empty($display_name)) {
        $stmt = $pdo->prepare("INSERT INTO judges (username, display_name) VALUES (?, ?)");
        try {
            $stmt->execute([$username, $display_name]);
            $message = "Judge added successfully!";
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
        }
    } else {
        $message = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Judge</title>
</head>
<body>
    <h2>Add New Judge</h2>
    <?php if ($message): ?>
        <p><strong><?= htmlspecialchars($message) ?></strong></p>
    <?php endif; ?>
    <form method="post">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Display Name:</label><br>
        <input type="text" name="display_name" required><br><br>

        <button type="submit">Add Judge</button>
    </form>
</body>
</html>
