<?php
/**
 * Find Care Scotland Pro bundle.
 *
 * A care provider on the Pro plan at findcarescotland.com gets Simple Data Cleaner included. This asks the directory whether an
 * email address has an active Pro listing, using a shared secret (HMAC) so only this app can ask. Nothing is stored here about
 * the provider beyond the answer, cached in the session for an hour; if the directory cannot be reached, the last answer from
 * the past day is used rather than locking someone out. Switched off unless FINDCARE_URL and FINDCARE_SHARED_SECRET are set.
 */
class Bundle
{
    private const FRESH = 3600;      // trust an answer for an hour
    private const STALE = 86400;     // use an old answer for up to a day if the directory is unreachable

    public static function enabled(): bool
    {
        return (string) getenv('FINDCARE_URL') !== '' && (string) getenv('FINDCARE_SHARED_SECRET') !== '';
    }

    /** True if this (verified) email has an active Pro listing on Find Care Scotland. */
    public static function proEntitlement(string $email): bool
    {
        $email = strtolower(trim($email));
        if ($email === '' || !self::enabled()) return false;

        $key = 'bundle_' . sha1($email);
        $cached = (session_status() === PHP_SESSION_ACTIVE) ? ($_SESSION[$key] ?? null) : null;
        if (is_array($cached) && time() - (int) $cached['t'] < self::FRESH) return (bool) $cached['v'];

        $answer = self::ask($email);
        if ($answer === null) {   // the directory did not answer: carry on with what we knew, if recent enough
            return (is_array($cached) && time() - (int) $cached['t'] < self::STALE) ? (bool) $cached['v'] : false;
        }
        if (session_status() === PHP_SESSION_ACTIVE) $_SESSION[$key] = ['t' => time(), 'v' => $answer];
        return $answer;
    }

    /** @return bool|null null when the directory could not be asked */
    private static function ask(string $email): ?bool
    {
        $ts  = time();
        $sig = hash_hmac('sha256', $email . '|' . $ts, (string) getenv('FINDCARE_SHARED_SECRET'));
        $url = rtrim((string) getenv('FINDCARE_URL'), '/') . '/api/sdc-entitlement?' . http_build_query(['email' => $email, 'ts' => $ts, 'sig' => $sig]);
        $body = false;
        if (function_exists('curl_init')) {
            $ch = curl_init($url);
            curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 3, CURLOPT_CONNECTTIMEOUT => 2, CURLOPT_FOLLOWLOCATION => false]);
            $body = curl_exec($ch);
            $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($code !== 200) $body = false;
        } else {
            $body = @file_get_contents($url, false, stream_context_create(['http' => ['timeout' => 3, 'ignore_errors' => false]]));
        }
        $d = is_string($body) ? json_decode($body, true) : null;
        return (is_array($d) && array_key_exists('pro', $d)) ? (bool) $d['pro'] : null;
    }
}
