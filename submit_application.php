<?php
$servername = "localhost";
$dbname = "techsmartrepair";  // Change to your database name
$username = "root";  // Change to your MySQL username
$password = "";  // Change to your MySQL password


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate required fields
if (
    empty($_POST["firstName"]) || 
    empty($_POST["lastName"]) || 
    empty($_POST["email"]) || 
    empty($_POST["phone"]) || 
    empty($_POST["position"])
) {
    die("All fields are required.");
}

// Sanitize input data
$first_name = filter_var($_POST['firstName'], FILTER_SANITIZE_STRING);
$last_name = filter_var($_POST['lastName'], FILTER_SANITIZE_STRING);
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
$position = filter_var($_POST['position'], FILTER_SANITIZE_STRING);
$cover_letter = filter_var($_POST['coverLetter'], FILTER_SANITIZE_STRING);

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email format.");
}

// Handle file upload securely
$target_dir = "uploads/";
$resume_path = "";

if (isset($_FILES["resume"]) && $_FILES["resume"]["error"] == 0) {
    $allowed_extensions = ["pdf", "doc", "docx"];
    $file_extension = strtolower(pathinfo($_FILES["resume"]["name"], PATHINFO_EXTENSION));

    if (!in_array($file_extension, $allowed_extensions)) {
        die("Only PDF, DOC, JPEG, and DOCX files are allowed.");
    }

    $resume_path = $target_dir . time() . "_" . basename($_FILES["resume"]["name"]); // Unique filename
    move_uploaded_file($_FILES["resume"]["tmp_name"], $resume_path);
}

// Use prepared statement to insert data securely
$stmt = $conn->prepare("INSERT INTO jobapplications (first_name, last_name, email, phone, position_applied, resume_path, cover_letter) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $first_name, $last_name, $email, $phone, $position, $resume_path, $cover_letter);

if ($stmt->execute()) {
    echo "Application submitted successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
