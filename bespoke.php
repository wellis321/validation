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

        // Rate limit form submissions (5 per hour per IP)
        $security->rateLimit($_SERVER['REMOTE_ADDR'], 'bespoke-enquiry', 5, 3600);

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
<body class="min-h-screen bg-neutral-950 text-neutral-100">
    <?php include __DIR__ . '/includes/header.php'; ?>

    <main id="main-content" class="max-w-4xl mx-auto px-4 py-8 md:py-12 mt-8">
        <div class="bg-neutral-900 rounded-xl shadow-lg border border-neutral-700 p-8">
            <h2 class="text-2xl font-bold text-center text-white mb-2">Tell us about the data you need cleaned</h2>
            <p class="text-center text-neutral-400 mb-8 flex items-center justify-center">
                <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                We build custom validators tailored to your data — 100% browser-based & private
            </p>

            <!-- Form in example-style dashed zone -->
            <div class="border-2 border-dashed border-neutral-500 rounded-2xl p-8 md:p-10 lg:p-12 bg-yellow-500/[0.04] hover:bg-yellow-500/[0.06] hover:border-yellow-500/60 transition-all duration-300" id="enquiry">
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full ring-2 ring-yellow-500/25 ring-offset-4 ring-offset-neutral-900 mb-4">
                        <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <p class="text-base text-neutral-400">Share the essentials and we'll respond within one working day.</p>
                </div>
                <?php if ($submitted): ?>
                    <div class="bespoke-success-message flex items-start gap-3 bg-green-500/10 border border-green-500/30 text-green-200 px-5 py-4 rounded-xl mb-6">
                        <svg class="w-5 h-5 shrink-0 mt-0.5 text-green-400" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-base font-medium">Thanks for sharing the details. We'll review your requirements and get back to you shortly to scope the bespoke solution.</p>
                    </div>
                <?php endif; ?>

                <?php if (!empty($errors)): ?>
                    <div class="bg-red-500/10 border border-red-500/30 text-red-200 px-4 py-3 rounded-lg mb-6">
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
                            <div class="bespoke-field">
                                <label for="contact_name" class="ds-input-bold-label">Contact name *</label>
                                <input type="text" id="contact_name" name="contact_name" required value="<?php echo htmlspecialchars($submitted ? '' : ($_POST['contact_name'] ?? ($user['name'] ?? ''))); ?>" class="ds-input-bold">
                            </div>
                            <div class="bespoke-field">
                                <label for="email" class="ds-input-bold-label">Email address *</label>
                                <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($submitted ? '' : ($_POST['email'] ?? $defaultEmail)); ?>" class="ds-input-bold">
                            </div>
                            <div class="bespoke-field">
                                <label for="company" class="ds-input-bold-label">Company <span class="optional">(optional)</span></label>
                                <input type="text" id="company" name="company" value="<?php echo htmlspecialchars($submitted ? '' : ($_POST['company'] ?? '')); ?>" class="ds-input-bold" placeholder="Organisation name or client you're supporting">
                            </div>
                            <div class="bespoke-field">
                                <label for="role" class="ds-input-bold-label">Role / job title <span class="optional">(optional)</span></label>
                                <input type="text" id="role" name="role" value="<?php echo htmlspecialchars($submitted ? '' : ($_POST['role'] ?? '')); ?>" class="ds-input-bold" placeholder="Operations manager, data analyst, CTO, etc.">
                            </div>
                        </div>

                        <div class="bespoke-field">
                            <label for="issue" class="ds-input-bold-label">What do you need help with? *</label>
                            <textarea id="issue" name="issue" required rows="5" class="ds-input-bold resize-y min-h-[140px]" placeholder="Tell us about the data, the rules you need, or the workflow you're trying to support."><?php echo htmlspecialchars($submitted ? '' : ($_POST['issue'] ?? '')); ?></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bespoke-field">
                                <label for="current_format" class="ds-input-bold-label">Current format(s) <span class="optional">(optional)</span></label>
                                <textarea id="current_format" name="current_format" rows="3" class="ds-input-bold resize-y min-h-[100px]" placeholder="e.g. CSV exports from Salesforce, Excel spreadsheets, JSON API payloads"><?php echo htmlspecialchars($submitted ? '' : ($_POST['current_format'] ?? '')); ?></textarea>
                            </div>
                            <div class="bespoke-field">
                                <label for="desired_format" class="ds-input-bold-label">Desired output format(s) <span class="optional">(optional)</span></label>
                                <textarea id="desired_format" name="desired_format" rows="3" class="ds-input-bold resize-y min-h-[100px]" placeholder="e.g. Clean CSV for upload, Excel template for finance, JSON for API ingestion"><?php echo htmlspecialchars($submitted ? '' : ($_POST['desired_format'] ?? '')); ?></textarea>
                            </div>
                        </div>

                        <div class="bespoke-field">
                            <label for="data_sources" class="ds-input-bold-label">Where does the data originate? <span class="optional">(optional)</span></label>
                            <textarea id="data_sources" name="data_sources" rows="3" class="ds-input-bold resize-y min-h-[100px]" placeholder="Line-of-business apps, internal databases, HR system, CRM exports, etc."><?php echo htmlspecialchars($submitted ? '' : ($_POST['data_sources'] ?? '')); ?></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bespoke-field">
                                <label for="data_volume" class="ds-input-bold-label">Approximate data volume <span class="optional">(optional)</span></label>
                                <select id="data_volume" name="data_volume" class="ds-input-bold cursor-pointer appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 fill=%27none%27 viewBox=%270 0 24 24%27 stroke=%27%23a3a3a3%27%3E%3Cpath stroke-linecap=%27round%27 stroke-linejoin=%27round%27 stroke-width=%272%27 d=%27M19 9l-7 7-7-7%27/%3E%3C/svg%3E')] bg-[length:1.25rem_1.25rem] bg-[right_0.75rem_center] bg-no-repeat pr-10">
                                    <option value="" <?php echo ($submitted || empty($_POST['data_volume'])) ? 'selected' : ''; ?>>Select a range (optional)</option>
                                    <option value="Under 10,000 rows" <?php echo (!$submitted && ($_POST['data_volume'] ?? '') === 'Under 10,000 rows') ? 'selected' : ''; ?>>Under 10,000 rows</option>
                                    <option value="10,000 - 50,000 rows" <?php echo (!$submitted && ($_POST['data_volume'] ?? '') === '10,000 - 50,000 rows') ? 'selected' : ''; ?>>10,000 - 50,000 rows</option>
                                    <option value="50,000 - 250,000 rows" <?php echo (!$submitted && ($_POST['data_volume'] ?? '') === '50,000 - 250,000 rows') ? 'selected' : ''; ?>>50,000 - 250,000 rows</option>
                                    <option value="250,000 - 1 million rows" <?php echo (!$submitted && ($_POST['data_volume'] ?? '') === '250,000 - 1 million rows') ? 'selected' : ''; ?>>250,000 - 1 million rows</option>
                                    <option value="Over 1 million rows" <?php echo (!$submitted && ($_POST['data_volume'] ?? '') === 'Over 1 million rows') ? 'selected' : ''; ?>>Over 1 million rows</option>
                                </select>
                            </div>
                            <div class="bespoke-field">
                                <label for="clean_frequency" class="ds-input-bold-label">How often do you need this cleaned? <span class="optional">(optional)</span></label>
                                <select id="clean_frequency" name="clean_frequency" class="ds-input-bold cursor-pointer appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 fill=%27none%27 viewBox=%270 0 24 24%27 stroke=%27%23a3a3a3%27%3E%3Cpath stroke-linecap=%27round%27 stroke-linejoin=%27round%27 stroke-width=%272%27 d=%27M19 9l-7 7-7-7%27/%3E%3C/svg%3E')] bg-[length:1.25rem_1.25rem] bg-[right_0.75rem_center] bg-no-repeat pr-10">
                                    <option value="" <?php echo ($submitted || empty($_POST['clean_frequency'])) ? 'selected' : ''; ?>>Select cadence (optional)</option>
                                    <option value="One-off project" <?php echo (!$submitted && ($_POST['clean_frequency'] ?? '') === 'One-off project') ? 'selected' : ''; ?>>One-off project</option>
                                    <option value="Weekly" <?php echo (!$submitted && ($_POST['clean_frequency'] ?? '') === 'Weekly') ? 'selected' : ''; ?>>Weekly</option>
                                    <option value="Monthly" <?php echo (!$submitted && ($_POST['clean_frequency'] ?? '') === 'Monthly') ? 'selected' : ''; ?>>Monthly</option>
                                    <option value="Quarterly" <?php echo (!$submitted && ($_POST['clean_frequency'] ?? '') === 'Quarterly') ? 'selected' : ''; ?>>Quarterly</option>
                                    <option value="Ad-hoc / when-needed" <?php echo (!$submitted && ($_POST['clean_frequency'] ?? '') === 'Ad-hoc / when-needed') ? 'selected' : ''; ?>>Ad-hoc / when-needed</option>
                                </select>
                            </div>
                            <div class="bespoke-field">
                                <label for="timeline" class="ds-input-bold-label">Target timeline <span class="optional">(optional)</span></label>
                                <input type="text" id="timeline" name="timeline" value="<?php echo htmlspecialchars($submitted ? '' : ($_POST['timeline'] ?? '')); ?>" class="ds-input-bold" placeholder="e.g. Need a prototype by end of month">
                            </div>
                            <div class="flex items-center gap-4 pt-6">
                                <input type="checkbox" id="needs_automation" name="needs_automation" class="bespoke-checkbox h-5 w-5 shrink-0 rounded border-2 border-neutral-600 bg-neutral-800 text-yellow-500 focus:border-yellow-500 focus:outline-none focus:ring-4 focus:ring-yellow-500/20 accent-yellow-500" <?php echo (!$submitted && !empty($_POST['needs_automation'])) ? 'checked' : ''; ?>>
                                <label for="needs_automation" class="text-base font-semibold text-neutral-200 cursor-pointer">We're interested in automation or ongoing integration</label>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bespoke-field">
                                <label for="compliance" class="ds-input-bold-label">Compliance or security requirements <span class="optional">(optional)</span></label>
                                <textarea id="compliance" name="compliance" rows="3" class="ds-input-bold resize-y min-h-[100px]" placeholder="GDPR, ISO, data residency, security approvals, etc."><?php echo htmlspecialchars($submitted ? '' : ($_POST['compliance'] ?? '')); ?></textarea>
                            </div>
                            <div class="bespoke-field">
                                <label for="additional_notes" class="ds-input-bold-label">Anything else we should know? <span class="optional">(optional)</span></label>
                                <textarea id="additional_notes" name="additional_notes" rows="4" class="ds-input-bold resize-y min-h-[120px]" placeholder="Share example fields, success metrics, internal stakeholders, or anything that's top of mind."><?php echo htmlspecialchars($submitted ? '' : ($_POST['additional_notes'] ?? '')); ?></textarea>
                            </div>
                        </div>
                    </section>

                    <div class="flex flex-wrap items-center gap-4">
                        <button type="submit" class="bespoke-submit-btn ds-btn-primary px-6 py-3 rounded-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2 focus-visible:ring-offset-neutral-900">
                            Submit bespoke enquiry
                        </button>
                        <a href="mailto:team@simple-data-cleaner.com" class="bespoke-email-link focus:outline-none focus-visible:ring-2 focus-visible:ring-yellow-500 focus-visible:ring-offset-2 focus-visible:ring-offset-neutral-900 rounded px-1 -mx-1" aria-label="Send your requirements by email">
                            Prefer email? Drop us your requirements directly.
                            <span class="bespoke-email-arrow inline-block" aria-hidden="true">→</span>
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
