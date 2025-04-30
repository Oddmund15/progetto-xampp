<?php
require_once 'includes/db.php';

// Gestione eliminazione studente
if (isset($_GET['delete_id'])) {
    deleteStudent($conn, $_GET['delete_id']);
    header("Location: index.php");
    exit();
}

$students = getStudents($conn);

// Calcola statistiche
$totalStudents = count($students);
$courses = array_unique(array_column($students, 'corso'));
$totalCourses = count($courses);

$totalAge = 0;
foreach ($students as $student) {
    $totalAge += calculateAge($student['data_nascita']);
}
$avgAge = $totalStudents > 0 ? round($totalAge / $totalStudents) : 0;
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Piattaforma Studenti</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <div class="logo">StudentiApp</div>
                <ul class="nav-links">
                    <li><a href="index.php" class="active">Home</a></li>
                    <li><a href="registrati.php">Registrati</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="main-container">
        <h1 class="page-title">Benvenuti nella Piattaforma Studenti</h1>

        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-user-graduate"></i></div>
                <div class="stat-value"><?php echo $totalStudents; ?></div>
                <div class="stat-label">Studenti Totali</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-book"></i></div>
                <div class="stat-value"><?php echo $totalCourses; ?></div>
                <div class="stat-label">Corsi Attivi</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-calendar-alt"></i></div>
                <div class="stat-value"><?php echo $avgAge; ?></div>
                <div class="stat-label">Età Media</div>
            </div>
        </div>

        <div class="student-list">
            <div class="student-list-header">
                <div class="student-list-title">Lista Studenti</div>
                <div class="student-count"><?php echo $totalStudents; ?> studenti</div>
            </div>
            
            <?php if (empty($students)): ?>
                <div class="empty-list">
                    <div class="empty-icon"><i class="fas fa-user-slash"></i></div>
                    <p>Nessuno studente registrato.</p>
                    <a href="registrati.php" class="register-btn">Registra Studente</a>
                </div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Cognome</th>
                            <th>Età</th>
                            <th>Email</th>
                            <th>Corso</th>
                            <th>Azioni</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $student): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($student['nome']); ?></td>
                                <td><?php echo htmlspecialchars($student['cognome']); ?></td>
                                <td><?php echo calculateAge($student['data_nascita']); ?></td>
                                <td><?php echo htmlspecialchars($student['email']); ?></td>
                                <td><?php echo htmlspecialchars($student['corso']); ?></td>
                                <td>
                                    <a href="index.php?delete_id=<?php echo $student['id']; ?>" class="delete-btn" 
                                       onclick="return confirm('Sei sicuro di voler eliminare questo studente?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> StudentiApp - Piattaforma di Gestione Studenti</p>
        </div>
    </footer>

    <script src="js/script.js"></script>
</body>
</html>

<?php $conn->close(); ?>