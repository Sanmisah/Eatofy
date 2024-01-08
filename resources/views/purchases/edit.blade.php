<x-layout.default>
    <style>
        table thead tr th, table tfoot tr th, table tbody tr td {
                padding-top: 0.75rem;
                padding-bottom: 0.75rem;
                padding-left: 0.2rem;
                padding-right: 0.2rem;
            }
    </style>
<div>
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="{{ route('roi_accountability_reports.index') }}" class="text-primary hover:underline">ROI Accountability Report</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>Edit</span>
        </li>
    </ul>
    <div class="pt-5" x-data="data">        
        <form class="space-y-5" action="{{ route('roi_accountability_reports.update', ['roi_accountability_report' => $roi_accountability_report->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Edit ROI Accountability Report</h5>
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">
                    <div>
                        <label>GAF Code :<span style="color: red">*</span></label>
                        <select class="form-input" name="grant_approval_id" x-model="code" id="code" @change="codeChange()">
                            @foreach ($gaf_code as $id => $code)
                                <option value="{{$id}}" {{ $roi_accountability_report->grant_approval_id ? ($roi_accountability_report->grant_approval_id == $id ? 'Selected' : '' ) : ''}}>{{ $code }}</option>
                            @endforeach
                        </select> 
                        <x-input-error :messages="$errors->get('grant_approval_id')" class="mt-2" /> 
                    </div>
                    <x-text-input class="bg-gray-100 dark:bg-gray-700" :label="__('Marketing Executive')"  :messages="$errors->get('employee_id_2')" x-model="manager" readonly="true"/>                       
                    <x-text-input class="bg-gray-100 dark:bg-gray-700" :label="__('Area Manager')"  :messages="$errors->get('employee_id_2')" x-model="area" readonly="true"/>                       
                    <x-text-input class="bg-gray-100 dark:bg-gray-700" :label="__('Zonal Manager')"  :messages="$errors->get('employee_id_2')" x-model="zone" readonly="true"/>   
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">
                   
                   <x-text-input class="bg-gray-100 dark:bg-gray-700" x-model="doctor"  :label="__('Doctor Name')"  :messages="$errors->get('doctor_id')" readonly="true"/>
                   <x-text-input name="mpl_no" class="bg-gray-100 dark:bg-gray-700" x-model="mpl_no" value="{{ old('mpl_no') }}" :label="__('MPL NO')"  :messages="$errors->get('mpl_no')" readonly="true"/>
                   <x-text-input name="speciality" class="bg-gray-100 dark:bg-gray-700" x-model="speciality" value="{{ old('speciality') }}" :label="__('Speciality')"  :messages="$errors->get('speciality')" readonly="true"/>
                   <x-text-input name="location" class="bg-gray-100 dark:bg-gray-700" x-model="location" value="{{ old('location') }}" :label="__('Location')"  :messages="$errors->get('location')" readonly="true"/>
               </div>
               <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">
                   <x-text-input name="rar_date" class="bg-gray-100 dark:bg-gray-700" x-model="date" value="{{ old('rar_date') }}" id="text" :label="__('Date')"  :messages="$errors->get('date')" readonly="true"/>
                   <x-text-input name="proposal_month" class="bg-gray-100 dark:bg-gray-700" x-model="month" value="{{ old('proposal_month') }}" :label="__('Proposal Month')"  :messages="$errors->get('month')" readonly="true"/>     
                   <x-combo-input name="amount" class="bg-gray-100 dark:bg-gray-700" x-model="amount" value="{{ old('amount') }}" :label="__('Amount')"  :messages="$errors->get('amount')" readonly="true"/>
                    <x-text-input name="roi" x-model="total_roi" @change="calcROI()" value="{{ old('roi', $roi_accountability_report->roi) }}" :label="__('ROI')"  :messages="$errors->get('roi')"/>
                </div>    
            </div>
            <div class="panel table-responsive">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light"> Add Products</h5>
                </div>
                <div>
                    <div class="flex xl:flex-row flex-col gap-1">
                        <div class="panel px-0 flex-1  ltr:xl:mr-6 rtl:xl:ml-6">
                            <div class="mt-8">
                                <div class="table-responsive">
                                    <table class="table-hover">
                                        <thead>
                                            <tr>
                                                <th width="5%">&nbsp; #</th>
                                                <th>Product</th>
                                                <th>NRV</th>
                                                <th>Month</th>
                                                <th>Scheme %</th>
                                                <th>Act Vol</th>
                                                <th>Act Val</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template x-if="productDetails.length <= 0">
                                                <tr >
                                                    <td colspan="5" class="!text-center font-semibold">No Data Available
                                                    </td>
                                                </tr>
                                            </template>
                                            <template x-for="(productDetail, i) in productDetails" :key="i">
                                                <tr>
                                                    <td>
                                                        <button type="button" @click="removeItem(productDetail)">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24px"
                                                                height="24px" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="1.5"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="w-5 h-5">
                                                                <line x1="18" y1="6" x2="6"
                                                                    y2="18"></line>
                                                                <line x1="6" y1="6" x2="18"
                                                                    y2="18"></line>
                                                            </svg>
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <input type="hidden" class="form-input min-w-[230px]" x-model="productDetail.id" x-bind:name="`product_details[${productDetail.id}][id]`"/>
                                                        <select class="form-input" name="product_id" x-model="productDetail.product_id" x-bind:name="`product_details[${productDetail.id}][product_id]`"  x-on:change="productChange()">
                                                            <option>Select Product</option>
                                                                @foreach ($products as $id => $product)
                                                                    <option value="{{$id}}"
                                                                    {{ $id ? ($id == $roi_accountability_report->product_id ? 'selected' : '') : '' }}> {{$product}} </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <x-text-input   class="bg-gray-100 dark:bg-gray-700" readonly="true" x-bind:name="`product_details[${productDetail.id}][nrv]`"  :messages="$errors->get('nrv')" x-model="productDetail.nrv"/>
                                                    </td>
                                                    <td>
                                                        <select class="form-input" style="width:120px;" x-bind:name="`product_details[${productDetail.id}][month]`" x-model="productDetail.month">
                                                            <option>Select Month</option>
                                                            <option value="Jan /2023">Jan /2023</option>
                                                            <option value="Feb /2023">Feb /2023</option>
                                                            <option value="Mar /2023">Mar /2023</option>
                                                            <option value="Apr /2023">Apr /2023</option>
                                                            <option value="May /2023">May /2023</option>
                                                            <option value="Jun /2023">Jun /2023</option>
                                                            <option value="Jul /2023">Jul /2023</option>
                                                            <option value="Aug /2023">Aug /2023</option>
                                                            <option value="Sep /2023">Sep /2023</option>
                                                            <option value="Oct /2023">Oct /2023</option>
                                                            <option value="Nov /2023">Nov /2023</option>
                                                            <option value="Dec /2023">Dec /2023</option>
                                                        </select> 
                                                        <x-input-error :messages="$errors->get('month')" class="mt-2" /> 
                                                    </td>
                                                    <td>
                                                        <!-- <x-text-input x-bind:name="`product_details[${productDetail.id}][scheme]`"  :messages="$errors->get('scheme')" x-model="productDetail.scheme"/> -->
                                                        <select class="form-input" style="width:100px;" x-bind:name="`product_details[${productDetail.id}][scheme]`" x-model="productDetail.scheme" >
                                                            <option> Scheme </option>
                                                            @for ($i = 1; $i < 100; $i++)
                                                                <option value="{{ $i }}" {{ $i ? ($i == $roi_accountability_report->scheme ? 'selected' : '') : '' }}> {{ $i }}% </option>
                                                            @endfor
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <x-text-input x-bind:name="`product_details[${productDetail.id}][act_vol]`"  :messages="$errors->get('act_vol')" x-model="productDetail.act_vol"/>
                                                    </td>
                                                    <td>
                                                        <x-text-input  x-bind:name="`product_details[${productDetail.id}][act_val]`"  :messages="$errors->get('act_val')" x-model="productDetail.act_val" @change="calculateTotal()"/>
                                                    </td>
                                                    
                                                </tr>
                                            </template>
                                            <tr>
                                                <td>
                                                    <button type="button" class="btn btn-info" @click.prevent="addItem()">+ </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot  style="background-color: #FFFFF;">
                                            <tr>
                                                <th colspan="6" style="text-align:right;">Total of Actual Value: </th>
                                                <td>               
                                                    <x-text-input class="form-input bg-gray-100 dark:bg-gray-700" x-model="total" readonly="true" :messages="$errors->get('total_actual_value')" value="{{ old('total_actual_value', $roi_accountability_report->total_actual_value) }}" name="total_actual_value"/>
                                                </td>
                                            </tr>
                                        </tfoot>                                   
                                    </table>
                                </div>
                            </div>                            
                        </div>                    
                    </div>
                </div>                
            </div>  
            <div class="flex justify-end mt-4">
                <x-success-button>
                    {{ __('Submit') }}
                </x-success-button>
                &nbsp;&nbsp;
                <x-cancel-button :link="route('roi_accountability_reports.index')">
                    {{ __('Cancel') }}
                </x-cancel-button>
            </div>
        </form> 
    </div>
