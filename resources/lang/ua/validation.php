<?php
return [

    /*
    |
    | Наступні рядки мови містять повідомлення про помилки за замовчуванням,
    | які використовуються класом валідатора. Деякі з цих правил мають кілька
    | версій, таких як правила розміру. Ви можете змінювати кожне з цих повідомлень тут.
    |
    */

    'accepted' => 'Поле :attribute повинно бути прийнято.',
    'active_url' => ':attribute не є дійсним URL.',
    'after' => ':attribute повинно бути датою після :date.',
    'after_or_equal' => ':attribute повинно бути датою після або рівною :date.',
    'alpha' => ':attribute може містити лише літери.',
    'alpha_dash' => ':attribute може містити лише літери, цифри, дефіси і підкреслення.',
    'alpha_num' => ':attribute може містити лише літери і цифри.',
    'array' => ':attribute повинно бути масивом.',
    'before' => ':attribute повинно бути датою перед :date.',
    'before_or_equal' => ':attribute повинно бути датою перед або рівною :date.',
    'between' => [
        'numeric' => ':attribute повинно бути між :min і :max.',
        'file' => ':attribute повинно бути між :min і :max кілобайт.',
        'string' => ':attribute повинно бути від :min до :max символів.',
        'array' => ':attribute повинно містити від :min до :max елементів.',
    ],
    'boolean' => 'Поле :attribute повинно бути true або false.',
    'confirmed' => 'Підтвердження :attribute не відповідає.',
    'date' => ':attribute не є дійсною датою.',
    'date_equals' => ':attribute повинно бути датою рівною :date.',
    'date_format' => ':attribute не відповідає формату :format.',
    'different' => ':attribute і :other повинні бути різними.',
    'digits' => ':attribute повинно бути :digits цифр.',
    'digits_between' => ':attribute повинно бути від :min до :max цифр.',
    'dimensions' => ':attribute має недійсні розміри зображення.',
    'distinct' => 'Поле :attribute має дубльоване значення.',
    'email' => ':attribute повинно бути дійсною адресою електронної пошти.',
    'ends_with' => ':attribute повинно закінчуватися одним із наступних: :values',
    'exists' => 'Вибране :attribute є недійсним.',
    'file' => ':attribute повинно бути файлом.',
    'filled' => 'Поле :attribute повинно містити значення.',
    'gt' => [
        'numeric' => ':attribute повинно бути більшим, ніж :value.',
        'file' => ':attribute повинно бути більшим, ніж :value кілобайт.',
        'string' => ':attribute повинно бути довше, ніж :value символів.',
        'array' => ':attribute повинно містити більше, ніж :value елементів.',
    ],
    'gte' => [
        'numeric' => ':attribute повинно бути більшим або рівним :value.',
        'file' => ':attribute повинно бути більшим або рівним :value кілобайт.',
        'string' => ':attribute повинно бути довше або рівним :value символів.',
        'array' => ':attribute повинно містити :value елементів або більше.',
    ],
    'image' => ':attribute повинно бути зображенням.',
    'in' => 'Вибране :attribute є недійсним.',
    'in_array' => 'Поле :attribute не існує в :other.',
    'integer' => ':attribute повинно бути цілим числом.',
    'ip' => ':attribute повинно бути дійсною IP-адресою.',
    'ipv4' => ':attribute повинно бути дійсною IPv4-адресою.',
    'ipv6' => ':attribute повинно бути дійсною IPv6-адресою.',
    'json' => ':attribute повинно бути дійсним JSON-рядком.',
    'lt' => [
        'numeric' => ':attribute повинно бути меншим, ніж :value.',
        'file' => ':attribute повинно бути меншим, ніж :value кілобайт.',
        'string' => ':attribute повинно бути коротше, ніж :value символів.',
        'array' => ':attribute повинно містити менше, ніж :value елементів.',
    ],
    'lte' => [
        'numeric' => ':attribute повинно бути меншим або рівним :value.',
        'file' => ':attribute повинно бути меншим або рівним :value кілобайт.',
        'string' => ':attribute повинно бути коротше або рівним :value символів.',
        'array' => ':attribute повинно містити не більше :value елементів.',
    ],
    'max' => [
        'numeric' => ':attribute не може бути більшим, ніж :max.',
        'file' => ':attribute не може бути більшим, ніж :max кілобайт.',
        'string' => ':attribute не може бути довшим, ніж :max символів.',
        'array' => ':attribute не може містити більше, ніж :max елементів.',
    ],
    'mimes' => ':attribute повинно бути файлом типу: :values.',
    'mimetypes' => ':attribute повинно бути файлом типу: :values.',
    'min' => [
        'numeric' => ':attribute повинно бути принаймні :min.',
        'file' => ':attribute повинно бути принаймні :min кілобайт.',
        'string' => ':attribute повинно бути принаймні :min символів.',
        'array' => ':attribute повинно містити принаймні :min елементів.',
    ],
    'not_in' => 'Вибране :attribute є недійсним.',
    'not_regex' => 'Формат :attribute недійсний.',
    'numeric' => ':attribute повинно бути числом.',
    'present' => 'Поле :attribute повинно бути присутнім.',
    'regex' => 'Формат :attribute недійсний.',
    'required' => 'Поле :attribute є обов\'язковим.',
    'required_if' => 'Поле :attribute є обов\'язковим, коли :other є :value.',
    'required_unless' => 'Поле :attribute є обов\'язковим, якщо :other не є в :values.',
    'required_with' => 'Поле :attribute є обов\'язковим, коли :values присутні.',
    'required_with_all' => 'Поле :attribute є обов\'язковим, коли всі :values присутні.',
    'required_without' => 'Поле :attribute є обов\'язковим, коли :values не присутні.',
    'required_without_all' => 'Поле :attribute є обов\'язковим, коли ні одне з :values не присутнє.',
    'same' => ':attribute і :other повинні співпадати.',
    'size' => [
        'numeric' => ':attribute повинно бути :size.',
        'file' => ':attribute повинно бути :size кілобайт.',
        'string' => ':attribute повинно бути :size символів.',
        'array' => ':attribute повинно містити :size елементів.',
    ],
    'starts_with' => ':attribute повинно починатися з одного із наступних: :values',
    'string' => ':attribute повинно бути рядком.',
    'timezone' => ':attribute повинно бути дійсною зоною.',
    'unique' => ':attribute вже існує.',
    'uploaded' => ':attribute не вдалося завантажити.',
    'url' => 'Формат :attribute недійсний.',
    'uuid' => ':attribute повинно бути дійсним UUID.',

    /*
    |--------------------------------------------------------------------------
    | Власні мовні лінії валідації
    |--------------------------------------------------------------------------
    |
    | Тут ви можете вказати власні повідомлення про валідацію для атрибутів за допомогою
    | конвенції "attribute.rule" для назви ліній. Це дозволяє швидко вказати
    | спеціальну мовну лінію для певного правила валідації для атрибута.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Власні атрибути валідації
    |--------------------------------------------------------------------------
    |
    | Наступні мовні лінії використовуються для заміни наших місцезнаходжень атрибутів
    | чимось більш читаємим, таким як "E-Mail Address" замість "email". Це просто допомагає
    | нам робити наші повідомлення більш виразними.
    |
    */

    'attributes' => [],

];
