<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('userIsActive')) {
    /**
     * Check if authenticated user is active
     *
     * @return bool
     */
    function userIsActive(): bool
    {
        return Auth::check() && Auth::user()->status === 'active';
    }
}

if (!function_exists('currentUser')) {
    /**
     * Get currently authenticated user
     *
     * @return \App\Models\User|null
     */
    function currentUser()
    {
        return Auth::user();
    }
}

if (!function_exists('isAdmin')) {
    /**
     * Check if current user is admin
     *
     * @return bool
     */
    function isAdmin(): bool
    {
        if (!Auth::check()) {
            return false;
        }

        // Spatie permission support
        return Auth::user()->hasRole('admin');
    }
}

if (!function_exists('formatCurrency')) {
    /**
     * Format amount as INR
     *
     * @param float|int $amount
     * @return string
     */
    function formatCurrency($amount): string
    {
        return '₹' . number_format((float) $amount, 2);
    }
}

if (!function_exists('statusBadge')) {
    /**
     * Return HTML badge for status
     *
     * @param string $status
     * @return string
     */
    function statusBadge(string $status): string
    {
        return match ($status) {
            'active'   => '<span class="badge bg-success">Active</span>',
            'inactive' => '<span class="badge bg-danger">Inactive</span>',
            'blocked'  => '<span class="badge bg-dark">Blocked</span>',
            default    => '<span class="badge bg-secondary">Unknown</span>',
        };
    }
}

if (!function_exists('abortIfInactive')) {
    /**
     * Abort request if user is inactive
     *
     * @return void
     */
    function abortIfInactive(): void
    {
        if (!userIsActive()) {
            abort(403, 'Your account is disabled. Please contact support.');
        }
    }
}
