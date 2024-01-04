<x-layout.auth>
    <div
        class="flex justify-center items-center min-h-screen bg-[url('/assets/images/map.svg')] dark:bg-[url('/assets/images/map-dark.svg')] bg-cover bg-center">
        <div class="panel sm:w-[480px] m-6 max-w-lg w-full">
            <h2 class="font-bold text-2xl mb-3">Password Reset</h2>
            <p class="mb-7">Enter your email to recover your ID</p>
            <x-auth-session-status class="mb-4" :status="session('status')" />
            <form method="POST" class="space-y-5" action="{{ route('password.email') }}">
                @csrf
                <div>
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" class="form-input" placeholder="Enter Email" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <button type="submit" class="btn btn-primary w-full">RECOVER</button>
            </form>
        </div>
    </div>
</x-layout.auth>
