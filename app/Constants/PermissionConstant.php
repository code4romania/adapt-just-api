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
            'complaints' => [
                'ViewAny' => 'Vizualizare raportari',
                'Update' => 'Modificare raportari',
            ],
            'articles' => [
                'ViewAny' => 'Vizualizare articole',
                'Create' => 'Creare articole',
                'Update' => 'Modificare articole',
                'Delete' => 'Stergere articole',
            ],
            'resources' => [
                'ViewAny' => 'Vizualizare resurse de sprijin',
                'Create' => 'Creare resurse de sprijin',
                'Update' => 'Modificare resurse de sprijin',
                'Delete' => 'Stergere resurse de sprijin',
            ],
        ];
    }
}
