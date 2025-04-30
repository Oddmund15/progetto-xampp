<?php
// config.php
$servername = "localhost";
$username = "tuo_username"; // Sostituisci con il tuo username MySQL
$password = "tua_password"; // Sostituisci con la tua password MySQL
$dbname = "studenti_db";    // Sostituisci con il nome del tuo database

// Crea connessione
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Funzioni del database
function getAllStudents($conn) {
    $sql = "SELECT id, nome, cognome, data_nascita, email, corso FROM studenti";
    $result = $conn->query($sql);
    $students = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
    }
    return $students;
}

function deleteStudent($conn, $id) {
    $sql = "DELETE FROM studenti WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

function calculateAge($birthDate) {
    $birth = new DateTime($birthDate);
    $now = new DateTime();
    return $now->diff($birth)->y;
}

function addStudent($conn, $nome, $cognome, $data_nascita, $email, $corso) {
    $sql = "INSERT INTO studenti (nome, cognome, data_nascita, email, corso) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nome, $cognome, $data_nascita, $email, $corso);
    return $stmt->execute();
}
?>