<?php

namespace App\Http\Middleware;

use Closure;
use HTMLPurifier;
use HTMLPurifier_Config;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SanitizeInput
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $sanitized = $this->sanitize($request->all());
        $request->merge($sanitized);

        return $next($request);
    }

    /**
     * Sanitize input data.
     *
     * @param  array  $input
     * @return array
     */
    protected function sanitize(array $input)
    {
        $config = HTMLPurifier_Config::createDefault();
        $config->set('HTML.Allowed', 'b,i,em,strong,a[href],p');
        $purifier = new HTMLPurifier($config);

        $sanitized = array_map(function ($value) use ($purifier) {
            if (is_string($value)) {
                // return trim(htmlspecialchars($value, ENT_QUOTES, 'UTF-8'));
                return $purifier->purify($value);
            }
    
            if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
                // Sanitize email
                return filter_var($value, FILTER_SANITIZE_EMAIL);
            }
    
            if (filter_var($value, FILTER_VALIDATE_URL)) {
                // Sanitize URL
                return filter_var($value, FILTER_SANITIZE_URL);
            }
    
            if (is_numeric($value)) {
                // Sanitize numeric values
                return filter_var($value, FILTER_SANITIZE_NUMBER_INT);
            }
    
            if (is_array($value)) {
                return $this->sanitize($value);
            }
    
            return $value;
        }, $input);
    
        return $sanitized;
    }
}
