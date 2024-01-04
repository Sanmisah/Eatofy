@props(['disabled' => false, 'email' => false,  'label', 'require' => false, 'messages'])

<div>
    <label>
        {{ $label  }}: 
        @if($require)
        <span style="color: red">*</span>
        @endif
    </label>

    <div class="flex">
        <div class="bg-[#eee] flex justify-center items-center ltr:rounded-l-md rtl:rounded-r-md px-3 font-semibold border ltr:border-r-0 rtl:border-l-0 border-[#e0e6ed] dark:border-[#17263c] dark:bg-[#1b2e4b]">{!! $email ? '@' : '&#8377;' !!}</div>
        <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'form-input ltr:rounded-l-none rtl:rounded-r-none']) !!} />
    </div>

    @if ($messages)
        <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 space-y-1 mt-2']) }}>
            @foreach ((array) $messages as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    @endif
</div>

