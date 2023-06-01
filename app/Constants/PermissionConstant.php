<?php

namespace App\Constants;

final class PermissionConstant
{
    public static function list(): array
    {
        return [
            'users' => [
                'ViewAny' => 'Vizualizare utilizatori',
                'Create' => 'Creare utilizator',
                'Update' => 'Modificare utilizator',
                'Delete' => 'Stergere utilizator',
            ],
        ];
    }
}
