<?php
require_once __DIR__ . '/includes/init.php';

$feedbackSubmitted = false;
$errors = [];
$auth = Auth::getInstance();
$user = $auth->getCurrentUser();

$defaultEmail = $user['email'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        validate_csrf();

        $email = trim($_POST['email'] ?? '');
        $experience = trim($_POST['experience'] ?? '');
        $wins = trim($_POST['wins'] ?? '');
        $frustrations = trim($_POST['frustrations'] ?? '');
        $validators = trim($_POST['validators'] ?? '');
        $wantsCall = isset($_POST['wants_call']) ? true : false;

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please provide a valid email address so we can follow up.';
        }

        if (empty($experience)) {
            $errors[] = 'Let us know how the beta is going so far.';
        }

        if (empty($errors)) {
            $feedbackEmail = getenv('FEEDBACK_EMAIL') ?: 'team@simple-data-cleaner.com';
            $subject = 'Beta Feedback from ' . $email;

            $messageLines = [
                'Beta feedback received via simple-data-cleaner.com',
                '--------------------------------------------------',
                'Email: ' . $email,
                'Wants follow-up call: ' . ($wantsCall ? 'Yes' : 'No'),
                '',
                'Overall experience:',
                $experience,
                '',
                'What worked well:',
                $wins ?: 'Not provided',
                '',
                'Pain points / blockers:',
                $frustrations ?: 'Not provided',
                '',
                'Custom validator requests / ideas:',
                $validators ?: 'Not provided',
            ];

            $headers = 'From: feedback@simple-data-cleaner.com' . "\r\n" .
                'Reply-To: ' . $email . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            // Attempt to send email. Even if mail() fails on hosting, show success message to the user and log quietly.
            $mailResult = @mail($feedbackEmail, $subject, implode("\n", $messageLines), $headers);
            if (!$mailResult) {
                error_log('Feedback email could not be sent. Check mail() configuration.');
            }

            $feedbackSubmitted = true;
        }
    } catch (Exception $e) {
        $errors[] = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="canonical" href="https://simple-data-cleaner.com/feedback.php">
    <title>Beta Feedback - Simple Data Cleaner</title>
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon_io/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon_io/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicon_io/apple-touch-icon.png">
    <link rel="manifest" href="/assets/images/favicon_io/site.webmanifest">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-50">
    <?php include __DIR__ . '/includes/header.php'; ?>

    <main class="max-w-4xl mx-auto py-12 px-4">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-slate-900 text-white px-6 py-8">
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-amber-400/20 text-amber-200 text-xs font-semibold uppercase tracking-wide">Beta</span>
                <h1 class="text-3xl font-bold mt-4">Tell us how the beta is going</h1>
                <p class="text-slate-200 mt-3 text-base">
                    We're offering a lifetime licence to today's validators while we're in beta. Your feedback helps us prioritise new data types, UX improvements, and enterprise features.
                </p>
            </div>

            <div class="px-6 py-8">
                <?php if ($feedbackSubmitted): ?>
                    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
                        Thanks for the insight! We'll review your feedback and be in touch if we need any extra detail.
                    </div>
                <?php endif; ?>

                <?php if (!empty($errors)): ?>
                    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6">
                        <ul class="list-disc list-inside space-y-1 text-sm">
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" class="space-y-6">
                    <?php echo csrf_field(); ?>
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-800">Email address</label>
                        <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($feedbackSubmitted ? '' : ($defaultEmail ?: ($_POST['email'] ?? ''))); ?>" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">We'll only use this to follow up about your beta feedback.</p>
                    </div>

                    <div>
                        <label for="experience" class="block text-sm font-semibold text-gray-800">Overall experience so far</label>
                        <textarea id="experience" name="experience" required rows="4" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="What feels great? What's confusing? What stopped you from cleaning data faster?"><?php echo htmlspecialchars($feedbackSubmitted ? '' : ($_POST['experience'] ?? '')); ?></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="wins" class="block text-sm font-semibold text-gray-800">What worked well?</label>
                            <textarea id="wins" name="wins" rows="4" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Speed? Accuracy? Something else you loved?"><?php echo htmlspecialchars($feedbackSubmitted ? '' : ($_POST['wins'] ?? '')); ?></textarea>
                        </div>
                        <div>
                            <label for="frustrations" class="block text-sm font-semibold text-gray-800">Any blockers or frustrations?</label>
                            <textarea id="frustrations" name="frustrations" rows="4" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Bug reports, missing validators, UX pain points---tell us everything."><?php echo htmlspecialchars($feedbackSubmitted ? '' : ($_POST['frustrations'] ?? '')); ?></textarea>
                        </div>
                    </div>

                    <div>
                        <label for="validators" class="block text-sm font-semibold text-gray-800">Need bespoke validators?</label>
                        <textarea id="validators" name="validators" rows="3" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Share internal field names (e.g. region_description, employee_number) so we can explore adding them."><?php echo htmlspecialchars($feedbackSubmitted ? '' : ($_POST['validators'] ?? '')); ?></textarea>
                    </div>

                    <div class="flex items-center gap-3">
                        <input type="checkbox" id="wants_call" name="wants_call" class="h-4 w-4 text-blue-600 border-gray-300 rounded" <?php echo (!empty($_POST['wants_call']) && !$feedbackSubmitted) ? 'checked' : ''; ?>>
                        <label for="wants_call" class="text-sm text-gray-700">I'd like to jump on a quick call to discuss my use case.</label>
                    </div>

                    <div class="flex flex-wrap items-center gap-4">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                            Submit feedback
                        </button>
                        <a href="mailto:team@simple-data-cleaner.com" class="text-sm text-slate-600 hover:text-slate-900">Prefer email? Drop us a note directly.</a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
    <?php include __DIR__ . '/includes/cookie-banner.php'; ?>
</body>
</html>
