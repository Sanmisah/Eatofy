<x-layout.default>
    <div>
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="{{ route('items.index') }}" class="text-primary hover:underline">Items</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>Edit</span>
            </li>
        </ul>
        <div class="pt-5">                                   
            <form method="POST" action="{{ route('items.update', ['item'=>$item->id]) }}">
            @csrf
            @method('PATCH')
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Edit Item</h5>
                </div>   
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4"> 
                    <div>
                        <label>Hotels:<span style="color: red">*</span></label>
                        <select class="form-input" name="hotel_id" required="true">
                            <option>Select Hotels</option>
                            @foreach ($hotels as $id => $hotel)
                                <option value="{{$id}}" {{ $item->hotel_id ? ($item->hotel_id == $id ? 'Selected' : '' ) : ''}}>{{ $hotel }}</option>
                            @endforeach
                        </select> 
                        <x-input-error :messages="$errors->get('hotel')" class="mt-2" /> 
                    </div> 
                    <div>
                        <label>Item Categories:<span style="color: red">*</span></label>
                        <select class="form-input" name="item_category_id" required="true">
                            <option>Select Category</option>
                            @foreach ($item_categories as $id => $category)
                                <option value="{{$id}}" {{ $item->item_category_id ? ($item->item_category_id == $id ? 'Selected' : '' ) : ''}}>{{ $category }}</option>
                            @endforeach
                        </select> 
                        <x-input-error :messages="$errors->get('category')" class="mt-2" /> 
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">
                    <x-text-input name="name" value="{{ old('name', $item->name) }}" :label="__('Name')" :require="true" :messages="$errors->get('name')"/>  
                    <div>
                        <label>Unit:</label>
                        <select class="form-input" name="unit">
                            <option selected disabled>Select Status</option>
                            <option value="KG" @if ($item->unit == 'KG') {{ 'Selected' }} @endif>KG</option>
                            <option value="LTR" @if ($item->unit == 'LTR') {{ 'Selected' }} @endif>LTR</option>      
                        </select>
                    </div>
                    <x-text-input name="opening_qty" value="{{ old('opening_qty', $item->opening_qty) }}" :label="__('Opening Quantity')" :messages="$errors->get('opening_qty')"/>
                    <x-text-input name="closing_qty" value="{{ old('closing_qty', $item->closing_qty) }}" :label="__('Closing Quantity')" :messages="$errors->get('closing_qty')"/>
                </div> 
                <div class="flex justify-end mt-4">
                    <x-success-button>
                        {{ __('Submit') }}
                    </x-success-button>
                    &nbsp;&nbsp;
                    <x-cancel-button :link="route('menus.index')">
                        {{ __('Cancel') }}
                    </x-cancel-button>
                </div>
            </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function(e) {
            // default
            var els = document.querySelectorAll(".selectize");
            els.forEach(function(select) {
                NiceSelect.bind(select);
            });
        });
    </script>
</x-layout.default>
