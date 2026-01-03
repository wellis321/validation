<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detailed Validation Issues Report</title>
</head>
<body>
    <script>
        // This page loads and displays the report from localStorage
        (function() {
            let currentReportId = null;

            function loadReport() {
                const stored = localStorage.getItem('detailedIssuesReport');
                const storedId = localStorage.getItem('detailedIssuesReportId');

                if (!stored) {
                    document.body.innerHTML = `
                        <div style="font-family: sans-serif; padding: 40px; text-align: center;">
                            <h1>No Report Available</h1>
                            <p>No validation report was found in storage.</p>
                            <p><a href="/">Return to Data Cleaner</a></p>
                        </div>
                    `;
                    return;
                }

                // Only reload if the report has actually changed
                if (currentReportId !== storedId) {
                    currentReportId = storedId;

                    // Replace current document with stored HTML
                    document.open('text/html', 'replace');
                    document.write(stored);
                    document.close();
                }
            }

            // Load the report initially
            loadReport();

            // Listen for storage events (when localStorage changes in another tab)
            window.addEventListener('storage', function(e) {
                // Check if the report was updated
                if (e.key === 'detailedIssuesReport' || e.key === 'detailedIssuesReportId') {
                    // Reload the report with the new data
                    loadReport();
                }
            });
        })();
    </script>
</body>
</html>
