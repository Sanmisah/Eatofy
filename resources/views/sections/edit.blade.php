<x-layout.default>
    <div>
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="{{ route('sections.index') }}" class="text-primary hover:underline">Section</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>Edit</span>
            </li>
        </ul>
        <div class="pt-5">                                   
            <form method="POST" action="{{ route('sections.update', ['section'=>$section->id]) }}">
            @csrf
            @method('PATCH')
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Edit Section</h5>
                </div>   
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-3">     
                    @foreach ($hotels as $id => $hotel)
                    <input type="hidden" value="{{ $id }}" name="hotel_id"/>
                    @endforeach
                </div> 
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-4">                    
                    <x-text-input name="section_name" value="{{ old('section_name', $section->section_name) }}" :label="__('Section Name')" :require="true" :messages="$errors->get('section_name')"/> 
                </div>
                <div class="flex justify-end mt-4">
                    <x-cancel-button :link="route('sections.index')">
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
