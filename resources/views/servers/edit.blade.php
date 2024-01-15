<x-layout.default>
    <div>
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="{{ route('servers.index') }}" class="text-primary hover:underline">Server</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>Edit</span>
            </li>
        </ul>
        <div class="pt-5">                                   
            <form method="POST" action="{{ route('servers.update', ['server'=>$server->id]) }}">
            @csrf
            @method('PATCH')
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Edit Server</h5>
                </div>   
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-3">     
                    @foreach ($hotels as $id => $hotel)
                    <input type="hidden" value="{{ $id }}" name="hotel_id"/>
                    @endforeach
                </div> 
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">                    
                    <x-text-input name="name" value="{{ old('name', $server->name) }}" :label="__('Name')" :require="true" :messages="$errors->get('name')"/> 
                </div>
                <div class="flex justify-end mt-4">
                    <x-cancel-button :link="route('servers.index')">
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
