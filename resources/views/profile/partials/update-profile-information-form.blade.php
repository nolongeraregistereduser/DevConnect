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
                    <img src="{{ asset('storage/app/public/' . $user->profile_picture) }}" 
                        alt="{{ $user->name }}'s profile picture"
                        class="w-20 h-20 rounded-full object-cover ring-2 ring-indigo-500 ring-offset-2">
                @else
                    <div class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                @endif
                <div class="flex flex-col space-y-2 flex-1">
                    <input type="file" id="profile_picture" name="profile_picture" 
                        class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4
                        file:rounded-full file:border-0 file:text-sm file:font-semibold
                        file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100
                        cursor-pointer focus:outline-none" 
                        accept="image/*"
                        onchange="previewImage(this)"/>
                    @if($user->profile_picture)
                        <p class="text-xs text-gray-500">Current profile picture will be replaced upon save</p>
                    @endif
                </div>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('profile_picture')" />
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

        <!-- Projects -->
        <div class="mt-4">
            <div class="flex justify-between items-center">
                <x-input-label :value="__('Projects')" />
                <button type="button" 
                    onclick="openModal('project-modal')"
                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Add Project
                </button>
            </div>
            <div id="projects-container" class="mt-3 space-y-3">
                <!-- Projects will be displayed here -->
            </div>
            <input type="hidden" name="projects" id="projects-hidden" :value="old('projects', json_encode($user->projects))" />
        </div>

        <!-- Certifications -->
        <div class="mt-4">
            <div class="flex justify-between items-center">
                <x-input-label :value="__('Certifications')" />
                <button type="button" 
                    onclick="openModal('certification-modal')"
                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Add Certification
                </button>
            </div>
            <div id="certifications-container" class="mt-3 space-y-3">
                <!-- Certifications will be displayed here -->
            </div>
            <input type="hidden" name="certifications" id="certifications-hidden" :value="old('certifications', json_encode($user->certifications))" />
        </div>

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

<!-- Project Modal -->
<div id="project-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden items-center justify-center">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Add New Project</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" id="project-title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="project-description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Project Link</label>
                <input type="url" id="project-link" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Date</label>
                <input type="date" id="project-date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
        </div>
        <div class="mt-6 flex justify-end space-x-3">
            <button type="button" onclick="closeModal('project-modal')" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Cancel</button>
            <button type="button" onclick="saveProject()" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700">Save Project</button>
        </div>
    </div>
</div>

<!-- Certification Modal -->
<div id="certification-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden items-center justify-center mr-10">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mr-4">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Add New Certification</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" id="certification-title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Organization</label>
                <input type="text" id="certification-organization" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Issue Date</label>
                <input type="date" id="certification-date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Credential Link</label>
                <input type="url" id="certification-link" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
        </div>
        <div class="mt-6 flex justify-end space-x-3">
            <button type="button" onclick="closeModal('certification-modal')" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Cancel</button>
            <button type="button" onclick="saveCertification()" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700">Save Certification</button>
        </div>
    </div>
</div>

<!-- Add this before your existing script -->
<script>
// Global variables and functions
let projects = [];
let certifications = [];

function openModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.remove('flex');
    modal.classList.add('hidden');
}

function saveProject() {
    const project = {
        title: document.getElementById('project-title').value,
        description: document.getElementById('project-description').value,
        link: document.getElementById('project-link').value,
        date: document.getElementById('project-date').value
    };

    projects.push(project);
    document.getElementById('projects-hidden').value = JSON.stringify(projects);
    updateProjectsDisplay();
    closeModal('project-modal');
    clearProjectForm();
}

function saveCertification() {
    const certification = {
        title: document.getElementById('certification-title').value,
        organization: document.getElementById('certification-organization').value,
        date: document.getElementById('certification-date').value,
        link: document.getElementById('certification-link').value
    };

    certifications.push(certification);
    document.getElementById('certifications-hidden').value = JSON.stringify(certifications);
    updateCertificationsDisplay();
    closeModal('certification-modal');
    clearCertificationForm();
}

function updateProjectsDisplay() {
    const container = document.getElementById('projects-container');
    if (!container) return;
    
    container.innerHTML = projects.map((project, index) => `
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-lg font-medium text-gray-900">${project.title}</h4>
                    <p class="text-sm text-gray-500">${project.date}</p>
                </div>
                <button onclick="removeProject(${index})" class="text-gray-400 hover:text-red-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <p class="mt-2 text-gray-600">${project.description}</p>
            ${project.link ? `<a href="${project.link}" target="_blank" class="mt-2 inline-flex items-center text-sm text-indigo-600 hover:text-indigo-500">
                View Project
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
            </a>` : ''}
        </div>
    `).join('');
}

function updateCertificationsDisplay() {
    const container = document.getElementById('certifications-container');
    if (!container) return;

    container.innerHTML = certifications.map((cert, index) => `
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-lg font-medium text-gray-900">${cert.title}</h4>
                    <p class="text-sm text-gray-500">${cert.organization} - ${cert.date}</p>
                </div>
                <button onclick="removeCertification(${index})" class="text-gray-400 hover:text-red-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            ${cert.link ? `<a href="${cert.link}" target="_blank" class="mt-2 inline-flex items-center text-sm text-indigo-600 hover:text-indigo-500">
                View Certificate
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
            </a>` : ''}
        </div>
    `).join('');
}

