<!DOCTYPE html>
<html lang="en">
<head>
    <script>
        // CRITICAL: This must run FIRST, synchronously, before any other content
        // Check localStorage and write document immediately - no body should render
        const stored = localStorage.getItem('previewReport');
        const errorHtml = '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>No Report Available</title><style>body{font-family:system-ui,sans-serif;padding:40px;max-width:520px;margin:0 auto;}h1{font-size:1.5rem;margin-bottom:1rem;text-align:center;}p{color:#374151;line-height:1.6;}ol{color:#374151;line-height:1.8;margin:1rem 0;padding-left:1.5rem;}ol strong{color:#1f2937;}a{color:#2563eb;text-decoration:none;}a:hover{text-decoration:underline;}.links{margin-top:1.5rem;display:flex;flex-direction:column;gap:0.75rem;align-items:center;}.btn{display:inline-block;padding:0.5rem 1rem;background:#2563eb;color:white;border-radius:0.375rem;font-weight:500;}a.btn:hover{background:#1d4ed8;text-decoration:none;}.tip{margin-top:1rem;padding:0.75rem;background:#fef3c7;border-radius:0.375rem;font-size:0.875rem;color:#92400e;}</style></head><body><h1>No Report Available</h1><p>Generate the report from the app:</p><ol><li><a href="/index.php">Upload &amp; clean data</a> and upload your file.</li><li>Select columns, then click <strong>Clean My Data</strong>.</li><li>When results appear, open the <strong>Full Preview</strong> tab and click <strong>Open Full Preview Report</strong>.</li></ol><p>The report opens here when you click that button. Visiting this URL first will not show a report.</p><p class="tip">If you did that and still see this: use the same address for both (e.g. always <code>localhost:8000</code> or always <code>127.0.0.1:8000</code>) and ensure you clicked <strong>Open Full Preview Report</strong> after results loaded.</p><div class="links"><a href="/index.php" class="btn">Upload &amp; clean data</a><a href="/">Home</a></div></body></html>';
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
            try { window.opener.postMessage({ type: 'REPORT_PLEASE', reportKey: 'previewReport' }, window.location.origin); } catch (err) {}
        } else {
            document.open('text/html', 'replace');
            document.write(errorHtml);
            document.close();
        }
    </script>
</head>
<!-- Body intentionally left empty - script above handles everything -->
</html>
