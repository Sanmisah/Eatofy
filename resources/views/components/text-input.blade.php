@props(['disabled' => false, 'label', 'require' => false, 'messages'])
<div>
    @if(!empty($label))
        <label>
            {{ $label ?? $slot }}: 
            @if($require)
            <span style="color: red">*</span>
            @endif
        </label>
    @endif
    <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'form-input']) !!}>

    @if ($messages)
        <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 space-y-1 mt-2']) }}>
            @foreach ((array) $messages as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    @endif
</div>