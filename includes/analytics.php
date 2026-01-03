<?php
/**
 * Google Analytics 4 Integration
 * Only loads if user has accepted cookies
 * 
 * To set up:
 * 1. Create a GA4 property in Google Analytics
 * 2. Get your Measurement ID (format: G-XXXXXXXXXX)
 * 3. Add it to your .env file: GA4_MEASUREMENT_ID=G-XXXXXXXXXX
 * 4. Or set it directly below (for testing)
 */

// Get GA4 Measurement ID from environment or config
$ga4MeasurementId = getenv('GA4_MEASUREMENT_ID') ?: 'G-ST8EVR3BBJ';
// If you want to use .env instead, add: GA4_MEASUREMENT_ID=G-ST8EVR3BBJ

// Only output analytics if ID is configured
if (!empty($ga4MeasurementId)) {
?>
<!-- Google Analytics 4 - Only loads if cookies accepted -->
<script>
(function() {
    // Check if user has accepted cookies
    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }
    
    const cookieConsent = getCookie('cookie_consent');
    
    // Only load GA4 if user has accepted cookies
    if (cookieConsent === 'accepted') {
        // Google Analytics 4
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '<?php echo htmlspecialchars($ga4MeasurementId); ?>', {
            'anonymize_ip': true // GDPR compliance
            // Let GA4 manage its own cookie expiration automatically
        });
        
        // Load the GA4 script
        const script = document.createElement('script');
        script.async = true;
        script.src = 'https://www.googletagmanager.com/gtag/js?id=<?php echo htmlspecialchars($ga4MeasurementId); ?>';
        document.head.appendChild(script);
    }
    
    // Listen for cookie consent changes
    window.addEventListener('cookieConsentChanged', function(e) {
        if (e.detail === 'accepted' && !window.dataLayer) {
            // Reload page to initialize GA4
            window.location.reload();
        }
    });
})();
</script>
<?php
}
?>

