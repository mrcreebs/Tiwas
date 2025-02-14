<?php

namespace App\Providers\Filament;

use Althinect\FilamentSpatieRolesPermissions\FilamentSpatieRolesPermissionsPlugin;
use App\Filament\Admin\Resources\UserResource;
use Awcodes\Overlook\OverlookPlugin;
use Awcodes\Overlook\Widgets\OverlookWidget;
use Edwink\FilamentUserActivity\FilamentUserActivityPlugin;
use Edwink\FilamentUserActivity\Http\Middleware\RecordUserActivity;
use Filament\Forms\Components\FileUpload;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Filament\Support\Enums\Platform;
use Filament\Widgets;
use GeoSot\FilamentEnvEditor\FilamentEnvEditorPlugin;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Jeffgreco13\FilamentBreezy\BreezyCore;
use ShuvroRoy\FilamentSpatieLaravelBackup\FilamentSpatieLaravelBackupPlugin;


class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->spa()
            ->sidebarFullyCollapsibleOnDesktop()
            ->login()
            ->authGuard('web')
            ->maxContentWidth(MaxWidth::Full)
            ->databaseNotifications()
            ->globalSearchDebounce('1000ms')
            ->globalSearchFieldSuffix(fn (): ?string => match (Platform::detect()) {
                Platform::Windows, Platform::Linux => 'CTRL+K',
                Platform::Mac => '⌘K',
                default => null,
            })
            ->plugin(
                FilamentSpatieRolesPermissionsPlugin::make()
            )
            ->plugin(
                \Hasnayeen\Themes\ThemesPlugin::make()
            )
            ->plugin(
                BreezyCore::make()
                    ->enableTwoFactorAuthentication(
                        force: false,
                    )
                    
                    ->myProfile(
                        shouldRegisterUserMenu: true, // Sets the 'account' link in the panel User Menu (default = true)
                        shouldRegisterNavigation: false, // Adds a main navigation item for the My Profile page (default = false)
                        //navigationGroup: 'Settings', // Sets the navigation group for the My Profile page (default = null)
                        hasAvatars: true, // Enables the avatar upload form component (default = false)
                        slug: 'my-profile' // Sets the slug for the profile page (default = 'my-profile')
                    )
                    ->passwordUpdateRules(
                        rules: [Password::default()->mixedCase()->uncompromised(3)], // you may pass an array of validation rules as well. (default = ['min:8'])
                        requiresCurrentPassword: true, // when false, the user can update their password without entering their current password. (default = true)
                    )
                    ->avatarUploadComponent(
                        fn() => FileUpload::make('avatar_url')
                            ->disk('public')
                            ->directory(fn() => 'profiles-avatar/' . auth()->user()->id)
                            ->image()
                            ->avatar()
                            ->moveFiles()
                            ->previewable(true)
                            ->visibility('public') // Stelle sicher, dass die Sichtbarkeit korrekt ist
                    )
                    
            )
            
            ->plugin(FilamentSpatieLaravelBackupPlugin::make()
                ->usingPolingInterval('10s') // default value is 4s
                ->noTimeout()
            )
            ->plugin(
                FilamentEnvEditorPlugin::make()
                ->navigationGroup('Administration')
                ->navigationLabel('My Env')
                ->navigationIcon('heroicon-o-cog-8-tooth')
                ->navigationSort(4)
                ->slug('env-editor')
                ->authorize(
                    fn () => auth()->user()->hasAnyRole(['Super-Admin']),
                )
            )
            ->plugins([
                OverlookPlugin::make()
                ->sort(2)
                ->columns([
                    'default' => 1,
                    'sm' => 2,
                    'md' => 3,
                    'lg' => 4,
                    'xl' => 5,
                    '2xl' => null,
                ])
                ->icons([
                    'heroicon-o-user' => UserResource::class,
                ])
                ->includes([
                    UserResource::class,
                ])
            ])
            ->widgets([
                OverlookWidget::class,
            ])
            ->plugins([
                FilamentUserActivityPlugin::make(),
            ])
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(
                in: app_path('Filament/Admin/Resources'),
                for: 'App\\Filament\\Admin\\Resources'
            )
            ->discoverPages(
                in: app_path('Filament/Admin/Pages'),
                for: 'App\\Filament\\Admin\\Pages'
            )
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(
                in: app_path('Filament/Admin/Widgets'),
                for: 'App\\Filament\\Admin\\Widgets'
            )
            ->widgets([
                Widgets\AccountWidget::class,
                //Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                \Hasnayeen\Themes\Http\Middleware\SetTheme::class,
                RecordUserActivity::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}

