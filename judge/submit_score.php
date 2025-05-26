<?php
require_once '../config/db.php';

$message = '';

// Fetch participants
$participants = $pdo->query("SELECT * FROM participants ORDER BY name")->fetchAll();

// Fetch judges
$judges = $pdo->query("SELECT * FROM judges ORDER BY display_name")->fetchAll();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $judge_id = $_POST['judge_id'];
    $participant_id = $_POST['participant_id'];
    $score = $_POST['score'];

    // Basic validation
    if ($judge_id && $participant_id && is_numeric($score) && $score >= 1 && $score <= 100) {
        try {
            // Check if score already exists, update if so
            $stmt = $pdo->prepare("SELECT * FROM scores WHERE judge_id = ? AND participant_id = ?");
            $stmt->execute([$judge_id, $participant_id]);
            $existing = $stmt->fetch();

            if ($existing) {
                $stmt = $pdo->prepare("UPDATE scores SET score = ? WHERE judge_id = ? AND participant_id = ?");
                $stmt->execute([$score, $judge_id, $participant_id]);
                $message = "Score updated successfully!";
            } else {
                $stmt = $pdo->prepare("INSERT INTO scores (judge_id, participant_id, score) VALUES (?, ?, ?)");
                $stmt->execute([$judge_id, $participant_id, $score]);
                $message = "Score submitted successfully!";
            }
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
        }
    } else {
        $message = "Please fill all fields correctly.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Submit Score</title>
</head>
<body>
    <h2>Judge Portal: Submit Score</h2>
    <?php if ($message): ?>
        <p><strong><?= htmlspecialchars($message) ?></strong></p>
    <?php endif; ?>
    <form method="post">
        <label>Judge:</label><br>
        <select name="judge_id" required>
            <option value="">Select judge</option>
            <?php foreach ($judges as $judge): ?>
                <option value="<?= $judge['id'] ?>"><?= htmlspecialchars($judge['display_name']) ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Participant:</label><br>
        <select name="participant_id" required>
            <option value="">Select participant</option>
            <?php foreach ($participants as $participant): ?>
                <option value="<?= $participant['id'] ?>"><?= htmlspecialchars($participant['name']) ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Score (1–100):</label><br>
        <input type="number" name="score" min="1" max="100" required><br><br>

        <button type="submit">Submit Score</button>
    </form>
</body>
</html>
