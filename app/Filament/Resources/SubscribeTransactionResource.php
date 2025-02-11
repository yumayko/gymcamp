<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\SubscribePackage;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use App\Models\SubscribeTransaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SubscribeTransactionResource\Pages;
use App\Filament\Resources\SubscribeTransactionResource\RelationManagers;

class SubscribeTransactionResource extends Resource
{
    protected static ?string $model = SubscribeTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make('Product and Price')
                    ->schema([
                        Grid::make(2)
                        ->schema([
                            Forms\Components\Select::make('subscribe_package_id')
                            ->relationship('SubscribeTransaction', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set){
                                $subscribePackage = SubscribePackage::find($state);
                                $price = $subscribePackage ? $subscribePackage->price : 0;
                                $duration = $subscribePackage ? $subscribePackage->diration : 0;

                                $set('price', $price);
                                $set('diration', $duration);

                                $tax = 0.11;
                                $totalTaxAmount = $tax * $price;

                                $totalAmount = $price + $totalTaxAmount;
                                $set('total_amount', number_format($totalAmount, 0, '', ''));
                                $set('total_tax_amount', number_format($totalTaxAmount, 0, '', ''));
                            })

                            ->afterStateHydrated(function (callable $get, callable $set, $state){
                                $subscribePackageId = $state;
                                if($subscribePackageId){
                                    $subscribePackage = SubscribePackage::find($subscribePackageId);
                                    $price = $subscribePackage ? $subscribePackage->price : 0;
                                    $set('price', $price);

                                    $tax = 0.11;
                                    $totalTaxAmount = $tax * $price;
                                    $set('total_tax_amount', number_format($totalTaxAmount, 0, '', ''));
                                }
                            }),

                            Forms\Components\TextInput::make('price')
                            ->required()
                            ->readOnly()
                            ->numeric()
                            ->prefix('IDR'),

                            Forms\Components\TextInput::make('total_amount')
                            ->required()
                            ->readOnly()
                            ->numeric()
                            ->prefix('IDR'),

                            Forms\Components\TextInput::make('total_tax_amount')
                            ->readOnly()
                            ->required()
                            ->numeric()
                            ->prefix('IDR'),

                            Forms\Components\DatePicker::make('started_at')
                            ->required(),

                            Forms\Components\DatePicker::make('ended_at')
                            ->required(),

                            Forms\Components\TextInput::make('duration')
                            ->required()
                            ->readOnly()
                            ->numeric()
                            ->prefix('Days'),
                        ]),
                    ])
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListSubscribeTransactions::route('/'),
            'create' => Pages\CreateSubscribeTransaction::route('/create'),
            'edit' => Pages\EditSubscribeTransaction::route('/{record}/edit'),
        ];
    }
}
