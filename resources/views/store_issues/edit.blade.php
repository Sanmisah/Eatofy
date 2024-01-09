<x-layout.default>
<div>
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="{{ route('store_issues.index') }}" class="text-primary hover:underline">Store Issues</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>Edit</span>
        </li>
    </ul>
    <div class="pt-5" x-data="data">        
        <form class="space-y-5" action="{{ route('store_issues.update', ['store_issue' => $store_issue->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Edit Store Issue</h5>
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-3">     
                    @foreach ($hotels as $id => $hotel)
                    <input type="hidden" value="{{ $id }}" name="hotel_id"/>
                    @endforeach
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">
                    <x-text-input name="issue_no" class="bg-gray-100 dark:bg-gray-700" readonly="true" value="{{ old('issue_no', $store_issue->issue_no) }}" :label="__('Issue No')"  :messages="$errors->get('issue_no')"  />
                    <x-text-input name="issue_date" value="{{ old('issue_date', $store_issue->issue_date) }}" id="issue_date" :label="__('Issue Date')" :messages="$errors->get('issue_date')"/>                           
                </div>
            </div>    
            <div class="panel table-responsive">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light"> Add Items</h5>
                </div>
                <div class="flex xl:flex-row flex-col gap-2.5">
                    <div class="panel px-0 flex-1 py-1 ltr:xl:mr-6 rtl:xl:ml-6">
                        <div class="mt-8">
                            <template x-if="storeIssueDetails">
                                <div class="table-responsive">
                                    <table class="table-hover">
                                        <thead>
                                            <tr>
                                                <th>&nbsp; #</th>
                                                <th>Items</th>
                                                <th>Qty</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template x-if="storeIssueDetails.length <= 0">
                                                <tr >
                                                    <td colspan="6" class="!text-center font-semibold">No Data Available
                                                    </td>
                                                </tr>
                                            </template>
                                            <template x-for="(issueDetail, i) in storeIssueDetails" :key="i">
                                                <tr>
                                                    <td>
                                                        <button type="button" @click="removeItem(issueDetail)">
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
                                                    <input type="hidden" class="form-input min-w-[230px]" x-model="issueDetail.id" x-bind:name="`store_issue_details[${issueDetail.id}][id]`"/>

                                                        <select class="form-input" x-model="issueDetail.item" x-bind:name="`store_issue_details[${issueDetail.id}][item]`" x-on:change="itemChange()">
                                                            <option>Select Items</option>
                                                                @foreach ($items as $id => $item)
                                                                    <option value="{{$id}}"> {{$item}} </option>
                                                            @endforeach
                                                        </select>
                                                        <x-input-error :messages="$errors->get('item')" class="mt-2" /> 
                                                    </td>                                                    
                                                    <td>
                                                        <input type="hidden" class="form-input min-w-[230px]" x-model="issueDetail.unit" x-bind:name="`store_issue_details[${issueDetail.id}][unit]`"/>
                                                        <x-text-input class="mt-2" x-bind:name="`store_issue_details[${issueDetail.id}][qty]`" :messages="$errors->get('qty')" x-model="issueDetail.qty" />
                                                        <!-- <span x-text="issueDetail.unit"></span> -->
                                                    </td>                                            
                                                </tr>
                                            </template>
                                            <tr>
                                                <td>
                                                    <button type="button" class="btn btn-info" @click.prevent="addItem()">+ </button>
                                                </td>
                                            </tr>
                                        </tbody>      
                                    </table>
                                </div>
                            </template>                                                
                        </div>                            
                    </div>                    
                </div>
                <div class="flex justify-end mt-4">
                    <x-cancel-button :link="route('store_issues.index')">
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
        issueData:'',
        init() {   
            flatpickr(document.getElementById('issue_date'), {
                dateFormat: 'd/m/Y',
            });

            let maxId = 0; 
            id='';
            @if($store_issue['StoreIssueDetails'])
            @foreach($store_issue['StoreIssueDetails'] as $i=>$details)
            this.storeIssueDetails.push({
                i: ++maxId,
                id: '{{ $details->id }}',
                item: '{{ $details->item }}',
                qty: '{{ $details->qty }}',
            });   
                             
            @endforeach
            @endif
        },

        async itemChange() {      
            this.issueData = await (await fetch('/items/'+ this.issueDetail.item, {
            method: 'GET',
            headers: {
                'Content-type': 'application/json;',
            },
            })).json();
            this.issueDetail.unit = this.issueData.unit;
        },

        storeIssueDetails: [],
        addItem() {
            let maxId = 0;
            if (this.storeIssueDetails && this.storeIssueDetails.length) {
                maxId = this.storeIssueDetails.reduce((max, character) => (character.id > max ? character
                    .id : max), this.storeIssueDetails[0].id);
            }
            this.storeIssueDetails.push({
                id: maxId + 1,
                item: '',             
                qty: '',
            });
        }, 
        
        removeItem(issueDetail) {
            this.storeIssueDetails = this.storeIssueDetails.filter((d) => d.id != issueDetail.id);           
        },    
    }));
});
</script> 
</x-layout.default>
