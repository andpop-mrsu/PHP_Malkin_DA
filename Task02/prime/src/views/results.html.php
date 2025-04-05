<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Результаты игр</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #4CAF50;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #4CAF50;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>История игр</h1>
    <table>
        <thead>
            <tr>
                <th>Игрок</th>
                <th>Число</th>
                <th>Ваш ответ</th>
                <th>Правильный ответ</th>
                <th>Результат</th>
                <th>Дата</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $result): ?>
                <tr>
                    <td><?= htmlspecialchars($result['player_name']) ?></td>
                    <td><?= htmlspecialchars($result['number']) ?></td>
                    <td><?= htmlspecialchars($result['user_answer']) ?></td>
                    <td><?= htmlspecialchars($result['correct_answer']) ?></td>
                    <td><?= htmlspecialchars($result['result']) ?></td>
                    <td><?= htmlspecialchars($result['created_at']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="index.php?page=home">Вернуться на главную</a>
</body>
</html>
