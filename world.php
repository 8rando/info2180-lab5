<?php
$host = 'localhost';
$port = 8889; // Default MAMP MySQL port, change if your MAMP setup uses a different one
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';
$unix_socket = '/Applications/MAMP/tmp/mysql/mysql.sock'; // Replace with the correct path

$conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4;unix_socket=$unix_socket", $username, $password);


// Check if 'country' is passed as a GET request variable
if (isset($_GET['country']) && $_GET['country'] != '') {
    $country = $_GET['country'];
    $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE ?");
    $stmt->execute(["%$country%"]);
} else {
    // If no country is specified, select all countries
    $stmt = $conn->query("SELECT * FROM countries");
}

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: text/html; charset=utf-8');

?>

<ul>
<?php foreach ($results as $row): ?>
  <li><?= htmlspecialchars($row['name'] ?? '') . ' is ruled by ' . htmlspecialchars($row['head_of_state'] ?? ''); ?></li>
<?php endforeach; ?>
</ul>
