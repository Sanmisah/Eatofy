<x-layout.default>
<div>
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="{{ route('menus.index') }}" class="text-primary hover:underline">Menus</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>Add</span>
        </li>
    </ul>
    <div class="pt-5" x-data="data">        
        <form class="space-y-5" action="{{ route('menus.store') }}" method="POST">
            @csrf
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Add Menu</h5>
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-3">     
                    @foreach ($hotels as $id => $hotel)
                    <input type="hidden" value="{{ $id }}" name="hotel_id"/>
                    @endforeach
                </div>  
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">                     
                    <div>
                        <label>Menu Categories:<span style="color: red">*</span></label>
                        <select class="form-input" name="menu_category_id" id="menu_category_id" required="true" x-model="menu_category_id" @change="menuCategoryChange()">
                            <!-- <option>Select Category</option> -->
                            @foreach ($menu_categories as $id => $category)
                                <option value="{{$id}}">{{ $category }}</option>
                            @endforeach
                        </select> 
                        <x-input-error :messages="$errors->get('category')" class="mt-2" /> 
                    </div>
                    <div>
                        <label>Food Type:<span style="color: red">*</span></label>
                        <select class="form-input" name="type" id="type">
                            <option value='Veg'>Veg</option>
                            <option value='Non-Veg'>Non-Veg</option>
                            <option value='Jain Food'>Jain Food</option>
                        </select>
                        <x-input-error :messages="$errors->get('type')" class="mt-2" /> 
                    </div> 
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">
                    <x-text-input name="item_name" value="{{ old('item_name') }}" :label="__('Item Name')" :require="true" :messages="$errors->get('item_name')"/>   
                    <x-combo-input name="rate" value="{{ old('rate') }}" :label="__('Rate')" :messages="$errors->get('rate')" :require="true"/>
                    <x-text-input name="gst_rate" value="{{ old('gst_rate') }}" :label="__('GST Rate')" :messages="$errors->get('gst_rate')" x-model="gst_rate"/>
                    <x-text-input name="additional_tax" value="{{ old('additional_tax') }}" :label="__('Additional Tax')" :messages="$errors->get('additional_tax')"/>
                </div> 
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-1">
                    <x-text-input name="item_description" value="{{ old('item_description') }}" :label="__('Description')" :messages="$errors->get('item_description')"/>                       
                </div> 
                <div class="flex justify-end mt-4">
                    <x-cancel-button :link="route('menus.index')">
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
        init(){
            var options = {
                searchable: true
            };
            NiceSelect.bind(document.getElementById("menu_category_id"), options);
            NiceSelect.bind(document.getElementById("type"), options);
        },          
        menu_category_id: '',
        menuData:'',
        gst_rate: '',
        async menuCategoryChange() {                  
            this.menuData = await (await fetch('/menu_categories/'+ this.menu_category_id, {
            method: 'GET',
            headers: {
                'Content-type': 'application/json;',
            },
            })).json();
            this.gst_rate = this.menuData.gst_rate;
        },    
    }));
});
</script>
</x-layout.default>