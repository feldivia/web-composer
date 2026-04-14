<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Models\User;
use App\Services\SettingsService;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class SiteSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Sistema';

    protected static ?string $navigationLabel = 'Site Settings';

    protected static ?int $navigationSort = 2;

    protected static ?string $title = 'Site Settings';

    protected static string $view = 'filament.pages.site-settings';

    /**
     * Solo Admin puede acceder a la configuración del sitio.
     */
    public static function canAccess(): bool
    {
        /** @var User|null $user */
        $user = auth()->user();

        return $user !== null && $user->isAdmin();
    }

    public ?array $data = [];

    /**
     * Lista de claves de configuración gestionadas por esta página.
     *
     * @var list<string>
     */
    private const SETTING_KEYS = [
        'site_name',
        'site_description',
        'site_logo',
        'site_favicon',
        'font_heading',
        'font_body',
        'color_primary',
        'color_secondary',
        'color_accent',
        'color_background',
        'color_text',
        'social_facebook',
        'social_instagram',
        'social_twitter',
        'social_linkedin',
        'social_youtube',
        'whatsapp_number',
        'whatsapp_message',
        'footer_text',
        'analytics_id',
        'meta_pixel_id',
    ];

    public function mount(): void
    {
        $settings = SettingsService::getMany(self::SETTING_KEYS);

        $this->form->fill($settings);
    }

    public function form(Form $form): Form
    {
        $fontOptions = array_combine(
            config('webcomposer.fonts'),
            config('webcomposer.fonts'),
        );

        return $form
            ->schema([
                Forms\Components\Section::make('Site Info')
                    ->schema([
                        Forms\Components\TextInput::make('site_name')
                            ->label('Site Name')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('site_description')
                            ->label('Site Description')
                            ->maxLength(500),

                        Forms\Components\FileUpload::make('site_logo')
                            ->label('Logo')
                            ->image()
                            ->directory('site'),

                        Forms\Components\FileUpload::make('site_favicon')
                            ->label('Favicon')
                            ->image()
                            ->directory('site'),
                    ])->columns(2),

                Forms\Components\Section::make('Typography')
                    ->schema([
                        Forms\Components\Select::make('font_heading')
                            ->label('Heading Font')
                            ->options($fontOptions)
                            ->searchable(),

                        Forms\Components\Select::make('font_body')
                            ->label('Body Font')
                            ->options($fontOptions)
                            ->searchable(),
                    ])->columns(2),

                Forms\Components\Section::make('Colors')
                    ->schema([
                        Forms\Components\ColorPicker::make('color_primary')
                            ->label('Primary'),

                        Forms\Components\ColorPicker::make('color_secondary')
                            ->label('Secondary'),

                        Forms\Components\ColorPicker::make('color_accent')
                            ->label('Accent'),

                        Forms\Components\ColorPicker::make('color_background')
                            ->label('Background'),

                        Forms\Components\ColorPicker::make('color_text')
                            ->label('Text'),
                    ])->columns(3),

                Forms\Components\Section::make('Social Media')
                    ->schema([
                        Forms\Components\TextInput::make('social_facebook')
                            ->label('Facebook')
                            ->url()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('social_instagram')
                            ->label('Instagram')
                            ->url()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('social_twitter')
                            ->label('Twitter / X')
                            ->url()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('social_linkedin')
                            ->label('LinkedIn')
                            ->url()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('social_youtube')
                            ->label('YouTube')
                            ->url()
                            ->maxLength(255),
                    ])->columns(2),

                Forms\Components\Section::make('WhatsApp')
                    ->schema([
                        Forms\Components\TextInput::make('whatsapp_number')
                            ->label('Phone Number')
                            ->maxLength(20),

                        Forms\Components\TextInput::make('whatsapp_message')
                            ->label('Default Message')
                            ->maxLength(255),
                    ])->columns(2),

                Forms\Components\Section::make('Footer')
                    ->schema([
                        Forms\Components\TextInput::make('footer_text')
                            ->label('Footer Text')
                            ->maxLength(500),
                    ]),

                Forms\Components\Section::make('Analytics')
                    ->schema([
                        Forms\Components\TextInput::make('analytics_id')
                            ->label('Google Analytics ID')
                            ->placeholder('G-XXXXXXXXXX')
                            ->maxLength(50),

                        Forms\Components\TextInput::make('meta_pixel_id')
                            ->label('Meta Pixel ID')
                            ->placeholder('123456789')
                            ->maxLength(50),
                    ])->columns(2),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach (self::SETTING_KEYS as $key) {
            if (array_key_exists($key, $data)) {
                SettingsService::set($key, $data[$key]);
            }
        }

        Notification::make()
            ->title('Settings saved successfully')
            ->success()
            ->send();
    }
}
