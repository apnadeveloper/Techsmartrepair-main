<?php
require_once 'db_config.php';

header('Content-Type: application/json'); // Ensure response is JSON

$response = ["success" => false, "message" => "Something went wrong", "errors" => []];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = trim($_POST["firstName"]);
    $lastName = trim($_POST["lastName"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $deviceName = trim($_POST["deviceName"]);
    $model = trim($_POST["model"]);
    $faultDescription = trim($_POST["faultDescription"]);
    $faultType = trim($_POST["faulttype"]);
    $storeLocation = trim($_POST["storelocation"]);
    $appointmentDate = trim($_POST["appointmentDate"]);

    // Validate required fields
    if (empty($firstName)) {
        $response["errors"]["firstName"] = "First name is required";
    }
    if (empty($lastName)) {
        $response["errors"]["lastName"] = "Last name is required";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["errors"]["email"] = "Valid email is required";
    }
    if (empty($phone)) {
        $response["errors"]["phone"] = "Phone number is required";
    }
    if (empty($deviceName)) {
        $response["errors"]["deviceName"] = "Device name is required";
    }
    if (empty($model)) {
        $response["errors"]["model"] = "Model is required";
    }
    if (empty($faultDescription)) {
        $response["errors"]["faultDescription"] = "Fault description is required";
    }
    if (empty($faultType)) {
        $response["errors"]["faulttype"] = "Fault type is required";
    }
    if (empty($storeLocation)) {
        $response["errors"]["storelocation"] = "Store location is required";
    }
    if (empty($appointmentDate)) {
        $response["errors"]["appointmentDate"] = "Appointment date is required";
    }

    // If there are no errors, proceed with database insertion
    if (empty($response["errors"])) {
        $stmt = $conn->prepare("INSERT INTO bookings (first_name, last_name, email, phone, device_name, model, fault_description, fault_type, store_location, appointment_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssss", $firstName, $lastName, $email, $phone, $deviceName, $model, $faultDescription, $faultType, $storeLocation, $appointmentDate);

        if ($stmt->execute()) {
            $response["success"] = true;
            $response["message"] = "Your booking has been successfully submitted!";
        } else {
            $response["message"] = "Database error: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
echo json_encode($response);
exit;
?>
