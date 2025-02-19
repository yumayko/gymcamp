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
use Filament\Forms\Components\ToggleButtons;
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
                                $duration = $subscribePackage ? $subscribePackage->duration : 0;

                                $set('price', $price);
                                $set('duration', $duration);

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
                    ]),

                    Forms\Components\Wizard\Step::make('Costomer Information')
                    ->schema([
                        Grid::make(2)
                        ->schema([
                            Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                            Forms\Components\TextInput::make('phone')
                            ->required()
                            ->maxLength(255),

                            Forms\Components\TextInput::make('email')
                            ->required()
                            ->maxLength(255),
                        ]),
                    ]),

                    Forms\Components\Wizard\Step::make('Payment Information')
                    ->schema([
                        Forms\Components\TextInput::make('booking_trx_id')
                        ->required()
                        ->maxLength(255),

                        ToggleButtons::make('is_paid')
                        ->label('Apakah Sudah Bayar?')
                        ->boolean()
                        ->grouped()
                        ->icons([
                            true => 'heroicon-o-pencil',
                            false => 'heroicon-o-clock',
                        ])
                        ->required(),

                        Forms\Components\FileUpload::make('proof')
                        ->image()
                        ->required(),
                        ]),
                    ])
                    ->columnSpan('full')
                    ->columns(1)
                    ->skippable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('booking_trx_id'),
                Tables\Columns\IconColumn::make('is_paid')
                ->boolean()
                ->trueColor('success')
                ->falseColor('danger')
                ->trueIcon('heroicon-o-check-circle')
                ->falseIcon('heroicon-o-x-circle')
                ->label('Terverifikasi'),
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
