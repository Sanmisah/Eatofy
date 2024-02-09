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
    <div class="pt-5" x-data="data">        
        <form class="space-y-5" action="{{ route('hotel_staffs.store') }}" method="POST">
            @csrf
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Add Staffs</h5>
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-3">     
                    @foreach ($hotels as $id => $hotel)
                    <input type="hidden" value="{{ $id }}" name="hotel_id"/>
                    @endforeach
                </div>  
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">
                    <x-text-input name="staff_name" value="{{ old('staff_name') }}" :label="__('Staff Name')" :require="true" :messages="$errors->get('staff_name')"/>  
                    <x-text-input name="contact_no" value="{{ old('contact_no') }}" :label="__('Contact No')" :messages="$errors->get('contact_no')" :require="true" /> 
                    <div>
                        <label>Role:<span style="color: red">*</span></label>
                        <select class="form-input" name="role" id="role">
                            <!-- <option value="">Select role</option> -->
                            <option value='Manager'>Manager</option>
                            <option value='Cashier'>Cashier</option>
                            <option value='Captain'>Captain</option>     
                            <option value='Waiter'>Waiter</option>  
                            <option value='Cleaner'>Cleaner</option>  
                            <option value='Chef'>Chef</option>  
                            <option value='Co-owner'>Co-owner</option>                                  
                        </select>
                    </div> 
                    <x-text-input name="salary" value="{{ old('salary') }}" :label="__('Salary')" :messages="$errors->get('salary')"/>
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-1">
                    <x-text-input name="address" value="{{ old('address') }}" :label="__('Address')" :messages="$errors->get('address')" :require="true"/>                     
                </div>
            </div>
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Login details</h5>
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">                    
                    <x-text-input name="email" :require="true" :label="__('Email')" :messages="$errors->get('email')"/>
                    <x-text-input name="new_password" type="password" :require="true" :label="__('Password')" :messages="$errors->get('new_password')"/>
                </div> 
                <div class="flex justify-end mt-4">
                    <x-cancel-button :link="route('hotel_staffs.index')">
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
            NiceSelect.bind(document.getElementById("role"), options);
        }
    }));
});
</script>
</x-layout.default>