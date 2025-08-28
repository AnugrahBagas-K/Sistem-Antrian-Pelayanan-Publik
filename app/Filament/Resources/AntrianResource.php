<?php

namespace App\Filament\Resources;


use Filament\Forms;
use Filament\Tables;
use App\Models\Antrian;
use App\Models\Layanan;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\AntrianResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AntrianResource\RelationManagers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AntrianResource extends Resource
{
    
    protected static ?string $model = Antrian::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        $user = Auth::user();
        return $form
            ->schema([
                Forms\Components\DatePicker::make('tanggal_kunjungan')
                    ->required(),
                Forms\Components\Select::make('instansi_id')
                    ->required()
                    ->relationship('instansi','instansi')
                    ->reactive()
                    ->afterStateUpdated(fn (callable $set) => $set('layanan_id', null)),
                Forms\Components\Select::make('layanan_id')
                    ->label('Layanan')
                    ->options(function (callable $get) {
                        $instansiId = $get('instansi_id');
                        if (! $instansiId) {
                            return [];
                        }
                        return Layanan::where('instansi_id', $instansiId)
                                    ->pluck('layanan', 'id')
                                    ->toArray();
                    })
                    ->disabled(fn (callable $get) => ! $get('instansi_id'))
                    ->required(),
                $user && $user->role === 'admin' ?
                    Forms\Components\Select::make('user_id')
                        ->label('Pilih User')
                        ->options(User::pluck('name','id'))
                        ->searchable()
                        ->required()
                    : Forms\Components\Hidden::make('user_id')
                        ->default(fn () => Auth::id()),
                
                $user && $user->role === 'admin' ?
                    Forms\Components\Select::make('status_tiket')
                        ->label('Status Tiket')
                        ->options([
                            'aktif' => 'Aktif',
                            'selesai' => 'Selesai',
                        
                        ])
                        ->searchable()
                        ->required()
                    : Forms\Components\Hidden::make('status_tiket')
                        ->default('aktif'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal_kunjungan')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('instansi.instansi')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('layanan.layanan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status_tiket')
                    ->searchable(),
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
            'index' => Pages\ListAntrians::route('/'),
            'create' => Pages\CreateAntrian::route('/create'),
            'edit' => Pages\EditAntrian::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        return in_array(Auth::user()?->role, ['admin', 'peserta']);
    }

    public static function canCreate(): bool
    {
        return in_array(Auth::user()?->role, ['admin','peserta']);
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

        public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        $user = Auth::user();
        /** @var \App\Models\User $user */
        if ($user && $user ->role === 'peserta') {
            return $query->where('user_id', $user->id);
        }

        return $query;
    }

}
