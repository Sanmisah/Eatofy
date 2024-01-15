<x-layout.default>
<div>
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="{{ route('payments.index') }}" class="text-primary hover:underline">Payment</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>Edit</span>
        </li>
    </ul>
    <div class="pt-5" x-data="data">        
        <form class="space-y-5" action="{{ route('payments.update', ['payment' => $payment->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Edit Purchase</h5>
                </div>                
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">                                      
                    <x-text-input name="voucher_no" class="bg-gray-100 dark:bg-gray-700" readonly="true" value="{{ old('voucher_no', $payment->voucher_no) }}" :label="__('Voucher No')" :messages="$errors->get('voucher_no')"  />  
                    <x-text-input name="voucher_date" class="bg-gray-100 dark:bg-gray-700" readonly="true" value="{{ old('voucher_date', $payment->voucher_date) }}" id="voucher_date" :label="__('Voucher Date')" :messages="$errors->get('voucher_date')" class="bg-gray-100 dark:bg-gray-700" readonly="true"/>
                    <x-text-input name="supplier_name" class="bg-gray-100 dark:bg-gray-700" readonly="true" value="{{ $payment->supplier->supplier_name }}" :label="__('Supplier Name')" :messages="$errors->get('supplier_name')"  />  
                </div>                 
            </div>    
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Purchase list</h5>
                </div>
                <div class="table-responsive">
                    <table class="table-striped">
                        <thead>
                            <tr>
                                <th>Invoice No</th>
                                <th>Invoice Date</th>                               
                                <th>Total Amount</th>
                                <th>Balance Amount</th>
                                <th>Paid Amount</th>
                            </tr>
                        </thead>
                        @foreach ($payment->paymentDetails as $val)
                        <tbody>  
                            
                            <tr>
                                <td>{{ @$val->purchase->invoice_no }}</td>
                                <td>{{ @$val->purchase->invoice_date }}</td>                                
                                <td>{{ @$val->purchase->total_amount }}</td>
                                <td>{{ @$val->purchase->balance_amount }}</td>
                                <td>
                                    <x-text-input class="form-input" name="paid_amount" value="{{ @$val->paid_amount }}" :messages="$errors->get('paid_amount')" @change="calculateTotal()"/>  
                                    <template x-for="(supplier, i) in suppliers" :key="i">
                                    </template>
                                </td>
                            </tr>
                            
                        </tbody>
                        @endforeach
                        <tfoot>
                            <tr>
                                <th colspan="4" style="text-align:right;">Total Amount: </th>
                                <td>               
                                    <x-text-input class="form-input bg-gray-100 dark:bg-gray-700" readonly="true" :messages="$errors->get('total')" x-model="total" name="total" value="{{ $payment->total }}"/>
                                </td>
                            </tr>
                        </tfoot>   
                    </table>
                </div>
            </div>
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Payment mode</h5>
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">
                    <div>
                        <label>Payment Mode:</label>
                        <select class="form-select" name="payment_mode" x-model="paymentMode" @change="paymentModeChange()">
                            <option>Select Payment mode</option>
                            <option value="Cash" @if ($payment->payment_mode == "Cash") {{ 'Selected' }} @endif>Cash</option>
                            <option value="Bank" @if ($payment->payment_mode == "Bank") {{ 'Selected' }} @endif>Bank</option>
                            <option value="UPI" @if ($payment->payment_mode == "UPI") {{ 'Selected' }} @endif>UPI</option>
                            <option value="Card" @if ($payment->payment_mode == "Card") {{ 'Selected' }} @endif>Card</option>                            
                        </select>
                        <x-input-error :messages="$errors->get('payment_mode')" class="mt-2" /> 
                    </div>               
                    <div x-show="chqno_open">
                        <x-text-input class="form-input" :label="__('Cheque No')" id="cheque_no" name="cheque_no" value="{{ old('cheque_no', $payment->cheque_no) }}" :messages="$errors->get('cheque_no')"/>  
                    </div>
                    <div x-show="bkname_open">
                        <x-text-input class="form-input" :label="__('Bank name')" id="bank_name" name="bank_name" value="{{ old('bank_name', $payment->bank_name) }}" :messages="$errors->get('bank_name')"/>    
                    </div>   
                    <div x-show="refno_open">   
                        <x-text-input class="form-input" :label="__('Reference No')" name="reference_no" value="{{ old('reference_no', $payment->reference_no) }}" :messages="$errors->get('reference_no')"/>     
                    </div>  
                    <div x-show="upino_open">     
                        <x-text-input class="form-input" :label="__('UPI No')" name="upi_no" value="{{ old('upi_no', $payment->upi_no) }}" :messages="$errors->get('upi_no')"/>
                    </div>         
                    <div>
                        <x-text-input class="form-input" :label="__('Payment Date')" id="payment_date" name="payment_date" value="{{ old('payment_date', $payment->payment_date) }}" :messages="$errors->get('payment_date')"/>
                    </div>         
                </div>               
            </div>            
        </form> 
    </div>
</div>
<script>
document.addEventListener("alpine:init", () => {
    Alpine.data('data', () => ({     
        suppliers: [],      
        init() {       
            this.refno_open = false;
            this.chqno_open = false;
            this.bkname_open = false; 
            this.upino_open = false;    
            flatpickr(document.getElementById('voucher_date'), {
                dateFormat: 'd/m/Y',
            });

            flatpickr(document.getElementById('payment_date'), {
                dateFormat: 'd/m/Y',
            });

            @if($payment->payment_mode)
                this.paymentMode = '{{$payment->payment_mode}}';
                this.paymentModeChange();
            @endif

            @if($payment->total)                
                this.total = {{ $payment->total }};
            @endif

            // @if($payment['paymentDetails'])
            //     @foreach($payment['paymentDetails'] as $i=>$details)            
            //         this.suppliers.paid_amount = {{ $details->paid_amount }};                                
            //     @endforeach
            // @endif 
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
                @if($payment->paymentMode)
                    this.upino_open={{$payment->upi_no}};
                @endif
            } else if (this.paymentMode == 'Card'){
                this.refno_open = true; 
                @if($payment->paymentMode)
                    this.refno_open={{$payment->reference_no}};
                @endif
                this.chqno_open = false;
                this.bkname_open = false;
                this.upino_open = false; 
            } else if (this.paymentMode == 'Bank'){
                this.refno_open = false;
                this.chqno_open = true;
                @if($payment->paymentMode)
                    this.chqno_open={{$payment->cheque_no}};
                @endif
                this.bkname_open = true;
                @if($payment->paymentMode)
                    this.bkname_open={{$payment->bank_name}};
                @endif
                this.upino_open = false; 
            } else {
                this.refno_open = true;
                this.chqno_open = true;
                this.bkname_open = true;
                this.upino_open = true; 
            }
        },

        calculateTotal() {            
            let total = 0;
            this.suppliers.forEach(supplier => {
                total = parseFloat(total) + parseFloat(supplier.paid_amount);                
            });                         
            if(!isNaN(total)){
                this.total = total.toFixed(2);
            }     
        },
    }));
});
</script>
</x-layout.default>
