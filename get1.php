<?php
include("connection.php");

$nurseId = isset($_GET["nurse_id"]) ? $_GET["nurse_id"] : null;

if (!$nurseId) {
    die("Помилка: не вибрано медсестру.");
}

if (!ctype_digit($nurseId)) {
    die("Помилка: невірний ID медсестри.");
}

echo "ID медсестри: " . htmlspecialchars($nurseId) . "<br><br>";

try {
    $dbh = new PDO($dsn, $user, $pass);

    $sqlSelect = "SELECT ward.name AS Ward, nurse.department AS Dep, nurse.shift AS Shift 
    FROM ward
    JOIN nurse_ward ON ward.id_ward = nurse_ward.fid_ward
    JOIN nurse ON nurse_ward.fid_nurse = nurse.id_nurse
    WHERE nurse.id_nurse = :nurseId";

    $sth = $dbh->prepare($sqlSelect);
    $sth->bindValue(":nurseId", $nurseId, PDO::PARAM_INT);  
    $sth->execute();
    $res = $sth->fetchAll(PDO::FETCH_ASSOC);

    echo "<table border='1'>";
    echo "<thead><tr><th>Палата</th><th>Відділення</th><th>Зміна</th></tr></thead>";
    echo "<tbody>";
    foreach ($res as $row) {
        echo "<tr><td>{$row['Ward']}</td><td>{$row['Dep']}</td><td>{$row['Shift']}</td></tr>";
    }   
    echo "</tbody></table>";

} catch (PDOException $ex) {
    echo "Помилка БД: " . $ex->getMessage();
}

$dbh = null;
?>
