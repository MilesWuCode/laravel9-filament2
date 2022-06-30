<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminResource\Pages;
use App\Models\Admin;
use Filament\Forms;
use Filament\Forms\Components\MultiSelect;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class AdminResource extends Resource
{
    protected static ?string $model = Admin::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'System';

    protected static ?string $modelLabel = 'Admin';

    protected static ?string $pluralModelLabel = 'Admins';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()->schema([
                    Forms\Components\Card::make()->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->visibleOn(Pages\CreateAdmin::class)
                            ->hiddenOn(Pages\ViewAdmin::class)
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->visibleOn(Pages\EditAdmin::class)
                            ->hiddenOn(Pages\ViewAdmin::class)
                            ->maxLength(255),
                    ])->columns([
                        'sm' => 2,
                    ]),

                    Forms\Components\Card::make()->schema([
                        MultiSelect::make('roles')
                        ->relationship('roles', 'name'),

                        MultiSelect::make('permissions')
                            ->relationship('permissions', 'name'),
                    ])
                    ->columns([
                        'sm' => 2,
                    ]),
                ])->columnSpan([
                    'sm' => 2,
                ]),

                Forms\Components\Group::make()->schema([
                    Forms\Components\Card::make()
                        ->schema([
                            Forms\Components\Placeholder::make('created_at')
                                ->label('Created at')
                                ->content(fn (?Admin $record): string => $record ? $record->created_at->diffForHumans() : '-'),

                            Forms\Components\Placeholder::make('updated_at')
                                ->label('Updated at')
                                ->content(fn (?Admin $record): string => $record ? $record->updated_at->diffForHumans() : '-'),
                        ]),
                ])->columnSpan([
                    'sm' => 1,
                ]),
            ])
            ->columns([
                'sm' => 3,
                'lg' => null,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('Y-m-d')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('Y-m-d')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                Tables\Filters\Filter::make('verified')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('email_verified_at')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdmins::route('/'),
            'create' => Pages\CreateAdmin::route('/create'),
            'view' => Pages\ViewAdmin::route('/{record}'),
            'edit' => Pages\EditAdmin::route('/{record}/edit'),
        ];
    }
}
