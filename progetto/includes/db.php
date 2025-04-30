<?php
// Configurazione del database
$servername = "localhost";
$username = "tuo_username"; // Sostituisci con il tuo username MySQL
$password = "tua_password"; // Sostituisci con la tua password MySQL
$dbname = "studenti_db";

// Crea connessione
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Funzione per ottenere tutti gli studenti
function getStudents($conn) {
    $sql = "SELECT id, nome, cognome, data_nascita, email, corso FROM studenti ORDER BY cognome, nome";
    $result = $conn->query($sql);
    $students = array();
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
    }
    
    return $students;
}

// Funzione per aggiungere uno studente
function addStudent($conn, $nome, $cognome, $data_nascita, $email, $corso) {
    $stmt = $conn->prepare("INSERT INTO studenti (nome, cognome, data_nascita, email, corso) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nome, $cognome, $data_nascita, $email, $corso);
    return $stmt->execute();
}

// Funzione per eliminare uno studente
function deleteStudent($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM studenti WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

// Funzione per calcolare l'età
function calculateAge($birthdate) {
    $birth = new DateTime($birthdate);
    $now = new DateTime();
    return $now->diff($birth)->y;
}
?>