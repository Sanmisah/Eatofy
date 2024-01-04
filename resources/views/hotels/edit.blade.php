<x-layout.default>   
<div>
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="{{ route('employees.index') }}" class="text-primary hover:underline">Employees</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>Edit</span>
        </li>
    </ul>
    <div class="pt-5" x-data="data">        
        <form class="space-y-5" action="{{ route('employees.update', ['employee' => $employee->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Edit Employee</h5>
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4"> 
                    <x-text-input name="employee_code" value="{{ old('employee_code', $employee->employee_code) }}" :label="__('Employee Code')" :messages="$errors->get('employee_code')" :require="true"/>     
                    <div class="col-span-3">
                        <x-text-input name="name" value="{{ old('name', $employee->name) }}" :label="__('Employee Name')" :require="true" :messages="$errors->get('name')"/>  
                    </div>                       
                </div>  
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">
                <x-text-input name="contact_no_1" value="{{ old('contact_no_1', $employee->contact_no_1) }}" :label="__('Contact No 1')" :messages="$errors->get('contact_no_1')" :require="true"/>   
                    <x-text-input name="contact_no_2" value="{{ old('contact_no_2', $employee->contact_no_2) }}" :label="__('Contact No 2')" :messages="$errors->get('contact_no_2')"/>
                    <x-text-input name="dob" type="dob" value="{{ old('dob', $employee->dob) }}" id="dob" :label="__('DOB')" :messages="$errors->get('dob')" :require="true"/>
                </div>   
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-1"> 
                    <x-text-input name="address" value="{{ old('address', $employee->address) }}" :label="__('Address')" :messages="$errors->get('address')"/> 
                </div> 
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">               
                    <div>
                        <label>State:<span style="color: red">*</span></label>
                        <select class="form-input" name="state_name">
                            <option value="">Select state</option>
                            <template x-for="state in states" :key="state.code">
                                <option :value="state.name" x-text="state.name" :selected="state.name == '{{ $employee->state_name}}'"></option>
                            </template>
                        </select> 
                        <x-input-error :messages="$errors->get('state_name')" class="mt-2" />
                    </div>   
                    <x-text-input name="city" value="{{ old('city', $employee->city) }}" :label="__('City')" :messages="$errors->get('city')" :require="true"/>        
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">
                    <x-text-input name="fieldforce_name" value="{{ old('fieldforce_name', $employee->fieldforce_name) }}" :label="__('Fieldforce Name')" :messages="$errors->get('fieldforce_name')" :require="true"/>
                    <div>
                        <label>Designation :<span style="color: red">*</span></label>
                        <select class="form-input" name="designation" id="designation" x-model="designation" @change="designationChange()">
                            <!-- <option>Select Designation</option> -->
                            <option value="Zonal Manager" @if ($employee->designation == "Zonal Manager") {{ 'Selected' }} @endif>Zonal Manager</option>
                            <option value="Area Manager" @if ($employee->designation == "Area Manager") {{ 'Selected' }} @endif>Area Manager</option>                        
                            <option value="Marketing Executive" @if ($employee->designation == "Marketing Executive") {{ 'Selected' }} @endif>Marketing Executive</option> 
                        </select> 
                        <x-input-error :messages="$errors->get('designation')" class="mt-2" /> 
                    </div>
                    <div x-show="rbmopen">
                        <label>Zonal Manager :</label>
                        <select class="form-input" name="reporting_office_1" id="office_1" x-model="rbm" @change="reportOffice()">
                            <!-- <option value="">Select Office-1</option>                             -->
                            @foreach ($employee_list as $list)
                                @if($list->designation == 'Zonal Manager')
                                    <option value="{{$list->id}}" {{ $list->id ? ($list->id == $employee->reporting_office_1 ? 'Selected' : '') : '' }}>{{$list->name}}</option>
                                @endif
                            @endforeach
                        </select> 
                        <x-input-error :messages="$errors->get('reporting_office_1')" class="mt-2" /> 
                    </div>
                    <div x-show="abmopen">
                        <label>Area Manager :</label>
                        <select class="form-input" name="reporting_office_2" x-model="abml">
                            <option value="">Select Area Manager</option>
                            <template x-for="list in abm" :key="list.id">
                                <option :value="list.id" :selected='list.id == abml' x-text="list.name"></option>
                            </template>
                        </select> 
                        <x-input-error :messages="$errors->get('reporting_office_2')" class="mt-2" />
                    </div>  
                </div> 
                <hr><br>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">
                    <x-combo-input name="email" type="email" :email="true" value="{{ old('email', $employee->email) }}" :label="__('Email')" :messages="$errors->get('email')" :require="true"/> 
                    <x-text-input name="new_password" type="password" :label="__('New Password')" :messages="$errors->get('new_password')"/>
                </div>
                <div class="flex justify-end mt-4">
                    <x-success-button>
                        {{ __('Submit') }}
                    </x-success-button>
                    &nbsp;&nbsp;
                    <x-cancel-button :link="route('employees.index')">
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
            this.rbmopen = true;
            this.abmopen = true;
            this.abm = '';
            this.mehq = '';
            this.manager = '';
            @if($employee->designation)
                this.designation = '{{  $employee->designation }}';
                this.designationChange();
            @endif
          
            flatpickr(document.getElementById('dob'), {
                dateFormat: 'd/m/Y',
            });           

            var options = {
                searchable: true
            };
            NiceSelect.bind(document.getElementById("designation"), options);
            NiceSelect.bind(document.getElementById("office_1"), options);
            // NiceSelect.bind(document.getElementById("office_2"), options);
            // NiceSelect.bind(document.getElementById("office_3"), options);

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
        
        rbm: '',
        abm: '',
        async reportOffice() {               
            this.abm = await (await fetch('/employees/'+ this.rbm, {
                method: 'GET',
                headers: {
                    'Content-type': 'application/json;',
                },
            })).json();

            @if($employee->reporting_office_2)
                this.abml = {{  $employee->reporting_office_2 }};
            @endif
        },      

        mehq: '',
        abml:'',
        async reportOfficeME() {
            this.mehq = await (await fetch('/employees/getReportingOfficer3/'+ this.abml, {
                method: 'GET',
                headers: {
                    'Content-type': 'application/json;',
                },
            })).json();
            console.log(this.mehq);
        },

        designation: '',
        designationChange(){
            if (this.designation == 'Zonal Manager') {
                this.rbmopen = false;
                this.abmopen = false;
            } else if (this.designation == 'Area Manager') {
                this.rbmopen = true;
                this.abmopen = false;
                @if($employee->reporting_office_1)
                    this.rbm ={{  $employee->reporting_office_1 }};
                @endif
            } else if (this.designation == 'Marketing Executive') {
                this.rbmopen = true;
                @if($employee->reporting_office_1)
                    this.rbm ={{  $employee->reporting_office_1 }};
                @endif
                this.reportOffice();
                this.abmopen = true;

            } else {                
                this.rbmopen = true;
                this.abmopen = true;

                @if($employee->reporting_office_1)
                    this.rbm ={{  $employee->reporting_office_1 }};
                @endif

                this.reportOffice();
                @if($employee->reporting_office_2)
                    this.abml = {{  $employee->reporting_office_2 }};
                @endif

                @if($employee->reporting_office_3)
                    this.manager ={{  $employee->reporting_office_3 }};
                @endif
               
            }
        }
    }));
});   
</script>
</x-layout.default>
