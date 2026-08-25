<?php
  header('Content-Type: application/json'); // Set response type

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize data
    $name = htmlspecialchars($_POST['name'] ?? '');
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars($_POST['subject'] ?? '');
    $service = htmlspecialchars($_POST['service'] ?? '');
    $message = htmlspecialchars($_POST['message'] ?? '');

    // Validate (basic example)
    if (empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($subject) || empty($message)) {
      echo json_encode(['success' => false, 'error' => 'Please fill in all fields correctly.']);
      exit;
    }

    $to = "dts.eliteus@gmail.com, dbopsinclair@gmail.com";
    $from = "note.ziimoo@gmail.com";
    $headers = "From: " . $from . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";  // Ensure proper encoding
    $subject = "New Contact Form Submission: " . $subject;  // Add a prefix to the subject

    $body = "Name: " . $name . "\n";
    $body .= "Email: " . $email . "\n";
    $body .= "Subject: " . $subject . "\n";
    $body .= "Service: " . $service . "\n";
    $body .= "Message:\n" . $message;

    if (mail($to, $subject, $body, $headers)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to send email. Please try again later.']);
    }
  } else {
      echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
  }
?>
