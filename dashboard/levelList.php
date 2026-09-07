<?php
require __DIR__ . "/../incl/connection.php";
$query = "SELECT * FROM levels";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        table { border-collapse: collapse; width: 100%; font-family: Arial; }
        th, td { border: 1px solid #000000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>List of levels on the GDPS</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Level Name</th>
                <th>Featured?</th>
                <th>Stars</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result->fetchAll(PDO::FETCH_ASSOC) as $level): ?>
                <tr>
                    <td><?php echo htmlspecialchars($level['levelID']); ?></td>
                    <td><?php echo htmlspecialchars($level['name']); ?></td>
                    <td><?php echo htmlspecialchars($level['featureType']); ?></td>
                    <td><?php echo htmlspecialchars($level['stars']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
