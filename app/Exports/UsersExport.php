<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, WithHeadings, WithMapping
{
    protected $role;

    public function __construct($role)
    {
        $this->role = $role;
    }

    public function collection()
    {
        return User::where('role', $this->role)->get();
    }

    public function headings(): array
    {
        return ['Name', 'Email', 'Password'];
    }

    public function map($user): array
    {
        $passwordDisplay = "";
        
        if ($user->created_at == $user->updated_at) {
            $passwordDisplay = substr($user->email, 0, 4) . $user->id;
        } else {
            $passwordDisplay = "Password Sudah Diganti";
        }

        return [
            $user->name,
            $user->email,
            $passwordDisplay,
        ];
    }
}