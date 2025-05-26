<?php
require_once '../config/db.php';

// Fetch total scores per participant
$query = "
    SELECT 
        participants.name,
        SUM(scores.score) AS total_score
    FROM participants
    LEFT JOIN scores ON participants.id = scores.participant_id
    GROUP BY participants.id
    ORDER BY total_score DESC
";

$results = $pdo->query($query)->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Scoreboard</title>
    <meta http-equiv="refresh" content="10"> <!-- auto-refresh every 10 seconds -->
    <style>
        body { font-family: Arial; margin: 20px; }
        h2 { color: #333; }
        table {
            border-collapse: collapse;
            width: 60%;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: left;
        }
        tr:nth-child(1) { background-color: gold; }
        tr:nth-child(2) { background-color: silver; }
        tr:nth-child(3) { background-color: #cd7f32; }
        tr:hover { background-color: #f1f1f1; }
    </style>
</head>
<body>
    <h2>🏆 Public Scoreboard</h2>
    <table>
        <thead>
            <tr>
                <th>Rank</th>
                <th>Participant</th>
                <th>Total Score</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $rank = 1;
            foreach ($results as $row):
            ?>
            <tr>
                <td><?= $rank++ ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= $row['total_score'] ?? 0 ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <p><em>Page refreshes every 10 seconds.</em></p>
</body>
</html>
