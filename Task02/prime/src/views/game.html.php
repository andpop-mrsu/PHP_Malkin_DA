<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Игра "Простое ли число"</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        h1 {
            color: #4CAF50;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"] {
            padding: 10px;
            width: 200px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        p {
            font-size: 1.2em;
        }
        a {
            color: #4CAF50;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Игра "Простое ли число"</h1>
    <p>Определите, является ли число <b><?= $_SESSION['number'] ?></b> простым:</p>

    <form method="post" <?php if (isset($_SESSION['result_announced']) && $_SESSION['result_announced']): ?>style="display:none;"<?php endif; ?>>
    <label for="user_answer">Ваш ответ (Простое/Не простое):</label>
    <input type="text" name="user_answer" required <?php if (isset($_SESSION['result_announced']) && $_SESSION['result_announced']): ?>disabled<?php endif; ?>>
    <button type="submit" <?php if (isset($_SESSION['result_announced']) && $_SESSION['result_announced']): ?>disabled<?php endif; ?>>Проверить</button>
	</form>


    <?php if (isset($message)): ?>
        <p><?= $message ?></p>
    <?php endif; ?>

    <br>

    <form method="post">
      <input type="submit" name="new_game" value="Новая игра" />
    </form>

    <br>

    <a href="index.php?page=home">Закончить игру</a>
</body>
</html>
