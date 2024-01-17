<x-layout.default>   
<div>
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="{{ route('hotels.index') }}" class="text-primary hover:underline">Hotels</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>Edit</span>
        </li>
    </ul>
    <div class="pt-5" x-data="data">        
        <form class="space-y-5" action="{{ route('hotels.storeSubscription', ['hotel' => $hotel->id]) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Add Subscription</h5>
                </div>                
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">
                    <div>
                        <label>Package :<span style="color: red">*</span></label>
                        <select class="form-input" name="package_id" x-model="package_id" x-on:change="packageChange()">
                            <option value="">Select Package</option>
                            @foreach ($packages as $id=>$package)                                
                                <option value="{{$id}}">{{$package}}</option>
                            @endforeach
                        </select> 
                        <x-input-error :messages="$errors->get('package_id')" class="mt-2" /> 
                    </div>
                    <x-text-input class="bg-gray-100 dark:bg-gray-700" readonly="true" :messages="$errors->get('validity_in_days')" :label="__('Validity(In Days)')" x-model="validity_in_days" />
                    <x-text-input class="bg-gray-100 dark:bg-gray-700" readonly="true" :messages="$errors->get('cost')" :label="__('Cost')" x-model="cost"/>                                                          
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">
                    <x-text-input name="subscription_no" value="{{ old('subscription_no') }}" :label="__('Subscription No')"  :messages="$errors->get('subscription_no')" class="bg-gray-100 dark:bg-gray-700" readonly="true" />  
                    <x-text-input name="subscription_date" value="{{ old('subscription_date') }}" :label="__('Subscription Date')" id="subscription_date" x-model="subscription_date" x-on:change.debounce="dateChange()" :messages="$errors->get('subscription_date')" :require="true"/>     
                    <x-text-input name="expiry_date" value="{{ old('expiry_date') }}" x-model="expiry_date" :label="__('Expiry Date')" id="expiry_date" class="bg-gray-100 dark:bg-gray-700" readonly="true"  :messages="$errors->get('expiry_date')"/>                                     
                </div>
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Payment mode</h5>
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">
                    <div>
                        <label>Payment Mode:<span style="color: red">*</span></label>
                        <select class="form-select" name="payment_mode" x-model="paymentMode" @change="paymentModeChange()">
                            <option value="">Select Payment mode</option>
                            <option value="Cash">Cash</option>
                            <option value="Bank">Bank</option>
                            <option value="UPI">UPI</option>
                            <option value="Card">Card</option>                            
                        </select>
                        <x-input-error :messages="$errors->get('payment_mode')" class="mt-2" /> 
                    </div>               
                    <div x-show="chqno_open">
                        <x-text-input class="form-input" :label="__('Cheque No')" id="cheque_no" name="cheque_no" value="{{ old('cheque_no') }}" :messages="$errors->get('cheque_no')"/>  
                    </div>
                    <div x-show="bkname_open">
                        <x-text-input class="form-input" :label="__('Bank name')" id="bank_name" name="bank_name" value="{{ old('bank_name') }}" :messages="$errors->get('bank_name')"/>    
                    </div>   
                    <div x-show="refno_open">   
                        <x-text-input class="form-input" :label="__('Reference No')" name="reference_no" value="{{ old('reference_no') }}" :messages="$errors->get('reference_no')"/>     
                    </div>  
                    <div x-show="upino_open">     
                        <x-text-input class="form-input" :label="__('UPI No')" name="upi_no" value="{{ old('upi_no') }}" :messages="$errors->get('upi_no')"/>
                    </div>    
                    <div>
                        <x-text-input class="form-input" :label="__('Payment Date')" id="payment_date" name="payment_date" value="{{ old('payment_date') }}" :messages="$errors->get('payment_date')"/>
                    </div>             
                </div> 
                <div class="flex justify-end mt-4">
                    <x-cancel-button :link="route('hotels.index')">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script>
document.addEventListener("alpine:init", () => {
    Alpine.data('data', () => ({     
        packageData:'',
        validity_in_days: '',
        cost: '',
        package_id: '',
        init() {        
            this.refno_open = false;
            this.chqno_open = false;
            this.bkname_open = false; 
            this.upino_open = false;  

            flatpickr(document.getElementById('subscription_date'), {
                dateFormat: 'd/m/Y',
            });

            flatpickr(document.getElementById('payment_date'), {
                dateFormat: 'd/m/Y',
            });

            flatpickr(document.getElementById('expiry_date'), {
                dateFormat: 'd/m/Y',
            });
        },
        
        async packageChange() {                  
            this.packageData = await (await fetch('/packages/'+ this.package_id, {
            method: 'GET',
            headers: {
                'Content-type': 'application/json;',
            },
            })).json();
            this.validity_in_days = this.packageData.validity_in_days;
            this.cost = this.packageData.cost;
        },    
        
        paymentMode: '',
        paymentModeChange(){
            if (this.paymentMode == 'Cash') {
                this.refno_open = false;
                this.chqno_open = false;
                this.bkname_open = false;
                this.upino_open = false; 
            } else if (this.paymentMode == 'UPI') {
                this.refno_open = false;
                this.chqno_open = false;
                this.bkname_open = false;
                this.upino_open = true; 
            } else if (this.paymentMode == 'Card'){
                this.refno_open = true; 
                this.chqno_open = false;
                this.bkname_open = false;
                this.upino_open = false; 
            } else if (this.paymentMode == 'Bank'){
                this.refno_open = false;
                this.chqno_open = true;
                this.bkname_open = true;
                this.upino_open = false; 
            } else {
                this.refno_open = true;
                this.chqno_open = true;
                this.bkname_open = true;
                this.upino_open = true; 
            }
        },

        subscription_date: '',
        expiry_date : '',
        dateChange(){   
            this.expiry_date = moment(this.subscription_date, 'DD/MM/YYYY').add(this.validity_in_days, 'days').format("DD/MM/YYYY");
            console.log(this.expiry_date);
        },
    }));
});
</script>
</x-layout.default>
