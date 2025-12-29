@php
    /**
     * Common List Actions Blade
     * -------------------------
     * Variables expected:
     * $module      -> The permission name (e.g., 'users', 'roles')
     * $routePrefix -> The route prefix (e.g., 'backend.users', 'backend.roles')
     * $data        -> The model instance (e.g., $user)
     * $extra       -> (Optional) Raw HTML for extra buttons
     */
    $routePrefix = $routePrefix ?? $module;
@endphp

<div class="d-flex gap-2 align-items-center">

    {{-- VIEW / SHOW --}}
    @if (Route::has($routePrefix . '.show'))
        @can($module . '.view')
            <a href="{{ route($routePrefix . '.show', $data->id) }}"
                class="btn btn-info btn-sm text-white d-flex align-items-center gap-1" title="View">
                <svg class="icon icon-sm" width="16" height="16" style="fill: currentColor; vertical-align: middle;">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-notes"></use>
                </svg>
                <span>Show</span>
            </a>
        @endcan
    @endif

    {{-- EDIT --}}
    @if (Route::has($routePrefix . '.edit'))
        @can($module . '.edit')
            <a href="{{ route($routePrefix . '.edit', $data->id) }}"
                class="btn btn-primary btn-sm d-flex align-items-center gap-1" title="Edit">
                <svg class="icon icon-sm" width="16" height="16" style="fill: currentColor; vertical-align: middle;">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-pencil"></use>
                </svg>
                <span>Edit</span>
            </a>
        @endcan
    @endif

    {{-- SPECIAL CASE: ROLES PERMISSIONS --}}
    @if ($module == 'role' || $module == 'roles')
        @if (Route::has('backend.roles.permissions'))
            <a href="{{ route('backend.roles.permissions', $data->id) }}"
                class="btn btn-warning btn-sm d-flex align-items-center gap-1" title="Permissions">
                <svg class="icon icon-sm" width="16" height="16"
                    style="fill: currentColor; vertical-align: middle;">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-lock-locked"></use>
                </svg>
                <span>Permissions</span>
            </a>
        @endif
    @endif

    {{-- EXTRA ACTIONS SLOT --}}
    @if (isset($extra) && !empty($extra))
        {!! $extra !!}
    @endif

    {{-- DELETE --}}
    @if (Route::has($routePrefix . '.destroy'))
        @can($module . '.delete')
            <a href="javascript:;" data-url="{{ route($routePrefix . '.destroy', $data->id) }}"
                class="btn btn-danger btn-sm delete-btn d-flex align-items-center gap-1" title="Delete">
                <svg class="icon icon-sm" width="16" height="16" style="fill: currentColor; vertical-align: middle;">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-trash"></use>
                </svg>
                <span>Delete</span>
            </a>
        @endcan
    @endif

</div>
