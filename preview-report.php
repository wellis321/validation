<!DOCTYPE html>
<html lang="en">
<head>
    <script>
        // CRITICAL: This must run FIRST, synchronously, before any other content
        // Check localStorage and write document immediately - no body should render
        const stored = localStorage.getItem('previewReport');
        
        if (stored) {
            // Use document.write() but do it BEFORE body is parsed
            // This should work since we're in the head and body hasn't been parsed yet
            document.open('text/html', 'replace');
            document.write(stored);
            document.close();
        } else {
            // No stored report - show error message
            const errorHtml = '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>No Report Available</title></head><body><div style="font-family: sans-serif; padding: 40px; text-align: center;"><h1>No Report Available</h1><p>No preview report was found in storage.</p><p><a href="/">Home</a></p></div></body></html>';
            document.open('text/html', 'replace');
            document.write(errorHtml);
            document.close();
        }
    </script>
</head>
<!-- Body intentionally left empty - script above handles everything -->
</html>
