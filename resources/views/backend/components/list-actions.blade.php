@props([
    'module', // roles, users, lectures, materials
    'routePrefix', // backend.roles, backend.users etc.
    'data', // current row model
    'extra' => [], // optional extra actions
])

<div class="d-flex gap-2 align-items-center">

    {{-- ================== SHOW ================== --}}
    @can($module . '.view')
        <a href="{{ route($routePrefix . '.show', $data->id) }}" class="btn btn-info btn-sm d-flex align-items-center gap-1"
            title="View">
            <svg class="icon icon-sm">
                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-eye"></use>
            </svg>
            <span>Show</span>
        </a>
    @endcan


    {{-- ================== EDIT ================== --}}
    @can($module . '.edit')
        <a href="{{ route($routePrefix . '.edit', $data->id) }}"
            class="btn btn-warning btn-sm d-flex align-items-center gap-1" title="Edit">
            <svg class="icon icon-sm">
                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-pencil"></use>
            </svg>
            <span>Edit</span>
        </a>
    @endcan


    {{-- ================== EXTRA ACTIONS (ROLE PERMISSIONS ETC) ================== --}}
    @foreach ($extra as $action)
        @can($action['permission'])
            <a href="{{ route($action['route'], $data->id) }}"
                class="btn {{ $action['class'] ?? 'btn-secondary' }} btn-sm
                      d-flex align-items-center gap-1"
                title="{{ $action['label'] }}">
                <svg class="icon icon-sm">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#{{ $action['icon'] }}"></use>
                </svg>
                <span>{{ $action['label'] }}</span>
            </a>
        @endcan
    @endforeach


    {{-- ================== DELETE ================== --}}
    @can($module . '.delete')
        <form action="{{ route($routePrefix . '.destroy', $data->id) }}" method="POST"
            onsubmit="return confirm('Are you sure?')">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center gap-1" title="Delete">
                <svg class="icon icon-sm">
                    <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg') }}#cil-trash"></use>
                </svg>
                <span>Delete</span>
            </button>
        </form>
    @endcan

</div>
