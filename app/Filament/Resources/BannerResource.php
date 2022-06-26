<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Filament\Resources\BannerResource\RelationManagers;
use App\Models\Banner;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Collection;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

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
                        if (count($records) === 1) {
                            $record = $records->first();

                            if ($record->id !== $data['to']) {
                                $orderColumn = $record->determineOrderColumnName();

                                $target = Banner::find($data['to']);

                                $order = [$target->$orderColumn, $record->$orderColumn];

                                sort($order);

                                $startOrder = $order[0];

                                $ids = Banner::whereBetween($orderColumn, $order)
                                    ->whereNotIn('id', [$target->getKey(), $record->getKey()])
                                    ->ordered()
                                    ->pluck('id')
                                    ->toArray();

                                if($record->$orderColumn > $target->$orderColumn && $data['shift'] === 'up') {
                                    // 7 -> 4+ -> 4,5,6,7 = 7,4,5,6
                                    array_unshift($ids, $record->getKey(), $target->getKey());

                                }else if($record->$orderColumn > $target->$orderColumn && $data['shift'] === 'down') {
                                    // 7 -> 4- -> 4,5,6,7 = 4,7,5,6
                                    array_unshift($ids, $target->getKey(), $record->getKey());

                                }else if($record->$orderColumn < $target->$orderColumn && $data['shift'] === 'up') {
                                    // 4 -> 7+ -> 4,5,6,7 = 5,6,4,7
                                    array_push($ids, $record->getKey(), $target->getKey());

                                }else if($record->$orderColumn < $target->$orderColumn && $data['shift'] === 'down') {
                                    // 4 -> 7- -> 4,5,6,7 = 5,6,7,4
                                    array_push($ids, $target->getKey(), $record->getKey());

                                }

                                Banner::setNewOrder($ids, $startOrder);
                            }
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
                            ->default('up')
                    ])
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
