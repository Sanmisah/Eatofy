@props(['link', 'text'=>'Followup'])

<div class="lead" style="display:inline-block;">
    <a href="{{ $link }}">
        <span class="badge bg-info rounded-full"> 
            {{ $text }}
        </span>
    </a>
</div>

