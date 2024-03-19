<x-layout.auth>

    <div class="flex min-h-screen">
        <div
            class="bg-gradient-to-t from-[#ff1361bf] to-[#44107A] w-1/2  min-h-screen hidden lg:flex flex-col items-center justify-center text-white dark:text-black p-4">
            <div class="w-full mx-auto mb-5"><img src="public/assets/images/auth-cover.svg"
                    alt="coming_soon" class="lg:max-w-[370px] xl:max-w-[500px] mx-auto" /></div>
        </div>
        <div class="w-full lg:w-1/2 relative flex justify-center items-center">
            <div class="panel sm:w-[480px] m-6 max-w-lg w-full">
                <h2 class="font-bold text-3xl mb-3">Sign In</h2>
                <p class="mb-7">Enter your email and password to login</p>
                <x-auth-session-status class="mb-4" :status="session('status')" />
                <form class="space-y-5" method="POST" action="{{ route('login') }}">
                @csrf
                <div>
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" class="form-input" value="{{ old('email') }}" placeholder="Enter Email" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <div>
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" class="form-input" placeholder="Enter Password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <button type="submit" class="btn btn-primary w-full">SIGN IN</button>
            </form>
            </div>
        </div>
    </div>
</x-layout.auth>

