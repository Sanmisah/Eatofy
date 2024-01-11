<x-layout.default>
<div>
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="{{ route('items.index') }}" class="text-primary hover:underline">Items</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>Add</span>
        </li>
    </ul>
    <div class="pt-5" x-data="data">        
        <form class="space-y-5" action="{{ route('items.store') }}" method="POST">
            @csrf
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Add Item</h5>
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-3">     
                    @foreach ($hotels as $id => $hotel)
                    <input type="hidden" value="{{ $id }}" name="hotel_id"/>
                    @endforeach
                </div>  
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">                     
                    <div>
                        <label>Item Categories:<span style="color: red">*</span></label>
                        <select class="form-input" name="item_category_id" required="true">
                            <option>Select Category</option>
                            @foreach ($item_categories as $id => $category)
                                <option value="{{$id}}">{{ $category }}</option>
                            @endforeach
                        </select> 
                        <x-input-error :messages="$errors->get('category')" class="mt-2" /> 
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">
                    <x-text-input name="name" value="{{ old('name') }}" :label="__('Name')" :require="true" :messages="$errors->get('name')"/>   
                    <!-- <x-text-input name="unit" value="{{ old('unit') }}" :label="__('Unit')" :messages="$errors->get('unit')"/> -->
                    <div>
                        <label>Unit:</label>
                        <select class="form-input" name="unit">
                            <option selected disabled>Select Unit</option>
                            <option value='KG'>KG</option>
                            <option value='LTR'>LTR</option> 
                            <option value='Gram'>Gram</option>    
                            <option value='Dozen'>Dozen</option>                        
                        </select>
                    </div>
                    <x-text-input name="opening_qty" value="{{ old('opening_qty') }}" x-model="opening_qty" :label="__('Opening Quantity')" :messages="$errors->get('opening_qty')" x-on:change.debounce="qtyChange()"/>
                    <x-text-input class="bg-gray-100 dark:bg-gray-700" readonly="true" x-model="closing_qty" name="closing_qty" value="{{ old('closing_qty') }}" :label="__('Closing Quantity')" :messages="$errors->get('closing_qty')"/>
                </div> 
                <div class="flex justify-end mt-4">
                    <x-cancel-button :link="route('items.index')">
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
<script>
document.addEventListener("alpine:init", () => {
    Alpine.data('data', () => ({  
        opening_qty : '',
        closing_qty: '',
        qtyChange(){  
            console.log('hiii');
            this.closing_qty = this.opening_qty;
        },
    }));
});
</script>
</x-layout.default>