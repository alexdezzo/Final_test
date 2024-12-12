<?php

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


session_start();

if (!isset($_SESSION['animals'])) {
    $_SESSION['animals'] = [];
}

if (isset($_POST['add_command']) && isset($_POST['animal_index'])) {
    $index = (int)$_POST['animal_index'];
    $command = $_POST['command'];
    if (isset($_SESSION['animals'][$index])) {
        $_SESSION['animals'][$index]->addCommand($command);
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Список животных</title>
</head>

<body>
    <h1>Список животных</h1>
    <ul>
        <?php foreach ($_SESSION['animals'] as $i => $animal): ?>
            <li>
                <strong><?= htmlspecialchars($animal->getName()) ?></strong>
                (<?= htmlspecialchars(get_class($animal)) ?>)<br>
                Дата рождения: <?= htmlspecialchars($animal->getBirthDate()) ?><br>
                Команды: <?= implode(", ", $animal->getCommands()) ?><br>
                <form method="post">
                    <input type="hidden" name="animal_index" value="<?= $i ?>">
                    <input type="text" name="command" placeholder="Новая команда">
                    <button type="submit" name="add_command">Обучить команде</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="index.php">На главную</a>
</body>

</html>