<div class="w-full px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <div class="grid gap-4 lg:gap-6">
        <!-- Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
            <x-form.field-group id="username" name="username" label="Username">
                <x-form.input required id="username" name="username" value="{{ old('username', $user->username ?? null) }}" />
            </x-form.field-group>

            <x-form.field-group id="email" name="email" label="Email">
                <x-form.input type="email" required id="email" name="email" value="{{ old('email', $user->email ?? null) }}" />
            </x-form.field-group>
        </div>
        <!-- End Grid -->

        <!-- Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
            <x-form.field-group id="first_name" name="first_name" label="First Name">
                <x-form.input required id="first_name" name="first_name" value="{{ old('first_name', $user->first_name ?? null) }}" />
            </x-form.field-group>
            <x-form.field-group id="last_name" name="last_name" label="Last Name">
                <x-form.input required id="last_name" name="last_name" value="{{ old('last_name', $user->last_name ?? null) }}" />
            </x-form.field-group>
        </div>
        <!-- End Grid -->

        <div class="py-3 flex items-center text-sm text-gray-800 before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6 dark:text-white dark:before:border-neutral-600 dark:after:border-neutral-600">
            Password
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
            <x-form.field-group id="password" name="password" label="Password">
                <x-form.input type="password" id="password" name="password" value="{{ old('password') }}" />
            </x-form.field-group>

            <x-form.field-group id="password_confirmation" name="password_confirmation" label="Confirm Password">
                <x-form.input type="password" id="password_confirmation" name="password_confirmation" />
            </x-form.field-group>

        </div>
        <!-- End Grid -->

        <!-- Grid -->
        {{-- <div>
            <label for="hs-about-contacts-1" class="block mb-2 text-sm text-gray-800 dark:text-neutral-200 font-medium">Details</label>
            <textarea id="hs-about-contacts-1" name="hs-about-contacts-1" rows="4" class="py-2.5 sm:py-3 px-4 block w-full bg-white dark:bg-neutral-800 border-gray-200 dark:border-neutral-700 rounded-lg sm:text-sm text-gray-800 dark:text-neutral-200 placeholder:text-gray-500 dark:placeholder:text-neutral-400 focus:border-gray-900 dark:focus:border-neutral-300 focus:ring-gray-900 dark:focus:ring-neutral-300 disabled:opacity-50 disabled:pointer-events-none"></textarea>
        </div> --}}
        <!-- End Grid -->
    </div>
</div>
