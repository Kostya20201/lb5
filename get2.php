<?php
include("connection.php");

$department = $_GET["department"];
echo "Обране відділення: " . htmlspecialchars($department);
echo "<br><br>";

try {
    $dbh = new PDO($dsn, $user, $pass);

    $sqlSelect = "SELECT name, shift FROM nurse WHERE department = ?";
    
    $sth = $dbh->prepare($sqlSelect);
    $sth->bindParam(1, $department, PDO::PARAM_STR);
    $sth->execute(); 
    $res = $sth->fetchAll();

    echo "<table border='1'>";
    echo "<thead><tr><th>Ім'я</th><th>Зміна</th></tr></thead>";
    echo "<tbody>";
    foreach ($res as $row) {
        echo "<tr><td>{$row['name']}</td><td>{$row['shift']}</td></tr>";
    }
    echo "</tbody></table>";
} 
catch (PDOException $ex) {
    echo "Помилка: " . $ex->getMessage();
}

$dbh = null;
?>
