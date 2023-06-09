<?php

namespace App\Constants;

final class ResourceConstant
{
    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISHED = 'published';

    const TYPE_ORGANISATION = 'organisation';
    const TYPE_PHONE_NUMBER = 'phone_number';
    const TYPE_LAWYER = 'lawyer';


    public static function types()
    {
        return [
          self::TYPE_ORGANISATION => 'Organizatie',
          self::TYPE_PHONE_NUMBER => 'Numar de telefon',
          self::TYPE_LAWYER => 'Sfaturi avocat',
        ];
    }

    public static function getTypeLabel($type)
    {
        return self::types()[$type];
    }

}
