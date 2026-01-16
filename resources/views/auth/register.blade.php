<x-guest-layout>
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800 dark:text-slate-100 mb-2">Create your account</h1>
        <p class="text-slate-600 dark:text-slate-400">Join DevConnect and connect with developers worldwide</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Full name')" class="mb-2 text-slate-700 dark:text-slate-300 font-medium" />
            <x-text-input 
                id="name" 
                class="block mt-1 w-full border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-blue-500 dark:focus:ring-blue-400 rounded-lg transition-colors" 
                type="text" 
                name="name" 
                :value="old('name')" 
                required 
                autofocus 
                autocomplete="name"
                placeholder="John Doe"
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email address')" class="mb-2 text-slate-700 dark:text-slate-300 font-medium" />
            <x-text-input 
                id="email" 
                class="block mt-1 w-full border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-blue-500 dark:focus:ring-blue-400 rounded-lg transition-colors" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autocomplete="username"
                placeholder="you@example.com"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="mb-2 text-slate-700 dark:text-slate-300 font-medium" />
            <x-text-input 
                id="password" 
                class="block mt-1 w-full border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-blue-500 dark:focus:ring-blue-400 rounded-lg transition-colors"
                type="password"
                name="password"
                required 
                autocomplete="new-password"
                placeholder="At least 8 characters"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm password')" class="mb-2 text-slate-700 dark:text-slate-300 font-medium" />
            <x-text-input 
                id="password_confirmation" 
                class="block mt-1 w-full border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-100 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-blue-500 dark:focus:ring-blue-400 rounded-lg transition-colors"
                type="password"
                name="password_confirmation" 
                required 
                autocomplete="new-password"
                placeholder="Confirm your password"
            />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div>
            <x-primary-button class="w-full justify-center py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-lg shadow-lg shadow-blue-500/50 hover:shadow-xl hover:shadow-blue-500/50 transition-all transform hover:-translate-y-0.5">
                {{ __('Create account') }}
            </x-primary-button>
        </div>

        <!-- Login Link -->
        <div class="text-center pt-4 border-t border-slate-200 dark:border-slate-700">
            <p class="text-sm text-slate-600 dark:text-slate-400">
                Already have an account?
                <a href="{{ route('login') }}" class="font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 hover:underline transition-colors">
                    Log in
                </a>
            </p>
        </div>

        <!-- Terms -->
        <p class="text-xs text-center text-slate-500 dark:text-slate-500">
            By creating an account, you agree to our Terms of Service and Privacy Policy.
        </p>
    </form>
</x-guest-layout>

