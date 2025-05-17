<?php
// Configurare DB - adaptează după setup-ul tău
$host = 'localhost';
$db = 'testdb';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    exit("Eroare DB: " . $e->getMessage());
}

// Creare tabel contacte dacă nu există
$pdo->exec("CREATE TABLE IF NOT EXISTS contacte (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nume VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    telefon VARCHAR(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

// Funcție pentru curățare input
function clean($data)
{
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Procesare formular adăugare / editare
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
    $nume = clean($_POST['nume']);
    $email = clean($_POST['email']);
    $telefon = clean($_POST['telefon']);

    if ($id > 0) {
        // UPDATE contact
        $stmt = $pdo->prepare("UPDATE contacte SET nume = ?, email = ?, telefon = ? WHERE id = ?");
        try {
            $stmt->execute([$nume, $email, $telefon, $id]);
            echo "<p class='success'>Contact actualizat cu succes.</p>";
        } catch (PDOException $e) {
            echo "<p class='error'>Eroare actualizare: " . $e->getMessage() . "</p>";
        }
    } else {
        // INSERT contact nou
        $stmt = $pdo->prepare("INSERT INTO contacte (nume, email, telefon) VALUES (?, ?, ?)");
        try {
            $stmt->execute([$nume, $email, $telefon]);
            echo "<p class='success'>Contact adăugat cu succes.</p>";
        } catch (PDOException $e) {
            echo "<p class='error'>Eroare adăugare: " . $e->getMessage() . "</p>";
        }
    }
}

// Ștergere contact (GET cu parametru ?delete=id)
if (isset($_GET['delete'])) {
    $delete_id = (int) $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM contacte WHERE id = ?");
    try {
        $stmt->execute([$delete_id]);
        echo "<p class='success'>Contact șters cu succes.</p>";
    } catch (PDOException $e) {
        echo "<p class='error'>Eroare la ștergere: " . $e->getMessage() . "</p>";
    }
}

// Afișare lista contacte
$stmt = $pdo->query("SELECT * FROM contacte ORDER BY id DESC");
$contacte = $stmt->fetchAll();

if ($contacte):
    ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nume</th>
                <th>Email</th>
                <th>Telefon</th>
                <th>Acțiuni</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacte as $c): ?>
                <tr>
                    <td><?php echo $c['id']; ?></td>
                    <td><?php echo htmlspecialchars($c['nume']); ?></td>
                    <td><?php echo htmlspecialchars($c['email']); ?></td>
                    <td><?php echo htmlspecialchars($c['telefon']); ?></td>
                    <td>
                        <button onclick="editContact(
                        '<?php echo $c['id']; ?>',
                        '<?php echo addslashes(htmlspecialchars($c['nume'])); ?>',
                        '<?php echo addslashes(htmlspecialchars($c['email'])); ?>',
                        '<?php echo addslashes(htmlspecialchars($c['telefon'])); ?>'
                    )">Editează</button>
                        <a href="?delete=<?php echo $c['id']; ?>"
                            onclick="return confirm('Sigur vrei să ștergi acest contact?');">Șterge</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Nu există contacte în baza de date.</p>
<?php endif; ?>