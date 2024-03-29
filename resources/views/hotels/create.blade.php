<x-layout.default>  
<div>
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="{{ route('hotels.index') }}" class="text-primary hover:underline">Hotels</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>Add</span>
        </li>
    </ul>
    <div class="pt-5" x-data="data">        
        <form class="space-y-5" action="{{ route('hotels.store') }}" method="POST">
            @csrf
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Add Hotel Data</h5>
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-3"> 
                    <x-text-input name="hotel_name" value="{{ old('hotel_name') }}" :label="__('Hotel Name')" :require="true" :messages="$errors->get('hotel_name')"/>
                    <x-text-input name="branch_name" value="{{ old('branch_name') }}" :label="__('Branch Name')" :messages="$errors->get('branch_name')"/>
                </div> 
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">   
                    <x-text-input name="contact_no" value="{{ old('contact_no') }}" :label="__('Contact No')" :messages="$errors->get('contact_no')" :require="true"/>                  
                    <x-text-input name="website_url" value="{{ old('website_url') }}" :label="__('Website URL')" :messages="$errors->get('website_url')"/>
                    <x-text-input name="gstin" value="{{ old('gstin') }}" :label="__('GSTIN')" :messages="$errors->get('gstin')" /> 
                    <x-text-input name="fssai_no" value="{{ old('fssai_no') }}" :label="__('FSSAI No')" :messages="$errors->get('fssai_no')" />
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-1"> 
                    <x-text-input name="address" value="{{ old('address') }}" :label="__('Address')" :messages="$errors->get('address')" :require="true"/> 
                </div>  
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">                     
                    <div>
                        <label>State:<span style="color: red">*</span></label>
                        <select class="form-input" name="state">
                            <option value="">Select state</option>
                            <template x-for="state in states" :key="state.code">
                                <option :value="state.name" x-text="state.name"></option>
                            </template>
                        </select> 
                        <x-input-error :messages="$errors->get('state_name')" class="mt-2" />
                    </div>
                    <x-text-input name="city" value="{{ old('city') }}" :label="__('City')" :require="true" :messages="$errors->get('city')" />
                </div>
            </div>
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Add Owner Data</h5>
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">
                    <x-text-input name="owner_name" value="{{ old('owner_name') }}" :label="__('Owner Name')" :messages="$errors->get('owner_name')" :require="true"/>          
                    <x-text-input name="owner_contact_no" value="{{ old('owner_contact_no') }}" :label="__('Owner Contact No')" :messages="$errors->get('owner_contact_no')" :require="true"/> 
                    <x-text-input name="email" :email="true" :label="__('Email')" :messages="$errors->get('email')" :require="true"/>
                    <x-text-input name="new_password" type="password" :label="__('Password')" :messages="$errors->get('new_password')" :require="true"/>
                </div> 
            </div> 
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Add Partner Data</h5>
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">
                    <x-text-input name="partner_name" value="{{ old('partner_name') }}" :label="__('Partner Name')" :messages="$errors->get('partner_name')"/>          
                    <x-text-input name="partner_contact_no" value="{{ old('partner_contact_no') }}" :label="__('Partner Contact No')" :messages="$errors->get('partner_contact_no')"/> 
                    <x-text-input name="partner_email" :email="true" :label="__('Partner Email')" :messages="$errors->get('partner_email')" />
                    <x-text-input name="partner_password" type="password" :label="__('Partner Password')" :messages="$errors->get('partner_password')"/>
                </div>         
                <div class="flex justify-end mt-4">
                    <x-success-button>
                        {{ __('Submit') }}
                    </x-success-button>
                    &nbsp;&nbsp;
                    <x-cancel-button :link="route('hotels.index')">
                        {{ __('Cancel') }}
                    </x-cancel-button>
                </div>       
            </div> 
        </form> 
    </div>
</div> 
<script>
document.addEventListener("alpine:init", () => {
    Alpine.data('data', () => ({  
        states: '',    
        init() {
            this.states = [
                { code: 'AN', name: 'Andaman and Nicobar Islands' },
                { code: 'AP', name: 'Andhra Pradesh' },
                { code: 'AR', name: 'Arunachal Pradesh' },
                { code: 'AS', name: 'Assam' },
                { code: 'BR', name: 'Bihar' },
                { code: 'CG', name: 'Chandigarh' },
                { code: 'CH', name: 'Chhattisgarh' },
                
                { code: 'DN', name: 'Dadra and Nagar Haveli' },
                { code: 'DD', name: 'Daman and Diu' },
                { code: 'DL', name: 'Delhi' },
                { code: 'GA', name: 'Goa' },
                { code: 'GJ', name: 'Gujarat' },
                { code: 'HR', name: 'Haryana' },
                { code: 'HP', name: 'Himachal Pradesh' },

                { code: 'JK', name: 'Jammu and Kashmir' },
                { code: 'JH', name: 'Jharkhand' },
                { code: 'KA', name: 'Karnataka' },
                { code: 'KL', name: 'Kerala' },
                { code: 'LA', name: 'Ladakh' },
                { code: 'LD', name: 'Lakshadweep' },
                { code: 'MP', name: 'Madhya Pradesh' },
                
                { code: 'MH', name: 'Maharashtra' },
                { code: 'MN', name: 'Manipur' },
                { code: 'ML', name: 'Meghalaya' },
                { code: 'MZ', name: 'Mizoram' },
                { code: 'NL', name: 'Nagaland' },
                { code: 'OR', name: 'Odisha' },
                { code: 'PY', name: 'Puducherry' },
                
                { code: 'PB', name: 'Punjab' },
                { code: 'RJ', name: 'Rajasthan' },
                { code: 'SK', name: 'Sikkim' },
                { code: 'TN', name: 'Tamil Nadu' },
                { code: 'TS', name: 'Telangana' },
                { code: 'TR', name: 'Tripura' },
                { code: 'UP', name: 'Uttar Pradesh' },
                { code: 'UK', name: 'Uttarakhand' },
                { code: 'WB', name: 'West Bengal' },
            ];
        },   
    }));
});
</script>
</x-layout.default>
