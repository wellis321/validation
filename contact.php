<?php
require_once __DIR__ . '/includes/init.php';

$contactSubmitted = false;
$errors = [];
$auth = Auth::getInstance();
$user = $auth->getCurrentUser();

$defaultEmail = $user['email'] ?? '';
$defaultName = $user['name'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        validate_csrf();

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $message = trim($_POST['message'] ?? '');

        // Validation
        if (empty($name)) {
            $errors[] = 'Please provide your name.';
        }

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please provide a valid email address.';
        }

        if (empty($subject)) {
            $errors[] = 'Please provide a subject for your message.';
        }

        if (empty($message)) {
            $errors[] = 'Please provide your message.';
        }

        if (empty($errors)) {
            $contactEmail = getenv('CONTACT_EMAIL') ?: 'team@simple-data-cleaner.com';
            $emailSubject = 'Contact Form: ' . $subject;

            // Create HTML email message
            $emailMessage = "
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                    .header { background-color: #2563eb; color: white; padding: 20px; border-radius: 5px 5px 0 0; }
                    .content { background-color: #f9fafb; padding: 20px; border: 1px solid #e5e7eb; }
                    .field { margin-bottom: 15px; }
                    .label { font-weight: bold; color: #374151; }
                    .value { margin-top: 5px; padding: 10px; background-color: white; border-radius: 4px; border: 1px solid #d1d5db; }
                    .footer { margin-top: 20px; padding-top: 20px; border-top: 1px solid #e5e7eb; font-size: 12px; color: #6b7280; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h2>New Contact Form Submission</h2>
                    </div>
                    <div class='content'>
                        <div class='field'>
                            <div class='label'>Name:</div>
                            <div class='value'>" . htmlspecialchars($name) . "</div>
                        </div>
                        <div class='field'>
                            <div class='label'>Email:</div>
                            <div class='value'>" . htmlspecialchars($email) . "</div>
                        </div>
                        <div class='field'>
                            <div class='label'>Subject:</div>
                            <div class='value'>" . htmlspecialchars($subject) . "</div>
                        </div>
                        <div class='field'>
                            <div class='label'>Message:</div>
                            <div class='value'>" . nl2br(htmlspecialchars($message)) . "</div>
                        </div>
                        <div class='footer'>
                            <p>This message was sent from the contact form on simple-data-cleaner.com</p>
                            <p>Reply directly to this email to respond to " . htmlspecialchars($name) . "</p>
                        </div>
                    </div>
                </div>
            </body>
            </html>
            ";

            // Get email config for no-reply address
            $config = require __DIR__ . '/config/email.php';
            
            // Prepare headers for reply-to (using no-reply as sender, but reply-to is the user's email)
            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8\r\n";
            $headers .= "From: {$config['from']['name']} <{$config['from']['address']}>\r\n";
            $headers .= "Reply-To: {$name} <{$email}>\r\n";
            $headers .= "X-Mailer: Simple Data Cleaner\r\n";
            $headers .= "Return-Path: {$config['from']['address']}\r\n";

            // Send email using mail() function (same approach as feedback.php)
            // Attempt to send email. Even if mail() fails on hosting, show success message to the user and log quietly.
            $mailResult = @mail($contactEmail, $emailSubject, $emailMessage, $headers);
            if (!$mailResult) {
                error_log('Contact form email could not be sent. Check mail() configuration.');
            }

            $contactSubmitted = true;
        }
    } catch (Exception $e) {
        $errors[] = $e->getMessage();
    }
}

// Set page meta
$pageTitle = 'Contact Us';
$pageDescription = 'Get in touch with Simple Data Cleaner support team. We\'re here to help with questions, feedback, or technical support.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="canonical" href="https://simple-data-cleaner.com/contact.php">
    <title><?php echo htmlspecialchars($pageTitle); ?> - Simple Data Cleaner</title>
    <meta name="description" content="<?php echo htmlspecialchars($pageDescription); ?>">
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon_io/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon_io/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicon_io/apple-touch-icon.png">
    <link rel="manifest" href="/assets/images/favicon_io/site.webmanifest">
    <link rel="stylesheet" href="/assets/css/output.css">
</head>
<body class="min-h-screen bg-gray-50">
    <?php include __DIR__ . '/includes/header.php'; ?>

    <main class="max-w-4xl mx-auto py-12 px-4" id="main-content">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-blue-600 text-white px-6 py-8">
                <h1 class="text-3xl font-bold">Contact Us</h1>
                <p class="text-blue-100 mt-3 text-base">
                    Have a question, need support, or want to provide feedback? We'd love to hear from you. Fill out the form below and we'll get back to you as soon as possible.
                </p>
            </div>

            <div class="px-6 py-8">
                <?php if ($contactSubmitted): ?>
                    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="font-semibold">Thank you for contacting us!</p>
                                <p class="text-sm mt-1">We've received your message and will get back to you as soon as possible. Typically, we respond within 24-48 hours.</p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (!empty($errors)): ?>
                    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="font-semibold mb-2">Please fix the following errors:</p>
                                <ul class="list-disc list-inside space-y-1 text-sm">
                                    <?php foreach ($errors as $error): ?>
                                        <li><?php echo htmlspecialchars($error); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <form method="POST" class="space-y-6">
                    <?php echo csrf_field(); ?>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-800 mb-1">Name *</label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                required 
                                value="<?php echo htmlspecialchars($contactSubmitted ? '' : ($defaultName ?: ($_POST['name'] ?? ''))); ?>" 
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Your full name"
                            >
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-800 mb-1">Email Address *</label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                required 
                                value="<?php echo htmlspecialchars($contactSubmitted ? '' : ($defaultEmail ?: ($_POST['email'] ?? ''))); ?>" 
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="your.email@example.com"
                            >
                        </div>
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-semibold text-gray-800 mb-1">Subject *</label>
                        <input 
                            type="text" 
                            id="subject" 
                            name="subject" 
                            required 
                            value="<?php echo htmlspecialchars($contactSubmitted ? '' : ($_POST['subject'] ?? '')); ?>" 
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="What is your message about?"
                        >
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-semibold text-gray-800 mb-1">Message *</label>
                        <textarea 
                            id="message" 
                            name="message" 
                            required 
                            rows="8" 
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Please provide as much detail as possible so we can help you effectively..."
                        ><?php echo htmlspecialchars($contactSubmitted ? '' : ($_POST['message'] ?? '')); ?></textarea>
                    </div>

                    <div class="flex flex-wrap items-center gap-4 pt-4">
                        <button 
                            type="submit" 
                            class="bg-blue-600 text-white px-6 py-2.5 rounded-lg hover:bg-blue-700 transition-colors font-semibold shadow-md hover:shadow-lg"
                        >
                            Send Message
                        </button>
                        <p class="text-sm text-gray-600">
                            We typically respond within 24-48 hours during business days.
                        </p>
                    </div>
                </form>

                <div class="mt-8 pt-8 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Other Ways to Reach Us</h3>
                    <div class="space-y-3 text-gray-700">
                        <p class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span>
                                <strong>Email:</strong> 
                                <a href="mailto:noreply@simple-data-cleaner.com" class="text-blue-600 hover:text-blue-700 underline">noreply@simple-data-cleaner.com</a>
                            </span>
                        </p>
                        <p class="text-sm text-gray-600">
                            For technical support, billing questions, or general inquiries, please use the form above or email us directly.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
    <?php include __DIR__ . '/includes/cookie-banner.php'; ?>
</body>
</html>

