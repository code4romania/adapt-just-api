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

    public static function typeLabels()
    {
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

    public static function detailLabels()
    {
        return [
            self::DETAIL_BEATEN => 'AM FOST BĂTUT/Ă',
            self::DETAIL_ABUSED => 'AM FOST VIOLAT/Ă',
            self::DETAIL_SEDATED => 'AM FOST SEDAT/Ă',
            self::DETAIL_PUNISHED => 'AM FOST LEGAT/Ă',
            self::DETAIL_OTHER => 'ALTCEVA'
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


    public static function institutionTypeList()
    {
        return [
            self::VICTIM_ME => [
                self::TYPE_HURT => [
                    'with_location' => [
                        'Parchetul de pe lângă jud.',
                        'Inspectorat Județean Poliție',
                        'Consiliul de Monitorizare',
                        'ANPDPD',
                        'Ministerul Muncii',
                        'Ministerul Sănătății',
                        'DGASPC',
                        'CNSMLA',
                        'Avocatul Poporului Biroul teritorial',
                        'Avocatul Poporului'
                    ],
                    'without_location' => [
                        'Parchetul General',
                        'Inspectorat General Poliție',
                        'Consiliul de Monitorizare',
                        'ANPDPD',
                        'Ministerul Muncii',
                        'Ministerul Sănătății',
                        'CNSMLA',
                        'Avocatul Poporului'
                    ]
                ],
                self::TYPE_MOVE => [
                    'with_location' => [
                        'DGAPSC',
                        'AJPIS',
                        'CJ',
                        'ANPDPD',
                        'Consiliul de Monitorizare',
                        'Avocatul Poporului',
                        'Ministerul Muncii',
                        'Ministerul Sănătății',
                        'CNSMLA',
                        'CNCD'
                    ],
                    'without_location' => [
                        'ANPDPD',
                        'Consiliul de Monitorizare',
                        'Avocatul Poporului',
                        'ANPIS',
                        'Ministerul Muncii',
                        'Ministerul Sănătății',
                        'CNSMLA',
                        'CNCD'
                    ]
                ],
                self::TYPE_EVALUATION => [
                    'with_location' => [
                        'DGASPC',
                        'Judecătorie',
                        'Parchet de pe lângă Judecătorie',
                        'Baroul județean'
                    ],
                    'without_location' => [
                        'ANPDPD',
                        'Consiliul de Monitorizare',
                        'Avocatul Poporului',
                        'Parchet general'
                    ]
                ]
            ],
            self::VICTIM_OTHER => [
                'with_location' => [
                    'Parchetul de pe lângă jud.',
                    'Inspectorat Județean Poliție',
                    'Consiliul de Monitorizare',
                    'ANPDPD',
                    'Ministerul Muncii',
                    'Ministerul Sănătății',
                    'DGASPC',
                    'CNSMLA',
                    'Avocatul Poporului',
                    'Avocatul Poporului Biroul teritorial'
                ],
                'without_location' => [
                    'Parchetul General',
                    'Inspectorat General Poliție',
                    'Consiliul de Monitorizare',
                    'ANPDPD',
                    'Ministerul Muncii',
                    'Ministerul Sănătății',
                    'CNSMLA',
                    'Avocatul Poporului'
                ]
            ]
        ];
    }

}
