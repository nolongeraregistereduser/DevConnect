<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevConnect - Social Network for Developers</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-50">
    <!-- Navigation -->

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

    <!-- Add this after your navigation section -->
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-semibold">Feed</h2>
        <a href="{{ route('posts.create') }}" 
           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Create Post
        </a>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto pt-20 px-4">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Profile Card -->
            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="relative">
                        <div class="h-24 bg-gradient-to-r from-blue-600 to-blue-400"></div>
                        <img src="{{ asset('storage/' . $user->profile_picture)}}" alt="Profile" 
                             class="absolute -bottom-6 left-4 w-20 h-20 rounded-full border-4 border-white shadow-md"/>
                    </div>
                    <div class="pt-14 p-4">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-bold">{{$user->name}}</h2>

                            <span>
                            <a href="https://github.com" target="_blank" class="text-gray-600 hover:text-black">
                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                </svg>
                            </a>
                        </div>
                        <p> 📍 {{$user->location}}</p>

                        <p class="text-gray-500 text-sm mt-2">{{$user->bio}}</p>
<br> 
                        @foreach($user->skills as $skill)     

                                <span class="px-2 py-1 bg-blue-100 text-red-800 rounded-full text-xs ">{{$skill}}</span>
                        @endforeach

                        <br>

                        @foreach($user->programming_languages as $programming_language)     

                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">{{$programming_language}}</span>
                         @endforeach

                        <div class="mt-4 pt-4 border-t">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Connections</span>
                                <span class="text-blue-600 font-medium">{{ $user->connections_count }}</span>
                            </div>
                            <div class="flex justify-between text-sm mt-2">
                                <span class="text-gray-500">Posts</span>
                                <span class="text-blue-600 font-medium">{{ $user->posts_count }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Popular Tags -->
                <div class="bg-white rounded-xl shadow-sm p-4">
                    <h3 class="font-semibold mb-4">Trending Tags</h3>
                    <div class="space-y-2">
                        @foreach($trendingTags as $tag)
                        <a href="#" class="flex items-center justify-between hover:bg-gray-50 p-2 rounded">
                            <span class="text-gray-600">#{{ $tag->name }}</span>
                            <span class="text-gray-400 text-sm">{{ $tag->posts_count }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Main Feed -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Post Creation -->
                <div class="bg-white rounded-xl shadow-sm p-4">
                    <div class="flex items-center space-x-4">
                        <img src="{{ asset('storage/' . $user->profile_picture)}}" alt="User" class="w-12 h-12 rounded-full"/>
                        <button class="bg-gray-100 hover:bg-gray-200 text-gray-500 text-left rounded-lg px-4 py-3 flex-grow transition-colors duration-200">
                            Share your knowledge or ask a question...
                        </button>
                    </div>
                    <div class="flex justify-between mt-4 pt-4 border-t">
                        <button class="flex items-center space-x-2 text-gray-500 hover:bg-gray-100 px-4 py-2 rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                            </svg>
                            <span>Code</span>
                        </button>
                        <button class="flex items-center space-x-2 text-gray-500 hover:bg-gray-100 px-4 py-2 rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>Image</span>
                        </button>
                        <button class="flex items-center space-x-2 text-gray-500 hover:bg-gray-100 px-4 py-2 rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                            </svg>
                            <span>Link</span>
                        </button>
                    </div>
                </div>

                <!-- Posts -->
                @foreach($posts as $post)
                <div class="bg-white rounded-xl shadow-sm">
                    <div class="p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('profile.view', $post->user->id) }}" class="hover:opacity-80">
                                    <img src="{{ $post->user->profile_picture ? asset('storage/' . $post->user->profile_picture) : 'https://avatar.iran.liara.run/public/boy' }}" 
                                         alt="{{ $post->user->name }}" 
                                         class="w-12 h-12 rounded-full"/>
                                </a>
                                <div>
                                    <a href="{{ route('profile.view', $post->user->id) }}" class="hover:text-blue-500">
                                        <h3 class="font-semibold">{{ $post->user->name }}</h3>
                                    </a>
                                    <p class="text-gray-500 text-sm">{{ "📍". $post->user->location  }}</p>
                                    <p class="text-gray-400 text-xs">{{ $post->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <button class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/>
                                </svg>
                            </button>
                        </div>
                        
                        <div class="mt-4">
                            <p class="text-gray-700">{{ $post->content }}</p>
                            
                            @if($post->code_snippet)
                            <div class="mt-4 bg-gray-900 rounded-lg p-4 font-mono text-sm text-gray-200">
                                <pre><code>{{ $post->code_snippet }}</code></pre>
                            </div>
                            @endif

                            <div class="mt-4 border-t pt-4">
    <!-- Post Stats Section -->
    <div class="flex items-center space-x-4" id="postStats-{{ $post->id }}">
        <!-- Like Button -->
        <form action="{{ route($post->isLikedBy(auth()->user()) ? 'posts.unlike' : 'posts.like', $post) }}" 
              method="POST" 
              class="like-form">
            @csrf
            @if($post->isLikedBy(auth()->user()))
                @method('DELETE')
            @endif
            <button type="submit" class="flex items-center space-x-2 text-gray-500 hover:text-blue-500 group">
                <svg class="w-5 h-5 {{ $post->isLikedBy(auth()->user()) ? 'text-blue-500' : 'text-gray-500 group-hover:text-blue-500' }}" 
                     fill="{{ $post->isLikedBy(auth()->user()) ? 'currentColor' : 'none' }}" 
                     stroke="currentColor" 
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                </svg>
                <span class="likes-count {{ $post->isLikedBy(auth()->user()) ? 'text-blue-500' : '' }}">
                    {{ $post->likes_count }}
                </span>
            </button>
        </form>

        <!-- Comment Button -->
        <button onclick="toggleComments('comments-{{ $post->id }}')" 
                class="flex items-center space-x-2 text-gray-500 hover:text-blue-500">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
            </svg>
            <span>{{ $post->comments_count }}</span>
        </button>

        <!-- Share Button -->
        <button 
            onclick="sharePost('{{ $post->id }}', '{{ route('feed') }}#post-{{ $post->id }}', '{{ addslashes(Str::limit($post->content, 100)) }}')"
            class="flex items-center text-gray-500 hover:text-blue-500 transition"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
            </svg>
            <span>Share</span>
        </button>
    </div>

    <!-- Comments Section -->
    <div id="comments-{{ $post->id }}" class="hidden mt-4">
    <!-- Add Comment Form -->
    <form class="mb-4 comment-form" data-post-id="{{ $post->id }}">
        @csrf
        <div class="flex items-start space-x-3">
            <img src="{{ auth()->user()->profile_picture ? asset('storage/' . auth()->user()->profile_picture) : 'https://avatar.iran.liara.run/public/boy' }}" 
                 alt="{{ auth()->user()->name }}" 
                 class="w-8 h-8 rounded-full"/>
            <div class="flex-1">
                <textarea 
                    name="content"
                    placeholder="Write a comment..." 
                    class="w-full px-3 py-2 text-sm border rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                    rows="2"
                ></textarea>
                <div class="mt-2 flex justify-end">
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-600">
                        Post
                    </button>
                </div>
            </div>
        </div>
    </form>

    <!-- Comments List -->
    <div class="space-y-4" id="commentsList-{{ $post->id }}">
        @foreach($post->comments as $comment)
            <div class="flex space-x-3">
                <a href="{{ route('profile.view', $comment->user->id) }}" class="hover:opacity-80">
                    <img src="{{ $comment->user->profile_picture ? asset('storage/' . $comment->user->profile_picture) : 'https://avatar.iran.liara.run/public/boy' }}" 
                         alt="{{ $comment->user->name }}" 
                         class="w-8 h-8 rounded-full"/>
                </a>
                <div class="flex-1">
                    <div class="bg-gray-50 rounded-lg px-4 py-2">
                        <a href="{{ route('profile.view', $comment->user->id) }}" class="hover:text-blue-500">
                            <div class="font-medium text-sm">{{ $comment->user->name }}</div>
                        </a>
                        <p class="text-sm text-gray-700">{{ $comment->content }}</p>
                    </div>
                    <div class="mt-1 flex items-center space-x-4 text-xs text-gray-500">
                        <span>{{ $comment->created_at->diffForHumans() }}</span>
                        <button class="hover:text-blue-500">Reply</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
</div>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- Add pagination links -->
                <div class="mt-6">
                    {{ $posts->links() }}
                </div>
            
                <!-- Right Sidebar -->
                <div class="space-y-6">
                    <!-- Job Recommendations -->
                    <div class="bg-white rounded-xl shadow-sm p-4">
                        <h3 class="font-semibold mb-4">Job Recommendations</h3>
                        <div class="space-y-4">
                            <div class="p-3 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                                <div class="flex items-start space-x-3">
                                    <img src="/api/placeholder/40/40" alt="Company" class="w-10 h-10 rounded"/>
                                    <div>
                                        <h4 class="font-medium">Senior Full Stack Developer</h4>
                                        <p class="text-gray-500 text-sm">TechStart Inc.</p>
                                        <p class="text-gray-500 text-sm">Remote • Full-time</p>
                                        <div class="mt-2 flex flex-wrap gap-2">
                                            <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded-full text-xs">React</span>
                                            <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded-full text-xs">Node.js</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
            
                            <div class="p-3 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                                <div class="flex items-start space-x-3">
                                    <img src="/api/placeholder/40/40" alt="Company" class="w-10 h-10 rounded"/>
                                    <div>
                                        <h4 class="font-medium">DevOps Engineer</h4>
                                        <p class="text-gray-500 text-sm">CloudScale Solutions</p>
                                        <p class="text-gray-500 text-sm">San Francisco • Hybrid</p>
                                        <div class="mt-2 flex flex-wrap gap-2">
                                            <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded-full text-xs">AWS</span>
                                            <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded-full text-xs">Docker</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="mt-4 w-full text-blue-500 hover:text-blue-600 text-sm font-medium">
                            View All Jobs
                        </button>
                    </div>
            
                    <!-- Suggested Connections -->
                    <div class="bg-white rounded-xl shadow-sm p-4">
                        <h3 class="font-semibold mb-4">Suggested Connections</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <img src="https://avatar.iran.liara.run/public/boy" alt="User" class="w-10 h-10 rounded-full"/>
                                    <div>
                                        <h4 class="font-medium">Emily Zhang</h4>
                                        <p class="text-gray-500 text-sm">Frontend Developer</p>
                                    </div>
                                </div>
                                <button class="text-blue-500 hover:text-blue-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </body>
            </html>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.like-form').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const url = this.action;
            const method = this.querySelector('input[name="_method"]')?.value || 'POST';
            const token = this.querySelector('input[name="_token"]').value;
            
            try {
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    const button = this.querySelector('button');
                    const svg = button.querySelector('svg');
                    const count = button.querySelector('.likes-count');
                    
                    if (method === 'DELETE') {
                        // Change to like state
                        this.action = this.action.replace('unlike', 'like');
                        svg.classList.remove('text-blue-500');
                        svg.setAttribute('fill', 'none');
                        count.classList.remove('text-blue-500');
                        this.querySelector('input[name="_method"]')?.remove();
                    } else {
                        // Change to unlike state
                        this.action = this.action.replace('like', 'unlike');
                        const methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.value = 'DELETE';
                        this.appendChild(methodInput);
                        svg.classList.add('text-blue-500');
                        svg.setAttribute('fill', 'currentColor');
                        count.classList.add('text-blue-500');
                    }
                    
                    count.textContent = data.likes_count;
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });
    });

    document.querySelectorAll('.comment-form').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const postId = this.dataset.postId;
            const textarea = this.querySelector('textarea');
            const content = textarea.value.trim();
            
            if (!content) return;

            try {
                const response = await fetch(`/posts/${postId}/comment`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        content: content
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Clear textarea
                    textarea.value = '';
                    
                    // Add new comment to the list
                    const commentsList = document.getElementById(`commentsList-${postId}`);
                    const newComment = `
                        <div class="flex space-x-3">
                            <img src="${data.comment.user.profile_picture || 'https://avatar.iran.liara.run/public/boy'}" 
                                 alt="${data.comment.user.name}" 
                                 class="w-8 h-8 rounded-full"/>
                            <div class="flex-1">
                                <div class="bg-gray-50 rounded-lg px-4 py-2">
                                    <div class="font-medium text-sm">${data.comment.user.name}</div>
                                    <p class="text-sm text-gray-700">${data.comment.content}</p>
                                </div>
                                <div class="mt-1 flex items-center space-x-4 text-xs text-gray-500">
                                    <span>${data.comment.created_at}</span>
                                    <button class="hover:text-blue-500">Reply</button>
                                </div>
                            </div>
                        </div>
                    `;
                    commentsList.insertAdjacentHTML('afterbegin', newComment);

                    // Update comment count
                    const commentCount = document.querySelector(`#postStats-${postId} span:last-child`);
                    commentCount.textContent = parseInt(commentCount.textContent) + 1;
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });
    });
});

