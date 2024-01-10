<x-layout.default>
<div>
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="{{ route('purchases.index') }}" class="text-primary hover:underline">Purchases</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>Edit</span>
        </li>
    </ul>
    <div class="pt-5" x-data="data">        
        <form class="space-y-5" action="{{ route('purchases.update', ['purchase' => $purchase->id]) }}" method="POST">
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
                    <x-text-input name="purchase_date" value="{{ old('purchase_date', $purchase->purchase_date) }}" id="purchase_date" :label="__('Purchase Date')" :messages="$errors->get('purchase_date')"/>
                    <div>
                        <label>Supplier :</label>
                        <select class="form-input" name="supplier_id" id="supplier_id">
                            @foreach ($suppliers as $id=>$supplier)                                
                                <option value="{{$id}}"  {{ $purchase->supplier_id ? ($purchase->supplier_id == $id ? 'Selected' : '' ) : ''}}>{{$supplier}}</option>
                            @endforeach
                        </select> 
                        <x-input-error :messages="$errors->get('supplier_id')" class="mt-2" /> 
                    </div>
                    <x-text-input name="invoice_no" value="{{ old('invoice_no', $purchase->invoice_no) }}" :label="__('Invoice No')"  :messages="$errors->get('invoice_no')"  /> 
                    <x-text-input name="invoice_date" value="{{ old('invoice_date', $purchase->invoice_date) }}" id="invoice_date" :label="__('Invoice Date')" :messages="$errors->get('invoice_date')"/>
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">
                    <div>
                        <label>Upload File :</label>
                        <input type="file" name="attachment" class="form-input">  
                        <br />
                        @if($purchase->getFirstMediaUrl('attachment'))
                            <a href="{{ $purchase->getFirstMediaUrl('attachment')}}" target="_blank" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{basename($purchase->getFirstMediaUrl('attachment'))}}</a>
                        @endif
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
                            <template x-if="purchaseDetails">
                                <div class="table-responsive">
                                    <table class="table-hover">
                                        <thead>
                                            <tr>
                                                <th>&nbsp; #</th>
                                                <th>Items</th>
                                                <th>Unit</th>
                                                <th>Qty</th>
                                                <th>Rate</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template x-if="purchaseDetails.length <= 0">
                                                <tr >
                                                    <td colspan="6" class="!text-center font-semibold">No Data Available
                                                    </td>
                                                </tr>
                                            </template>
                                            <template x-for="(purchaseDetail, i) in purchaseDetails" :key="i">
                                                <tr>
                                                    <td>
                                                        <button type="button" @click="removeItem(purchaseDetail)">
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
                                                        <input type="hidden" class="form-input min-w-[230px]" x-model="purchaseDetail.id" x-bind:name="`purchase_details[${purchaseDetail.id}][id]`"/>
                                                        <select class="form-input" x-model="purchaseDetail.item" x-bind:name="`purchase_details[${purchaseDetail.id}][item]`"  x-on:change="purchaseChange()">
                                                            <option>Select Items</option>
                                                                @foreach ($items as $id => $item)
                                                                    <option value="{{$id}}" {{ $id ? ($id == $purchase->item ? 'selected' : '') : '' }}> {{$item}} </option>
                                                            @endforeach
                                                        </select>
                                                        <x-input-error :messages="$errors->get('item')" class="mt-2" /> 
                                                    </td>
                                                    <td>
                                                        <x-text-input class="bg-gray-100 dark:bg-gray-700" readonly="true" x-bind:name="`purchase_details[${purchaseDetail.id}][unit]`" :messages="$errors->get('unit')" x-model="purchaseDetail.unit"/>
                                                    </td> 
                                                    <td>
                                                        <x-text-input  x-bind:name="`purchase_details[${purchaseDetail.id}][qty]`" :messages="$errors->get('qty')" x-model="purchaseDetail.qty" @change="calculateAmount()"/>
                                                    </td>                                                   
                                                    <td>
                                                        <x-text-input  x-bind:name="`purchase_details[${purchaseDetail.id}][rate]`"  :messages="$errors->get('rate')" x-model="purchaseDetail.rate" @change="calculateAmount()"/>
                                                    </td>
                                                    <td>
                                                        <x-text-input  x-bind:name="`purchase_details[${purchaseDetail.id}][amount]`"  :messages="$errors->get('amount')" x-model="purchaseDetail.amount" @change="calculateTotal()"/>
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
                                                <th colspan="6" style="text-align:right;">Total Amount: </th>
                                                <td>               
                                                    <x-text-input class="form-input bg-gray-100 dark:bg-gray-700" readonly="true" :messages="$errors->get('total_amount')"  value="{{ $purchase->total_amount }}" x-model="total_amount" name="total_amount"/>
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
                    <x-cancel-button :link="route('purchases.index')">
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
        purchaseData:'',
        init() {   
            this.amount = 0;    
            this.total_amount = 0;     
            flatpickr(document.getElementById('purchase_date'), {
                dateFormat: 'd/m/Y',
            });

            flatpickr(document.getElementById('invoice_date'), {
                dateFormat: 'd/m/Y',
            });

            @if($purchase->total_amount)                
                this.total_amount = {{  $purchase->total_amount }};
            @endif

            let maxId = 0; 
            id='';
            @if($purchase['PurchaseDetails'])
            @foreach($purchase['PurchaseDetails'] as $i=>$details)
            this.purchaseDetails.push({
                i: ++maxId,
                id: '{{ $details->id }}',
                item: '{{ $details->item }}',
                unit: '{{ $details->unit }}',
                qty: '{{ $details->qty }}',
                rate: '{{ $details->rate }}',
                amount: '{{ $details->amount }}',
            });   
                             
            @endforeach
            @endif    
        },
        
        async purchaseChange() {                  
            this.purchaseData = await (await fetch('/items/'+ this.purchaseDetail.item, {
            method: 'GET',
            headers: {
                'Content-type': 'application/json;',
            },
            })).json();
            this.purchaseDetail.unit = this.purchaseData.unit;
        },

        purchaseDetails: [],
        addItem() {
            let maxId = 0;
            if (this.purchaseDetails && this.purchaseDetails.length) {
                maxId = this.purchaseDetails.reduce((max, character) => (character.id > max ? character
                    .id : max), this.purchaseDetails[0].id);
            }
            this.purchaseDetails.push({
                id: maxId + 1,
                item: '',
                unit: '',
                qty: '',
                rate: '',
                amount: '',
            });
            this.calculateAmount();
            this.calculateTotal();
        }, 
        
        removeItem(purchaseDetail) {
            this.purchaseDetails = this.purchaseDetails.filter((d) => d.id != purchaseDetail.id);
            this.calculateAmount();
            this.calculateTotal();
        },    
        
        calculateAmount() {            
            this.purchaseDetails.forEach(purchaseDetail => {     
                total = purchaseDetail.qty * purchaseDetail.rate;          
                purchaseDetail.amount = total.toFixed(2);
            }); 
            this.calculateTotal();
        },

        calculateTotal() {
            let total_amount = 0;
            this.purchaseDetails.forEach(purchaseDetail => {
                total_amount = parseFloat(total_amount) + parseFloat(purchaseDetail.amount);
            });                     
            if(!isNaN(total_amount)){
                this.total_amount = total_amount.toFixed(2);
            }     
        },
    }));
});
</script>
</x-layout.default>
