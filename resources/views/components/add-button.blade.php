@props(['link', 'text'=>'Add'])

<div class="lead" style="display:inline-block;">
    <!-- <a href="{{ $link }}" class="btn btn-warning rounded-full">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg> {{ $text }}
    </a> -->
    <a href="{{ $link }}" class="btn btn-primary gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"
            fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
            stroke-linejoin="round" class="w-5 h-5">
            <line x1="12" y1="5" x2="12" y2="19"></line>
            <line x1="5" y1="12" x2="19" y2="12"></line>
        </svg>{{ $text }}
    </a>
</div>

