<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute muss akzeptiert werden.',
    'accepted_if' => ':attribute muss akzeptiert werden, wenn :other :value ist.',
    'active_url' => ':attribute ist keine gültige URL.',
    'after' => ':attribute muss ein Datum nach :date sein.',
    'after_or_equal' => ':attribute muss ein Datum nach oder gleich :date sein.',
    'alpha' => ':attribute darf nur Buchstaben enthalten.',
    'alpha_dash' => ':attribute darf nur Buchstaben, Zahlen, Bindestriche und Unterstriche enthalten.',
    'alpha_num' => ':attribute darf nur Buchstaben und Zahlen enthalten.',
    'array' => ':attribute muss ein Array sein.',
    'before' => ':attribute muss ein Datum vor :date sein.',
    'before_or_equal' => ':attribute muss ein Datum vor oder gleich :date sein.',
    'between' => [
        'array' => ':attribute muss zwischen :min und :max Elemente haben.',
        'file' => ':attribute muss zwischen :min und :max Kilobytes groß sein.',
        'numeric' => ':attribute muss zwischen :min und :max liegen.',
        'string' => ':attribute muss zwischen :min und :max Zeichen lang sein.',
    ],
    'boolean' => ':attribute muss wahr oder falsch sein.',
    'confirmed' => 'Die Bestätigung für :attribute stimmt nicht überein.',
    'current_password' => 'Das Passwort ist nicht korrekt.',
    'date' => ':attribute ist kein gültiges Datum.',
    'date_equals' => ':attribute muss ein Datum sein, das :date entspricht.',
    'date_format' => ':attribute entspricht nicht dem Format :format.',
    'declined' => ':attribute muss abgelehnt werden.',
    'declined_if' => ':attribute muss abgelehnt werden, wenn :other :value ist.',
    'different' => ':attribute und :other müssen unterschiedlich sein.',
    'digits' => ':attribute muss :digits Ziffern enthalten.',
    'digits_between' => ':attribute muss zwischen :min und :max Ziffern enthalten.',
    'dimensions' => ':attribute hat ungültige Bildabmessungen.',
    'distinct' => ':attribute-Feld hat einen doppelten Wert.',
    'email' => ':attribute muss eine gültige E-Mail-Adresse sein.',
    'ends_with' => ':attribute muss mit einem der folgenden Enden: :values.',
    'enum' => 'Das ausgewählte :attribute ist ungültig.',
    'exists' => 'Das ausgewählte :attribute ist ungültig.',
    'file' => ':attribute muss eine Datei sein.',
    'filled' => ':attribute-Feld muss einen Wert enthalten.',
    'gt' => [
        'array' => ':attribute muss mehr als :value Elemente enthalten.',
        'file' => ':attribute muss größer als :value Kilobytes sein.',
        'numeric' => ':attribute muss größer als :value sein.',
        'string' => ':attribute muss mehr als :value Zeichen enthalten.',
    ],
    'gte' => [
        'array' => ':attribute muss :value oder mehr Elemente enthalten.',
        'file' => ':attribute muss größer als oder gleich :value Kilobytes sein.',
        'numeric' => ':attribute muss größer als oder gleich :value sein.',
        'string' => ':attribute muss größer als oder gleich :value Zeichen enthalten.',
    ],
    'image' => ':attribute muss ein Bild sein.',
    'in' => ':attribute ist ungültig.',
    'in_array' => 'Das :attribute-Feld existiert nicht in :other.',
    'integer' => ':attribute muss eine ganze Zahl sein.',
    'ip' => ':attribute muss eine gültige IP-Adresse sein.',
    'ipv4' => ':attribute muss eine gültige IPv4-Adresse sein.',
    'ipv6' => ':attribute muss eine gültige IPv6-Adresse sein.',
    'json' => ':attribute muss eine gültige JSON-Zeichenfolge sein.',
    'lt' => [
        'array' => ':attribute muss weniger als :value Elemente enthalten.',
        'file' => ':attribute muss kleiner als :value Kilobytes sein.',
        'numeric' => ':attribute muss kleiner als :value sein.',
        'string' => ':attribute muss weniger als :value Zeichen enthalten.',
    ],
    'lte' => [
        'array' => ':attribute darf nicht mehr als :value Elemente enthalten.',
        'file' => ':attribute muss kleiner als oder gleich :value Kilobytes sein.',
        'numeric' => ':attribute muss kleiner als oder gleich :value sein.',
        'string' => ':attribute muss kleiner als oder gleich :value Zeichen enthalten.',
    ],
    'mac_address' => ':attribute muss eine gültige MAC-Adresse sein.',
    'max' => [
        'array' => ':attribute darf nicht mehr als :max Elemente enthalten.',
        'file' => ':attribute darf nicht größer als :max Kilobytes sein.',
        'numeric' => ':attribute darf nicht größer als :max sein.',
        'string' => ':attribute darf nicht länger als :max Zeichen sein.',
    ],
    'mimes' => ':attribute muss eine Datei des Typs: :values sein.',
    'mimetypes' => ':attribute muss eine Datei des Typs: :values sein.',
    'min' => [
        'array' => ':attribute muss mindestens :min Elemente enthalten.',
        'file' => ':attribute muss mindestens :min Kilobytes groß sein.',
        'numeric' => ':attribute muss mindestens :min sein.',
        'string' => ':attribute muss mindestens :min Zeichen enthalten.',
    ],
    'multiple_of' => ':attribute muss ein Vielfaches von :value sein.',
    'not_in' => ':attribute ist ungültig.',
    'not_regex' => ':attribute Format ist ungültig.',
    'numeric' => ':attribute muss eine Zahl sein.',
    'present' => ':attribute-Feld muss vorhanden sein.',
    'prohibited' => ':attribute-Feld ist verboten.',
    'prohibited_if' => ':attribute-Feld ist verboten, wenn :other :value ist.',
    'prohibited_unless' => ':attribute-Feld ist verboten, es sei denn, :other ist in :values.',
    'prohibits' => ':attribute-Feld verbietet das Vorhandensein von :other.',
    'regex' => ':attribute Format ist ungültig.',
    'required' => ':attribute-Feld ist erforderlich.',
    'required_array_keys' => ':attribute-Feld muss Einträge für :values enthalten.',
    'required_if' => ':attribute-Feld ist erforderlich.',
    'required_unless' => ':attribute-Feld ist erforderlich, es sei denn, :other ist in :values.',
    'required_with' => ':attribute-Feld ist erforderlich, wenn :values vorhanden ist.',
    'required_with_all' => ':attribute-Feld ist erforderlich, wenn :values vorhanden sind.',
    'required_without' => ':attribute-Feld ist erforderlich, wenn :values nicht vorhanden ist.',
    'required_without_all' => ':attribute-Feld ist erforderlich, wenn keine von :values vorhanden ist.',
    'same' => ':attribute und :other müssen übereinstimmen.',
    'size' => [
        'array' => ':attribute muss :size Elemente enthalten.',
        'file' => ':attribute muss :size Kilobytes groß sein.',
        'numeric' => ':attribute muss :size sein.',
        'string' => ':attribute muss :size Zeichen enthalten.',
    ],
    'starts_with' => ':attribute muss mit einem der folgenden beginnen: :values.',
    'string' => ':attribute muss eine Zeichenfolge sein.',
    'timezone' => ':attribute muss eine gültige Zeitzone sein.',
    'unique' => ':attribute wurde bereits vergeben.',
    'uploaded' => ':attribute konnte nicht hochgeladen werden.',
    'url' => ':attribute muss eine gültige URL sein.',
    'uuid' => ':attribute muss eine gültige UUID sein.',


    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
