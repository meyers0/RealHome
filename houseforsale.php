<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Houses for Sale</title>
    <link rel="stylesheet" href="houses.css">
</head>
<body>
    <h1>Houses for Sale</h1>
    <div class="property-list">
        <?php
        // Database connection
        $conn = new mysqli('localhost', 'username', 'password', 'real_estate');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch properties from database
        $result = $conn->query("SELECT * FROM properties");

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='property'>";
                echo "<img src='" . $row['image_path'] . "' alt='Property Image'>";
                echo "<h2>" . $row['title'] . "</h2>";
                echo "<p>" . $row['description'] . "</p>";
                echo "<p><strong>Price:</strong> R" . $row['price'] . "</p>";
                echo "<p><strong>Location:</strong> " . $row['location'] . "</p>";
                echo "<p><strong>Contact:</strong> " . $row['contact'] . "</p>";
                echo "</div>";
            }
        } else {
            echo "No properties available.";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
