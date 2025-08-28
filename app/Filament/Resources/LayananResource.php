<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Layanan;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\LayananResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\LayananResource\RelationManagers;

class LayananResource extends Resource
{
    protected static ?string $model = Layanan::class;

    protected static ?string $navigationLabel = 'Daftar Layanan';
    protected static ?string $pluralModelLabel = 'Daftar Layanan';
    protected static ?string $navigationIcon = 'ri-service-fill';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('instansi_id')
                    ->relationship('instansi', 'instansi')
                    ->required(),
                Forms\Components\TextInput::make('layanan')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('layanan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('instansi.instansi')
                    ->numeric()
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
            'index' => Pages\ListLayanans::route('/'),
            'create' => Pages\CreateLayanan::route('/create'),
            'edit' => Pages\EditLayanan::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return in_array(Auth::user()?->role, ['admin','peserta']);
    }

    public static function canCreate(): bool
    {
        return in_array(Auth::user()?->role, ['admin']);
    }

    public static function canEdit($record): bool
    {
        $user = Auth::user();
        if ($user?->role === 'admin') {
            return true;
        }

        // Peserta hanya bisa edit transaksinya sendiri
        return $record->user_id === $user->id;
    }

    public static function canDelete($record): bool
    {
        return Auth::user()?->role === 'admin'; // hanya admin boleh delete
    }
}
