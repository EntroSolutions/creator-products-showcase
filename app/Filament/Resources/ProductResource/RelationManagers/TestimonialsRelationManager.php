<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TestimonialsRelationManager extends RelationManager
{
    protected static string $relationship = 'testimonials';

    protected static ?string $recordTitleAttribute = 'author_name';

    protected static ?string $title = 'Customer Testimonials';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Customer Information')
                    ->schema([
                        Forms\Components\TextInput::make('author_name')
                            ->label('Customer Name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('author_title')
                            ->label('Customer Title/Position')
                            ->placeholder('e.g., CEO at Company X')
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('author_avatar')
                            ->label('Customer Avatar (Optional)')
                            ->image()
                            ->directory('testimonial-avatars')
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('150')
                            ->imageResizeTargetHeight('150'),
                    ])->columns(2),
                
                Forms\Components\Section::make('Testimonial Content')
                    ->schema([
                        Forms\Components\Textarea::make('content')
                            ->label('Testimonial Text')
                            ->required()
                            ->rows(4)
                            ->placeholder('What did the customer say about your product?'),
                        Forms\Components\Select::make('rating')
                            ->label('Rating')
                            ->options([
                                1 => '1 Star - Poor',
                                2 => '2 Stars - Fair',
                                3 => '3 Stars - Good',
                                4 => '4 Stars - Very Good',
                                5 => '5 Stars - Excellent',
                            ])
                            ->default(5)
                            ->required(),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('author_name')
            ->columns([
                Tables\Columns\ImageColumn::make('author_avatar')
                    ->label('Avatar')
                    ->circular(),
                Tables\Columns\TextColumn::make('author_name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('author_title')
                    ->label('Title/Company')
                    ->searchable(),
                Tables\Columns\TextColumn::make('content')
                    ->label('Testimonial')
                    ->wrap()
                    ->limit(60)
                    ->searchable(),
                Tables\Columns\TextColumn::make('rating')
                    ->badge()
                    ->color(fn (int $state): string => match ($state) {
                        1 => 'danger',
                        2 => 'warning',
                        3 => 'gray',
                        4 => 'success',
                        5 => 'primary',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => "{$state} " . ($state === 1 ? 'Star' : 'Stars')),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Add Testimonial'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
} 