function removeProject(index) {
    projects.splice(index, 1);
    document.getElementById('projects-hidden').value = JSON.stringify(projects);
    updateProjectsDisplay();
}

function removeCertification(index) {
    certifications.splice(index, 1);
    document.getElementById('certifications-hidden').value = JSON.stringify(certifications);
    updateCertificationsDisplay();
}

function clearProjectForm() {
    document.getElementById('project-title').value = '';
    document.getElementById('project-description').value = '';
    document.getElementById('project-link').value = '';
    document.getElementById('project-date').value = '';
}

function clearCertificationForm() {
    document.getElementById('certification-title').value = '';
    document.getElementById('certification-organization').value = '';
    document.getElementById('certification-date').value = '';
    document.getElementById('certification-link').value = '';
}

// Initialize data when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize existing data
    try {
        const projectsData = document.getElementById('projects-hidden').value;
        const certificationsData = document.getElementById('certifications-hidden').value;
        
        projects = projectsData ? JSON.parse(projectsData) : [];
        certifications = certificationsData ? JSON.parse(certificationsData) : [];
        
        updateProjectsDisplay();
        updateCertificationsDisplay();
    } catch (e) {
        console.error('Error parsing existing data:', e);
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        if (event.target.id === 'project-modal' || event.target.id === 'certification-modal') {
            closeModal(event.target.id);
        }
    }
});
</script>

<!-- Your existing DOMContentLoaded script -->
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

    // Add these functions to your existing script
    let projects = [];
    let certifications = [];

    // Initialize existing data
    try {
        projects = JSON.parse(document.getElementById('projects-hidden').value || '[]');
        certifications = JSON.parse(document.getElementById('certifications-hidden').value || '[]');
        updateProjectsDisplay();
        updateCertificationsDisplay();
    } catch (e) {
        console.error('Error parsing existing data:', e);
    }

    function openModal(modalId) {
        document.getElementById(modalId).style.display = 'flex';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    function saveProject() {
        const project = {
            title: document.getElementById('project-title').value,
            description: document.getElementById('project-description').value,
            link: document.getElementById('project-link').value,
            date: document.getElementById('project-date').value
        };

        projects.push(project);
        document.getElementById('projects-hidden').value = JSON.stringify(projects);
        updateProjectsDisplay();
        closeModal('project-modal');
        clearProjectForm();
    }

    function saveCertification() {
        const certification = {
            title: document.getElementById('certification-title').value,
            organization: document.getElementById('certification-organization').value,
            date: document.getElementById('certification-date').value,
            link: document.getElementById('certification-link').value
        };

        certifications.push(certification);
        document.getElementById('certifications-hidden').value = JSON.stringify(certifications);
        updateCertificationsDisplay();
        closeModal('certification-modal');
        clearCertificationForm();
    }

    function updateProjectsDisplay() {
        const container = document.getElementById('projects-container');
        container.innerHTML = projects.map((project, index) => `
            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                <div class="flex justify-between items-start">
                    <div>
                        <h4 class="text-lg font-medium text-gray-900">${project.title}</h4>
                        <p class="text-sm text-gray-500">${project.date}</p>
                    </div>
                    <button onclick="removeProject(${index})" class="text-gray-400 hover:text-red-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <p class="mt-2 text-gray-600">${project.description}</p>
                ${project.link ? `<a href="${project.link}" target="_blank" class="mt-2 inline-flex items-center text-sm text-indigo-600 hover:text-indigo-500">
                    View Project
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </a>` : ''}
            </div>
        `).join('');
    }

    function updateCertificationsDisplay() {
        const container = document.getElementById('certifications-container');
        container.innerHTML = certifications.map((cert, index) => `
            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                <div class="flex justify-between items-start">
                    <div>
                        <h4 class="text-lg font-medium text-gray-900">${cert.title}</h4>
                        <p class="text-sm text-gray-500">${cert.organization} - ${cert.date}</p>
                    </div>
                    <button onclick="removeCertification(${index})" class="text-gray-400 hover:text-red-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                ${cert.link ? `<a href="${cert.link}" target="_blank" class="mt-2 inline-flex items-center text-sm text-indigo-600 hover:text-indigo-500">
                    View Certificate
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </a>` : ''}
            </div>
        `).join('');
    }

    function removeProject(index) {
        projects.splice(index, 1);
        document.getElementById('projects-hidden').value = JSON.stringify(projects);
        updateProjectsDisplay();
    }

    function removeCertification(index) {
        certifications.splice(index, 1);
        document.getElementById('certifications-hidden').value = JSON.stringify(certifications);
        updateCertificationsDisplay();
    }

    function clearProjectForm() {
        document.getElementById('project-title').value = '';
        document.getElementById('project-description').value = '';
        document.getElementById('project-link').value = '';
        document.getElementById('project-date').value = '';
    }

    function clearCertificationForm() {
        document.getElementById('certification-title').value = '';
        document.getElementById('certification-organization').value = '';
        document.getElementById('certification-date').value = '';
        document.getElementById('certification-link').value = '';
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        if (event.target.id === 'project-modal' || event.target.id === 'certification-modal') {
            closeModal(event.target.id);
        }
    }
});
</script>



