<x-layout.default>
<div>
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="{{ route('teams.index') }}" class="text-primary hover:underline">Teams</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>Add</span>
        </li>
    </ul>
    <div class="pt-5" x-data="data">        
        <form class="space-y-5" action="{{ route('teams.store') }}" method="POST">
            @csrf
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Add Teams</h5>
                </div>                
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">
                    <x-text-input name="name" value="{{ old('name') }}" :label="__('Member Name')" :require="true" :messages="$errors->get('name')"/>                      
                    <x-text-input name="contact_no" value="{{ old('contact_no') }}" :label="__('Contact No')" :messages="$errors->get('contact_no')" :require="true" />        
                    <div>
                        <label>Role:<span style="color: red">*</span></label>
                        <select class="form-input" name="role" id="role">
                            <option value='Sales'>Sales</option>
                            <option value='Root'>Root</option>                                 
                        </select>
                    </div>              
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-1">
                    <x-text-input name="address" value="{{ old('address') }}" :label="__('Address')" :messages="$errors->get('address')" :require="true"/>                     
                </div>
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">
                    <x-text-input name="email" :require="true" :label="__('Email')" :messages="$errors->get('email')"/>
                    <x-text-input name="new_password" type="password" :require="true" :label="__('Password')" :messages="$errors->get('new_password')"/>
                </div>
                <div class="flex justify-end mt-4">
                    <x-cancel-button :link="route('teams.index')">
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
        init(){
            var options = {
                searchable: true
            };
            NiceSelect.bind(document.getElementById("role"), options);
        }
    }));
});
</script>
</x-layout.default>