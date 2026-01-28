<?php
// Database connection
$dsn = 'sqlite:jewelry.db'; // Path to your SQLite database file

function getJewelry($type, $gender) {
    global $dsn;
    
    try {
        // Connect to the database
        $pdo = new PDO($dsn);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Prepare the SQL query
        $stmt = $pdo->prepare("SELECT * FROM product WHERE product_type = :type AND gender = :gender");
        $stmt->execute(['type' => $type, 'gender' => $gender]);
        
        // Fetch all matching records
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Return data as JSON
        header('Content-Type: application/json');
        echo json_encode($items);
    } catch (PDOException $e) {
        // Handle database errors
        echo json_encode(['error' => $e->getMessage()]);
    }
}

// Check if the request is for Men's Bracelets
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['type']) && $_GET['type'] === 'bracelet' && isset($_GET['gender']) && $_GET['gender'] === 'men') {
    getJewelry('bracelet', 'men');
}
?>
