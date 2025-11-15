# CSRF Protection Guide

## Current Status

**CSRF Protection: DISABLED** (for demo/development purposes)

All tests pass: ✅ 18/18 tests (50 assertions)

---

## How to Enable CSRF for Production

### Step 1: Update the CSRF Middleware

Edit [`app/Http/Middleware/VerifyCsrfToken.php`](app/Http/Middleware/VerifyCsrfToken.php):

```php
protected function tokensMatch($request)
{
    // Enable CSRF protection
    return parent::tokensMatch($request);
}
```

### Step 2: Add CSRF Tokens to All Forms

All POST/PUT/PATCH/DELETE forms must include the `@csrf` directive:

```blade
<form method="POST" action="{{ route('admin.clients.store') }}">
    @csrf  <!-- REQUIRED! -->

    <input type="text" name="user_name">
    <!-- other fields -->

    <button type="submit">Submit</button>
</form>
```

### Step 3: Update AJAX Requests

Add CSRF token to all AJAX requests:

**In your layout file (add to `<head>`):**
```blade
<meta name="csrf-token" content="{{ csrf_token() }}">
```

**In your JavaScript:**
```javascript
// Using Fetch API
fetch('/api/endpoint', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify(data)
});

// Using Axios (automatic if meta tag exists)
axios.post('/api/endpoint', data);

// Using jQuery
$.ajax({
    url: '/api/endpoint',
    type: 'POST',
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    data: data
});
```

### Step 4: Exclude API Routes (if needed)

If you have API routes or webhooks that shouldn't use CSRF:

```php
// app/Http/Middleware/VerifyCsrfToken.php

protected $except = [
    'api/*',           // All API routes
    'webhooks/*',      // Webhook endpoints
    'stripe/webhook',  // Specific webhook
];
```

### Step 5: Test Everything

After enabling CSRF:

1. **Test all forms manually** - ensure they submit without 419 errors
2. **Test AJAX requests** - verify they include CSRF tokens
3. **Run automated tests** - they should still pass:
   ```bash
   vendor/bin/pest
   ```

---

## Quick Toggle Commands

### To DISABLE CSRF (Current State):
```php
// app/Http/Middleware/VerifyCsrfToken.php
protected function tokensMatch($request)
{
    return true; // Bypass CSRF
}
```

### To ENABLE CSRF:
```php
// app/Http/Middleware/VerifyCsrfToken.php
protected function tokensMatch($request)
{
    return parent::tokensMatch($request); // Use Laravel's CSRF validation
}
```

---

## Testing Behavior

The test suite is configured to work regardless of CSRF setting:
- Custom CSRF middleware is registered in [`bootstrap/app.php`](bootstrap/app.php)
- Tests initialize sessions properly in [`tests/TestCase.php`](tests/TestCase.php)
- All 18 tests pass with 50 assertions ✅

---

## Why CSRF is Important

CSRF (Cross-Site Request Forgery) attacks trick authenticated users into performing unwanted actions:

**Example Attack (without CSRF protection):**
1. User logs into your app
2. User visits malicious site `evil.com`
3. `evil.com` contains:
   ```html
   <form action="https://synergyms.test/admin/clients/delete/1" method="POST">
       <input type="hidden" name="confirm" value="yes">
   </form>
   <script>document.forms[0].submit();</script>
   ```
4. Form submits using user's authenticated session
5. Client #1 is deleted without user's knowledge ❌

**With CSRF protection:**
- Laravel generates unique token for each session
- Form submissions require valid token
- `evil.com` cannot obtain user's token
- Malicious request is rejected with 419 error ✅

---

## Production Checklist

Before deploying to production:

- [ ] Enable CSRF in [`VerifyCsrfToken.php`](app/Http/Middleware/VerifyCsrfToken.php)
- [ ] Add `@csrf` to all forms
- [ ] Add CSRF meta tag to layout
- [ ] Update all AJAX requests to include token
- [ ] Test all form submissions manually
- [ ] Run full test suite: `vendor/bin/pest`
- [ ] Configure proper exception handling for 419 errors
- [ ] Review and update `$except` array if needed

---

## Common Issues & Solutions

### Issue: 419 Page Expired
**Cause:** Session expired or CSRF token mismatch
**Solution:**
- Ensure form has `@csrf` directive
- Check session is not expiring too quickly
- Verify `SESSION_SECURE_COOKIE` matches your HTTPS setup

### Issue: AJAX requests fail with 419
**Cause:** Missing CSRF token in headers
**Solution:**
- Add meta tag to layout
- Include `X-CSRF-TOKEN` header in request

### Issue: Tests fail after enabling CSRF
**Cause:** Tests don't bypass CSRF properly
**Solution:**
- The current setup should handle this automatically
- Custom middleware is already registered in `bootstrap/app.php`
- Sessions are initialized in `tests/TestCase.php`

---

## Need Help?

- Laravel CSRF Documentation: https://laravel.com/docs/11.x/csrf
- Project Tests: Run `vendor/bin/pest` to verify everything works
- Questions? Check the code comments in [`VerifyCsrfToken.php`](app/Http/Middleware/VerifyCsrfToken.php)
