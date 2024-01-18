<x-layout.default>

    <div>
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="javascript:;" class="text-primary hover:underline">Users</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>Account Settings</span>
            </li>
        </ul>
        <div class="pt-5">
            <div class="flex items-center justify-between mb-5">
                <h5 class="font-semibold text-lg dark:text-white-light">Settings</h5>
            </div>
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Recent Orders</h5>
                </div>
                <form class="space-y-5" action="{{ route('profile.update', ['user' => $user->id]) }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <x-text-input name="name" value="{{ old('name', $user->name) }}" placeholder="Enter Full Name" :label="__('User Name')" :require="true" :messages="$errors->get('name')"/>                     
                        <x-text-input name="email" value="{{ old('email', $user->email) }}" :label="__('Email')" :messages="$errors->get('email')"/>  
                    </div>
                    <div class="flex justify-end mt-4">
                    <x-success-button>
                        {{ __('Submit') }}
                    </x-success-button>                    
                    &nbsp;&nbsp;
                    <x-cancel-button :link="route('dashboard')">
                        {{ __('Cancel') }}
                    </x-cancel-button>
                </div>
                    
                </form>
            </div>
        </div>
    </div>

</x-layout.default>
