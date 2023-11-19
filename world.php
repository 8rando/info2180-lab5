<?php
$host = 'localhost';
$port = 8889; // Default MAMP MySQL port, change if your MAMP setup uses a different one
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';
$unix_socket = '/Applications/MAMP/tmp/mysql/mysql.sock'; // Replace with the correct path

$conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4;unix_socket=$unix_socket", $username, $password);

header('Content-Type: text/html; charset=utf-8');

// Check if the 'lookup' parameter is set to 'cities' and 'country' is provided
if (isset($_GET['lookup']) && $_GET['lookup'] === 'cities' && isset($_GET['country'])) {
    $country = $_GET['country'];
    $stmt = $conn->prepare("SELECT cities.name, cities.district, cities.population 
                            FROM cities 
                            JOIN countries ON cities.country_code = countries.code 
                            WHERE countries.name LIKE ?");
    $stmt->execute(["%$country%"]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output cities in an HTML table
    echo '<table>';
    echo '<tr><th>Name</th><th>District</th><th>Population</th></tr>';
    foreach ($results as $row) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['name'] ?? 'N/A') . '</td>';
        echo '<td>' . htmlspecialchars($row['district'] ?? 'N/A') . '</td>';
        echo '<td>' . htmlspecialchars($row['population'] ?? 'N/A') . '</td>';
        echo '</tr>';
    }
    echo '</table>';
} else if (isset($_GET['country'])) {
    // This is the country lookup logic
    $country = $_GET['country'];
    $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE ?");
    $stmt->execute(["%$country%"]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output countries in an HTML table
    echo '<table>';
    echo '<tr><th>Name</th><th>Continent</th><th>Independence Year</th><th>Head of State</th></tr>';
    foreach ($results as $row) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['name'] ?? 'N/A') . '</td>';
        echo '<td>' . htmlspecialchars($row['continent'] ?? 'N/A') . '</td>';
        echo '<td>' . htmlspecialchars($row['independence_year'] ?? 'N/A') . '</td>';
        echo '<td>' . htmlspecialchars($row['head_of_state'] ?? 'N/A') . '</td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    // If no country is specified, you might want to handle this case as well
    echo 'Please enter a country name.';
}
?>
