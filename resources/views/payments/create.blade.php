<?php
use Carbon\Carbon; 
?>
<x-layout.default>
<div>
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="{{ route('payments.index') }}" class="text-primary hover:underline">Payment</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>Add</span>
        </li>
    </ul>
    <div class="pt-5" x-data="data">        
        <form class="space-y-5" action="{{ route('payments.store') }}" method="POST">
            @csrf
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Add Payment</h5>
                </div>               
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-3">     
                    @foreach ($hotels as $id => $hotel)
                    <input type="hidden" value="{{ $id }}" name="hotel_id"/>
                    @endforeach
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">                         
                    <x-text-input name="voucher_no" class="bg-gray-100 dark:bg-gray-700" readonly="true" value="{{ old('voucher_no') }}" :label="__('Voucher No')"  :messages="$errors->get('voucher_no')"  />  
                    <x-text-input name="voucher_date" value="{{ old('voucher_date', Carbon::now()->format('d/m/Y')) }}" class="bg-gray-100 dark:bg-gray-700" readonly="true" :label="__('Voucher Date')" :messages="$errors->get('voucher_date')"/>
                    <div>
                        <label>Supplier :</label>
                        <select class="form-input" name="supplier_id" x-model="supplier_id" x-on:change="supplierChange()">
                            <option>Select Supplier</option>
                            @foreach ($suppliers as $id=>$supplier)                                
                                <option value="{{$id}}">{{$supplier}}</option>
                            @endforeach
                        </select> 
                        <x-input-error :messages="$errors->get('supplier_id')" class="mt-2" /> 
                    </div>
                    <!-- <x-text-input name="amount" value="{{ old('amount') }}" :label="__('Amount')"  :messages="$errors->get('amount')"  />  -->
                </div>    
            </div>
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Purchase list</h5>
                </div>               
                <div class="table-responsive">
                    <table class="table-hover">
                        <thead>
                            <tr>
                                <th>Invoice No</th>
                                <th>Invoice Date</th>                               
                                <th>Total Amount</th>
                                <th>Balance Amount</th>
                                <th>Paid Amount</th>
                            </tr>
                        </thead>
                        <template x-if="suppliers">
                        <tbody> 
                            <template x-for="(supplier,i) in suppliers" :key="i">
                            <tr>
                                <td x-text="supplier.invoice_no"></td>
                                <td x-text="supplier.invoice_date"></td>                                
                                <td x-text="supplier.total_amount"></td>
                                <td x-text="supplier.balance_amount"></td>
                                <td>          
                                    <input type="hidden" class="form-input min-w-[230px]" x-model="supplier.id" x-bind:name="`payment_details[${supplier.id}][id]`"/>                                   
                                    <x-text-input x-bind:name="`payment_details[${supplier.id}][paid_amount]`" :messages="$errors->get('paid_amount')" x-model="supplier.paid_amount" @change="calculateTotal()"/>
                                </td>
                            </tr>
                            </template>
                        </tbody>                        
                        </template>
                        <tfoot>
                            <tr>
                                <th colspan="4" style="text-align:right;">Total Amount: </th>
                                <td>               
                                    <x-text-input class="form-input bg-gray-100 dark:bg-gray-700" readonly="true" :messages="$errors->get('total')" x-model="total" name="total"/>
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
                    <x-cancel-button :link="route('payments.index')">
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
        init() {       
            this.refno_open = false;
            this.chqno_open = false;
            this.bkname_open = false; 
            this.upino_open = false;  
            this.total = 0;       
            // flatpickr(document.getElementById('voucher_date'), {
            //     dateFormat: 'd/m/Y',
            // });

            flatpickr(document.getElementById('payment_date'), {
                dateFormat: 'd/m/Y',
            });
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
        suppliers:'',
        async supplierChange() {            
            this.suppliers = await (await fetch('/purchases/getPurchaseData/'+ this.supplier_id, {
                method: 'GET',
                headers: {
                    'Content-type': 'application/json;',
                },
            })).json();
            console.log(this.suppliers)
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
