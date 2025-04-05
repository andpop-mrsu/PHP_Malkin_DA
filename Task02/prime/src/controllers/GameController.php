<?php
namespace JesusStar\prime\Controllers;

class GameController {
    private $model;
    private $maxAttempts = 3; // Максимальное количество попыток

    public function __construct() {
        require_once __DIR__ . '/../Model.php';
        $this->model = new \JesusStar\Prime\Model();
    }

    public function handleRequest() {
        session_start();

        if (!isset($_SESSION['player_name'])) {
            header('Location: index.php?page=home');
            exit();
        }

        if (isset($_POST['new_game'])) {
            unset($_SESSION['number']);
            unset($_SESSION['attempts']);
            unset($_SESSION['result_announced']);
        }

        if (!isset($_SESSION['number'])) {
            $number = rand(1, 100);
            $_SESSION['number'] = $number;
            $_SESSION['attempts'] = $this->maxAttempts;
            $_SESSION['result_announced'] = false;
        } else {
            $number = $_SESSION['number'];
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_answer'])) {
            $userAnswer = $_POST['user_answer'];
            $isPrime = $this->model->isPrime($number);
            $correctAnswer = $isPrime ? 'Простое' : 'Не простое';
            $divisors = !$isPrime ? $this->model->getNonTrivialDivisors($number) : [];

            $_SESSION['attempts']--;

            if ($userAnswer == $correctAnswer || $_SESSION['attempts'] == 0) {
                $message = ($userAnswer == $correctAnswer)
                    ? "Правильно! Число $number является $correctAnswer."
                    : "Попытки закончились. Число $number является $correctAnswer.";

                if (!$isPrime) {
                    $message .= " Нетривиальные делители: " . implode(", ", $divisors) . ".";
                }

                $this->model->saveGameResult($_SESSION['player_name'], $number, $userAnswer, $correctAnswer);
                $_SESSION['result_announced'] = true;
            } else {
                $message = "Неправильно. Попробуйте еще раз. Осталось попыток: " . $_SESSION['attempts'];
            }
        }

        require_once __DIR__ . '/../views/game.html.php';
    }
}
