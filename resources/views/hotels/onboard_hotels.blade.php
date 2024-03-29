<?php
// use Carbon\Carbon; 
// $today_date = Carbon::now()->format('d/m/Y');
// echo $today_date;
?>
<x-layout.default>
    <div x-data="multicolumn">        
        <x-add-button :link="route('hotels.create')" />
        <div class="panel mt-6 table-responsive">
            <h5 class="md:absolute md:top-[25px] md:mb-0 mb-5 font-semibold text-lg dark:text-white-light">Hotels
            </h5>
            <table id="myTable" class="whitespace-nowrap table-hover">
                @foreach ($hotels as $hotel)
                <tr>  
                    <td>
                        <div class="flex items-center font-semibold">
                            <div class="p-0.5 bg-white-dark/30 rounded-full w-max ltr:mr-2 rtl:ml-2">
                                <img class="h-8 w-8 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ $hotel->hotel_name }}&rounded=true" />
                            </div>
                            {{ $hotel->hotel_name }}
                        </div>             
                    </td> 
                    <td>{{ $hotel->contact_no }}</td>                        
                    <td>{{ $hotel->owner_name }}</td>
                    <td>{{ $hotel->owner_contact_no }}</td>
                    <td>{{ $hotel->city }}</td> 
                    <td>{{ $hotel->gstin }}</td>  
                    <td>
                        @if($hotel->expiry_date <  Carbon\Carbon::today()->format('d/m/Y'))                           
                                <span class="badge bg-danger/20 text-danger rounded-full hover:top-0">{{$hotel->expiry_date }}</span> 
                            @else
                                <span class="badge bg-info/20 text-info rounded-full hover:top-0">{{$hotel->expiry_date }}</span>                            
                        @endif 
                    </td> 
                    <td class="float-right">
                        <ul class="flex items-center gap-2" >
                            <li style="display: inline-block;vertical-align:top;">
                                <x-subscription-button :link=" route('hotels.subscription', $hotel->id)" />                               
                            </li>
                            <li style="display: inline-block;vertical-align:top;">
                                <x-edit-button :link=" route('hotels.edit', $hotel->id)" />                               
                            </li>
                            <li style="display: inline-block;vertical-align:top;">
                                <x-delete-button :link=" route('hotels.destroy', $hotel->id)" />  
                            </li>   
                        </ul>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("multicolumn", () => ({
                datatable: null,
                init() {
                    this.datatable = new simpleDatatables.DataTable('#myTable', {
                        data: {
                            headings: ["Hotel Name", "Hotel Contact No", "Owner Name", "Owner Contact No", "City", "GSTIN", "Expiry Date", "Action"],
                        },
                        searchable: true,
                        perPage: 30,
                        perPageSelect: [10, 20, 30, 50, 100],
                        columns: [{
                            order: [[0, 'asc']]
                        }, ],
                        firstLast: true,
                        firstText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M13 19L7 12L13 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M16.9998 19L10.9998 12L16.9998 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                        lastText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M11 19L17 12L11 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M6.99976 19L12.9998 12L6.99976 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                        prevText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M15 5L9 12L15 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                        nextText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                        labels: {
                            perPage: "{select}"
                        },
                        layout: {
                            top: "{search}",
                            bottom: "{info}{select}{pager}",
                        },
                    })
                }
            }));
        });
    </script>


</x-layout.default>
