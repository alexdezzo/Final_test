<?php
session_start();
unset($_SESSION['animals']); // Удаляем данные о животных
header("Location: index.php");
exit;
