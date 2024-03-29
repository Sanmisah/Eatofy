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
        <div class="pt-5" x-data="data">
            <form method="POST" action="{{ route('hotel_staffs.update', ['hotel_staff'=>$hotel_staff->id]) }}">
            @csrf
            @method('PATCH')
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Edit Staff</h5>
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-3">
                    @foreach ($hotels as $id => $hotel)
                    <input type="hidden" value="{{ $id }}" name="hotel_id"/>
                    @endforeach
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">
                    <x-text-input name="staff_name" value="{{ old('staff_name', $hotel_staff->staff_name) }}" :label="__('Staff Name')" :require="true" :messages="$errors->get('staff_name')"/>
                    <x-text-input name="contact_no" value="{{ old('contact_no', $hotel_staff->contact_no) }}" :label="__('Contact No')" :messages="$errors->get('contact_no')" :require="true"/>
                    <div>
                        <label>Role:<span style="color: red">*</span></label>
                        <select class="form-input" name="role" id="role">
                            <!-- <option selected disabled>Select Role</option> -->
                            <option value='Manager' @if ($hotel_staff->role == 'Manager') {{ 'Selected' }} @endif>Manager</option>
                            <option value='Cashier' @if ($hotel_staff->role == 'Cashier') {{ 'Selected' }} @endif>Cashier</option>
                            <option value='Captain' @if ($hotel_staff->role == 'Captain') {{ 'Selected' }} @endif>Captain</option>
                            <option value='Waiter' @if ($hotel_staff->role == 'Waiter') {{ 'Selected' }} @endif>Waiter</option>
                            <option value='Cleaner' @if ($hotel_staff->role == 'Cleaner') {{ 'Selected' }} @endif>Cleaner</option>
                            <option value='Chef' @if ($hotel_staff->role == 'Chef') {{ 'Selected' }} @endif>Chef</option>
                            <option value='Co-owner' @if ($hotel_staff->role == 'Co-owner') {{ 'Selected' }} @endif>Co-owner</option>
                        </select>
                    </div>
                    <x-text-input name="salary" value="{{ old('salary', $hotel_staff->salary) }}" :label="__('Salary')" :messages="$errors->get('salary')"/>
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-1">
                    <x-text-input name="address" value="{{ old('address', $hotel_staff->address) }}" :label="__('Address')" :messages="$errors->get('address')" :require="true"/>
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-1">
                    <x-text-input name="aadhar_no" value="{{ old('aadhar_no', $hotel_staff->aadhar_no) }}" :label="__('Aadhar No')" :messages="$errors->get('aadhar_no')" :require="true"/>
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
            <br />
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Staff Data</h5>
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">
                    <x-text-input name="email" class="bg-gray-100 dark:bg-gray-700" readonly="true" value="{{ old('email', $hotel_staff->email) }}"  :label="__('Email')" :messages="$errors->get('email')"/>
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
