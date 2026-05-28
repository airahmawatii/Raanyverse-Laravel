@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-bold text-sm text-indigo-600 bg-indigo-50 border border-indigo-100 px-4 py-3 rounded-xl shadow-sm']) }}>
        {{ $status }}
    </div>
@endif