function toggleComments(commentsSectionId) {
    const commentsSection = document.getElementById(commentsSectionId);
    const postId = commentsSectionId.split('-')[1];
    const postStats = document.getElementById('postStats-' + postId);
    
    if (commentsSection.classList.contains('hidden')) {
        // Show comments
        commentsSection.classList.remove('hidden');
        postStats.classList.add('hidden'); // Hide the stats
    } else {
        // Hide comments
        commentsSection.classList.add('hidden');
        postStats.classList.remove('hidden'); // Show the stats
    }
}


    function sharePost(postId, url, text) {
        // Create sharing content
        const title = 'DevConnect Post';
        const shareData = {
            title: title,
            text: text,
            url: url
        };
        
        // Show share dialog
        if (navigator.share && navigator.canShare && navigator.canShare(shareData)) {
            // Use native sharing on supported devices
            navigator.share(shareData)
                .catch((error) => {
                    console.log('Error sharing:', error);
                    showShareFallback(postId, url, text, title);
                });
        } else {
            // Fallback for browsers that don't support Web Share API
            showShareFallback(postId, url, text, title);
        }
    }
    
    function showShareFallback(postId, url, text, title) {
        // Create modal for sharing options
        const modal = document.createElement('div');
        modal.id = `share-modal-${postId}`;
        modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
        
        // Encode for sharing
        const encodedUrl = encodeURIComponent(url);
        const encodedText = encodeURIComponent(text);
        const encodedTitle = encodeURIComponent(title);
        
        // Create sharing options
        modal.innerHTML = `
            <div class="bg-white rounded-lg p-6 w-full max-w-md">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Share Post</h3>
                    <button onclick="document.getElementById('share-modal-${postId}').remove()" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="mb-4">
                    <p class="text-sm text-gray-500 mb-2">Share this post via:</p>
                    <div class="flex space-x-4">
                        <a href="https://twitter.com/intent/tweet?text=${encodedText}&url=${encodedUrl}" target="_blank" class="p-2 bg-blue-400 text-white rounded-full">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723 10.059 10.059 0 01-3.127 1.195 4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.997 4.997 0 01-2.212.085 4.937 4.937 0 004.604 3.417 9.868 9.868 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.054 0 13.999-7.496 13.999-13.986 0-.209 0-.42-.015-.63a9.936 9.936 0 002.46-2.548l-.047-.02z"></path>
                            </svg>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=${encodedUrl}" target="_blank" class="p-2 bg-blue-600 text-white rounded-full">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18.77 7.46H14.5v-1.9c0-.9.6-1.1 1-1.1h3V.5h-4.33C10.24.5 9.5 3.44 9.5 5.32v2.15h-3v4h3v12h5v-12h3.85l.42-4z"></path>
                            </svg>
                        </a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=${encodedUrl}&title=${encodedTitle}&summary=${encodedText}" target="_blank" class="p-2 bg-blue-700 text-white rounded-full">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"></path>
                            </svg>
                        </a>
                        <a href="mailto:?subject=${encodedTitle}&body=${encodedText}%0A%0A${encodedUrl}" class="p-2 bg-gray-500 text-white rounded-full">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"></path>
                            </svg>
                        </a>
                        <a href="https://api.whatsapp.com/send?text=${encodedText}%20${encodedUrl}" target="_blank" class="p-2 bg-green-500 text-white rounded-full">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.498 14.382c-.301-.15-1.767-.867-2.04-.966-.273-.101-.473-.15-.673.15-.197.295-.771.964-.944 1.162-.175.195-.349.21-.646.075-.3-.15-1.263-.465-2.403-1.485-.888-.795-1.484-1.77-1.66-2.07-.174-.3-.019-.465.13-.615.136-.135.301-.345.451-.523.146-.181.194-.301.297-.496.1-.21.049-.375-.025-.524-.075-.15-.672-1.62-.922-2.206-.24-.584-.487-.51-.672-.51-.172-.015-.371-.015-.571-.015-.2 0-.523.074-.797.359-.273.3-1.045 1.02-1.045 2.475s1.07 2.865 1.219 3.075c.149.195 2.105 3.195 5.1 4.485.714.3 1.27.48 1.704.629.714.227 1.365.195 1.88.121.574-.091 1.767-.721 2.016-1.426.255-.705.255-1.29.18-1.425-.074-.135-.27-.21-.57-.345m-5.446 7.443h-.016c-1.77 0-3.524-.48-5.055-1.38l-.36-.214-3.75.975 1.005-3.645-.239-.375c-.99-1.576-1.516-3.391-1.516-5.26 0-5.445 4.455-9.885 9.942-9.885 2.655 0 5.14 1.035 7.021 2.91 1.875 1.859 2.909 4.35 2.909 6.99-.004 5.444-4.46 9.885-9.935 9.885M20.52 3.449C18.24 1.245 15.24 0 12.045 0 5.463 0 .104 5.334.101 11.893c0 2.096.549 4.14 1.595 5.945L0 24l6.335-1.652c1.746.943 3.71 1.444 5.71 1.447h.006c6.585 0 11.946-5.336 11.949-11.896 0-3.176-1.24-6.165-3.495-8.411"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="border-t border-gray-200 pt-4">
                    <p class="text-sm text-gray-500 mb-2">Or copy link:</p>
                    <div class="flex">
                        <input type="text" value="${url}" class="flex-1 border border-gray-300 rounded-l-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500" readonly>
                        <button onclick="copyToClipboard('${url}')" class="bg-blue-500 text-white px-4 py-2 rounded-r-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Copy
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        // Add modal to body
        document.body.appendChild(modal);
    }
    
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            // Show success message
            const copyButton = event.target;
            const originalText = copyButton.textContent;
            copyButton.textContent = 'Copied!';
            setTimeout(() => {
                copyButton.textContent = originalText;
            }, 2000);
        });
    }

</script>
