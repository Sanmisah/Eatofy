@props(['link', 'text'=>'Cancel'])

<div class="lead" style="display:inline-block;">
    <a href="{{ $link }}" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel?')">
        {{ $text }}
    </a>
</div>