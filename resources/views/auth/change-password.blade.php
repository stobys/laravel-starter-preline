@extends('layout.main')

@section('content')

<div class="flex items-center justify-center py-32">
    <div class="bg-card border border-card-line rounded-xl shadow-2xs" style="width: 500px;">
        <!-- Change Pass -->
        <div class="p-4 sm:p-7">
            <div class="text-center border-b border-card-line pb-4">
            <h3 id="hs-modal-signin-label" class="block text-2xl font-bold text-foreground">Password Change</h3>

            </div>

            <div class="mt-5">
            <!-- Form -->
            <x-form action="{{ route('password.change') }}">
                <div class="grid gap-y-4">
                    <!-- Form Group -->
                    <x-form.field-group id="current_password" name="current_password" label="Current Password">
                        <x-form.input type="password" required id="current_password" name="current_password" value="{{ old('current_password') }}" />
                    </x-form.field-group>
                    <!-- End Form Group -->

                    <!-- Form Group -->
                    <x-form.field-group id="new_password" name="new_password" label="New Password">
                        <x-form.input type="password" required id="new_password" name="new_password" value="{{ old('new_password') }}" />
                    </x-form.field-group>
                    <!-- End Form Group -->

                    <!-- Form Group -->
                    <x-form.field-group id="new_password_confirmation" name="new_password_confirmation" label="New Password Confirmation">
                        <x-form.input type="password" required id="new_password_confirmation" name="new_password_confirmation" />
                    </x-form.field-group>
                    <!-- End Form Group -->

                    <button type="submit" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg bg-gray-800 dark:bg-white border border-transparent text-white dark:text-neutral-800 hover:bg-gray-900 dark:hover:bg-neutral-300 focus:outline-hidden focus:bg-gray-900 dark:focus:bg-neutral-300 disabled:opacity-50 disabled:pointer-events-none">
                        Change Password
                    </button>
                </div>
            </x-form>
            <!-- End Form -->
        </div>
        <!-- End Sign In -->
    </div>

    @if(session('status'))
        <!-- Alert -->
        <div class="m-2 bg-teal-50 border-t-2 border-teal-500 rounded-lg p-4 dark:bg-teal-800/30" role="alert" tabindex="-1" aria-labelledby="hs-bordered-success-style-label">
            <div class="flex">
                <div class="shrink-0">
                <!-- Icon -->
                <span class="inline-flex justify-center items-center size-8 rounded-full border-4 border-teal-100 bg-teal-200 text-teal-800 dark:border-teal-900 dark:bg-teal-800 dark:text-teal-400">
                    <x-feather-thumbs-up class="shrink-0 size-4" />
                </span>
                <!-- End Icon -->
                </div>
                <div class="ms-3">
                <h3 id="hs-bordered-success-style-label" class="text-foreground font-semibold">
                    Successfully updated.
                </h3>
                <p class="text-sm text-foreground">
                    {{ session('status') }}
                </p>
                </div>
            </div>
        </div>
        <!-- End Alert -->
    @endif
</div>
@endsection