</div>
<script>
document.addEventListener("alpine:init", () => {
    Alpine.data('data', () => ({
        product_id: '',
        nrv: '',
        async productChange() {               
            this.productDetail.nrv = await (await fetch('/products/'+ this.productDetail.product_id, {
            method: 'GET',
            headers: {
                'Content-type': 'application/json;',
            },
            })).json();
            this.calcROI();
        },

        product_id: '',
        nrv: '',     
        productDetails: [],       
        init() {
            
            this.roi = 0;
            this.total = 0;
            this.total_roi = 0;
            var options = {
                searchable: true
            };
            NiceSelect.bind(document.getElementById("code"), options);
            @if($roi_accountability_report->grant_approval_id)
                this.code = {{  $roi_accountability_report->grant_approval_id }};
                this.codeChange();
            @endif

          

            let maxId = 0; 
            id='';
            @if($roi_accountability_report['RoiAccountabilityReportDetails'])
            @foreach($roi_accountability_report['RoiAccountabilityReportDetails'] as $i=>$details)
            this.productDetails.push({
                i: ++maxId,
                id: '{{ $details->id }}',
                product_id: '{{ $details->product_id }}',
                nrv: '{{ $details->nrv }}',
                month: '{{ $details->month }}',
                act_vol: '{{ $details->act_vol }}',
                act_val: '{{ $details->act_val }}',
                scheme: '{{ $details->scheme }}',
            });                    
            @endforeach
            @endif 
            
            @if($roi_accountability_report->total_actual_value)                
                this.total = {{  $roi_accountability_report->total_actual_value }};
                this.calculateTotal();
            @endif

            @if($roi_accountability_report->roi)                
                this.total_roi = {{  $roi_accountability_report->roi }};
            @endif

        },
           
        addItem() {
            let maxId = 0;
            if (this.productDetails && this.productDetails.length) {
                maxId = this.productDetails.reduce((max, character) => (character.id > max ? character
                    .id : max), this.productDetails[0].id);
            }
            this.productDetails.push({
                id: maxId + 1,
                product_id: '',
                nrv: '',
                month: '',
                act_vol: '',
                act_val: '',
                scheme: '',
            });
            this.calculateTotal();
        }, 
                        
        removeItem(productDetail) {
            this.productDetails = this.productDetails.filter((d) => d.id != productDetail.id);
            this.calculateTotal();
        },

        code: '',
        employee_id_1: '',
        employee_id_2: '',
        employee_id_3: '',
        doctor: '',
        mpl_no: '',
        speciality: '',
        location: '',
        date: '',
        month: '',
        amount: '',
        data: '',
        area: '',
        zone: '',
        manager: '',
        docData: '',
        async codeChange(){
            this.data = await (await fetch('/grant_approvals/'+ this.code, {
                method: 'GET',
                headers: {
                    'Content-type': 'application/json;',
                },
            })).json();
            this.manager = this.data.manager.name;
            this.area = this.data.manager.area_manager.name;
            this.zone = this.data.manager.zonal_manager.name;
            this.doctor = this.data.doctor.doctor_name;
            this.mpl_no = this.data.doctor.mpl_no;
            this.location = this.data.doctor.type;
            this.speciality = this.data.doctor.speciality;
            this.date = this.data.date_of_issue;
            this.month = this.data.proposal_month;
            this.amount = this.data.proposal_amount;
        },

        calculateTotal() {
            let total = 0;  
            this.productDetails.forEach(productDetail => {
                total = (parseFloat(total) + parseFloat(productDetail.act_val)).toFixed(2);
            });                     
            if(!isNaN(total)){
                this.total = total;
            }    
            this.calcROI();
        },

        calcROI() {
            let roi = 0;
            if(!isNaN(this.total) && this.total != '' && !isNaN(this.amount) && this.amount != ''){
                this.roi = (this.total / this.amount).toFixed(2); 
            }    

          
        },
    }));
});

</script>
</x-layout.default>
