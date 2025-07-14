<?php
echo "Test DB<br>\n";
$host = getenv('MYSQL_HOST');
$username = getenv('MYSQL_USERNAME');
$password = getenv('MYSQL_PASSWORD');
$dbname = getenv('MYSQL_DBNAME');

echo $dbname . "<br>\n";

try {
    // Create connection
    // $conn = mysqli_connect($host, $username, $password, $dbname);

    // Initialize connection with SSL
    $conn = mysqli_init();
    mysqli_ssl_set($conn, NULL, NULL, "BaltimoreCyberTrustRoot.crt.pem", NULL, NULL);
    mysqli_real_connect($conn, $host, $username, $password, $dbname, 3306, NULL, MYSQLI_CLIENT_SSL);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    echo "Connected securely with SSL!";

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Query
    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn, $sql);

    // Fetch data
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "ID: " . $row["id"] . " - Name: " . $row["name"] . "<br>";
        }
    } else {
        echo "0 results";
    }

    // Close connection
    mysqli_close($conn);
} catch (\Exception $e) {
    echo "Exception: " . $e->getMessage();
}
