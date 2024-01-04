<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-combo-input id="email" :email="true"  :label="__('Email')"  type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username"  :messages="$errors->get('email')"/>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-text-input id="password"  :label="__('Password')" type="password" name="password" required autocomplete="new-password" :messages="$errors->get('password')"/>
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-text-input id="password_confirmation"
                                type="password"
                                name="password_confirmation" :label="__('Confirm Password')"  required autocomplete="new-password" :messages="$errors->get('password_confirmation')"/>

        </div>

        <div class="flex items-center justify-end mt-4">
            <x-success-button>
                {{ __('Reset Password') }}
            </x-success-button>
        </div>
    </form>
</x-guest-layout>
