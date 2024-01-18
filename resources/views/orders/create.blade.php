<?php
use Carbon\Carbon; 
?>
<x-layout.default>
<div>
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="{{ route('orders.index') }}" class="text-primary hover:underline">Order</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>Add</span>
        </li>
    </ul>
    <div class="pt-5" x-data="data">        
        <form class="space-y-5" action="{{ route('orders.store') }}" method="POST">
            @csrf
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Add Order</h5>
                </div>               
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-3">     
                    @foreach ($hotels as $id => $hotel)
                    <input type="hidden" value="{{ $id }}" name="hotel_id"/>
                    @endforeach
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">
                    <x-text-input name="bill_date" value="{{ old('bill_date', Carbon::now()->format('d/m/Y')) }}" :label="__('Bill Date')" id="bill_date" class="bg-gray-100 dark:bg-gray-700" readonly="true" :messages="$errors->get('bill_date')"/>                    
                    <x-text-input name="bill_no" value="{{ old('bill_no') }}" :label="__('Bill No')"  :messages="$errors->get('bill_no')" class="bg-gray-100 dark:bg-gray-700" readonly="true" />  
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">
                    <x-text-input name="customer_name" value="{{ old('customer_name') }}" :label="__('Customer Name')" :require="true" :messages="$errors->get('customer_name')"/>
                    <x-text-input name="mobile_no" value="{{ old('mobile_no') }}" :label="__('Mobile No')" :messages="$errors->get('mobile_no')" :require="true"/>     
                    <div>
                        <label>Table :<span style="color: red">*</span></label>
                        <select class="form-input" name="table_id" id="table_id">
                            <option value="">Select Table</option>
                            @foreach ($tables as $id=>$table)                                
                                <option value="{{$id}}">{{$table}}</option>
                            @endforeach
                        </select> 
                        <x-input-error :messages="$errors->get('table_id')" class="mt-2" /> 
                    </div> 
                    <div>
                        <label>Server :<span style="color: red">*</span></label>
                        <select class="form-input" name="server_id" id="server_id">
                            <option value="">Select Server</option>
                            @foreach ($servers as $id=>$server)                                
                                <option value="{{$id}}">{{$server}}</option>
                            @endforeach
                        </select> 
                        <x-input-error :messages="$errors->get('server_id')" class="mt-2" /> 
                    </div>
                </div>
            </div>            
            <div class="panel table-responsive">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light"> Add Items</h5>
                </div>
                <div class="flex xl:flex-row flex-col gap-2.5">
                    <div class="panel px-0 flex-1 py-1 ltr:xl:mr-6 rtl:xl:ml-6">
                        <div class="mt-8">
                            <template x-if="orderDetails">
                                <div class="table-responsive">
                                    <table class="table-hover">
                                        <thead>
                                            <tr>
                                                <th>&nbsp; #</th>
                                                <th>Items</th>
                                                <th>Rate</th>  
                                                <th>Qty</th>                               
                                                <th>Instruction</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template x-if="orderDetails.length <= 0">
                                                <tr >
                                                    <td colspan="6" class="!text-center font-semibold">No Data Available
                                                    </td>
                                                </tr>
                                            </template>
                                            <template x-for="(orderDetail, i) in orderDetails" :key="i">
                                                <tr>
                                                    <td>
                                                        <button type="button" @click="removeItem(orderDetail)">
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
                                                        <select class="form-input" x-model="orderDetail.menu_id" x-bind:name="`order_details[${orderDetail.id}][menu_id]`" x-on:change="menuChange()">
                                                            <option>Select Items</option>
                                                                @foreach ($menus as $id => $menu)
                                                                    <option value="{{$id}}"> {{$menu}} </option>
                                                            @endforeach
                                                        </select>
                                                        <x-input-error :messages="$errors->get('menu_id')" class="mt-2" /> 
                                                    </td>
                                                    <td>
                                                        <x-text-input class="bg-gray-100 dark:bg-gray-700" readonly="true" x-bind:name="`order_details[${orderDetail.id}][rate]`"  :messages="$errors->get('rate')" x-model="orderDetail.rate"/>
                                                    </td>
                                                    <td>
                                                        <x-text-input x-bind:name="`order_details[${orderDetail.id}][qty]`" :messages="$errors->get('qty')" x-model="orderDetail.qty" @change="calculateAmount()"/>
                                                    </td> 
                                                    <td>
                                                        <x-text-input x-bind:name="`order_details[${orderDetail.id}][instruction]`" :messages="$errors->get('instruction')" x-model="orderDetail.instruction"/>
                                                    </td> 
                                                    <td>
                                                        <x-text-input  x-bind:name="`order_details[${orderDetail.id}][amount]`"  :messages="$errors->get('amount')" x-model="orderDetail.amount" @change="calculateTotal()"/>
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
                                                <th colspan="5" style="text-align:right;">Total Amount: </th>
                                                <td>               
                                                    <x-text-input class="form-input bg-gray-100 dark:bg-gray-700" readonly="true" :messages="$errors->get('total_amount')" x-model="total_amount" name="total_amount"/>
                                                </td>
                                            </tr>
                                        </tfoot>                
                                    </table>
                                </div>
                            </template>                                                
                        </div>                            
                    </div>                    
                </div>
                <div class="flex justify-end mt-4">
                    <x-cancel-button :link="route('orders.index')">
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
        menuData:'',            
        init() {     
            this.amount = 0;  
            this.total_amount = 0;   
            flatpickr(document.getElementById('bill_date'), {
                dateFormat: 'd/m/Y',
            });
        },      
        
        orderDetails: [],
        addItem() {
            let maxId = 0;
            if (this.orderDetails && this.orderDetails.length) {
                maxId = this.orderDetails.reduce((max, character) => (character.id > max ? character
                    .id : max), this.orderDetails[0].id);
            }
            this.orderDetails.push({
                id: maxId + 1,
                menu_id: '',
                qty: '',
                rate: '',                
                instruction: '',
                amount: '',
            });         
            this.calculateAmount();
            this.calculateTotal();
        }, 
        
        removeItem(orderDetail) {
            this.orderDetails = this.orderDetails.filter((d) => d.id != orderDetail.id);
            this.calculateAmount();
            this.calculateTotal();
           
        }, 
        
        async menuChange() {                  
            this.menuData = await (await fetch('/menus/'+ this.orderDetail.menu_id, {
            method: 'GET',
            headers: {
                'Content-type': 'application/json;',
            },
            })).json();
            this.orderDetail.rate = this.menuData.rate;
        },

        calculateAmount() {            
            this.orderDetails.forEach(orderDetail => {     
                total = orderDetail.qty * orderDetail.rate;          
                orderDetail.amount = total.toFixed(2);
            }); 
            this.calculateTotal();
        },

        calculateTotal() {
            let total_amount = 0;
            this.orderDetails.forEach(orderDetail => {
                total_amount = parseFloat(total_amount) + parseFloat(orderDetail.amount);
            });                     
            if(!isNaN(total_amount)){
                this.total_amount = total_amount.toFixed(2);
            }     
        },
    }));
});
</script> 
</x-layout.default>
