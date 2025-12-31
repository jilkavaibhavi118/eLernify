<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccessCheck
{
    public function handle(Request $request, Closure $next, $type): Response
    {
        $id = $request->route('id');
        $user = auth()->user();

        // 1. Admin bypass
        if ($user && $user->hasRole('admin')) {
            return $next($request);
        }

        $item = null;
        switch ($type) {
            case 'course':
                $item = \App\Models\Course::find($id);
                if (!$item) return abort(404);
                if ($item->is_free) return $next($request);
                if ($user && ($user->hasPurchased('course', $id) || \App\Models\Enrollment::where('user_id', $user->id)->where('course_id', $id)->exists())) {
                    return $next($request);
                }
                break;

            case 'lecture':
                $item = \App\Models\Lecture::find($id);
                if (!$item) return abort(404);
                if ($item->is_free) return $next($request);

                $enrollment = $user ? \App\Models\Enrollment::where('user_id', $user->id)
                    ->where('course_id', $item->course_id)
                    ->first() : null;

                if ($enrollment) {
                    if ($enrollment->status === 'refunded') {
                        abort(403, 'This course is refunded, you cannot access this lecture.');
                    }
                    return $next($request);
                }

                if ($user && $user->hasPurchased('lecture', $id)) {
                    return $next($request);
                }
                break;

            case 'material':
                $item = \App\Models\Material::find($id);
                if (!$item) return abort(404);
                if ($item->is_free) return $next($request);
                if ($user && $user->hasPurchased('material', $id)) {
                    return $next($request);
                }
                // Check if material belongs to a lecture the user has access to
                if ($item->lecture_id) {
                    $lecture = \App\Models\Lecture::find($item->lecture_id);
                    if ($lecture && $user) {
                        if ($user->hasPurchased('lecture', $lecture->id)) return $next($request);
                        if (\App\Models\Enrollment::where('user_id', $user->id)->where('course_id', $lecture->course_id)->exists()) return $next($request);
                    }
                }
                break;

            case 'quiz':
                $item = \App\Models\Quiz::find($id);
                if (!$item) return abort(404);
                if ($item->is_free) return $next($request);
                if ($user && $user->hasPurchased('quiz', $id)) {
                    return $next($request);
                }
                if ($item->lecture_id) {
                    $lecture = \App\Models\Lecture::find($item->lecture_id);
                    if ($lecture && $user) {
                        if ($user->hasPurchased('lecture', $lecture->id)) return $next($request);
                        if (\App\Models\Enrollment::where('user_id', $user->id)->where('course_id', $lecture->course_id)->exists()) return $next($request);
                    }
                }
                break;
        }

        if (!$user) {
            return redirect()->route('login')->with('info', 'Please login to access this content.');
        }

        return redirect()->route('landing')->with('error', 'You do not have access to this content. Please purchase it first.');
    }
}
