@extends('layout.clean')

@section('content')

<div class="flex items-center justify-center py-32">
    <div class="bg-card border border-card-line rounded-xl shadow-2xs" style="width: 500px;">
    <!-- Sign In -->
    <div class="p-4 sm:p-7">
        <div class="text-center border-b border-card-line pb-4">
        <h3 id="hs-modal-signin-label" class="block text-2xl font-bold text-foreground">Sign up</h3>

        </div>

        <div class="mt-5">
        <!-- Form -->
        <form>
            <div class="grid gap-y-4">
            <!-- Form Group -->
            <div>
                <label for="email" class="block text-sm mb-2 text-foreground">Email address</label>
                <div class="relative">
                <input type="email" id="email" name="email" class="py-2.5 sm:py-3 px-4 block w-full bg-layer border-layer-line rounded-lg sm:text-sm text-foreground placeholder:text-muted-foreground-1 focus:border-primary-focus focus:ring-primary-focus disabled:opacity-50 disabled:pointer-events-none" required aria-describedby="email-error">
                <div class="hidden absolute inset-y-0 end-0 pointer-events-none pe-3">
                    <svg class="size-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                    </svg>
                </div>
                </div>
                <p class="hidden text-xs text-red-600 mt-2" id="email-error">Please include a valid email address so we can get back to you</p>
            </div>
            <!-- End Form Group -->

            <!-- Form Group -->
            <div>
                <div class="flex flex-wrap items-center gap-2">
                <label for="password" class="block text-sm mb-2 text-foreground">Password</label>
                </div>
                <div class="relative">
                <input type="password" id="password" name="password" class="py-2.5 sm:py-3 px-4 block w-full bg-layer border-layer-line rounded-lg sm:text-sm text-foreground placeholder:text-muted-foreground-1 focus:border-primary-focus focus:ring-primary-focus disabled:opacity-50 disabled:pointer-events-none" required aria-describedby="password-error">
                <div class="hidden absolute inset-y-0 end-0 pointer-events-none pe-3">
                    <svg class="size-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                    </svg>
                </div>
                </div>
                <p class="hidden text-xs text-red-600 mt-2" id="password-error">8+ characters required</p>
            </div>
            <!-- End Form Group -->

            <!-- Form Group -->
            <div>
                <label for="confirm-password" class="block text-sm mb-2 text-foreground">Confirm Password</label>
                <div class="relative">
                <input type="password" id="confirm-password" name="confirm-password" class="py-2.5 sm:py-3 px-4 block w-full bg-layer border-layer-line rounded-lg sm:text-sm text-foreground placeholder:text-muted-foreground-1 focus:border-primary-focus focus:ring-primary-focus disabled:opacity-50 disabled:pointer-events-none" required aria-describedby="confirm-password-error">
                <div class="hidden absolute inset-y-0 end-0 pointer-events-none pe-3">
                    <svg class="size-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                    </svg>
                </div>
                </div>
                <p class="hidden text-xs text-red-600 mt-2" id="confirm-password-error">Password does not match the password</p>
            </div>
            <!-- End Form Group -->

            <!-- Checkbox -->
            <div class="flex items-center">
                <div class="flex">
                <input id="checkbox" name="checkbox" type="checkbox" class="shrink-0 size-4 bg-transparent border-line-3 rounded-sm shadow-2xs text-primary focus:ring-0 focus:ring-offset-0 checked:bg-primary-checked checked:border-primary-checked disabled:opacity-50 disabled:pointer-events-none">
                </div>
                <div class="ms-3">
                <label for="checkbox" class="text-sm text-foreground">
                    I accept the <a class="text-primary decoration-2 hover:underline focus:outline-hidden focus:underline font-medium" href="#">Terms and Conditions</a>
                </label>
                </div>
            </div>
            <!-- End Checkbox -->

            <button type="submit" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg bg-primary border border-primary-line text-primary-foreground hover:bg-primary-hover focus:outline-hidden focus:bg-primary-focus disabled:opacity-50 disabled:pointer-events-none">Sign up</button>
            </div>
        </form>
        <!-- End Form -->


        <div class="py-3 flex items-center text-xs text-muted-foreground uppercase before:flex-1 before:border-t before:border-line-2 before:me-6 after:flex-1 after:border-t after:border-line-2 after:ms-6">Or</div>
        <p class="mt-2 text-sm text-muted-foreground-2">
            Already have an account?
            <a class="text-primary decoration-2 hover:underline focus:outline-hidden focus:underline font-medium" href="{{ route('login') }}">
            Sign in here
            </a>
        </p>
        </div>
    </div>
    <!-- End Sign In -->
    </div>
</div>
@endsection
