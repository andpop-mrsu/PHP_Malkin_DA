<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Простое число - математическая игра</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4a6fa5;
            --secondary: #166088;
            --accent: #4fc3f7;
            --background: #f5f7fa;
            --card-bg: #ffffff;
            --text: #333333;
            --success: #4caf50;
            --error: #f44336;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--background);
            color: var(--text);
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .container {
            max-width: 800px;
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }
        
        .game-card {
            background-color: var(--card-bg);
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 30px;
        }
        
        h1 {
            color: var(--secondary);
            text-align: center;
            margin-bottom: 30px;
            font-weight: 500;
        }
        
        .input-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--secondary);
        }
        
        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            transition: border 0.3s;
        }
        
        input[type="text"]:focus,
        input[type="number"]:focus {
            border-color: var(--accent);
            outline: none;
        }
        
        .btn {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s;
            margin-right: 10px;
            margin-bottom: 10px;
        }
        
        .btn:hover {
            background-color: var(--secondary);
        }
        
        .btn-secondary {
            background-color: #607d8b;
        }
        
        #output {
            background-color: var(--card-bg);
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
            min-height: 100px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        
        .success {
            color: var(--success);
        }
        
        .error {
            color: var(--error);
        }
        
        .game-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
            
            .game-card {
                padding: 20px;
            }
            
            .btn {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="game-card">
            <h1>Угадай простое число</h1>
            
            <div class="input-group">
                <label for="playerName">Ваше имя:</label>
                <input type="text" id="playerName" placeholder="Введите ваше имя">
            </div>
            
            <button class="btn" onclick="startGame()">Начать новую игру</button>
            
            <div class="game-info">
                <div class="input-group" style="flex: 1; margin-right: 15px;">
                    <label for="gameId">ID игры:</label>
                    <input type="number" id="gameId" placeholder="Введите ID игры">
                </div>
                
                <div class="input-group" style="flex: 1;">
                    <label for="playerAnswer">Это простое число?</label>
                    <input type="text" id="playerAnswer" placeholder="Да/Нет">
                </div>
            </div>
            
            <button class="btn" onclick="makeStep()">Сделать ход</button>
            <button class="btn btn-secondary" onclick="getGames()">Показать все игры</button>
            
            <div id="output">
                <p>Добро пожаловать в игру! Начните новую игру или продолжите существующую.</p>
            </div>
        </div>
    </div>

    <script>
        const output = document.getElementById('output');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        async function startGame() {
            const player = document.getElementById('playerName').value.trim() || 'Аноним';
            if (!player) {
                output.innerHTML = '<p class="error">Пожалуйста, введите имя!</p>';
                return;
            }
            
            try {
                const res = await fetch('/games', {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/json', 
                        'X-CSRF-TOKEN': csrfToken 
                    },
                    body: JSON.stringify({ player })
                });
                
                if (!res.ok) throw new Error('Ошибка сервера');
                
                const data = await res.json();
                output.innerHTML = `
                    <p>Новая игра создана!</p>
                    <p><strong>ID игры:</strong> ${data.id}</p>
                    <p><strong>Число:</strong> ${data.num}</p>
                    <p>Теперь сделайте ход, указав выше ID игры и ваш ответ.</p>
                `;
            } catch (error) {
                output.innerHTML = `<p class="error">Ошибка: ${error.message}</p>`;
            }
        }

        async function makeStep() {
            const gameId = document.getElementById('gameId').value.trim();
            const playerAnswer = document.getElementById('playerAnswer').value.trim().toLowerCase();
            
            if (!gameId || !playerAnswer || !['да', 'нет'].includes(playerAnswer)) {
                output.innerHTML = '<p class="error">Пожалуйста, введите корректный ID игры и ответ (Да/Нет)!</p>';
                return;
            }
            
            try {
                const res = await fetch(`/step/${gameId}`, {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/json', 
                        'X-CSRF-TOKEN': csrfToken 
                    },
                    body: JSON.stringify({ answer: playerAnswer })
                });
                
                if (!res.ok) throw new Error('Ошибка сервера');
                
                const data = await res.json();
                const resultClass = data.result === 'Правильно!' ? 'success' : 'error';
                
                output.innerHTML = `
                    <p><strong>Ваш ответ:</strong> ${data.player_answer}</p>
                    <p><strong>Правильный ответ:</strong> ${data.isPrime ? 'Да' : 'Нет'}</p>
                    <p class="${resultClass}"><strong>Результат:</strong> ${data.result}</p>
                `;
            } catch (error) {
                output.innerHTML = `<p class="error">Ошибка: ${error.message}</p>`;
            }
        }

        async function getGames() {
            try {
                const res = await fetch('/games');
                if (!res.ok) throw new Error('Ошибка загрузки списка игр');
                
                const games = await res.json();
                let html = '<h3>История игр</h3>';
                
                if (games.length === 0) {
                    html += '<p>Игр пока нет</p>';
                } else {
                    html += '<div style="overflow-x: auto;"><table style="width: 100%; border-collapse: collapse;">';
                    html += `
                        <tr style="background-color: #f0f0f0;">
                            <th style="padding: 10px; text-align: left;">ID</th>
                            <th style="padding: 10px; text-align: left;">Игрок</th>
                            <th style="padding: 10px; text-align: left;">Число</th>
                            <th style="padding: 10px; text-align: left;">Результат</th>
                        </tr>
                    `;
                    
                    games.forEach(game => {
                        const resultClass = game.result === 'Правильно!' ? 'success' : 'error';
                        html += `
                            <tr style="border-bottom: 1px solid #eee;">
                                <td style="padding: 10px;">${game.id}</td>
                                <td style="padding: 10px;">${game.player_name}</td>
                                <td style="padding: 10px;">${game.num}</td>
                                <td style="padding: 10px;" class="${resultClass}">${game.result || '-'}</td>
                            </tr>
                        `;
                    });
                    
                    html += '</table></div>';
                }
                
                output.innerHTML = html;
            } catch (error) {
                output.innerHTML = `<p class="error">Ошибка: ${error.message}</p>`;
            }
        }
    </script>
</body>
</html>