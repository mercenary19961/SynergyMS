<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        // Add any API routes or webhooks that shouldn't use CSRF
        // Example: 'api/*', 'webhooks/*'
    ];

    /**
     * Determine if the CSRF token should be added to the response.
     *
     * @return bool
     */
    public function shouldAddXsrfTokenCookie()
    {
        return false;
    }

    /**
     * Determine if the session and input CSRF tokens match.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function tokensMatch($request)
    {
        // CSRF is currently DISABLED for development/testing
        //
        // To enable CSRF for production:
        // Replace the line below with: return parent::tokensMatch($request);
        // Then ensure all forms have @csrf directive
        return true;
    }
}
