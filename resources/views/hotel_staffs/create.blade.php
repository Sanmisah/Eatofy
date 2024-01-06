<x-layout.default>
<div>
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="{{ route('hotel_staffs.index') }}" class="text-primary hover:underline">Staffs</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>Add</span>
        </li>
    </ul>
    <div class="pt-5">        
        <form class="space-y-5" action="{{ route('hotel_staffs.store') }}" method="POST">
            @csrf
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Add Staffs</h5>
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-3">     
                    @foreach ($hotels as $id => $hotel)
                    <input type="hidden" value="{{ $id }}" name="hotel_id"/>
                    <x-text-input class="bg-gray-100 dark:bg-gray-700" value="{{ $hotel }}" :label="__('Hotel')" :require="true" :messages="$errors->get('hotel_id')"/>
                    @endforeach
                </div>  
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">
                    <x-text-input name="staff_name" value="{{ old('staff_name') }}" :label="__('Staff Name')" :require="true" :messages="$errors->get('staff_name')"/>  
                    <x-text-input name="contact_no" value="{{ old('contact_no') }}" :label="__('Contact No')" :messages="$errors->get('contact_no')"/> 
                    <div>
                        <label>Type:</label>
                        <select class="form-input" name="type">
                            <option selected disabled>Select type</option>
                            <option value='Manager'>Manager</option>
                            <option value='Cashier'>Cashier</option>
                            <option value='Waiter'>Waiter</option>
                            <option value='Cook'>Cook</option>                           
                        </select>
                    </div> 
                    <x-text-input name="salary" value="{{ old('salary') }}" :label="__('Salary')" :messages="$errors->get('salary')"/>
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-1">
                    <x-text-input name="address" value="{{ old('address') }}" :label="__('Address')" :messages="$errors->get('address')"/>                     
                </div>
                <div class="flex justify-end mt-4">
                    <x-success-button>
                        {{ __('Submit') }}
                    </x-success-button>
                    &nbsp;&nbsp;
                    <x-cancel-button :link="route('hotel_staffs.index')">
                        {{ __('Cancel') }}
                    </x-cancel-button>
                </div>
            </div>
        </form> 
    </div>
</div> 
</x-layout.default>