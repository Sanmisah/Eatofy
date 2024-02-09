<x-layout.default>
    <div>
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="{{ route('tables.index') }}" class="text-primary hover:underline">Table</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>Edit</span>
            </li>
        </ul>
        <div class="pt-5">                                   
            <form method="POST" action="{{ route('tables.update', ['table'=>$table->id]) }}">
            @csrf
            @method('PATCH')
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Edit Table</h5>
                </div>   
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-3">     
                    @foreach ($hotels as $id => $hotel)
                    <input type="hidden" value="{{ $id }}" name="hotel_id"/>
                    @endforeach
                </div> 
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">   
                    <div>
                        <label>Section:<span style="color: red">*</span></label>
                        <select class="form-input" name="section_id" required="true" id="section_id">
                            @foreach ($sections as $id => $section)
                                <option value="{{$id}}" {{ $table->section_id ? ($table->section_id == $id ? 'Selected' : '' ) : ''}}>{{ $section }}</option>
                            @endforeach
                        </select> 
                        <x-input-error :messages="$errors->get('section_id')" class="mt-2" /> 
                    </div>                 
                    <x-text-input name="name" value="{{ old('name', $table->name) }}" :label="__('Name')" :require="true" :messages="$errors->get('name')"/> 
                </div>
                <div class="flex justify-end mt-4">
                    <x-cancel-button :link="route('tables.index')">
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
                    var options = {
                        searchable: true
                    };
                    NiceSelect.bind(document.getElementById("section_id"), options);
                },   
            
            }));
        });
    </script>  
</x-layout.default>
