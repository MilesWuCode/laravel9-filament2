<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Models\Banner;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('url')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('url'),
                Tables\Columns\TextColumn::make('order_column'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\BulkAction::make('sortable')
                    ->icon('heroicon-o-switch-vertical')
                    ->deselectRecordsAfterCompletion()
                    ->action(function (Collection $records, array $data): void {
                        $target = Banner::find($data['to']);

                        $orderColumn = $target->determineOrderColumnName();

                        $keyName = $target->getKeyName();

                        $merged = $records->where($keyName, $target->id)->first() ? clone $records : $records->merge([$target]);

                        $mergedIds = $merged->sortBy($orderColumn)->pluck($keyName)->toArray();

                        $mergedOrders = $merged->sortBy($orderColumn)->pluck($orderColumn)->toArray();

                        $between = [$mergedOrders[0], end($mergedOrders)];

                        if (! is_null($key = array_search($target->getKey(), $mergedIds))) {
                            unset($mergedIds[$key]);
                        }

                        $ids = Banner::whereBetween($orderColumn, $between)
                            ->whereNotIn($keyName, $mergedIds)
                            ->ordered()
                            ->pluck($keyName)
                            ->toArray();

                        $key = array_search($target->getKey(), $ids);

                        $left = ! is_null($key) ? array_slice($ids, 0, $key) : [];

                        $right = ! is_null($key) ? array_slice($ids, $key + 1) : [];

                        if ($data['shift'] === 'up') {
                            Banner::setNewOrder(array_merge($left, $mergedIds, [$target->getKey()], $right), $between[0]);
                        } elseif ($data['shift'] === 'down') {
                            Banner::setNewOrder(array_merge($left, [$target->getKey()], $mergedIds, $right), $between[0]);
                        }
                    })
                    ->form([
                        Forms\Components\Select::make('to')
                            ->label('To')
                            ->options(Banner::query()->ordered()->pluck('name', 'id'))
                            ->required(),

                        Forms\Components\Radio::make('shift')
                            ->label('Shift')
                            ->options([
                                'up' => 'Up',
                                'down' => 'Down',
                            ])
                            ->default('up'),
                    ]),
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
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'view' => Pages\ViewBanner::route('/{record}'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return static::getModel()::query()->orderBy('order_column', 'asc');
    }
}
