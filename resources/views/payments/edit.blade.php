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
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-3">     
                    @foreach ($hotels as $id => $hotel)
                    <input type="hidden" value="{{ $id }}" name="hotel_id"/>
                    @endforeach
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">                                      
                    <x-text-input name="voucher_no" value="{{ old('voucher_no', $payment->voucher_no) }}" :label="__('Voucher No')"  :messages="$errors->get('voucher_no')"  />  
                    <x-text-input name="voucher_date" value="{{ old('voucher_date', $payment->voucher_date) }}" id="voucher_date" :label="__('Voucher Date')" :messages="$errors->get('voucher_date')"/>
                    <div>
                        <label>Supplier :</label>
                        <select class="form-input" name="supplier_id" x-model="supplier_id" x-on:change="supplierChange()">
                            <option>Select Supplier</option>
                            @foreach ($suppliers as $id=>$supplier)                                
                                <option value="{{$id}}" {{ $payment->supplier_id ? ($payment->supplier_id == $id ? 'Selected' : '' ) : ''}}>{{$supplier}}</option>
                            @endforeach
                        </select> 
                        <x-input-error :messages="$errors->get('supplier_id')" class="mt-2" /> 
                    </div>
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
                                <th>Paid Amount</th>
                            </tr>
                        </thead>
                        <tbody>  
                            <tr>
                                <td></td>
                                <td></td>                                
                                <td></td>
                                <td>
                                    <x-text-input class="form-input" name="paid_amount" value="{{ old('paid_amount') }}" :messages="$errors->get('paid_amount')"/>  
                                </td>
                            </tr>
                        </tbody>
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
                            <option value="Cash"@if ($payment->payment_mode == "Cash") {{ 'Selected' }} @endif>Cash</option>
                            <option value="Bank"@if ($payment->payment_mode == "Bank") {{ 'Selected' }} @endif>Bank</option>
                            <option value="UPI"@if ($payment->payment_mode == "UPI") {{ 'Selected' }} @endif>UPI</option>
                            <option value="Card"@if ($payment->payment_mode == "Card") {{ 'Selected' }} @endif>Card</option>                            
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
                </div>               
            </div>            
        </form> 
    </div>
</div>
<script>
document.addEventListener("alpine:init", () => {
    Alpine.data('data', () => ({     
        init() {       
            this.refno_open = false;
            this.chqno_open = false;
            this.bkname_open = false; 
            this.upino_open = false;    
            flatpickr(document.getElementById('voucher_date'), {
                dateFormat: 'd/m/Y',
            });
            @if($payment->paymentMode)
                this.paymentMode = '{{$payment->paymentMode}}';
                this.paymentModeChange();
            @endif
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

        supplier_id: '',
        data: '',
        async supplierChange() {
            this.data = await (await fetch('/purchases/'+ this.supplier_id, {
            method: 'GET',
            headers: {
                'Content-type': 'application/json;',
            },
            })).json();
            console.log(this.data);
        },
    }));
});
</script>
</x-layout.default>
