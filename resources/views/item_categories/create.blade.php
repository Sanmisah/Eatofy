<x-layout.default>
<div>
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="{{ route('item_categories.index') }}" class="text-primary hover:underline">Item Category</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>Add</span>
        </li>
    </ul>
    <div class="pt-5">        
        <form class="space-y-5" action="{{ route('item_categories.store') }}" method="POST">
            @csrf
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Add Item Category</h5>
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-3">     
                    @foreach ($hotels as $id => $hotel)
                    <input type="hidden" value="{{ $id }}" name="hotel_id"/>
                    @endforeach
                </div>  
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">                       
                    <x-text-input name="item_category_name" value="{{ old('item_category_name') }}" :label="__('Item Category Name')" :require="true" :messages="$errors->get('item_category_name')"/>  
                    <x-text-input name="gst_rate" value="{{ old('gst_rate') }}" :label="__('GST Rate')" :messages="$errors->get('gst_rate')"/>
                </div>
                <div class="flex justify-end mt-4">
                    <x-cancel-button :link="route('item_categories.index')">
                        {{ __('Cancel') }}
                    </x-cancel-button>
                    &nbsp;&nbsp;
                    <x-success-button>
                        {{ __('Submit') }}
                    </x-success-button>
                </div>
            </div>
        </form> 
    </div>
</div> 
</x-layout.default>