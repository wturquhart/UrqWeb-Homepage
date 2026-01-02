<?php
session_start(); // Add this at the very top
$pageTitle = "Contact Us";
$pageDescription = "Get in touch with Urquhart Web Systems, LLC for your technology needs";

// Generate CAPTCHA numbers if not set (before form display)
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

    // Sanitize and validate other inputs
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
        // Here you would typically send an email or save to database
        // For this example, we'll just set a success message
        $successMessage = "Thank you for contacting us! We'll get back to you soon.";
        $formSubmitted = true;
        
        // Clear form data and regenerate CAPTCHA after success
        $name = $email = $subject = $message = '';
        unset($_SESSION['captcha_num1'], $_SESSION['captcha_num2'], $_SESSION['captcha_sum']);
        $_SESSION['captcha_num1'] = rand(1, 20);
        $_SESSION['captcha_num2'] = rand(1, 20);
        $_SESSION['captcha_sum'] = $_SESSION['captcha_num1'] + $_SESSION['captcha_num2'];
    }
}

include 'includes/header.php';
?>

<main>
<!-- Hero Section with Image -->
    <section class="hero hero-with-image">
        <!-- Hero Image: Replace 'images/hero-bg.svg' with your image path -->
        <img src="images/hero-bg.jpg" alt="Technology Background" class="hero-image">
        
        <!-- Overlay options: 'dark', 'light', or 'gradient-accent' -->
        <div class="hero-overlay gradient-accent"></div>
        
        <div class="hero-content">
            <div class="container">
                <h1>Contact Us</h1>
				<p>Contact us to discuss how we can best suit your needs</p>
            </div>
        </div>
    </section>

    <!-- Contact Information -->
    <section>
        <div class="container">
            <div class="grid">
                <div class="card">
                    <h3>Email</h3>
                    <p>contact@urqweb.com</p>
                    <p>admin@urquhartsystems.com</p>
                </div>
                <div class="card">
                    <h3>Phone</h3>
                    <p>Main: +1 (555) 123-4567</p>
                </div>
                <div class="card">
                    <h3>Location</h3>
                    <p>Based in Central Texas</p>
                </div>
                <div class="card">
                    <h3>Business Hours</h3>
                    <p>Monday - Friday: N/A AM - N/A PM</p>
                    <p>Weekend: N/A</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form -->
    <section style="background-color: var(--secondary-bg); border-top: 1px solid var(--border-color); border-bottom: 1px solid var(--border-color);">
       
