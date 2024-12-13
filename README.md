## Информация о проекте

Необходимо организовать систему учета для питомника, в котором живут домашние и вьючные животные.

**Описание работы и логика приложения описана в задании 14!**

Все задания описаны в файле по ссылке: [Ссылка на файл](https://gbcdn.mrgcdn.ru/uploads/asset/4868005/attachment/1f0bfdadc1c954fc748a4890b644e605.pdf).

---

## Решения

### Задание 1

#### Создание файлов

Первый файл назовем `domestic.txt` (собаки, кошки, хомяки).  
Второй файл — `pack_animals.txt` (лошади, верблюды, ослы).

```bash
# Создаем файл для домашних животных:
cat > domestic.txt
собаки
кошки
хомяки
Ctrl+D

# Создаем файл для вьючных животных:
cat > pack_animals.txt
лошади
верблюды
ослы
Ctrl+D
```

#### Объединение файлов

```bash
cat domestic.txt pack_animals.txt > all_animals.txt
cat all_animals.txt
# Содержимое:
# собаки
# кошки
# хомяки
# лошади
# верблюды
# ослы
```

#### Переименование файла

```bash
mv all_animals.txt Друзья_человека.txt
```

---

### Задание 2

#### Создание директории и перемещение файла

Назовём директорию «animals».

```bash
mkdir animals
mv Друзья_человека.txt animals/
```

---

### Задание 3
Обновляю список пакетов:

```bash
sudo apt update
```
#### Установка MySQL Server

```bash
sudo apt update
sudo apt install mysql-server -y
```
Проверяю статус сервиса:
```bash
sudo systemctl status mysql
```

#### Настройка MySQL

```bash
sudo mysql_secure_installation

# Enter current password for root (enter for none): Enter
# Switch to unix_socket authentication [Y/n]: Y
# Change the root password? [Y/n]: Y
# Remove anonymous users? [Y/n]: Y
# Disallow root login remotely? [Y/n]: Y
# Remove test database and access to it? [Y/n]: Y
# Reload privilege tables now? [Y/n]: Y
```

#### Проверка установки

```bash
sudo mysql -u root -p
# Вводим пароль
```
ввожу пароль, убеждаюсь, что все работает и выхожу
```bash
EXIT;
```
Подключаю дополнительный репозиторий MySQL
Добавляю ключи репозитория MySQL:
```bash
wget https://repo.mysql.com/RPM-GPG-KEY-mysql-2022
sudo apt-key add RPM-GPG-KEY-mysql-2022
```
Скачиваю и добавляю репозиторий MySQL:
```bash
wget https://dev.mysql.com/get/mysql-apt-config_0.8.26-1_all.deb
sudo dpkg -i mysql-apt-config_0.8.26-1_all.deb
```
Обновляю список пакетов с новым репозиторием:
```bash
sudo apt update
```
Устанавливаю любой пакет из нового репозитория (например, MySQL Shell):
```bash
sudo apt install mysql-shell -y
```

---

### Задание 4

#### Установка deb-пакета с помощью dpkg

```bash
wget http://mirrors.kernel.org/ubuntu/pool/universe/h/htop/htop_3.2.2-1_amd64.deb
sudo dpkg -i htop_3.2.2-1_amd64.deb
sudo apt-get install -f
htop --version
```
---

### Задание 5
![image](https://github.com/user-attachments/assets/fa6f6945-41e2-42b2-b23e-6eaa8ab32799)


---

### Задание 6

#### Иерархия классов

Предположим, у нас есть общий родительский класс `Animal`.
От него наследуются два класса: `DomesticAnimals` (Домашние животные) и `PackAnimals` (Вьючные животные).
В свою очередь, у `DomesticAnimals` есть потомки: `Dogs` (Собаки), `Cats` (Кошки), `Hamsters` (Хомяки), а у `PackAnimals`: `Horses` (Лошади), `Camels` (Верблюды), `Donkeys` (Ослы).

- `DomesticAnimals`:
  - `Dogs`
  - `Cats`
  - `Hamsters`
- `PackAnimals`:
  - `Horses`
  - `Camels`
  - `Donkeys`

![image-2](https://github.com/user-attachments/assets/517eeccb-b452-4f88-804c-45cc043fbc7f)


### Задание 7

#### Создание базы данных
Подключаемся к MySQL
```sql
mysql -u root -p
```

Создаем базу данных
```sql
CREATE DATABASE `Друзья_человека` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```
Используем созданную базу данных
```sql
USE `Друзья_человека`;
```
![image-3](https://github.com/user-attachments/assets/e1e9f86d-4d8d-4650-8e2d-44ef4af70a0d)

---

### Задание 8

У нас будет одна общая таблица `animals` для базовой сущности `Animal`. Далее, для классов `DomesticAnimals` и `PackAnimals` — отдельные таблицы, которые ссылаются на `animals`. Затем для каждого конкретного вида (`Dogs`, `Cats`, `Hamsters`, `Horses`, `Camels`, `Donkeys`) — свои таблицы, ссылающиеся на соответствующего родителя (`domestic_animals` или `pack_animals`).


#### Структура таблиц для хранения данных
Таблица для общего класса Animal
```sql
CREATE TABLE animals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);
```
Таблица для класса DomesticAnimals
```sql
CREATE TABLE domestic_animals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    animal_id INT NOT NULL,
    FOREIGN KEY (animal_id) REFERENCES animals(id)
);
```
Таблица для класса PackAnimals
```sql
CREATE TABLE pack_animals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    animal_id INT NOT NULL,
    FOREIGN KEY (animal_id) REFERENCES animals(id)
);
```
Таблицы для DomesticAnimals
```sql
CREATE TABLE dogs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    domestic_id INT NOT NULL,
    FOREIGN KEY (domestic_id) REFERENCES domestic_animals(id)
);

CREATE TABLE cats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    domestic_id INT NOT NULL,
    FOREIGN KEY (domestic_id) REFERENCES domestic_animals(id)
);

CREATE TABLE hamsters (
    id INT AUTO_INCREMENT PRIMARY KEY,
    domestic_id INT NOT NULL,
    FOREIGN KEY (domestic_id) REFERENCES domestic_animals(id)
);
```
Таблицы для PackAnimals
```sql
CREATE TABLE horses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pack_id INT NOT NULL,
    FOREIGN KEY (pack_id) REFERENCES pack_animals(id)
);

CREATE TABLE camels (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pack_id INT NOT NULL,
    FOREIGN KEY (pack_id) REFERENCES pack_animals(id)
);

CREATE TABLE donkeys (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pack_id INT NOT NULL,
    FOREIGN KEY (pack_id) REFERENCES pack_animals(id)
);
```
![image-4](https://github.com/user-attachments/assets/9bd0ae9d-cf01-4a8f-8f66-b054c858b864)

![image-5](https://github.com/user-attachments/assets/f2a02b6a-f8cf-4498-8466-411bd6c631fe)

![image-6](https://github.com/user-attachments/assets/0e5e7d5a-62ac-49eb-ae22-82e676fc15cd)

---

### Задание 9
Будем вносить изменения в структуру таблиц, чтобы хранить требуемые данные (имена животных, команды, даты рождения).

#### Предварительная подготовка

На предыдущем шаге в таблицах нижнего уровня (`dogs`, `cats`, `hamsters`, `horses`, `camels`, `donkeys`) у нас были только первичные и внешние ключи. Нам нужны колонки для хранения:
`name` (имя животного),
`commands` (команды, которые может выполнять животное),
`birth_date` (дата рождения).

У каждого вида животных структура полей будет одинаковой. Внесём изменения в структуру таблиц (создаем еще дополнительные поля):

Добавление полей в таблицы для хранения дополнительных данных
```sql
ALTER TABLE dogs ADD COLUMN name VARCHAR(50), 
                  ADD COLUMN commands VARCHAR(255),
                  ADD COLUMN birth_date DATE;

ALTER TABLE cats ADD COLUMN name VARCHAR(50), 
                 ADD COLUMN commands VARCHAR(255),
                 ADD COLUMN birth_date DATE;

ALTER TABLE hamsters ADD COLUMN name VARCHAR(50), 
                     ADD COLUMN commands VARCHAR(255),
                     ADD COLUMN birth_date DATE;

ALTER TABLE horses ADD COLUMN name VARCHAR(50), 
                   ADD COLUMN commands VARCHAR(255),
                   ADD COLUMN birth_date DATE;

ALTER TABLE camels ADD COLUMN name VARCHAR(50), 
                   ADD COLUMN commands VARCHAR(255),
                   ADD COLUMN birth_date DATE;

ALTER TABLE donkeys ADD COLUMN name VARCHAR(50), 
                    ADD COLUMN commands VARCHAR(255),
                    ADD COLUMN birth_date DATE;
```
![image-7](https://github.com/user-attachments/assets/9fb54184-0dfe-4e5b-b8ee-800626986e1b)

#### Вставка данных в таблицы
Для вставки данных нам нужны ID в родительских таблицах. Логика такая:
- Создаем запись в animals для животного.
- Создаем запись в domestic_animals или pack_animals (в зависимости от вида) с animal_id равным id из animals.
- Создаем запись в конкретной таблице вида.
- В каждую таблицу заведем по одному животному. 
Данные для собаки

```sql
INSERT INTO animals (name) VALUES ('Животное #1');
SET @animal_id = LAST_INSERT_ID();
INSERT INTO domestic_animals (animal_id) VALUES (@animal_id);
SET @domestic_id = LAST_INSERT_ID();
INSERT INTO dogs (domestic_id, name, commands, birth_date)
VALUES (@domestic_id, 'Бобик', 'сидеть, лежать', '2021-05-10');
```
Вставляем запись в domestic_animals
```sql
INSERT INTO domestic_animals (animal_id) VALUES (@animal_id);
SET @domestic_id = LAST_INSERT_ID();
```
По аналогии заполнаются другие животные

![image-8](https://github.com/user-attachments/assets/c1b95fbe-0eb1-4377-8174-ad570da94b33)

![image-9](https://github.com/user-attachments/assets/7954286c-0f11-4e60-bbdd-56071a07e4db)

![image-10](https://github.com/user-attachments/assets/f1ea0c0d-7722-4e89-8caf-83c83f559608)


### Задание 10

#### Удаление верблюдов и объединение таблиц
Удаление всех записей из таблицы camels
```sql
DELETE FROM camels;
```
Для объединения создадим новую таблицу `horses_donkeys`. Структура будет аналогична `horses` и `donkeys` (`id`, `pack_id`, `name`, `commands`, `birth_date`).
Чтобы знать, откуда пришла запись, нам нужен столбец, (лошадь или осел). Добавим поле `source_type`:

Создание новой объединенной таблицы horses_donkeys
```sql
CREATE TABLE horses_donkeys (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pack_id INT NOT NULL,
    name VARCHAR(50),
    commands VARCHAR(255),
    birth_date DATE,
    source_type VARCHAR(10),
    FOREIGN KEY (pack_id) REFERENCES pack_animals(id)
);
```
![image-11](https://github.com/user-attachments/assets/bec2603a-0180-4309-a867-4723bc3400de)


Перенос данных из таблиц horses и donkeys
```sql
INSERT INTO horses_donkeys (pack_id, name, commands, birth_date, source_type)
SELECT pack_id, name, commands, birth_date, 'horse'
FROM horses;

INSERT INTO horses_donkeys (pack_id, name, commands, birth_date, source_type)
SELECT pack_id, name, commands, birth_date, 'donkey'
FROM donkeys;
```

![image-12](https://github.com/user-attachments/assets/91956758-df16-4c3f-825e-f775d9a351a1)

Удаление исходных таблиц
```sql
DROP TABLE horses;
DROP TABLE donkeys;
```
![image-13](https://github.com/user-attachments/assets/35370593-a4dc-44ce-8612-60f6a8b5406b)

---

### Задание 11
#### Выборка молодых животных
Нам нужно выбрать всех животных из всех имеющихся таблиц нижнего уровня, проверить их возраст.
Возраст вычисляем на основании `birth_date` относительно текущей даты (например, `CURDATE())`.
Условие: 1 год < возраст < 3 года.
Чтобы объединить всех животных, нам нужно сделать `SELECT` из всех наших таблиц последнего уровня. Сейчас у нас есть: `dogs`, `cats`, `hamsters` (домашние) и `horses_donkeys` (вьючные). Верблюдов мы удалили.
Посчитаем возраст в месяцах с помощью `TIMESTAMPDIFF(MONTH, birth_date, CURDATE())`. Для отбора по годам можно использовать `TIMESTAMPDIFF(YEAR, birth_date, CURDATE())`.
Создадим таблицу `young_animals`:

Создание таблицы для молодых животных
```sql
CREATE TABLE young_animals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    animal_type VARCHAR(50),
    name VARCHAR(50),
    commands VARCHAR(255),
    birth_date DATE,
    age_in_months INT
);
```
Теперь вставим данные. Нам нужно выбрать те, у кого 1 год < возраст < 3 лет. Это значит `TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) > 1 AND TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) < 3`.

Вставка данных о животных возраста от 1 до 3 лет
```sql
INSERT INTO young_animals (animal_type, name, commands, birth_date, age_in_months)
SELECT 'dog', d.name, d.commands, d.birth_date, TIMESTAMPDIFF(MONTH, d.birth_date, CURDATE())
FROM dogs d
JOIN domestic_animals da ON d.domestic_id = da.id
JOIN animals a ON da.animal_id = a.id
WHERE TIMESTAMPDIFF(YEAR, d.birth_date, CURDATE()) > 1 
  AND TIMESTAMPDIFF(YEAR, d.birth_date, CURDATE()) < 3;

INSERT INTO young_animals (animal_type, name, commands, birth_date, age_in_months)
SELECT 'cat', c.name, c.commands, c.birth_date, TIMESTAMPDIFF(MONTH, c.birth_date, CURDATE())
FROM cats c
JOIN domestic_animals da ON c.domestic_id = da.id
JOIN animals a ON da.animal_id = a.id
WHERE TIMESTAMPDIFF(YEAR, c.birth_date, CURDATE()) > 1 
  AND TIMESTAMPDIFF(YEAR, c.birth_date, CURDATE()) < 3;

INSERT INTO young_animals (animal_type, name, commands, birth_date, age_in_months)
SELECT 'hamster', h.name, h.commands, h.birth_date, TIMESTAMPDIFF(MONTH, h.birth_date, CURDATE())
FROM hamsters h
JOIN domestic_animals da ON h.domestic_id = da.id
JOIN animals a ON da.animal_id = a.id
WHERE TIMESTAMPDIFF(YEAR, h.birth_date, CURDATE()) > 1 
  AND TIMESTAMPDIFF(YEAR, h.birth_date, CURDATE()) < 3;

INSERT INTO young_animals (animal_type, name, commands, birth_date, age_in_months)
SELECT source_type, hd.name, hd.commands, hd.birth_date, TIMESTAMPDIFF(MONTH, hd.birth_date, CURDATE())
FROM horses_donkeys hd
JOIN pack_animals pa ON hd.pack_id = pa.id
JOIN animals a ON pa.animal_id = a.id
WHERE TIMESTAMPDIFF(YEAR, hd.birth_date, CURDATE()) > 1 
  AND TIMESTAMPDIFF(YEAR, hd.birth_date, CURDATE()) < 3;
```
![image-14](https://github.com/user-attachments/assets/e70d6bb4-8d34-4ea3-bcbd-1d477cef6e9c)

---

### Задание 12

#### Объединение данных из всех таблиц в одну итоговую
Нужно объединить всех животных из всех таблиц (`dogs`, `cats`, `hamsters`, `horses_donkeys`, `young_animals`) в одну, но при этом сохранить информацию о том, из какой таблицы живтоное было взято.
Создадим финальную таблицу `all_animals_full`, которая будет содержать основные поля + колонку `origin_table`:

Создание итоговой таблицы `all_animals_full`
```sql
CREATE TABLE all_animals_full (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50),
    commands VARCHAR(255),
    birth_date DATE,
    age_in_months INT,
    origin_table VARCHAR(50)
);
```
Перенос данных из dogs
```sql
INSERT INTO all_animals_full (name, commands, birth_date, age_in_months, origin_table)
SELECT d.name, d.commands, d.birth_date, TIMESTAMPDIFF(MONTH, d.birth_date, CURDATE()), 'dogs'
FROM dogs d;
```
```sql
Перенос данных из cats
INSERT INTO all_animals_full (name, commands, birth_date, age_in_months, origin_table)
SELECT c.name, c.commands, c.birth_date, TIMESTAMPDIFF(MONTH, c.birth_date, CURDATE()), 'cats'
FROM cats c;
```
Перенос данных из hamsters
```sql
INSERT INTO all_animals_full (name, commands, birth_date, age_in_months, origin_table)
SELECT h.name, h.commands, h.birth_date, TIMESTAMPDIFF(MONTH, h.birth_date, CURDATE()), 'hamsters'
FROM hamsters h;
```
Перенос данных из horses_donkeys
```sql
INSERT INTO all_animals_full (name, commands, birth_date, age_in_months, origin_table)
SELECT hd.name, hd.commands, hd.birth_date, TIMESTAMPDIFF(MONTH, hd.birth_date, CURDATE()), source_type
FROM horses_donkeys hd;
```
Перенос данных из young_animals
```sql
INSERT INTO all_animals_full (name, commands, birth_date, age_in_months, origin_table)
SELECT ya.name, ya.commands, ya.birth_date, ya.age_in_months, 'young_animals'
FROM young_animals ya;
```
![image-15](https://github.com/user-attachments/assets/efbc1b9c-9449-4c92-abbc-9e26237721a3)

---

### Задание 13

## Задача: Создать класс с инкапсуляцией методов и с наследованием по диаграмме.
По ранее описанной диаграмме классов у нас есть следующая иерархия:
- Animal (родительский класс)
- DomesticAnimals (домашние животные)
  - Dogs
  - Cats
  - Hamsters
- PackAnimals (вьючные животные)
  - Horses
  - Camels
  - Donkeys

Принципы ООП, которые мы должны применить:
классы `DomesticAnimals` и `PackAnimals` наследуются от `Animal`, а специализированные классы (`Dogs`, `Cats` и т.п.) наследуются от соответствующих «родительских» классов `DomesticAnimals` или `PackAnimals`.
Стоит применить абстрактные классы там, где класс не предполагает прямого создания экземпляров (например, `Animal` может быть абстрактным).

Пример на PHP:

```php
<?php
// Родительский класс Animal - абстрактный
abstract class Animal {
    protected $name;
    protected $birthDate;
    protected $commands = [];

    public function __construct($name, $birthDate) {
        $this->name = $name;
        $this->birthDate = $birthDate;
    }

    public function getName() {
        return $this->name;
    }

    public function getBirthDate() {
        return $this->birthDate;
    }

    public function getCommands() {
        return $this->commands;
    }

    public function addCommand($command) {
        $this->commands[] = $command;
    }
}

// Домашние животные
abstract class DomesticAnimals extends Animal {
    // Тут логика, общая для всех домашних животных
}

class Dogs extends DomesticAnimals {
    // Можно добавить специфичную логику для собак
}

class Cats extends DomesticAnimals {
    // Для кошек
}

class Hamsters extends DomesticAnimals {
    // Для хомяков
}

// Вьючные животные
abstract class PackAnimals extends Animal {
    // Общая логика для вьючных
}

class Horses extends PackAnimals {
    // Для лошадей
}

class Camels extends PackAnimals {
    // Для верблюдов
}

class Donkeys extends PackAnimals {
    // Для ослов
}
```

`Dogs`, `Cats`, `Hamsters` наследуются от `DomesticAnimals`, а те в свою очередь от `Animal`. Аналогично для `PackAnimals` и их потомков. Доступ к полям идёт через методы, поля инкапсулированы (protected).

---

### Задание 14

#### Название:
Реестр домашних животных
#### Назначение приложения:
Веб-приложение для учета и управления информацией о домашних и вьючных животных.
В приложении реализован функционал добавления новых животных, просмотр списка животных (с отображением класса животного), обучение животного командам и удаление животного из списка.
#### Логика работы приложения:
Главная страница (`index.php`):
Отсюда пользователь может перейти:

- на страницу добавления нового животного (`add_animal.php`)
- на страницу просмотра списка животных (`view_animals.php`)
Добавление животного (`add_animal.php`):
- Пользователь вводит имя, дату рождения, тип и вид животного.
- При отправке формы создается объект соответствующего класса (`Dogs`, `Cats`, `Hamsters`, `Horses`, `Camels` или `Donkeys`) и сохраняется в сессии (`$_SESSION['animals']`).

Используется класс `Counter` для учета заведённых животных.
Просмотр животных (`view_animals.php`):
- Отображается список всех заведённых животных (из `$_SESSION['animals']`).

Для каждого животного отображается: имя, дата рождения, тип (класс) и список выученных команд.
Есть форма для добавления новой команды к выбранному животному. Дополнительно реализована функция удаления животного из списка (кнопка «Удалить» на странице `view_animals.php`).
#### Сессия:

В реальном случае данные должны храниться в базе данных. В данном приложении для упрощения логики работы приложения было принято решение, чтобы все данные о животных сохранялись в активной сессии браузера. До перезапуска браузера или прекращении текущей сессии данные сохраняются.

Сброс сессии (при необходимости):
Дополнительно реализована опция для сброса сессии.
Схема работы приложения:

![image](https://github.com/user-attachments/assets/ffd012a8-7203-4dce-ae22-00ed479dcabc)

 
Взаимосвязи (нет прямых зависимостей, кроме наследования)
Counter будет использоваться в add_animal.php, но это не отражается на уровне классовой диаграммы, так как это прикладное использование, а не отношение между классами.

> Сессия не отражена как класс, так как это не класс а механизм хранения данных.

`add_animal.php`:
- Форма → POST → Создание объекта → Добавление в сессию → Counter add()
- создает объект DomesticAnimals или PackAnimals
- сохраняет в сессию $_SESSION['animals']
- использует Counter при добавлении


`view_animals.php`:
- Чтение массива животных из сессии ($_SESSION['animals'])
- Вывод списка
- Добавление команд: POST → addCommand()
- Удаление животного: POST → unset из массива


`classes/`:
- Animal, DomesticAnimals, PackAnimals: основа иерархии
- Dogs, Cats, Hamsters (домашние)
- Horses, Camels, Donkeys (вьючные)
- Counter: для учета заведенных животных


`styles.css`:
- Общий стиль и адаптивный дизайн приложения
Требования к окружению:
PHP
Веб-сервер (Apache/Nginx)
Инструкция по запуску приложения:
Поместите файлы на веб-сервер с установленным php (рекомендуется PHP 7.4+), откройте index.php в браузере.
Для добавления животного перейдите по ссылке «Завести новое животное».
После добавления вернитесь на главную или перейдите к «Посмотреть список животных», чтобы увидеть добавленных питомцев, обучать их командам или удалять.
Если нужно сбросить весь список добавленных животных, на главной странице (index.php) внизу слева нажмите на кнопку «Сбросить сессию».


## Скриншоты работы приложения

![image-16](https://github.com/user-attachments/assets/a2e85e37-5e3d-40bd-8b9a-b96db4bbe0c0)

![image-17](https://github.com/user-attachments/assets/2f097a65-9248-4ab3-8f63-a75e4b598856)

![image-18](https://github.com/user-attachments/assets/78889bee-46ca-40bf-8fc4-8fc743ea7d25)
