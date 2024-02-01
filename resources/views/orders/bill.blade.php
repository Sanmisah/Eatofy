<?php
use Carbon\Carbon; 
?>
<x-layout.default>
<div>
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="{{ route('orders.index') }}" class="text-primary hover:underline">Orders</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>View</span>
        </li>
    </ul>
    <div class="pt-5" x-data="data">   
        <form class="space-y-5" action="{{ route('orders.updatePaymentData', ['order' => $order->id]) }}" method="POST">
            @csrf
            @method('PATCH')     
            <div class="panel">
                <div class="table-responsive">
                    <table>
                        <tr>                            
                            <th>Bill No</th>
                            <td>{{ $order->bill_no}}</td>
                            <th>Bill Date </th>
                            <td>{{ $order->bill_date }}</td>
                        </tr>                         
                        <tr> 
                            <th>Customer Name </th>
                            <td>{{ $order->customer_name }}</td>                         
                            <th>Mobile No</th>
                            <td>{{ $order->mobile_no }}</td> 
                        </tr>
                        <tr> 
                            <th>Table</th>
                            <td>{{ @$order->Table->name }}</td>                         
                            <th>Server</th>
                            <td>{{ @$order->Server->name }}</td> 
                        </tr>
                    </table>
                </div>
            </div>
            <div class="panel">
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>                            
                                <th>Item</th>                            
                                <th>Rate </th>                            
                                <th>Qty </th>  
                                <th>Instruction</th>                                             
                                <th>Amount</th>                          
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->OrderDetails as $detail)
                            <tr>                            
                                <td>{{ @$detail->Menu->item_name }}</td>                            
                                <td>{{ @$detail->rate }}</td>                            
                                <td>{{ @$detail->qty }}</td>                                               
                                <td>{{ @$detail->instruction }}</td>   
                                <td>{{ @$detail->amount }}</td>                         
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot> 
                            <tr>
                                <th colspan="4" style="text-align:right;">Total: </th>
                                <td>{{ @$order->total }}</td>
                            </tr>
                            <tr>
                                <th colspan="4" style="text-align:right;">Discount : </th>
                                <td>{{ @$order->discount_amount }}%</td>
                            </tr>
                            <tr>
                                <th colspan="4" style="text-align:right;">Total Amount: </th>
                                <td>{{ @$order->total_amount }}</td>
                            </tr>                            
                        </tfoot>
                    </table>
                </div>
            </div> 
            <div class="panel" x-data="data">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Payment mode</h5>
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">
                    <div>
                        <label>Payment Mode:</label>
                        <select class="form-select" name="payment_mode" id="payment_mode" x-model="paymentMode" @change="paymentModeChange()">
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

            flatpickr(document.getElementById('payment_date'), {
                dateFormat: 'd/m/Y',
            });

            // var options = {
            //     searchable: true
            // };
            // NiceSelect.bind(document.getElementById("payment_mode"), options);
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
    }));
});
</script> 
</x-layout.default>
