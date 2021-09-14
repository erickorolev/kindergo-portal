<?php

return [
    \Parents\Enums\GenderEnum::class => [
        \Parents\Enums\GenderEnum::FEMALE => 'Женский',
        \Parents\Enums\GenderEnum::MALE => 'Мужской',
        \Parents\Enums\GenderEnum::OTHER => 'Не указано'
    ],
    \Domains\Users\Enums\AttendantGenderEnum::class => [
        \Domains\Users\Enums\AttendantGenderEnum::FEMALE => 'Женский',
        \Domains\Users\Enums\AttendantGenderEnum::MALE => 'Мужской',
        \Domains\Users\Enums\AttendantGenderEnum::OTHER => 'Не указано',
    ],
    \Domains\Users\Enums\AttendantCategoryEnum::class => [
        \Domains\Users\Enums\AttendantCategoryEnum::DRIVER => 'Авто',
        \Domains\Users\Enums\AttendantCategoryEnum::PEDESTRIAN => 'Пешком',
        \Domains\Users\Enums\AttendantCategoryEnum::OTHER => 'Не указано'
    ],
    \Domains\Users\Enums\AttendantStatusEnum::class => [
        \Domains\Users\Enums\AttendantStatusEnum::ACTIVE => 'Активный',
        \Domains\Users\Enums\AttendantStatusEnum::INACTIVE => 'Не активный',
        \Domains\Users\Enums\AttendantStatusEnum::STANDBY => 'В резерве'
    ],
    \Domains\Payments\Enums\TypePaymentEnum::class => [
        \Domains\Payments\Enums\TypePaymentEnum::BANK_PAYMENT => 'Банковская транзакция',
        \Domains\Payments\Enums\TypePaymentEnum::ONLINE_PAYMENT => 'Онлайн платёж',
        \Domains\Payments\Enums\TypePaymentEnum::NOT_SPECIFIED => 'Не указано'
    ],
    \Domains\Trips\Enums\TripStatusEnum::class => [
        \Domains\Trips\Enums\TripStatusEnum::APPOINTED => 'Назначено',
        \Domains\Trips\Enums\TripStatusEnum::PERFORMED => 'Выполняется',
        \Domains\Trips\Enums\TripStatusEnum::COMPLETED => 'Завершена',
        \Domains\Trips\Enums\TripStatusEnum::CANCELED => 'Отменена',
        \Domains\Trips\Enums\TripStatusEnum::PENDING => 'В ожидании',
    ],
    \Domains\Payments\Enums\AttendantSignatureEnum::class => [
        \Domains\Payments\Enums\AttendantSignatureEnum::DISPUTED => 'Оспорить',
        \Domains\Payments\Enums\AttendantSignatureEnum::SIGNED_BY => 'Подписать',
        \Domains\Payments\Enums\AttendantSignatureEnum::WAITING => 'Ожидает подписи'
    ],
    \Domains\Payments\Enums\SpStatusEnum::class => [
        \Domains\Payments\Enums\SpStatusEnum::DELAYED => 'Просрочен',
        \Domains\Payments\Enums\SpStatusEnum::CANCELED => 'Отменён',
        \Domains\Payments\Enums\SpStatusEnum::EXECUTED => 'Выполнен',
        \Domains\Payments\Enums\SpStatusEnum::SCHEDULED => 'Запланирован',
    ]
];
