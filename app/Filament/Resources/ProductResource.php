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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('long_description')
                            ->label('Detailed Description')
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('image_path')
                            ->image()
                            ->directory('product-images')
                            ->visibility('public')
                            ->imageEditor()
                            ->preserveFilenames()
                            ->previewable()
                            ->downloadable(),
                    ]),
                
                Forms\Components\Section::make('Metrics')
                    ->schema([
                        Forms\Components\TextInput::make('mrr')
                            ->required()
                            ->numeric()
                            ->prefix('$')
                            ->step(0.01)
                            ->default(0.00)
                            ->label('Monthly Recurring Revenue'),
                            
                        Forms\Components\TextInput::make('arr')
                            ->required()
                            ->numeric()
                            ->prefix('$')
                            ->step(0.01)
                            ->default(0.00)
                            ->label('Annual Recurring Revenue'),
                            
                        Forms\Components\TextInput::make('live_users')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->label('Active Users'),
                    ])->columns(3),
                
                Forms\Components\Section::make('Links')
                    ->schema([
                        Forms\Components\TextInput::make('website_url')
                            ->url()
                            ->label('Product Website URL'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(
                fn (Product $record): string => route('filament.admin.resources.products.view', ['record' => $record])
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Image')
                    ->disk('public')
                    ->circular(),
                Tables\Columns\TextColumn::make('mrr')
                    ->money('usd')
                    ->sortable(),
                Tables\Columns\TextColumn::make('arr')
                    ->money('usd')
                    ->sortable(),
                Tables\Columns\TextColumn::make('live_users')
                    ->sortable(),
                Tables\Columns\TextColumn::make('creator.name')
                    ->label('Creator')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('tags.name')
                    ->badge()
                    ->label('Tags'),
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
                Tables\Filters\SelectFilter::make('tags')
                    ->relationship('tags', 'name')
                    ->multiple()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('View & Manage Features')
                    ->color('primary')
                    ->icon('heroicon-m-eye')
                    ->size('lg')
                    ->extraAttributes([
                        'class' => 'font-bold',
                    ]),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->defaultSort('created_at', 'desc')
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function performCreate(array $data): Model
    {
        $data['creator_id'] = Auth::id();
        
        $product = static::getModel()::create($data);
        
        return $product;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('creator_id', Auth::id());
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\FeaturesRelationManager::class,
            RelationManagers\TestimonialsRelationManager::class,
            RelationManagers\TagsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
