<?php
include("connection.php");

$shift = $_GET["shift"];
echo "Обрана зміна: " . htmlspecialchars($shift);
echo "<br><br>";

try {
    $dbh = new PDO($dsn, $user, $pass);

    $sqlSelect = "SELECT ward.name AS Ward, nurse.name AS Nurse, nurse.shift AS Shift
                  FROM nurse_ward
                  JOIN nurse ON nurse_ward.fid_nurse = nurse.id_nurse
                  JOIN ward ON nurse_ward.fid_ward = ward.id_ward
                  WHERE nurse.shift = :shift";
    
    $sth = $dbh->prepare($sqlSelect);
    $sth->bindValue(":shift", $shift, PDO::PARAM_STR);
    $sth->execute();
    $res = $sth->fetchAll();

    echo "<table border='1'>";
    echo "<thead><tr><th>Палата</th><th>Медсестра</th><th>Зміна</th></tr></thead>";
    echo "<tbody>";
    foreach ($res as $row) {
        echo "<tr><td>{$row['Ward']}</td><td>{$row['Nurse']}</td><td>{$row['Shift']}</td></tr>";
    }
    echo "</tbody></table>";
} 
catch (PDOException $ex) {
    echo "Помилка: " . $ex->getMessage();
}

$dbh = null;
?>
