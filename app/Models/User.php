<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Althinect\FilamentSpatieRolesPermissions\Concerns\HasSuperAdmin;
use Awcodes\Overlook\Concerns\HandlesOverlookWidgetCustomization;
use Edwink\FilamentUserActivity\Traits\UserActivityTrait;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Jeffgreco13\FilamentBreezy\Traits\TwoFactorAuthenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    use  HasRoles, HasFactory, Notifiable, TwoFactorAuthenticatable, HasSuperAdmin, UserActivityTrait, SoftDeletes, HandlesOverlookWidgetCustomization;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar_url',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return match ($panel->getId()) {
            'admin' => $this->hasAnyRole(['admin', 'Super-Admin']),
            'dashboard' => $this->hasAnyRole(['User', 'admin', 'Super-Admin']),
            default => false,
        };
    }
    public function switchPanel(Panel $panel): bool
    {
        return $this->hasRole('Super-Admin', 'admin');
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url 
            ? Storage::url($this->avatar_url)
            : null;
    }



    public function getInitials(): string
    {
        $names = explode(' ', $this->name);
        $initials = '';

        foreach ($names as $name) {
            $initials .= strtoupper($name[0]); // Nimm den ersten Buchstaben jedes Namens
        }

        return $initials;
    }

    // Events and Listeners

    protected static function booted()
    {
        static::updating(function ($user) {
            
            // Prüfen, ob der Avatar-URL geändert wurde und ein alter Avatar vorhanden ist
            $avatarPath = $user->getOriginal('avatar_url');

            if ($avatarPath && Storage::disk('public')->exists($avatarPath)) {
                Storage::disk('public')->delete($avatarPath);
            } else {
                \Log::info('Avatar-Datei nicht gefunden oder existiert nicht: ' . $avatarPath);
            }
            
        });

        static::deleting(function ($user) {
            // Avatar löschen, wenn der Benutzer gelöscht wird und ein Avatar vorhanden ist
            if ($user->avatar_url) {
                Storage::delete($user->avatar_url);
            }
        });
    }
}
