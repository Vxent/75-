<?php
session_start(); // Start the session

include 'db_connection.php'; // Database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Access denied. Please log in.");
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION['user_id']; // Get user ID from session
    $size = $_POST['size']; // Keep size if still needed
    $productName = "Custom T-Shirt"; // Adjust based on your logic
    $status = "Pending";

    // Get front and back text, allowing them to be blank
    $frontText = !empty($_POST['frontText']) ? $_POST['frontText'] : NULL;
    $backText = !empty($_POST['backText']) ? $_POST['backText'] : NULL;

    // Handle file upload
    if (isset($_FILES['fileUpload']) && $_FILES['fileUpload']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['fileUpload']['tmp_name'];
        $fileName = $_FILES['fileUpload']['name'];
        $uploadFileDir = './uploaded_files/';
        $dest_path = $uploadFileDir . $fileName;

        // Move the file to the upload directory
        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0777, true); // Create the directory if it doesn't exist
        }

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            echo "File is successfully uploaded.\n";
        } else {
            echo "There was an error moving the uploaded file.\n";
        }
    } else {
        echo "No file uploaded or there was an upload error.\n";
    }

    // Insert data into the customization_orders table
    $stmt = $db->prepare("INSERT INTO customization_orders (user_id, product_name, size, front_text, back_text, status, file_path) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssss", $userId, $productName, $size, $frontText, $backText, $status, $dest_path);

    if ($stmt->execute()) {
        echo "Order successfully placed!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $db->close();
}
?>