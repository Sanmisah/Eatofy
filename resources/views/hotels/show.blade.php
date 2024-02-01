
<x-layout.default>   
<div>
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="{{ route('hotels.index') }}" class="text-primary hover:underline">Hotels</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>Show</span>
        </li>
    </ul>
    <div class="pt-5" x-data="data">  
        <form class="space-y-5" action="{{ route('hotels.updateTagLine', ['hotel' => $hotel->id]) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="panel">
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">                       
                    <x-text-input name="tagline" value="{{ old('tagline', $hotel->tagline) }}" :label="__('Tagline')" :messages="$errors->get('tagline')"/>  
                </div>
                <div class="flex justify-end mt-4">
                    <x-cancel-button :link="route('dashboard')">
                        {{ __('Cancel') }}
                    </x-cancel-button>
                    &nbsp;&nbsp;
                    <x-success-button>
                        {{ __('Submit') }}
                    </x-success-button>
                </div>
            </div>
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Hotel Data</h5>
                </div>                
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4"> 
                    <x-text-input class="bg-gray-100 dark:bg-gray-700" readonly="true" value="{{ $hotel->hotel_name }}" :label="__('Hotel Name')" :messages="$errors->get('hotel_name')"/>
                    <x-text-input class="bg-gray-100 dark:bg-gray-700" readonly="true" value="{{ $hotel->branch_name }}" :label="__('Branch Name')" :messages="$errors->get('branch_name')"/>
                    <x-text-input class="bg-gray-100 dark:bg-gray-700" readonly="true" value="{{ $hotel->contact_no }}" :label="__('Contact No')" :messages="$errors->get('contact_no')"/>  
                    <x-text-input class="bg-gray-100 dark:bg-gray-700" readonly="true" value="{{ $hotel->gstin }}" :label="__('GSTIN')" :messages="$errors->get('gstin')" />
                </div> 
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">                                       
                    <x-text-input class="bg-gray-100 dark:bg-gray-700" readonly="true" value="{{ $hotel->website_url }}" :label="__('Website URL')" :messages="$errors->get('website_url')"/>
                    <x-text-input value="{{ $hotel->owner_name }}" :label="__('Owner Name')" :messages="$errors->get('owner_name')" class="bg-gray-100 dark:bg-gray-700" readonly="true"/>  
                    <x-text-input  value="{{ $hotel->owner_contact_no }}" :label="__('Owner Contact No')" :messages="$errors->get('owner_contact_no')" class="bg-gray-100 dark:bg-gray-700" readonly="true"/> 
                    <x-text-input  value="{{ $hotel->email }}" :label="__('Email')" :messages="$errors->get('email')" class="bg-gray-100 dark:bg-gray-700" readonly="true"/>
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-1"> 
                    <x-text-input class="bg-gray-100 dark:bg-gray-700" readonly="true" value="{{ old('address', $hotel->address) }}" :label="__('Address')" :messages="$errors->get('address')"/> 
                </div>  
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">                     
                    <div>
                    <label>State:</label>
                        <select class="form-input bg-gray-100 dark:bg-gray-700" name="state" readonly="true">
                            <template x-for="state in states" :key="state.code">
                                <option :value="state.name" x-text="state.name" :selected="state.name == '{{ $hotel->state}}'"></option>
                            </template>
                        </select> 
                        <x-input-error :messages="$errors->get('state_name')" class="mt-2" />
                    </div>
                    <x-text-input class="bg-gray-100 dark:bg-gray-700" readonly="true" value="{{ $hotel->city }}" :label="__('City')" :messages="$errors->get('city')"/>
                </div>
            </div>            
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Staff Data</h5>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>                            
                                <th>Name</th>   
                                <th>Email</th>                          
                                <th>Contact No </th>                            
                                <th>Designation </th>  
                                <th>Salary</th>         
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($staff as $detail)
                            <tr>                            
                                <td>{{ @$detail->staff_name }}</td>                            
                                <td>{{ @$detail->email }}</td>                            
                                <td>{{ @$detail->contact_no }}</td>                                               
                                <td>{{ @$detail->role }}</td>   
                                <td>{{ @$detail->salary }}</td>                         
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> 
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Subscription</h5>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>                     
                                <th>Subscription No</th>   
                                <th>Subscription Date</th> 
                                <th>Package Name</th>  
                                <th>Cost</th>                         
                                <th>Expiry Date </th>   
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subscription as $detail)
                            <tr>  
                                <td>{{ $detail->subscription_no }}</td>                            
                                <td>{{ $detail->subscription_date }}</td>
                                <td>{{ $detail->package_name }}</td>                       
                                <td>{{ $detail->cost }}</td>             
                                <td>{{ $detail->expiry_date }}</td>                      
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
