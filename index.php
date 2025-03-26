<?php
include 'connection.php';

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LB 5</title>
    <style>
    
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
            margin: 0;
        }

        .container {
            text-align: center;
        }

        form {
            display: inline-block;
            text-align: left; 
            margin-top: 20px;
        }

        label, input {
            margin: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h3>Варіант 3. БД для зберігання інформації про робочі зміни чергувань медсестер у поліклініці</h3>

        <!-- Форма для вибору медсестри -->
        <h4>Перелік палат, у яких чергує обрана медсестра</h4>
        <form action="get1.php" method="GET">
            <label for="nurse">Медсестра:</label>
            <select name="nurse_id" id="nurse">
                <?php
                $stmt = $pdo->query("SELECT id_nurse, name FROM nurse ORDER BY name ASC");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . htmlspecialchars($row['id_nurse']) . '">' . htmlspecialchars($row['name']) . '</option>';
                }
                ?>
            </select>
            <br><br>
            <button type="submit">Результати пошуку</button>
        </form>

        <!-- Форма для вибору відділення -->
        <h4>Медсестри обраного відділення</h4>
        <form action="get2.php" method="GET">
            <label for="department">Відділення:</label>
            <select name="department" id="department">
                <?php
                $stmt = $pdo->query("SELECT DISTINCT department FROM nurse");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . htmlspecialchars($row['department']) . '">Відділення ' . htmlspecialchars($row['department']) . '</option>';
                }
                ?>
            </select>
            <br><br>
            <button type="submit">Результати пошуку</button>
        </form>

        <!-- Форма для вибору зміни -->
        <h4>Чергування у будь-яких палатах для зазначеної зміни</h4>
        <form action="get3.php" method="GET">
            <label for="shift">Виберіть зміну:</label>
            <select name="shift" id="shift">
                <?php
                $stmt = $pdo->query("SELECT DISTINCT shift FROM nurse ORDER BY shift ASC");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . htmlspecialchars($row['shift']) . '">' . htmlspecialchars($row['shift']) . '</option>';
                }
                ?>
            </select>
            <br><br>
            <button type="submit">Результати пошуку</button>
        </form>
    </div>
</body>
</html>