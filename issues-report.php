<!DOCTYPE html>
<html lang="en">
<head>
    <script>
        // CRITICAL: This must run FIRST, synchronously, before any other content
        // Check localStorage and write document immediately - no body should render
        const stored = localStorage.getItem('detailedIssuesReport');
        const errorHtml = '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>No Report Available</title><style>body{font-family:system-ui,sans-serif;padding:40px;text-align:center;max-width:480px;margin:0 auto;}h1{font-size:1.5rem;margin-bottom:1rem;}p{color:#374151;line-height:1.6;}a{color:#2563eb;text-decoration:none;}a:hover{text-decoration:underline;}.links{margin-top:1.5rem;display:flex;flex-direction:column;gap:0.75rem;align-items:center;}</style></head><body><h1>No Report Available</h1><p>This page shows an issues report after you clean data in the app. Upload a file, run &ldquo;Clean My Data&rdquo;, then click <strong>Issues report</strong> on the results page to open the report here.</p><div class="links"><a href="/">Home</a><a href="/index.php">Upload &amp; clean data</a></div></body></html>';
        if (stored) {
            document.open('text/html', 'replace');
            document.write(stored);
            document.close();
        } else if (window.opener && !window.opener.closed) {
            var gotReport = false;
            var timeoutId = setTimeout(function() {
                if (gotReport) return;
                gotReport = true;
                document.open('text/html', 'replace');
                document.write(errorHtml);
                document.close();
            }, 500);
            function onMsg(e) {
                if (e.origin !== window.location.origin || !e.data || e.data.type !== 'REPORT_DATA' || !e.data.html) return;
                if (gotReport) return;
                gotReport = true;
                clearTimeout(timeoutId);
                window.removeEventListener('message', onMsg);
                document.open('text/html', 'replace');
                document.write(e.data.html);
                document.close();
            }
            window.addEventListener('message', onMsg);
            try { window.opener.postMessage({ type: 'REPORT_PLEASE', reportKey: 'detailedIssuesReport' }, window.location.origin); } catch (err) {}
        } else {
            document.open('text/html', 'replace');
            document.write(errorHtml);
            document.close();
        }
    </script>
</head>
<!-- Body intentionally left empty - script above handles everything -->
</html>
