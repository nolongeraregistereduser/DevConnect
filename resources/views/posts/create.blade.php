<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post - DevConnect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .code-editor {
            font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', 'Consolas', 'source-code-pro', monospace;
            font-size: 14px;
            line-height: 1.6;
        }
        .character-count {
            transition: color 0.2s;
        }
        .character-count.warning {
            color: #f59e0b;
        }
        .character-count.danger {
            color: #ef4444;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full bg-gray-900 text-white z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('feed') }}" class="text-2xl font-bold text-blue-400 hover:text-blue-300 transition-colors">
                        &lt;DevConnect/&gt;
                    </a>
                </div>
                
                <div class="flex items-center space-x-6">
                    <a href="{{ route('feed') }}" class="flex items-center space-x-1 hover:text-blue-400 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        <span>Back to Feed</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto pt-24 px-4 pb-12">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Create a New Post</h1>
            <p class="text-gray-600">Share your thoughts, code, or ask questions with the DevConnect community</p>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="text-green-800">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Post Creation Form -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200">
            <!-- Form Header with User Info -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                <div class="flex items-center space-x-4">
                    @if(auth()->user()->profile_picture && file_exists(public_path('storage/' . auth()->user()->profile_picture)))
                        <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" 
                             alt="{{ auth()->user()->name }}" 
                             class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-md"/>
                    @else
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center border-2 border-white shadow-md">
                            <span class="text-white font-semibold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        </div>
                    @endif
                    <div>
                        <h3 class="font-semibold text-gray-900">{{ auth()->user()->name }}</h3>
                        <p class="text-sm text-gray-500">What would you like to share?</p>
                    </div>
                </div>
            </div>

            <!-- Form Content -->
            <form action="{{ route('posts.store') }}" method="POST" class="p-6 space-y-6">
                @csrf
                
                <!-- Post Content -->
                <div>
                    <label for="content" class="block text-sm font-semibold text-gray-700 mb-2">
                        Post Content <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        name="content"
                        id="content"
                        rows="6"
                        maxlength="1000"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all resize-none"
                        placeholder="Share your thoughts, ideas, or questions... Use #hashtags to make your post discoverable (e.g., #laravel #javascript #webdev)"
                        required
                        oninput="updateCharCount()"
                    >{{ old('content') }}</textarea>
                    <div class="flex justify-between items-center mt-2">
                        <p class="text-sm text-gray-500">
                            Use <span class="font-semibold text-blue-600">#hashtags</span> to categorize your post
                        </p>
                        <span id="charCount" class="text-sm font-medium text-gray-500 character-count">
                            <span id="currentCount">0</span>/1000
                        </span>
                    </div>
                    @error('content')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Code Snippet Section -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="code_snippet" class="block text-sm font-semibold text-gray-700">
                            Code Snippet <span class="text-gray-500 font-normal">(optional)</span>
                        </label>
                        <button 
                            type="button" 
                            id="toggleCode"
                            class="text-sm text-blue-600 hover:text-blue-700 font-medium flex items-center space-x-1"
                            onclick="toggleCodeSection()"
                        >
                            <svg id="codeIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                            <span>Add Code</span>
                        </button>
                    </div>
                    
                    <div id="codeSection" class="hidden transition-all duration-300">
                        <div class="bg-gray-900 rounded-lg border border-gray-700 overflow-hidden shadow-inner">
                            <div class="flex items-center justify-between px-4 py-2 bg-gray-800 border-b border-gray-700">
                                <div class="flex items-center space-x-2">
                                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                    <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                    <span class="ml-2 text-xs text-gray-400 font-mono">code</span>
                                </div>
                            </div>
                            <textarea
                                name="code_snippet"
                                id="code_snippet"
                                rows="10"
                                class="code-editor w-full px-4 py-3 bg-gray-900 text-gray-100 focus:outline-none resize-none"
                                placeholder="// Paste or type your code here...&#10;function example() {&#10;    return 'Hello DevConnect!';&#10;}"
                            >{{ old('code_snippet') }}</textarea>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">
                            💡 Tip: Share code snippets to help other developers or get feedback
                        </p>
                        @error('code_snippet')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Preview Section (optional, for future enhancement) -->
                <div class="border-t border-gray-200 pt-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2 text-sm text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Your post will be visible to all DevConnect members</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
                    <a href="{{ route('feed') }}" 
                       class="px-6 py-3 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition-colors duration-200 flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        <span>Cancel</span>
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-lg font-semibold shadow-lg shadow-blue-500/50 hover:shadow-xl hover:shadow-blue-500/50 transition-all duration-200 transform hover:-translate-y-0.5 flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>Publish Post</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Help Tips Card -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-xl p-6">
            <h3 class="text-lg font-semibold text-blue-900 mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                </svg>
                Tips for Better Posts
            </h3>
            <ul class="space-y-2 text-sm text-blue-800">
                <li class="flex items-start">
                    <span class="text-blue-500 mr-2">•</span>
                    <span>Use <strong>#hashtags</strong> to make your post discoverable (e.g., #laravel, #javascript, #webdev)</span>
                </li>
                <li class="flex items-start">
                    <span class="text-blue-500 mr-2">•</span>
                    <span>Add code snippets to share solutions or ask for help</span>
                </li>
                <li class="flex items-start">
                    <span class="text-blue-500 mr-2">•</span>
                    <span>Be clear and concise - your fellow developers will appreciate it!</span>
                </li>
                <li class="flex items-start">
                    <span class="text-blue-500 mr-2">•</span>
                    <span>Engage with the community by responding to comments</span>
                </li>
            </ul>
        </div>
    </div>

    <script>
        // Character counter
        function updateCharCount() {
            const textarea = document.getElementById('content');
            const currentCount = textarea.value.length;
            const maxCount = 1000;
            const charCountEl = document.getElementById('charCount');
            const currentCountEl = document.getElementById('currentCount');
            
            currentCountEl.textContent = currentCount;
            
            charCountEl.classList.remove('warning', 'danger');
            if (currentCount > maxCount * 0.9) {
                charCountEl.classList.add('danger');
            } else if (currentCount > maxCount * 0.75) {
                charCountEl.classList.add('warning');
            }
        }

        // Initialize character count on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateCharCount();
            const textarea = document.getElementById('content');
            if (textarea.value) {
                updateCharCount();
            }
        });

        // Toggle code section
        let codeSectionVisible = false;
        function toggleCodeSection() {
            const codeSection = document.getElementById('codeSection');
            const codeIcon = document.getElementById('codeIcon');
            const toggleButton = document.getElementById('toggleCode');
            
            codeSectionVisible = !codeSectionVisible;
            
            if (codeSectionVisible) {
                codeSection.classList.remove('hidden');
                codeIcon.style.transform = 'rotate(180deg)';
                toggleButton.querySelector('span').textContent = 'Hide Code';
            } else {
                codeSection.classList.add('hidden');
                codeIcon.style.transform = 'rotate(0deg)';
                toggleButton.querySelector('span').textContent = 'Add Code';
            }
        }

        // Auto-resize code textarea
        const codeTextarea = document.getElementById('code_snippet');
        if (codeTextarea) {
            codeTextarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
        }
    </script>
</body>
</html>
