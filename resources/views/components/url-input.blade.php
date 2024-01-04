@props(['disabled' => false])

<div class="flex">
    <div class="bg-[#eee] flex justify-center items-center ltr:rounded-l-md rtl:rounded-r-md px-3 font-semibold border ltr:border-r-0 rtl:border-l-0 border-[#e0e6ed] dark:border-[#17263c] dark:bg-[#1b2e4b]">https://</div>
    <!-- <input type="text" {{ $disabled ? 'disabled' : '' }} class="form-input ltr:rounded-l-none rtl:rounded-r-none" /> -->
    <input type="text" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'form-input ltr:rounded-l-none rtl:rounded-r-none']) !!} />
</div>