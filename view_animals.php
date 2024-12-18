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
// Обучение новой команде
if (isset($_POST['add_command']) && isset($_POST['animal_index'])) {
    $index = (int)$_POST['animal_index'];
    $command = $_POST['command'];
    if (isset($_SESSION['animals'][$index])) {
        $_SESSION['animals'][$index]->addCommand($command);
    }
}
// Проверяем, была ли отправлена форма на удаление
if (isset($_POST['delete_animal']) && isset($_POST['animal_index'])) {
    $index = (int)$_POST['animal_index'];
    if (isset($_SESSION['animals'][$index])) {
        // Удаляем животное из массива
        unset($_SESSION['animals'][$index]);
        // Можно не пересобирать массив, но для удобства сделаем array_values
        $_SESSION['animals'] = array_values($_SESSION['animals']);
    }
}


?>
<!DOCTYPE html>
<html>

<head>
    <title>Список животных</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <h1>Список животных</h1>
        <ul>
            <?php foreach ($_SESSION['animals'] as $i => $animal): ?>
                <li>
                    <strong><?= htmlspecialchars($animal->getName()) ?></strong>
                    (<?= htmlspecialchars(get_class($animal)) ?>)<br>
                    Дата рождения: <?= htmlspecialchars($animal->getBirthDate()) ?><br>
                    Команды: <?= implode(", ", $animal->getCommands()) ?><br>

                    <!-- Форма для добавления команды -->
                    <form method="post" style="margin-top: 10px;">
                        <input type="hidden" name="animal_index" value="<?= $i ?>">
                        <input type="text" name="command" placeholder="Новая команда">
                        <button type="submit" name="add_command">Обучить команде</button>
                    </form>

                    <!-- Форма для удаления животного -->
                    <form method="post" style="margin-top:10px;">
                        <input type="hidden" name="animal_index" value="<?= $i ?>">
                        <button type="submit" name="delete_animal" class="btn_del_animal">Удалить</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
        <a href="index.php">На главную</a>
    </div>
</body>

</html>