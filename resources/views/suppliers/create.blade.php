<x-layout.default>  
<div>
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="{{ route('suppliers.index') }}" class="text-primary hover:underline">Supplier</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>Add</span>
        </li>
    </ul>
    <div class="pt-5">        
        <form class="space-y-5" action="{{ route('suppliers.store') }}" method="POST">
            @csrf
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Add Supplier</h5>
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-3"> 
                    @foreach ($hotels as $id => $hotel)
                    <input type="hidden" value="{{ $id }}" name="hotel_id"/>
                    <x-text-input class="bg-gray-100 dark:bg-gray-700" value="{{ $hotel }}" :label="__('Hotel')" :require="true" :messages="$errors->get('hotel_id')"/>
                    @endforeach
                </div> 
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4"> 
                    <x-text-input name="supplier_name" value="{{ old('supplier_name') }}" :label="__('Supplier Name')" :require="true" :messages="$errors->get('supplier_name')"/>  
                    <x-text-input name="supplier_contact_no" value="{{ old('supplier_contact_no') }}" :label="__('Supplier Contact Name')" :messages="$errors->get('supplier_contact_no')"/>  
                    <x-text-input name="gstin" value="{{ old('gstin') }}" :label="__('GSTIN')" :messages="$errors->get('gstin')" /> 
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-3"> 
                    <x-text-input name="customer_name" value="{{ old('customer_name') }}" :label="__('Customer Name')" :messages="$errors->get('customer_name')"/>  
                    <x-text-input name="customer_contact_no" value="{{ old('customer_contact_no') }}" :label="__('Customer Contact Name')" :messages="$errors->get('customer_contact_no')"/>  
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-1"> 
                    <x-text-input name="customer_address" value="{{ old('customer_address') }}" :label="__('Customer Address')" :messages="$errors->get('customer_address')"/>
                </div>
                <div class="flex justify-end mt-4">
                    <x-success-button>
                        {{ __('Submit') }}
                    </x-success-button>
                    &nbsp;&nbsp;
                    <x-cancel-button :link="route('suppliers.index')">
                        {{ __('Cancel') }}
                    </x-cancel-button>
                </div> 
            </div>
        </form> 
    </div>
</div> 
</x-layout.default>
