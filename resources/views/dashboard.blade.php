<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100"> 
                    @if (Auth::user()->bio === null && Auth::user()->skills === null && Auth::user()->github_link === null)
                        <div class="text-red-500">
                            <div class="text-red-500 font-bold mb-4">
                                Activate your account by completing your information.
                                <a href="{{ route('profile.edit') }}" class="text-blue-500 underline">Update your profile</a>
                            </div>
                        </div>
                    @endif
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
