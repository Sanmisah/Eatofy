<x-layout.default>
    <div>
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="{{ route('hotel_staffs.index') }}" class="text-primary hover:underline">Staffs</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>Edit</span>
            </li>
        </ul>
        <div class="pt-5">                                   
            <form method="POST" action="{{ route('hotel_staffs.update', ['hotel_staff'=>$hotel_staff->id]) }}">
            @csrf
            @method('PATCH')
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Edit Staff</h5>
                </div>   
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">     
                    @foreach ($hotels as $id => $hotel)
                    <input type="hidden" value="{{ $id }}" name="hotel_id"/>
                    <x-text-input class="bg-gray-100 dark:bg-gray-700" value="{{ $hotel }}" :label="__('Hotel')" :require="true" :messages="$errors->get('hotel_id')"/>
                    @endforeach   
                </div>  
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">
                    <x-text-input name="staff_name" value="{{ old('staff_name', $hotel_staff->staff_name) }}" :label="__('Staff Name')" :require="true" :messages="$errors->get('staff_name')"/>  
                    <x-text-input name="contact_no" value="{{ old('contact_no', $hotel_staff->contact_no) }}" :label="__('Contact No')" :messages="$errors->get('contact_no')"/> 
                    <div>
                        <label>Type:</label>
                        <select class="form-input" name="type">
                            <option selected disabled>Select type</option>
                            <option value="Manager" @if ($hotel_staff->type == 'Manager') {{ 'Selected' }} @endif>Manager</option>
                            <option value="Cashier" @if ($hotel_staff->type == 'Cashier') {{ 'Selected' }} @endif>Cashier</option>
                            <option value="Waiter" @if ($hotel_staff->type == 'Waiter') {{ 'Selected' }} @endif>Waiter</option>                          
                            <option value="Cook" @if ($hotel_staff->type == 'Cook') {{ 'Selected' }} @endif>Cook</option>
                        </select>
                    </div> 
                    <x-text-input name="salary" value="{{ old('salary', $hotel_staff->salary) }}" :label="__('Salary')" :messages="$errors->get('salary')"/>
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-1">
                    <x-text-input name="address" value="{{ old('address', $hotel_staff->address) }}" :label="__('Address')" :messages="$errors->get('address')"/>                     
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
