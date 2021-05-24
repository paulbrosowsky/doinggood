<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::all();
    }

      /**
    * @var Invoice $invoice
    */
    public function map($user): array
    {
        return [
            $user->id,
            'https://dgc-community.de/profiles/' . $user->username,
            $user->helper,
            $user->name,
            $user->email,
            $user->feedCounter['active'],
            $user->feedCounter['completed'],
            $user->lastActivityStamp,
            $user->fullyVerified,
            $user->settingsCompleted,
            !$user->isUnlocked
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Link zum Profil',
            'Helfer',
            'Name',
            'Email',
            'Hife/Bedarte aktiv',
            'Hife/Bedarte abgeschal.',
            'Letzete Aktivität',
            'Email bestätigt',
            'Einstellungen komplett',
            'Gesperrt'
        ];
    }
}
