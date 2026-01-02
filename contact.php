<?php
session_start();
$pageTitle = "Contact Us";
$pageDescription = "Get in touch with Urquhart Web Systems, LLC for your technology needs";

// Generate CAPTCHA numbers if not set
if (!isset($_SESSION['captcha_num1'])) {
    $_SESSION['captcha_num1'] = rand(1, 20);
    $_SESSION['captcha_num2'] = rand(1, 20);
    $_SESSION['captcha_sum'] = $_SESSION['captcha_num1'] + $_SESSION['captcha_num2'];
}

// Initialize variables
$formSubmitted = false;
$errors = [];
$successMessage = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CAPTCHA validation first
    $captchaAnswer = isset($_POST['captcha_answer']) ? (int)$_POST['captcha_answer'] : 0;
    if ($captchaAnswer !== $_SESSION['captcha_sum']) {
        $errors[] = "Incorrect CAPTCHA answer. Please try again.";
    }

    // Sanitize and validate inputs
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';
    
    // Validation
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    if (empty($subject)) {
        $errors[] = "Subject is required";
    }
    
    if (empty($message)) {
        $errors[] = "Message is required";
    }
    
    // If no errors, process the form
    if (empty($errors)) {
        $successMessage = "Thank
