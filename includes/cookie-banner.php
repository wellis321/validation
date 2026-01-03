<!-- Cookie Consent Banner -->
<div id="cookieBanner" class="hidden fixed bottom-0 left-0 right-0 bg-gray-900 text-white p-4 z-50 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex-1">
                <p class="text-sm">
                    We use cookies to improve your experience and analyze site usage. 
                    Your data processing remains 100% private in your browser.
                    <a href="/privacy.php" class="underline hover:text-blue-300">Learn more about our privacy policy</a>
                </p>
            </div>
            <div class="flex space-x-4">
                <button id="acceptCookies" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors text-sm font-medium">
                    Accept
                </button>
                <button id="declineCookies" class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition-colors text-sm font-medium">
                    Decline
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Cookie Consent Logic
(function() {
    const COOKIE_CONSENT_KEY = 'cookie_consent';
    const COOKIE_EXPIRY_DAYS = 365;

    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }

    function setCookie(name, value, days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        document.cookie = `${name}=${value};expires=${date.toUTCString()};path=/`;
    }

    function showBanner() {
        const banner = document.getElementById('cookieBanner');
        if (banner) banner.classList.remove('hidden');
    }

    function hideBanner() {
        const banner = document.getElementById('cookieBanner');
        if (banner) banner.classList.add('hidden');
    }

    function acceptCookies() {
        setCookie(COOKIE_CONSENT_KEY, 'accepted', COOKIE_EXPIRY_DAYS);
        hideBanner();
        // Dispatch event for analytics to listen to
        window.dispatchEvent(new CustomEvent('cookieConsentChanged', { detail: 'accepted' }));
    }

    function declineCookies() {
        setCookie(COOKIE_CONSENT_KEY, 'declined', COOKIE_EXPIRY_DAYS);
        hideBanner();
        // Dispatch event for analytics to listen to
        window.dispatchEvent(new CustomEvent('cookieConsentChanged', { detail: 'declined' }));
    }

    // Check if user has already made a choice
    const consent = getCookie(COOKIE_CONSENT_KEY);
    if (!consent) {
        // Show banner after page load
        setTimeout(showBanner, 500);
    }

    // Add event listeners
    const acceptBtn = document.getElementById('acceptCookies');
    const declineBtn = document.getElementById('declineCookies');

    if (acceptBtn) acceptBtn.addEventListener('click', acceptCookies);
    if (declineBtn) declineBtn.addEventListener('click', declineCookies);
})();
</script>
