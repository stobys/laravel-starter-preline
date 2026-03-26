@extends('layout.clean')

@section('content')

<div class="flex items-center justify-center py-32">
    <div class="bg-card border border-b border-card-line rounded-xl shadow-2xs" style="width: 400px;">
    <!-- Sign In -->
    <div class="p-4 sm:p-7">
        <div class="text-center border-b border-card-line pb-4">
            <h3 id="hs-modal-signin-label" class="block text-2xl font-bold text-foreground">Sign in</h3>
        </div>

        <div class="mt-5">
            <!-- Form -->
            <x-form action="{{ route('login') }}">
                <div class="grid gap-y-4">
                    <!-- Form Group -->
                    <x-form.field-group id="username" name="username" label="Username">
                        <x-form.input required id="username" name="username" value="{{ old('username') }}" />
                    </x-form.field-group>
                    <!-- End Form Group -->

                    <!-- Form Group -->
                    <x-form.field-group id="password" name="password" label="Password">
                        <x-form.input type="password" required id="password" name="password" />
                    </x-form.field-group>
                    <!-- End Form Group -->

                <!-- Checkbox -->
                <div class="flex items-center">
                    <div class="flex">
                        <input id="remember_me" name="remember" type="checkbox" class="shrink-0 size-4 bg-transparent border-line-3 rounded-sm shadow-2xs text-primary focus:ring-0 focus:ring-offset-0 checked:bg-primary-checked checked:border-primary-checked disabled:opacity-50 disabled:pointer-events-none">
                    </div>
                    <div class="ms-3">
                        <label for="remember_me" class="text-sm text-foreground">
                            Remember me
                        </label>
                    </div>
                </div>
                <!-- End Checkbox -->

                <button type="submit" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg bg-primary border border-primary-line text-primary-foreground hover:bg-primary-hover focus:outline-hidden focus:bg-primary-focus disabled:opacity-50 disabled:pointer-events-none">Sign in</button>
                </div>
            </x-form>
            <!-- End Form -->

            @if(Route::has('register') || Route::has('forgot-password'))
                <div class="py-3 flex items-center text-xs text-muted-foreground uppercase before:flex-1 before:border-t before:border-line-2 before:me-6 after:flex-1 after:border-t after:border-line-2 after:ms-6">
                    Or
                </div>
            @endif

            @if(Route::has('register'))
            <p class="mt-2 text-sm text-muted-foreground-2">
                Don't have an account yet?
                <a class="text-primary decoration-2 hover:underline focus:outline-hidden focus:underline font-medium" href="{{ route('register') }}">
                Sign up here
                </a>
            </p>
            @endif
            @if(Route::has('forgot-password'))
            <p class="mt-2 text-sm text-muted-foreground-2">
                Forgot your password?
                <a class="text-primary decoration-2 hover:underline focus:outline-hidden focus:underline font-medium" href="{{ route('forgot-password') }}">
                Request reset here
                </a>
            </p>
            @endif
        </div>
    </div>
    <!-- End Sign In -->
    </div>
</div>

@endsection

