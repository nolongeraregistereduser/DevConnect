<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'bio',
        'profile_picture',
        'location',
        'website',
        'skills',
        'programming_languages',
        'projects',
        'certifications',
        'github_link',
        'gitlab_link'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'skills' => 'array',
        'programming_languages' => 'array',
        'projects' => 'array',
        'certifications' => 'array'
    ];

    function posts() {
        return $this->hasMany(Post::class);
    }

    function comments() {
        return $this->hasMany(Comment::class);
    }

    function likes() {
        return $this->hasMany(Like::class);
    }

    public function connections()
    {
        return $this->hasMany(Connection::class);
    }

    public function connectedUsers()
    {
        return $this->belongsToMany(User::class, 'connections', 'user_id', 'connected_user_id')
                    ->withPivot('status')
                    ->withTimestamps();
    }

    public function pendingConnections()
    {
        return $this->connections()->where('status', 'pending');
    }

    public function acceptedConnections()
    {
        return $this->connections()->where('status', 'accepted');
    }
}
