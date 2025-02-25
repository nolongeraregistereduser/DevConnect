<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Profile Picture -->
        <div class="mt-4">
            <x-input-label for="profile_picture" :value="__('Profile Picture')" />
            <div class="mt-2 flex items-center space-x-4">
                @if($user->profile_picture)
                    <img src="{{ Storage::url($user->profile_picture) }}" class="w-20 h-20 rounded-full object-cover ring-2 ring-indigo-500 ring-offset-2">
                @else
                    <div class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                @endif
                <input type="file" id="profile_picture" name="profile_picture" 
                    class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0 file:text-sm file:font-semibold
                    file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100
                    cursor-pointer focus:outline-none" accept="image/*"/>
            </div>
        </div>

        <!-- Bio -->
        <div class="mt-4">
            <x-input-label for="bio" :value="__('Bio')" />
            <textarea id="bio" name="bio" rows="4" 
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150 ease-in-out"
                placeholder="Tell us about yourself...">{{ old('bio', $user->bio) }}</textarea>
            <p class="mt-1 text-sm text-gray-500" id="bio-counter">0/1000 characters</p>
        </div>

        <!-- Location -->
        <div>
            <x-input-label for="location" :value="__('Location')" />
            <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" :value="old('location', $user->location)" placeholder="City, Country" />
            <x-input-error class="mt-2" :messages="$errors->get('location')" />
        </div>

        <!-- Skills -->
        <div class="mt-4">
            <x-input-label for="skills-input" :value="__('Skills')" />
            <div class="mt-1 space-y-2">
                <div class="flex items-center gap-2">
                    <input type="text" id="skills-input" 
                        class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150 ease-in-out"
                        placeholder="Type a skill and press Enter" />
                    <button type="button" onclick="addTag_skills-input()" 
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Add
                    </button>
                </div>
                <div id="skills-tags" class="flex flex-wrap gap-2"></div>
                <input type="hidden" name="skills" id="skills-hidden" :value="old('skills', json_encode($user->skills))" />
            </div>
        </div>

        <!-- Programming Languages -->
        <div class="mt-4">
            <x-input-label for="languages-input" :value="__('Programming Languages')" />
            <div class="mt-1 space-y-2">
                <div class="flex items-center gap-2">
                    <input type="text" id="languages-input" 
                        class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150 ease-in-out"
                        placeholder="Type a language and press Enter" />
                    <button type="button" onclick="addTag_languages-input()" 
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Add
                    </button>
                </div>
                <div id="languages-tags" class="flex flex-wrap gap-2"></div>
                <input type="hidden" name="programming_languages" id="languages-hidden" :value="old('programming_languages', json_encode($user->programming_languages))" />
            </div>
        </div>

        <!-- Website -->
        <div>
            <x-input-label for="website" :value="__('Website')" />
            <x-text-input id="website" name="website" type="url" class="mt-1 block w-full" :value="old('website', $user->website)" placeholder="https://your-website.com" />
            <x-input-error class="mt-2" :messages="$errors->get('website')" />
        </div>

        <!-- GitHub Link -->
        <div>
            <x-input-label for="github_link" :value="__('GitHub Profile')" />
            <x-text-input id="github_link" name="github_link" type="url" class="mt-1 block w-full" :value="old('github_link', $user->github_link)" placeholder="https://github.com/username" />
            <x-input-error class="mt-2" :messages="$errors->get('github_link')" />
        </div>

        <!-- GitLab Link
        <div>
            <x-input-label for="gitlab_link" :value="__('GitLab Profile')" />
            <x-text-input id="gitlab_link" name="gitlab_link" type="url" class="mt-1 block w-full" :value="old('gitlab_link', $user->gitlab_link)" placeholder="https://gitlab.com/username" />
            <x-input-error class="mt-2" :messages="$errors->get('gitlab_link')" />
        </div> -->

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function initializeTagInput(inputId, tagsContainerId, hiddenInputId) {
        const input = document.getElementById(inputId);
        const tagsContainer = document.getElementById(tagsContainerId);
        const hiddenInput = document.getElementById(hiddenInputId);
        let tags = [];

        // Initialize existing tags if any
        try {
            const existingTags = JSON.parse(hiddenInput.value || '[]');
            tags = Array.isArray(existingTags) ? existingTags : [];
            updateTags();
        } catch (e) {
            console.error('Error parsing existing tags:', e);
        }

        function updateTags() {
            tagsContainer.innerHTML = tags.map(tag => `
                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800 group hover:bg-indigo-200 transition duration-150 ease-in-out">
                    ${tag}
                    <button type="button" 
                        class="ml-1.5 inline-flex items-center justify-center h-5 w-5 rounded-full text-indigo-400 hover:text-indigo-500 hover:bg-indigo-200 focus:outline-none" 
                        onclick="removeTag('${tag}', '${tagsContainerId}', '${hiddenInputId}')">
                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </span>
            `).join('');
            hiddenInput.value = JSON.stringify(tags);
        }

        function addTag() {
            const value = input.value.trim();
            if (value && !tags.includes(value)) {
                tags.push(value);
                updateTags();
                input.value = '';
                input.focus();
            }
        }

        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addTag();
            }
        });

        // Make the function available globally
        window[`addTag_${inputId}`] = addTag;
        
        window.removeTag = function(tag, targetContainerId, targetHiddenInputId) {
            if (tagsContainerId === targetContainerId) {
                tags = tags.filter(t => t !== tag);
                updateTags();
            }
        };
    }

    // Bio character counter
    const bioTextarea = document.getElementById('bio');
    const bioCounter = document.getElementById('bio-counter');
    
    function updateBioCounter() {
        const length = bioTextarea.value.length;
        bioCounter.textContent = `${length}/1000 characters`;
        
        if (length > 800) {
            bioCounter.classList.add('text-amber-600');
        } else {
            bioCounter.classList.remove('text-amber-600');
        }
    }
    
    bioTextarea.addEventListener('input', updateBioCounter);
    updateBioCounter();

    // Initialize tag inputs
    initializeTagInput('skills-input', 'skills-tags', 'skills-hidden');
    initializeTagInput('languages-input', 'languages-tags', 'languages-hidden');
});
</script>
