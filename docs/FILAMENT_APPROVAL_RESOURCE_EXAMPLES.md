# Filament Approval Resource Examples

Project ini saat ini belum memasang package Filament. Contoh di bawah mengikuti struktur Filament v3/v4 style dan bisa dipindahkan setelah Filament di-install.

## KasKeluarResource

```php
<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KasKeluarResource\Pages;
use App\Models\KasKeluar;
use App\Services\CashBalanceService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KasKeluarResource extends Resource
{
    protected static ?string $model = KasKeluar::class;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\DatePicker::make('tanggal')->required(),
            Forms\Components\TextInput::make('jenis_pengeluaran')->required()->maxLength(255),
            Forms\Components\TextInput::make('nominal')->numeric()->required()->minValue(0),
            Forms\Components\Textarea::make('keterangan')->columnSpanFull(),
            Forms\Components\Placeholder::make('approval_note')
                ->content('Status awal otomatis pending. Saldo utama baru terpotong setelah approval Ketua.')
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal')->date('d M Y')->sortable(),
                Tables\Columns\TextColumn::make('jenis_pengeluaran')->searchable(),
                Tables\Columns\TextColumn::make('nominal')->money('IDR'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('approver.name')->label('Approved By'),
                Tables\Columns\TextColumn::make('approved_at')->dateTime('d M Y H:i'),
                Tables\Columns\TextColumn::make('rejection_reason')->limit(50)->toggleable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn (KasKeluar $record) => $record->isPending()),
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (KasKeluar $record): bool => auth()->user()?->can('approve', $record) ?? false)
                    ->action(function (KasKeluar $record, CashBalanceService $cashBalanceService): void {
                        $record->approve(auth()->user(), $cashBalanceService);
                    }),
                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->color('danger')
                    ->visible(fn (KasKeluar $record): bool => auth()->user()?->can('reject', $record) ?? false)
                    ->form([
                        Forms\Components\Textarea::make('rejection_reason')
                            ->label('Alasan Penolakan')
                            ->required()
                            ->maxLength(2000),
                    ])
                    ->action(function (KasKeluar $record, array $data): void {
                        $record->reject(auth()->user(), $data['rejection_reason']);
                    }),
            ]);
    }
}
```

## JadwalKegiatanResource

```php
<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JadwalKegiatanResource\Pages;
use App\Models\JadwalKegiatan;
use App\Models\KasKeluar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class JadwalKegiatanResource extends Resource
{
    protected static ?string $model = JadwalKegiatan::class;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('nama_kegiatan')->required()->maxLength(255),
            Forms\Components\DatePicker::make('tanggal')->required(),
            Forms\Components\TimePicker::make('waktu'),
            Forms\Components\TextInput::make('tempat')->maxLength(255),
            Forms\Components\TextInput::make('penanggung_jawab')->maxLength(255),
            Forms\Components\TextInput::make('estimasi_anggaran')->numeric()->minValue(0),
            Forms\Components\Select::make('kas_keluar_id')
                ->label('Realisasi Anggaran')
                ->options(KasKeluar::availableForActivity()->pluck('jenis_pengeluaran', 'id'))
                ->searchable(),
            Forms\Components\Textarea::make('keterangan')->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_kegiatan')->searchable(),
                Tables\Columns\TextColumn::make('tanggal')->date('d M Y')->sortable(),
                Tables\Columns\TextColumn::make('tempat'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('approved_at')->dateTime('d M Y H:i'),
                Tables\Columns\TextColumn::make('rejection_reason')->limit(50)->toggleable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn (JadwalKegiatan $record) => $record->isPending()),
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (JadwalKegiatan $record): bool => auth()->user()?->can('approve', $record) ?? false)
                    ->action(fn (JadwalKegiatan $record) => $record->approve(auth()->user())),
                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->color('danger')
                    ->visible(fn (JadwalKegiatan $record): bool => auth()->user()?->can('reject', $record) ?? false)
                    ->form([
                        Forms\Components\Textarea::make('rejection_reason')
                            ->label('Alasan Penolakan')
                            ->required()
                            ->maxLength(2000),
                    ])
                    ->action(fn (JadwalKegiatan $record, array $data) => $record->reject(auth()->user(), $data['rejection_reason'])),
            ]);
    }
}
```
