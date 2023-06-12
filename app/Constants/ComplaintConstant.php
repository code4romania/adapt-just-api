<?php

namespace App\Constants;

final class ComplaintConstant
{
    const VICTIM_ME = 'me';
    const VICTIM_OTHER = 'other';

    const TYPE_HURT = 'hurt';
    const TYPE_MOVE = 'move';
    const TYPE_EVALUATION = 'evaluation';

    const DETAIL_BEATEN = 'beaten';
    const DETAIL_ABUSED = 'abused';
    const DETAIL_SEDATED = 'sedated';
    const DETAIL_PUNISHED = 'punished';
    const DETAIL_OTHER = 'other';

    const PROOF_TYPE_YES = 'yes';
    const PROOF_TYPE_NO = 'no';
    const PROOF_TYPE_LATER = 'later';


    public static function victims(): array
    {
        return [
            self::VICTIM_ME,
            self::VICTIM_OTHER
        ];
    }

    public static function types(): array
    {
        return [
            self::TYPE_HURT,
            self::TYPE_MOVE,
            self::TYPE_EVALUATION
        ];
    }

    public static function typeLabels() {
        return [
            self::TYPE_HURT => 'Abuz',
            self::TYPE_MOVE => 'Cerere de relocare',
            self::TYPE_EVALUATION => 'Cerere de reexaminare'
        ];
    }

    public static function details(): array
    {
        return [
            self::DETAIL_BEATEN,
            self::DETAIL_ABUSED,
            self::DETAIL_SEDATED,
            self::DETAIL_PUNISHED,
            self::DETAIL_OTHER
        ];
    }

    public static function proofTypes(): array
    {
        return [
            self::PROOF_TYPE_YES,
            self::PROOF_TYPE_LATER,
            self::PROOF_TYPE_NO
        ];
    }
}
