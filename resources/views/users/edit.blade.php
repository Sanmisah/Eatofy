<x-layout.default>
    <div>
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="{{ route('users.index') }}" class="text-primary hover:underline">Users</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>Edit</span>
            </li>
        </ul>
        <div class="pt-5">                                   
            <form method="POST" action="{{ route('users.update', ['user'=>$user->id]) }}">
            @csrf
            @method('PATCH')
            <div class="panel">
                <div class="flex items-center justify-between mb-5">
                    <h5 class="font-semibold text-lg dark:text-white-light">Edit User</h5>
                </div>   
                <div class="grid grid-cols-1 gap-4 mb-4 md:grid-cols-3">
                        <x-text-input name="name" value="{{ old('name', $user->name) }}" :label="__('Name')" :require="true" :messages="$errors->get('name')"/>  
                        <x-text-input name="email" value="{{ old('email', $user->email) }}" :require="true" :label="__('Email')" :messages="$errors->get('email')"/>
                        <x-text-input name="password" type="password" value="{{ old('password', $user->password) }}" :require="true" :label="__('Password')" :messages="$errors->get('password')"/>   
                    <div>
                        <label for="actionRole">Role:</label>
                        <select class="form-input" name="role">
                            <option selected disabled>Select Role</option>                           
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ in_array($role->name, $userRole) ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                        </select>
                    </div>   
                    <div>
                        <label for="actionRole">Active:</label>
                        <select class="form-input" name="active">
                            <option selected disabled>Select Status</option>
                            <option value="1" @if ($user->active == 1) {{ 'Selected' }} @endif>Active</option>
                            <option value="0" @if ($user->active == 0) {{ 'Selected' }} @endif>Inactive</option>      
                        </select>
                    </div>   
                </div>
                <div class="flex justify-end mt-4">
                    <x-success-button>
                        {{ __('Submit') }}
                    </x-success-button>
                    &nbsp;&nbsp;
                    <x-cancel-button :link="route('users.index')">
                        {{ __('Cancel') }}
                    </x-cancel-button>
                </div>
            </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function(e) {
            // default
            var els = document.querySelectorAll(".selectize");
            els.forEach(function(select) {
                NiceSelect.bind(select);
            });
        });
    </script>
</x-layout.default>
