<?php
require_once 'includes/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $cognome = trim($_POST['cognome']);
    $data_nascita = $_POST['data_nascita'];
    $email = trim($_POST['email']);
    $corso = trim($_POST['corso']);

    // Validazione
    if (empty($nome) || empty($cognome) || empty($data_nascita) || empty($email) || empty($corso)) {
        $error = 'Tutti i campi sono obbligatori';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email non valida';
    } else {
        // Verifica se l'email esiste già
        $stmt = $conn->prepare("SELECT id FROM studenti WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $error = 'Email già registrata';
        } else {
            if (addStudent($conn, $nome, $cognome, $data_nascita, $email, $corso)) {
                $success = 'Studente registrato con successo!';
                // Resetta i campi del form
                $nome = $cognome = $data_nascita = $email = $corso = '';
            } else {
                $error = 'Errore durante la registrazione';
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione Studente</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <div class="logo">StudentiApp</div>
                <ul class="nav-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="registrati.php" class="active">Registrati</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="registration-container">
        <h2>Registrazione Nuovo Studente</h2>
        
        <?php if ($error): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="success-message"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="registrati.php">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($nome ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="cognome">Cognome:</label>
                <input type="text" id="cognome" name="cognome" value="<?php echo htmlspecialchars($cognome ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="data_nascita">Data di Nascita:</label>
                <input type="date" id="data_nascita" name="data_nascita" value="<?php echo htmlspecialchars($data_nascita ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="corso">Corso di Studio:</label>
                <input type="text" id="corso" name="corso" value="<?php echo htmlspecialchars($corso ?? ''); ?>" required>
            </div>
            <button type="submit" class="btn-register">Registra</button>
        </form>
        <a href="index.php" class="back-home">Torna alla Home</a>
    </div>

    <script src="js/script.js"></script>
</body>
</html>

<?php $conn->close(); ?>