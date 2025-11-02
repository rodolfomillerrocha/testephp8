<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LayerResource\Pages;
use App\Models\Layer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;

class LayerResource extends Resource
{
    protected static ?string $model = Layer::class;

    protected static ?string $navigationIcon = 'heroicon-o-map';

    protected static ?string $navigationLabel = 'Camadas';

    protected static ?string $modelLabel = 'Camada';

    protected static ?string $pluralModelLabel = 'Camadas';

    protected static ?string $navigationGroup = 'Gerenciamento';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nome')
                    ->label('Nome da Camada')
                    ->required()
                    ->maxLength(100)
                    ->placeholder('Ex: Regiões de Interesse')
                    ->helperText('Digite um nome descritivo para esta camada geográfica'),

                FileUpload::make('arquivo_geojson')
                    ->label('Arquivo GeoJSON')
                    ->acceptedFileTypes(['application/json', 'application/geo+json'])
                    ->required()
                    ->disk('local')
                    ->directory('geojson')
                    ->visibility('private')
                    ->helperText('Faça upload de um arquivo GeoJSON com geometria válida')
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        // Processar o arquivo GeoJSON
                        if ($state) {
                            $conteudoArquivo = file_get_contents(storage_path('app/' . $state));
                            $dadosGeoJson = json_decode($conteudoArquivo, true);
                            
                            if ($dadosGeoJson && isset($dadosGeoJson['geometry'])) {
                                $set('geometry', $dadosGeoJson['geometry']);
                            } elseif ($dadosGeoJson && isset($dadosGeoJson['type'])) {
                                $set('geometry', $dadosGeoJson);
                            }
                        }
                    }),

                Forms\Components\Hidden::make('geometry'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLayers::route('/'),
            'create' => Pages\CreateLayer::route('/criar'),
            'edit' => Pages\EditLayer::route('/{record}/editar'),
        ];
    }
}





