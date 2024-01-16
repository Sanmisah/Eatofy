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
        <form class="space-y-5" action="{{ route('hotels.update', ['hotel' => $hotel->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Add Subscription</h5>
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">
                    <x-text-input name="subscription_no" value="{{ old('subscription_no') }}" :label="__('Subscription No')"  :messages="$errors->get('subscription_no')" class="bg-gray-100 dark:bg-gray-700" readonly="true" />  
                    <x-text-input name="subscription_date" value="{{ old('subscription_date') }}" :label="__('Subscription Date')" id="subscription_date" :messages="$errors->get('subscription_date')"/>                                        
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">
                    <div>
                        <label>Package :</label>
                        <select class="form-input" name="package_id" x-model="package_id" x-on:change="packageChange()">
                            <option value="">Select Package</option>
                            @foreach ($packages as $id=>$package)                                
                                <option value="{{$id}}">{{$package}}</option>
                            @endforeach
                        </select> 
                        <x-input-error :messages="$errors->get('package_id')" class="mt-2" /> 
                    </div>
                    <x-text-input class="bg-gray-100 dark:bg-gray-700" readonly="true" :messages="$errors->get('rate')" :label="__('Validity(In Days)')" x-model="validity_in_days"/>
                    <x-text-input class="bg-gray-100 dark:bg-gray-700" readonly="true" :messages="$errors->get('rate')" :label="__('Cost')" x-model="cost"/>
                    <x-text-input name="expiry_date" value="{{ old('expiry_date') }}" :label="__('Expiry Date')" id="expiry_date" class="bg-gray-100 dark:bg-gray-700" readonly="true"  :messages="$errors->get('expiry_date')"/>                                        
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
<script>
document.addEventListener("alpine:init", () => {
    Alpine.data('data', () => ({     
        purchaseData:'',
        init() {              
            flatpickr(document.getElementById('subscription_date'), {
                dateFormat: 'd/m/Y',
            });
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
                unit: '',
                qty: '',
                rate: '',
                amount: '',
            });
            this.calculateAmount();
            this.calculateTotal();
        }, 
        
        removeItem(orderDetail) {     
            console.log(this.orderDetail.id);       
            this.orderDetails = this.orderDetails.filter((d) => d.id != orderDetail.id);
            
            this.calculateAmount();
            this.calculateTotal();
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
