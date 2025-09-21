<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Inventory Management';
    protected static ?string $navigationLabel = 'Products';
    protected static ?string $recordTitleAttribute = 'name';
    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'description'];
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getModelLabel(): string
    {
        return 'Product';
    }
    public static function getPluralModelLabel(): string
    {
        return 'Products';
    }

    public static function getGlobalSearchInputs(): array
    {
        return [
            'categories' => [
                'label' => __('Category'),
                'search' => function (Category $record, array $query) {
                    return $record->name;
                },
            ],
        ];
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->autofocus()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('barcode')
                    ->label('Barcode')
                    ->unique(ignoreRecord: true)
                    ->maxLength(128)
                    ->placeholder('1234567890123'),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->step('0.01'),
                Forms\Components\TextInput::make('cost_price')
                    ->label('Cost Price')
                    ->numeric()
                    ->prefix('Rp')
                    ->step('0.01'),
                Forms\Components\Select::make('category_id')
                    ->label('Category')
                    ->options(
                        \App\Models\Category::all()->pluck('name', 'id')
                    )->required()
                    ->searchable(),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->directory('products')
                    ->visibility('public'),
                Forms\Components\TextInput::make('stock')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('min_stock_level')
                    ->label('Min Stock Level')
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Product column: name + description + barcode (HTML)
                Tables\Columns\TextColumn::make('name')
                    ->label('Product')
                    ->searchable()
                    ->html()
                    ->formatStateUsing(function ($state, $record) {
                        $desc = $record->description ? "<div class=\"text-sm text-gray-500\">" . e($record->description) . "</div>" : '';
                        $barcode = $record->barcode ? "<div class=\"text-xs text-gray-400 mt-1\">Barcode: " . e($record->barcode) . "</div>" : '';
                        return "<div class=\"font-semibold text-gray-900\">" . e($state) . "</div>" . $desc . $barcode;
                    }),

                // Category as badge
                Tables\Columns\BadgeColumn::make('category.name')
                    ->label('Category')
                    ->colors([
                        'primary' => fn($state) => (bool)$state,
                    ])
                    ->sortable(),

                // Price & cost
                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('cost_price')
                    ->label('Cost')
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->toggleable(isToggledHiddenByDefault: true),

                // Image (small)
                Tables\Columns\ImageColumn::make('image')
                    ->disk('public')
                    ->circular()
                    ->size(48),

                // Stock column with meta
                Tables\Columns\TextColumn::make('stock')
                    ->label('Stock')
                    ->sortable()
                    ->html()
                    ->formatStateUsing(function ($state, $record) {
                        $min = $record->min_stock_level ?? 0;
                        $meta = "<div class=\"text-xs text-gray-500 mt-1\">Min: " . e($min) . "</div>";
                        return "<div class=\"font-medium\">" . e($state) . "</div>" . $meta;
                    }),

                // Availability badge: In Stock / Low Stock / Inactive (blue-first theme)
                Tables\Columns\BadgeColumn::make('availability')
                    ->label('Status')
                    ->getStateUsing(fn($record) => !$record->is_active ? 'Inactive' : ($record->stock > $record->min_stock_level ? 'In Stock' : 'Low Stock'))
                    ->colors([
                        // primary = blue (In Stock)
                        'primary' => fn($state) => $state === 'In Stock',
                        // secondary = muted (Low Stock) to keep palette subtle but consistent
                        'secondary' => fn($state) => $state === 'Low Stock',
                        // gray = inactive
                        'gray' => fn($state) => $state === 'Inactive',
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('inactive')
                    ->label('Inactive')
                    ->query(fn(Builder $query) => $query->where('is_active', false)),

                Tables\Filters\Filter::make('low_stock')
                    ->label('Low stock')
                    ->query(fn(Builder $query) => $query->whereColumn('stock', '<=', 'min_stock_level')),

                Tables\Filters\Filter::make('in_stock')
                    ->label('In stock')
                    ->query(fn(Builder $query) => $query->where('is_active', true)->whereColumn('stock', '>', 'min_stock_level')),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
