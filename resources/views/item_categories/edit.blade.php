<x-layout.default>
    <div>
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="{{ route('item_categories.index') }}" class="text-primary hover:underline">Item Categories</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>Edit</span>
            </li>
        </ul>
        <div class="pt-5">                                   
            <form method="POST" action="{{ route('item_categories.update', ['item_category'=>$item_category->id]) }}">
            @csrf
            @method('PATCH')
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Edit Item Category</h5>
                </div>   
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-3">
                    <div>
                        <label>Hotels:<span style="color: red">*</span></label>
                        <select class="form-input" name="hotel_id" required="true">
                            <option>Select Hotels</option>
                            @foreach ($hotels as $id => $hotel)
                                <option value="{{$id}}" {{ $item_category->hotel_id ? ($item_category->hotel_id == $id ? 'Selected' : '' ) : ''}}>{{ $hotel }}</option>
                            @endforeach
                        </select> 
                        <x-input-error :messages="$errors->get('hotel')" class="mt-2" /> 
                    </div>  
                    <x-text-input name="item_category_name" value="{{ old('item_category_name', $item_category->item_category_name) }}" :label="__('Item Category Name')" :require="true" :messages="$errors->get('item_category_name')"/> 
                </div>
                <div class="flex justify-end mt-4">
                    <x-success-button>
                        {{ __('Submit') }}
                    </x-success-button>
                    &nbsp;&nbsp;
                    <x-cancel-button :link="route('item_categories.index')">
                        {{ __('Cancel') }}
                    </x-cancel-button>
                </div>
            </div>
            </form>
        </div>
    </div>    
</x-layout.default>
