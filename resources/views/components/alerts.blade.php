@props(['type' => 'info', 'message', 'dismissible' => true])

@php
$colorClasses = [
    'success' => 'bg-green-100 border-green-400 text-green-700',
    'error' => 'bg-red-100 border-red-400 text-red-700',
    'warning' => 'bg-yellow-100 border-yellow-400 text-yellow-700',
    'info' => 'bg-blue-100 border-blue-400 text-blue-700',
];

$iconClasses = [
    'success' => 'fas fa-check-circle text-green-600',
    'error' => 'fas fa-exclamation-circle text-red-600',
    'warning' => 'fas fa-exclamation-triangle text-yellow-600',
    'info' => 'fas fa-info-circle text-blue-600',
];

// Apply colors based on alert type
$classes = $colorClasses[$type] ?? $colorClasses['info'];
$icon = $iconClasses[$type] ?? $iconClasses['info'];
@endphp

<div {{ $attributes->merge(['class' => "{$classes} px-4 py-3 rounded relative mb-4 alert"]) }} role="alert">
    <div class="flex">
        <div class="flex-shrink-0">
            <i class="{{ $icon }} mr-2"></i>
        </div>
        <div class="flex-grow">
            @if(isset($title))
                <strong class="font-bold">{{ $title }}</strong>
                <span class="block sm:inline">{{ $message }}</span>
            @else
                <span class="block sm:inline">{{ $message }}</span>
            @endif
            
            @if(isset($slot) && !empty(trim($slot)))
                <div class="mt-2">
                    {{ $slot }}
                </div>
            @endif
        </div>
        
        @if($dismissible)
            <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3 alert-close">
                <i class="fas fa-times"></i>
            </button>
        @endif
    </div>
</div>

@if($dismissible)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.alert-close').forEach(function(button) {
            button.addEventListener('click', function() {
                this.closest('.alert').remove();
            });
        });
    });
</script>
@endif