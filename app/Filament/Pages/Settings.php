<?php

namespace App\Filament\Pages;

use App\Models\Settings as SettingsModel;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;


class Settings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $view = 'filament.pages.settings';

    protected static ?int $navigationSort = 2;

    public ?array $data = [];
    public SettingsModel $settingsModel;

    public function mount(): void
    {
        $this->settingsModel = SettingsModel::first();

        $this->form->fill($this->settingsModel->toArray());
    }
    public static function getNavigationGroup(): ?string
    {
        return 'System Settings';
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->model(SettingsModel::class)
            ->schema([
                Tabs::make('admin_settings')
                    ->persistTabInQueryString()
                    ->tabs([
                        Tabs\Tab::make('General Settings')
                            ->schema([
                                TextInput::make('project_title')
                                    ->required(),

                                Textarea::make('project_description'),
                            ]),

                        Tabs\Tab::make('Virtual Pos Settings')
                            ->schema([
                                TextInput::make('bank_name'),
                                TextInput::make('merchant_id'),
                                TextInput::make('prov_user_id'),
                                TextInput::make('provision_password')->password(),
                                TextInput::make('terminal_id'),
                                TextInput::make('store_key')->password(),
                                TextInput::make('pos_url'),
                            ]),
                    ])
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $this->settingsModel->update($data);

        if ($this->settingsModel->wasChanged()) {
            Notification::make()
                ->title('Success')
                ->body('Settings updated')
                ->success()
                ->send();
        }
    }
}
