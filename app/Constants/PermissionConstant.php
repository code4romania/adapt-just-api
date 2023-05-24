<?php

namespace App\Constants;

final readonly class PermissionConstant
{
    public static function list(): array
    {
        return [
            'users' => [
                'ViewAny' => 'View list',
                'Create' => 'Create',
                'Update' => 'Update',
                'Delete' => 'Delete',
            ],
        ];
    }
}
