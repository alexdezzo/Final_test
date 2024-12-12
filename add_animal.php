<?php
session_start();
require_once __DIR__ . '/classes/Animal.php';
require_once __DIR__ . '/classes/DomesticAnimals.php';
require_once __DIR__ . '/classes/PackAnimals.php';
require_once __DIR__ . '/classes/Dogs.php';
require_once __DIR__ . '/classes/Cats.php';
require_once __DIR__ . '/classes/Hamsters.php';
require_once __DIR__ . '/classes/Horses.php';
require_once __DIR__ . '/classes/Camels.php';
require_once __DIR__ . '/classes/Donkeys.php';
require_once __DIR__ . '/classes/Counter.php';

// Если не существует массива животных в сессии, создаем
if (!isset($_SESSION['animals'])) {
    $_SESSION['animals'] = [];
}

$message = "";

// Обработка формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $birthDate = $_POST['birthdate'] ?? '';
    $type = $_POST['type'] ?? '';
    $subtype = $_POST['subtype'] ?? '';

    // Проверим, что все поля заполнены
    if (!empty($name) && !empty($birthDate) && !empty($type) && !empty($subtype)) {
        $counter = new Counter();
        try {
            switch ($subtype) {
                case 'dogs':
                    $animal = new Dogs($name, $birthDate);
                    break;
                case 'cats':
                    $animal = new Cats($name, $birthDate);
                    break;
                case 'hamsters':
                    $animal = new Hamsters($name, $birthDate);
                    break;
                case 'horses':
                    $animal = new Horses($name, $birthDate);
                    break;
                case 'camels':
                    $animal = new Camels($name, $birthDate);
                    break;
                case 'donkeys':
                    $animal = new Donkeys($name, $birthDate);
                    break;
                default:
                    $animal = null;
            }

            if ($animal !== null) {
                $_SESSION['animals'][] = $animal;
                $counter->add(); // Увеличивает счетчик при успешном добавлении
                $message = "Животное успешно добавлено!";
            } else {
                $message = "Ошибка при определении класса животного.";
            }
        } finally {
            $counter->close(); // Закрываем ресурс
        }
    } else {
        $message = "Пожалуйста, заполните все поля.";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Добавить животное</title>
</head>

<body>
    <h1>Завести новое животное</h1>
    <?php if ($message) echo "<p>$message</p>"; ?>
    <form method="post">
        <label>Имя животного:</label><br>
        <input type="text" name="name" required><br>
        <label>Дата рождения:</label><br>
        <input type="date" name="birthdate" required><br>
        <label>Тип животного:</label><br>
        <select name="type">
            <option value="domestic">Домашнее</option>
            <option value="pack">Вьючное</option>
        </select><br>
        <label>Вид:</label><br>
        <select name="subtype">
            <option value="dogs">Собака</option>
            <option value="cats">Кошка</option>
            <option value="hamsters">Хомяк</option>
            <option value="horses">Лошадь</option>
            <option value="camels">Верблюд</option>
            <option value="donkeys">Осел</option>
        </select><br><br>
        <button type="submit">Добавить животное</button>
    </form>
    <a href="index.php">На главную</a>
</body>

</html>