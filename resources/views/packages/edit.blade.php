<x-layout.default>
    <div>
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="{{ route('packages.index') }}" class="text-primary hover:underline">Package</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>Edit</span>
            </li>
        </ul>
        <div class="pt-5">                                   
            <form method="POST" action="{{ route('packages.update', ['package'=>$package->id]) }}">
            @csrf
            @method('PATCH')
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Edit Package</h5>
                </div> 
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">
                    <x-text-input name="package_name" value="{{ old('package_name', $package->package_name) }}" :label="__('Package Name')" :require="true" :messages="$errors->get('package_name')"/>   
                    <x-text-input name="validity_in_days" value="{{ old('validity_in_days', $package->validity_in_days) }}" :label="__('Validity (in Days)')" :messages="$errors->get('validity_in_days')"/>
                    <x-combo-input name="cost" value="{{ old('cost', $package->cost) }}" :label="__('Cost')" :messages="$errors->get('cost')"/>                    
                </div> 
                <div class="flex justify-end mt-4">
                    <x-cancel-button :link="route('packages.index')">
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
</x-layout.default>
