<?php
require_once __DIR__ . '/includes/init.php';

$submitted = false;
$errors = [];
$auth = Auth::getInstance();
$user = $auth->getCurrentUser();

$defaultEmail = $user['email'] ?? '';

if (!empty($_SESSION['bespoke_enquiry_success'])) {
    $submitted = true;
    unset($_SESSION['bespoke_enquiry_success']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        validate_csrf();

        $contactName = trim($_POST['contact_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $company = trim($_POST['company'] ?? '');
        $role = trim($_POST['role'] ?? '');
        $issue = trim($_POST['issue'] ?? '');
        $currentFormat = trim($_POST['current_format'] ?? '');
        $desiredFormat = trim($_POST['desired_format'] ?? '');
        $dataSources = trim($_POST['data_sources'] ?? '');
        $dataVolume = trim($_POST['data_volume'] ?? '');
        $cleanFrequency = trim($_POST['clean_frequency'] ?? '');
        $timeline = trim($_POST['timeline'] ?? '');
        $needsAutomation = isset($_POST['needs_automation']);
        $compliance = trim($_POST['compliance'] ?? '');
        $additionalNotes = trim($_POST['additional_notes'] ?? '');

        if ($contactName === '') {
            $errors[] = 'Please tell us who we should speak to.';
        }

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please provide a valid email address so we can follow up.';
        }

        if ($issue === '') {
            $errors[] = 'Let us know what data challenge you need us to solve.';
        }

        if (empty($errors)) {
            $recipient = getenv('BESPOKE_EMAIL') ?: 'team@simple-data-cleaner.com';
            $subject = 'Bespoke data cleaning enquiry from ' . $contactName;

            $messageLines = [
                'New bespoke data cleaning enquiry via simple-data-cleaner.com',
                '-------------------------------------------------------------',
                'Contact name: ' . $contactName,
                'Email: ' . $email,
                'Company: ' . ($company !== '' ? $company : 'Not provided'),
                'Role / job title: ' . ($role !== '' ? $role : 'Not provided'),
                '',
                'Primary issue to solve:',
                $issue,
                '',
                'Current data format(s):',
                $currentFormat !== '' ? $currentFormat : 'Not provided',
                '',
                'Required output format(s):',
                $desiredFormat !== '' ? $desiredFormat : 'Not provided',
                '',
                'Where the data comes from:',
                $dataSources !== '' ? $dataSources : 'Not provided',
                '',
                'Approximate volume: ' . ($dataVolume !== '' ? $dataVolume : 'Not provided'),
                'Cleaning cadence: ' . ($cleanFrequency !== '' ? $cleanFrequency : 'Not provided'),
                'Target timeline: ' . ($timeline !== '' ? $timeline : 'Not provided'),
                'Interested in automation: ' . ($needsAutomation ? 'Yes' : 'No'),
                '',
                'Compliance / security considerations:',
                $compliance !== '' ? $compliance : 'Not provided',
                '',
                'Additional notes:',
                $additionalNotes !== '' ? $additionalNotes : 'Not provided',
            ];

            $fromAddress = getenv('MAIL_FROM_ADDRESS') ?: 'team@simple-data-cleaner.com';
            $fromName = getenv('MAIL_FROM_NAME') ?: 'Simple Data Cleaner';
            if ($fromName !== '') {
                $encodedFromName = function_exists('mb_encode_mimeheader')
                    ? mb_encode_mimeheader($fromName, 'UTF-8', 'B', "\r\n")
                    : $fromName;
                $fromHeader = $encodedFromName . ' <' . $fromAddress . '>';
            } else {
                $fromHeader = $fromAddress;
            }

            $headers = 'From: ' . $fromHeader . "\r\n" .
                'Reply-To: ' . $email . "\r\n" .
                'MIME-Version: 1.0' . "\r\n" .
                'Content-Type: text/plain; charset=UTF-8' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            $mailResult = @mail($recipient, $subject, implode("\n", $messageLines), $headers);
            if (!$mailResult) {
                error_log('Bespoke enquiry email could not be sent. Check mail() configuration.');
            }

            $_SESSION['bespoke_enquiry_success'] = true;
            header('Location: /bespoke.php#enquiry');
            exit;
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
    <link rel="canonical" href="https://simple-data-cleaner.com/bespoke.php">
    <title>Bespoke Data Cleaning - Simple Data Cleaner</title>
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon_io/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon_io/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicon_io/apple-touch-icon.png">
    <link rel="manifest" href="/assets/images/favicon_io/site.webmanifest">
    <link rel="stylesheet" href="/assets/css/output.css">
</head>
<body class="min-h-screen bg-slate-50">
    <?php include __DIR__ . '/includes/header.php'; ?>

    <main class="max-w-5xl mx-auto py-12 px-4">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
            <div class="bg-slate-900 text-white px-6 py-10" id="enquiry">
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-400/20 text-emerald-200 text-xs font-semibold uppercase tracking-wide">Enterprise & Bespoke</span>
                <h1 class="text-3xl sm:text-4xl font-bold mt-4">Tell us about the data you need cleaned</h1>
                <p class="text-slate-200 mt-4 text-base leading-relaxed">
                    We build custom, browser-based validators tailored to your internal data fields.
                    Share the essentials and we'll respond within one working day with next steps and any questions we need to scope the solution.
                </p>
            </div>

            <div class="px-6 py-8">
                <?php if ($submitted): ?>
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg mb-6">
                        Thanks for sharing the details. We'll review your requirements and get back to you shortly to scope the bespoke solution.
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

                <form method="POST" class="space-y-8">
                    <?php echo csrf_field(); ?>

                    <section class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="contact_name" class="block text-sm font-semibold text-gray-800">Contact name *</label>
                                <input type="text" id="contact_name" name="contact_name" required value="<?php echo htmlspecialchars($submitted ? '' : ($_POST['contact_name'] ?? ($user['name'] ?? ''))); ?>" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-800">Email address *</label>
                                <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($submitted ? '' : ($_POST['email'] ?? $defaultEmail)); ?>" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="company" class="block text-sm font-semibold text-gray-800">Company <span class="text-gray-400 font-normal">(optional)</span></label>
                                <input type="text" id="company" name="company" value="<?php echo htmlspecialchars($submitted ? '' : ($_POST['company'] ?? '')); ?>" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Organisation name or client you're supporting">
                            </div>
                            <div>
                                <label for="role" class="block text-sm font-semibold text-gray-800">Role / job title <span class="text-gray-400 font-normal">(optional)</span></label>
                                <input type="text" id="role" name="role" value="<?php echo htmlspecialchars($submitted ? '' : ($_POST['role'] ?? '')); ?>" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Operations manager, data analyst, CTO, etc.">
                            </div>
                        </div>

                        <div>
                            <label for="issue" class="block text-sm font-semibold text-gray-800">What do you need help with? *</label>
                            <textarea id="issue" name="issue" required rows="5" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Tell us about the data, the rules you need, or the workflow you're trying to support."><?php echo htmlspecialchars($submitted ? '' : ($_POST['issue'] ?? '')); ?></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="current_format" class="block text-sm font-semibold text-gray-800">Current format(s) <span class="text-gray-400 font-normal">(optional)</span></label>
                                <textarea id="current_format" name="current_format" rows="3" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="e.g. CSV exports from Salesforce, Excel spreadsheets, JSON API payloads"><?php echo htmlspecialchars($submitted ? '' : ($_POST['current_format'] ?? '')); ?></textarea>
                            </div>
                            <div>
                                <label for="desired_format" class="block text-sm font-semibold text-gray-800">Desired output format(s) <span class="text-gray-400 font-normal">(optional)</span></label>
                                <textarea id="desired_format" name="desired_format" rows="3" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="e.g. Clean CSV for upload, Excel template for finance, JSON for API ingestion"><?php echo htmlspecialchars($submitted ? '' : ($_POST['desired_format'] ?? '')); ?></textarea>
                            </div>
                        </div>

                        <div>
                            <label for="data_sources" class="block text-sm font-semibold text-gray-800">Where does the data originate? <span class="text-gray-400 font-normal">(optional)</span></label>
                            <textarea id="data_sources" name="data_sources" rows="3" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Line-of-business apps, internal databases, HR system, CRM exports, etc."><?php echo htmlspecialchars($submitted ? '' : ($_POST['data_sources'] ?? '')); ?></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="data_volume" class="block text-sm font-semibold text-gray-800">Approximate data volume <span class="text-gray-400 font-normal">(optional)</span></label>
                                <select id="data_volume" name="data_volume" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="" <?php echo ($submitted || empty($_POST['data_volume'])) ? 'selected' : ''; ?>>Select a range (optional)</option>
                                    <option value="Under 10,000 rows" <?php echo (!$submitted && ($_POST['data_volume'] ?? '') === 'Under 10,000 rows') ? 'selected' : ''; ?>>Under 10,000 rows</option>
                                    <option value="10,000 - 50,000 rows" <?php echo (!$submitted && ($_POST['data_volume'] ?? '') === '10,000 - 50,000 rows') ? 'selected' : ''; ?>>10,000 - 50,000 rows</option>
                                    <option value="50,000 - 250,000 rows" <?php echo (!$submitted && ($_POST['data_volume'] ?? '') === '50,000 - 250,000 rows') ? 'selected' : ''; ?>>50,000 - 250,000 rows</option>
                                    <option value="250,000 - 1 million rows" <?php echo (!$submitted && ($_POST['data_volume'] ?? '') === '250,000 - 1 million rows') ? 'selected' : ''; ?>>250,000 - 1 million rows</option>
                                    <option value="Over 1 million rows" <?php echo (!$submitted && ($_POST['data_volume'] ?? '') === 'Over 1 million rows') ? 'selected' : ''; ?>>Over 1 million rows</option>
                                </select>
                            </div>
                            <div>
                                <label for="clean_frequency" class="block text-sm font-semibold text-gray-800">How often do you need this cleaned? <span class="text-gray-400 font-normal">(optional)</span></label>
                                <select id="clean_frequency" name="clean_frequency" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="" <?php echo ($submitted || empty($_POST['clean_frequency'])) ? 'selected' : ''; ?>>Select cadence (optional)</option>
                                    <option value="One-off project" <?php echo (!$submitted && ($_POST['clean_frequency'] ?? '') === 'One-off project') ? 'selected' : ''; ?>>One-off project</option>
                                    <option value="Weekly" <?php echo (!$submitted && ($_POST['clean_frequency'] ?? '') === 'Weekly') ? 'selected' : ''; ?>>Weekly</option>
                                    <option value="Monthly" <?php echo (!$submitted && ($_POST['clean_frequency'] ?? '') === 'Monthly') ? 'selected' : ''; ?>>Monthly</option>
                                    <option value="Quarterly" <?php echo (!$submitted && ($_POST['clean_frequency'] ?? '') === 'Quarterly') ? 'selected' : ''; ?>>Quarterly</option>
                                    <option value="Ad-hoc / when-needed" <?php echo (!$submitted && ($_POST['clean_frequency'] ?? '') === 'Ad-hoc / when-needed') ? 'selected' : ''; ?>>Ad-hoc / when-needed</option>
                                </select>
                            </div>
                            <div>
                                <label for="timeline" class="block text-sm font-semibold text-gray-800">Target timeline <span class="text-gray-400 font-normal">(optional)</span></label>
                                <input type="text" id="timeline" name="timeline" value="<?php echo htmlspecialchars($submitted ? '' : ($_POST['timeline'] ?? '')); ?>" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="e.g. Need a prototype by end of month">
                            </div>
                            <div class="flex items-center gap-3 pt-6">
                                <input type="checkbox" id="needs_automation" name="needs_automation" class="h-4 w-4 text-blue-600 border-gray-300 rounded" <?php echo (!$submitted && !empty($_POST['needs_automation'])) ? 'checked' : ''; ?>>
                                <label for="needs_automation" class="text-sm text-gray-700">We're interested in automation or ongoing integration</label>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="compliance" class="block text-sm font-semibold text-gray-800">Compliance or security requirements <span class="text-gray-400 font-normal">(optional)</span></label>
                                <textarea id="compliance" name="compliance" rows="3" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="GDPR, ISO, data residency, security approvals, etc."><?php echo htmlspecialchars($submitted ? '' : ($_POST['compliance'] ?? '')); ?></textarea>
                            </div>
                            <div>
                                <label for="additional_notes" class="block text-sm font-semibold text-gray-800">Anything else we should know? <span class="text-gray-400 font-normal">(optional)</span></label>
                                <textarea id="additional_notes" name="additional_notes" rows="4" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Share example fields, success metrics, internal stakeholders, or anything that's top of mind."><?php echo htmlspecialchars($submitted ? '' : ($_POST['additional_notes'] ?? '')); ?></textarea>
                            </div>
                        </div>
                    </section>

                    <div class="flex flex-wrap items-center gap-4">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-semibold shadow-lg">
                            Submit bespoke enquiry
                        </button>
                        <a href="mailto:team@simple-data-cleaner.com" class="text-sm text-slate-600 hover:text-slate-900 transition-colors">
                            Prefer email? Drop us your requirements directly.
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
    <?php include __DIR__ . '/includes/cookie-banner.php'; ?>
</body>
</html>
