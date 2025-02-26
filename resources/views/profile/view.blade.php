<!-- resources/views/profile/show.blade.php -->
@extends('layouts.app')

@section('styles')
<style>
    .profile-card {
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        margin-bottom: 20px;
    }
    
    .profile-header {
        padding: 20px;
        position: relative;
        background-color: #f5f7fa;
        border-radius: 10px 10px 0 0;
        height: 200px;
    }
    
    .profile-picture {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        border: 5px solid white;
        position: absolute;
        bottom: -75px;
        left: 20px;
        object-fit: cover;
        background-color: #f0f2f5;
    }
    
    .profile-info {
        padding: 90px 20px 20px;
    }
    
    .profile-name {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 5px;
    }
    
    .profile-location {
        color: #666;
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
    
    .profile-bio {
        margin: 15px 0;
        line-height: 1.6;
    }
    
    .skill-tag {
        display: inline-block;
        background-color: #f0f2f5;
        padding: 5px 10px;
        border-radius: 20px;
        margin-right: 8px;
        margin-bottom: 8px;
        font-size: 14px;
        color: #666;
    }
    
    .skill-tag:hover {
        background-color: #e0e5ee;
    }
    
    .social-links {
        display: flex;
        margin-top: 15px;
    }
    
    .social-link {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #f0f2f5;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 10px;
        color: #555;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .social-link:hover {
        background-color: #0a66c2;
        color: white;
    }
    
    .section-card {
        padding: 20px;
    }
    
    .section-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }
    
    .project-card, .certification-card {
        padding: 15px;
        border-radius: 8px;
        background-color: #f7f9fc;
        margin-bottom: 15px;
    }
    
    .project-title, .certification-title {
        font-weight: 600;
        margin-bottom: 8px;
    }
    
    .project-description, .certification-details {
        font-size: 14px;
        color: #555;
        margin-bottom: 10px;
    }
    
    .project-link {
        display: inline-block;
        color: #0a66c2;
        text-decoration: none;
        font-size: 14px;
    }
    
    .project-link:hover {
        text-decoration: underline;
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <!-- Main Profile Card -->
            <div class="profile-card">
                <div class="profile-header">
                    <!-- Header background can be styled or have a background image -->
                    @if($user->profile_picture)
                        <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="{{ $user->name }}" class="profile-picture">
                    @else
                        <div class="profile-picture d-flex align-items-center justify-content-center">
                            <i class="fa fa-user fa-3x text-secondary"></i>
                        </div>
                    @endif
                </div>
                
                <div class="profile-info">
                    <h1 class="profile-name">{{ $user->name }}</h1>
                    
                    @if($user->bio)
                        <p class="profile-bio">{{ $user->bio }}</p>
                    @endif
                    
                    @if($user->location)
                        <div class="profile-location">
                            <i class="fa fa-map-marker-alt mr-2"></i> {{ $user->location }}
                        </div>
                    @endif
                    
                    <div class="social-links">
                        @if($user->website)
                            <a href="{{ $user->website }}" class="social-link" target="_blank" title="Website">
                                <i class="fa fa-globe"></i>
                            </a>
                        @endif
                        
                        @if($user->github_link)
                            <a href="{{ $user->github_link }}" class="social-link" target="_blank" title="GitHub">
                                <i class="fab fa-github"></i>
                            </a>
                        @endif
                        
                        <a href="mailto:{{ $user->email }}" class="social-link" title="Email">
                            <i class="fa fa-envelope"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Skills Section -->
            @if($user->skills)
                <div class="profile-card section-card">
                    <h2 class="section-title">مهارات</h2>
                    <div>
                        @foreach(json_decode($user->skills) as $skill)
                            <span class="skill-tag">{{ $skill }}</span>
                        @endforeach
                    </div>
                </div>
            @endif
            
            <!-- Programming Languages Section -->
            @if($user->programming_languages)
                <div class="profile-card section-card">
                    <h2 class="section-title">لغات البرمجة</h2>
                    <div>
                        @foreach(json_decode($user->programming_languages) as $language)
                            <span class="skill-tag">{{ $language }}</span>
                        @endforeach
                    </div>
                </div>
            @endif
            
            <!-- Projects Section -->
            @if($user->projects)
                <div class="profile-card section-card">
                    <h2 class="section-title">المشاريع</h2>
                    @foreach(json_decode($user->projects) as $project)
                        <div class="project-card">
                            <h3 class="project-title">{{ $project->title }}</h3>
                            <p class="project-description">{{ $project->description }}</p>
                            @if(isset($project->link))
                                <a href="{{ $project->link }}" class="project-link" target="_blank">
                                    <i class="fa fa-external-link-alt mr-1"></i> معاينة المشروع
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        
        <div class="col-md-4">
            <!-- Certifications Section -->
            @if($user->certifications)
                <div class="profile-card section-card">
                    <h2 class="section-title">الشهادات</h2>
                    @foreach(json_decode($user->certifications) as $certification)
                        <div class="certification-card">
                            <h3 class="certification-title">{{ $certification->title }}</h3>
                            <p class="certification-details">
                                {{ $certification->organization }} • {{ $certification->date }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @endif
            
            <!-- Contact Information -->
            <div class="profile-card section-card">
                <h2 class="section-title">معلومات الاتصال</h2>
                <div>
                    <p><i class="fa fa-envelope mr-2"></i> {{ $user->email }}</p>
                    @if($user->website)
                        <p>
                            <i class="fa fa-globe mr-2"></i> 
                            <a href="{{ $user->website }}" target="_blank">{{ $user->website }}</a>
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection