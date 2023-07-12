<?php
// Connect to the database using PDO
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle data insert
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['insertBtn'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];

    try {
        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");

        // Bind the parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);

        // Execute the statement
        $stmt->execute();

        echo '<p>Data inserted successfully</p>';
    } catch (PDOException $e) {
        echo '<p>Error inserting data: ' . $e->getMessage() . '</p>';
    }
}

// Handle data update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateBtn'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    try {
        // Prepare the SQL statement
        $stmt = $conn->prepare("UPDATE users SET name=:name, email=:email WHERE id=:id");

        // Bind the parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $id);

        // Execute the statement
        $stmt->execute();

        echo '<p>Data updated successfully</p>';
    } catch (PDOException $e) {
        echo '<p>Error updating data: ' . $e->getMessage() . '</p>';
    }
}

// Handle data delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteBtn'])) {
    $id = $_POST['id'];

    try {
        // Prepare the SQL statement
        $stmt = $conn->prepare("DELETE FROM users WHERE id=:id");

        // Bind the parameter
        $stmt->bindParam(':id', $id);

        // Execute the statement
        $stmt->execute();

        echo '<p>Data deleted successfully</p>';
    } catch (PDOException $e) {
        echo '<p>Error deleting data: ' . $e->getMessage() . '</p>';
    }
}

// Read data from the database
try {
    $stmt = $conn->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error retrieving data: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>CRUD Example | Algocodersmind.com</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h1 {
            text-align: center;
        }
        form {
            margin: 20px auto;
            max-width: 400px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }
        form label {
            display: block;
            margin-bottom: 10px;
        }
        form input[type="text"] {
            width: 100%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        form button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        form button[type="submit"] {
            width: 100%;
        }
        hr {
            margin-top: 50px;
            margin-bottom: 50px;
            border: none;
            border-top: 1px solid #ccc;
        }
        table {
            margin: 0 auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        input[type="hidden"] {
            display: none;
        }
    </style>
</head>
<body>
    <h1>CRUD Example | Algocodersmind.com</h1>
    <!-- form to collect input -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name">
        <br>
        <label for="email">Email:</label>
        <input type="text" name="email" id="email">
        <br>
        <button type="submit" name="insertBtn">Insert</button>
    </form>
    <hr>
    <!-- display data from the database in a table -->
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                    <td><input type="text" name="name" value="<?php echo $user['name']; ?>"></td>
                    <td><input type="text" name="email" value="<?php echo $user['email']; ?>"></td>
                    <td><button type="submit" name="updateBtn">Update</button></td>
                    <td><button type="submit" name="deleteBtn">Delete</button></td>
                </form>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>

