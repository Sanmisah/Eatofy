<x-layout.default>
    <div>
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="{{ route('menu_categories.index') }}" class="text-primary hover:underline">Item Categories</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>Edit</span>
            </li>
        </ul>
        <div class="pt-5">                                   
            <form method="POST" action="{{ route('menu_categories.update', ['menu_category'=>$menu_category->id]) }}">
            @csrf
            @method('PATCH')
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Edit Menu Category</h5>
                </div>   
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-3">     
                    @foreach ($hotels as $id => $hotel)
                    <input type="hidden" value="{{ $id }}" name="hotel_id"/>
                    @endforeach
                </div>  
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-3">
                    <x-text-input name="menu_category_name" value="{{ old('menu_category_name', $menu_category->menu_category_name) }}" :label="__('Category Name')" :require="true" :messages="$errors->get('menu_category_name')"/> 
                </div>
                <div class="flex justify-end mt-4">
                    <x-cancel-button :link="route('menu_categories.index')">
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
