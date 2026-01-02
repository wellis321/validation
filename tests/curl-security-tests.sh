#!/bin/bash
# Security Testing Script using cURL
# Tests security headers, config protection, and basic security measures
#
# Usage: ./curl-security-tests.sh https://your-site.com

if [ -z "$1" ]; then
    echo "Usage: $0 <site-url>"
    echo "Example: $0 https://simple-data-cleaner.com"
    exit 1
fi

SITE_URL="$1"
PASSED=0
FAILED=0
WARNINGS=0

echo "🔒 Security Testing: $SITE_URL"
echo "=================================="
echo ""

# Test 1: Check security headers
echo "Test 1: Security Headers"
HEADERS=$(curl -sI "$SITE_URL")
if echo "$HEADERS" | grep -qi "X-Frame-Options"; then
    echo "  ✅ X-Frame-Options: Present"
    ((PASSED++))
else
    echo "  ❌ X-Frame-Options: Missing"
    ((FAILED++))
fi

if echo "$HEADERS" | grep -qi "X-Content-Type-Options"; then
    echo "  ✅ X-Content-Type-Options: Present"
    ((PASSED++))
else
    echo "  ❌ X-Content-Type-Options: Missing"
    ((FAILED++))
fi

if echo "$HEADERS" | grep -qi "X-XSS-Protection"; then
    echo "  ✅ X-XSS-Protection: Present"
    ((PASSED++))
else
    echo "  ⚠️  X-XSS-Protection: Missing (may be deprecated)"
    ((WARNINGS++))
fi

if echo "$HEADERS" | grep -qi "Strict-Transport-Security"; then
    echo "  ✅ HSTS: Present"
    ((PASSED++))
else
    echo "  ⚠️  HSTS: Missing"
    ((WARNINGS++))
fi

echo ""

# Test 2: Check config file protection
echo "Test 2: Config File Protection"
CONFIG_STATUS=$(curl -s -o /dev/null -w "%{http_code}" "$SITE_URL/config/database.php")
if [ "$CONFIG_STATUS" = "403" ] || [ "$CONFIG_STATUS" = "404" ]; then
    echo "  ✅ Config files protected (HTTP $CONFIG_STATUS)"
    ((PASSED++))
else
    echo "  ❌ Config files may be accessible (HTTP $CONFIG_STATUS)"
    ((FAILED++))
fi

ENV_STATUS=$(curl -s -o /dev/null -w "%{http_code}" "$SITE_URL/.env")
if [ "$ENV_STATUS" = "403" ] || [ "$ENV_STATUS" = "404" ]; then
    echo "  ✅ .env file protected (HTTP $ENV_STATUS)"
    ((PASSED++))
else
    echo "  ❌ .env file may be accessible (HTTP $ENV_STATUS)"
    ((FAILED++))
fi

echo ""

# Test 3: Check HTTPS redirect
echo "Test 3: HTTPS Enforcement"
HTTP_URL=$(echo "$SITE_URL" | sed 's/https:/http:/')
HTTP_REDIRECT=$(curl -sI "$HTTP_URL" | head -n 1 | cut -d' ' -f2)
if [ "$HTTP_REDIRECT" = "301" ] || [ "$HTTP_REDIRECT" = "302" ]; then
    echo "  ✅ HTTP redirects to HTTPS"
    ((PASSED++))
else
    echo "  ⚠️  HTTP may not redirect to HTTPS"
    ((WARNINGS++))
fi

echo ""

# Test 4: Check WWW redirect
echo "Test 4: WWW Redirect"
if [[ "$SITE_URL" == *"://www."* ]]; then
    WWW_URL="$SITE_URL"
else
    WWW_URL=$(echo "$SITE_URL" | sed 's|://|://www.|')
fi
WWW_REDIRECT=$(curl -sI "$WWW_URL" 2>/dev/null | head -n 1 | cut -d' ' -f2)
if [ "$WWW_REDIRECT" = "301" ] || [ "$WWW_REDIRECT" = "302" ]; then
    echo "  ✅ WWW redirects to non-WWW"
    ((PASSED++))
else
    echo "  ⚠️  WWW redirect may not be configured"
    ((WARNINGS++))
fi

echo ""

# Test 5: Check 404 page
echo "Test 5: Custom 404 Page"
FOUR04_STATUS=$(curl -s -o /dev/null -w "%{http_code}" "$SITE_URL/nonexistent-page-12345")
if [ "$FOUR04_STATUS" = "404" ]; then
    echo "  ✅ 404 page returns correct status"
    ((PASSED++))
else
    echo "  ⚠️  404 page may not be configured (HTTP $FOUR04_STATUS)"
    ((WARNINGS++))
fi

echo ""

# Summary
echo "=================================="
echo "📊 Test Summary"
echo "  ✅ Passed: $PASSED"
echo "  ❌ Failed: $FAILED"
echo "  ⚠️  Warnings: $WARNINGS"
echo "  📝 Total: $((PASSED + FAILED + WARNINGS))"
echo ""

if [ $FAILED -eq 0 ]; then
    echo "✅ All critical tests passed!"
    exit 0
else
    echo "❌ Some tests failed. Please review the results above."
    exit 1
fi

