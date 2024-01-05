<x-layout.default>
    <div>
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="{{ route('menus.index') }}" class="text-primary hover:underline">Menu</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>Edit</span>
            </li>
        </ul>
        <div class="pt-5">                                   
            <form method="POST" action="{{ route('menus.update', ['menu'=>$menu->id]) }}">
            @csrf
            @method('PATCH')
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Edit Menu</h5>
                </div>   
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4"> 
                    <div>
                        <label>Hotels:<span style="color: red">*</span></label>
                        <select class="form-input" name="hotel_id" required="true">
                            <option>Select Hotels</option>
                            @foreach ($hotels as $id => $hotel)
                                <option value="{{$id}}" {{ $menu->hotel_id ? ($menu->hotel_id == $id ? 'Selected' : '' ) : ''}}>{{ $hotel }}</option>
                            @endforeach
                        </select> 
                        <x-input-error :messages="$errors->get('hotel')" class="mt-2" /> 
                    </div> 
                    <div>
                        <label>Menu Categories:<span style="color: red">*</span></label>
                        <select class="form-input" name="menu_category_id" required="true">
                            <option>Select Category</option>
                            @foreach ($menu_categories as $id => $category)
                                <option value="{{$id}}" {{ $menu->menu_category_id ? ($menu->menu_category_id == $id ? 'Selected' : '' ) : ''}}>{{ $category }}</option>
                            @endforeach
                        </select> 
                        <x-input-error :messages="$errors->get('category')" class="mt-2" /> 
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">
                    <x-text-input name="item_name" value="{{ old('item_name', $menu->item_name) }}" :label="__('Item Name')" :require="true" :messages="$errors->get('item_name')"/>   
                    <x-combo-input name="rate" value="{{ old('rate', $menu->rate) }}" :label="__('Rate')" :messages="$errors->get('rate')"/>
                    <x-text-input name="gst_rate" value="{{ old('gst_rate', $menu->gst_rate) }}" :label="__('GST Rate')" :messages="$errors->get('gst_rate')"/>
                </div> 
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-1">
                    <x-text-input name="item_description" value="{{ old('item_description', $menu->item_description) }}" :label="__('Description')" :messages="$errors->get('item_description')"/>                       
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
