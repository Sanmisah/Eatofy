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
                <h5 class="font-semibold text-lg dark:text-white-light">Change Password</h5>
            </div>
            <div class="panel">
               
                <form method="POST" action="{{ route('profile.change') }}">
                 @csrf
                   
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="col-md-4">
                                <label class="labels">Current Password</label>
                                <input type="password" name="current_password" class="form-input @error('current_password') is-invalid @enderror" placeholder="Current Password" required>
                                @error('current_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="labels">New Password</label>
                                <input type="password" name="new_password" class="form-input @error('new_password') is-invalid @enderror" required placeholder="New Password">
                                @error('new_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="labels">Confirm Password</label>
                                <input type="password" name="new_confirm_password" class="form-input @error('new_confirm_password') is-invalid @enderror" required placeholder="Confirm Password">
                                @error('new_confirm_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    <button type="submit" class="btn btn-primary !mt-6">Submit</button>
                </form>
            </div>
        </div>
    </div>

</x-layout.default>
