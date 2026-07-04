@props(['active' => false, 'mobile' => false])

@if ($mobile)
    @php
        $classes = ($active ?? false)
            ? 'block px-3 py-2 rounded-lg text-sm font-medium bg-indigo-50 text-indigo-700'
            : 'block px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900';
    @endphp
@else
    @php
        $classes = ($active ?? false)
            ? 'px-3 py-2 rounded-lg text-sm font-medium bg-indigo-50 text-indigo-700'
            : 'px-3 py-2 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900';
    @endphp
@endif

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
