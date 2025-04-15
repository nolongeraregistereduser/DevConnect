<x-app-layout>
    <nav class="fixed top-0 w-full bg-gray-900 text-white z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <div class="text-2xl font-bold text-blue-400">&lt;DevConnect/&gt;</div>
                    <div class="relative">
                        <input type="text" 
                               placeholder="Search developers, posts, or #tags" 
                               class="bg-gray-800 pl-10 pr-4 py-2 rounded-lg w-96 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-gray-700 transition-all duration-200"
                        >
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>
                
                <div class="flex items-center space-x-6">
                    <a href="{{ route('feed') }}" class="flex items-center space-x-1 hover:text-blue-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </a>
                    <a href="{{route('feed')}}" class="flex items-center space-x-1 hover:text-blue-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                        </svg>
                        <span class="bg-blue-500 rounded-full w-2 h-2"></span>
                    </a>
                    <a href="{{route('feed')}}" class="flex items-center space-x-1 hover:text-blue-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </a>

                    

                    <div class="relative">
                        <div class="h-8 w-8 rounded-full overflow-hidden cursor-pointer" onclick="toggleDropdown()">
                            <img src="{{ asset('storage/' . $user->profile_picture)}}" alt="Profile" class="w-full h-full object-cover"/>
                        </div>
                        <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50">
                            <a href="{{ route('profile.view', $user->id) }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Edit Profile</a>
                            <a href="{{ route('posts.create') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Create Poste</a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</button>
                            </form>
                        </div>
                    </div>
                    <script>
                        function toggleDropdown() {
                            const dropdownMenu = document.getElementById('dropdownMenu');
                            dropdownMenu.classList.toggle('hidden');
                        }

                        document.addEventListener('click', function(event) {
                            const dropdownMenu = document.getElementById('dropdownMenu');
                            const profileImage = dropdownMenu.previousElementSibling;

                            if (!profileImage.contains(event.target) && !dropdownMenu.contains(event.target)) {
                                dropdownMenu.classList.add('hidden');
                            }
                        });
                    </script>
                </div>
            </div>
            
        </div>
    </nav>

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
