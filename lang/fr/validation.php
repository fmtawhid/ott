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

    'accepted' => ':attribute doit être accepté.',
    'accepted_if' => ':attribute doit être accepté lorsque :other est :value.',
    'active_url' => ':attribute n\'est pas une URL valide.',
    'after' => ':attribute doit être une date après :date.',
    'after_or_equal' => ':attribute doit être une date égale ou après :date.',
    'alpha' => ':attribute ne peut contenir que des lettres.',
    'alpha_dash' => ':attribute ne peut contenir que des lettres, des chiffres, des tirets et des tirets bas.',
    'alpha_num' => ':attribute ne peut contenir que des lettres et des chiffres.',
    'array' => ':attribute doit être un tableau.',
    'before' => ':attribute doit être une date avant :date.',
    'before_or_equal' => ':attribute doit être une date égale ou avant :date.',
    'between' => [
        'array' => ':attribute doit contenir entre :min et :max éléments.',
        'file' => ':attribute doit être entre :min et :max kilooctets.',
        'numeric' => ':attribute doit être entre :min et :max.',
        'string' => ':attribute doit contenir entre :min et :max caractères.',
    ],
    'boolean' => ':attribute doit être vrai ou faux.',
    'confirmed' => 'La confirmation de :attribute ne correspond pas.',
    'current_password' => 'Le mot de passe est incorrect.',
    'date' => ':attribute n\'est pas une date valide.',
    'date_equals' => ':attribute doit être une date égale à :date.',
    'date_format' => ':attribute ne correspond pas au format :format.',
    'declined' => ':attribute doit être refusé.',
    'declined_if' => ':attribute doit être refusé lorsque :other est :value.',
    'different' => ':attribute et :other doivent être différents.',
    'digits' => ':attribute doit comporter :digits chiffres.',
    'digits_between' => ':attribute doit comporter entre :min et :max chiffres.',
    'dimensions' => ':attribute a des dimensions d\'image invalides.',
    'distinct' => 'Le champ :attribute a une valeur en double.',
    'email' => ':attribute doit être une adresse e-mail valide.',
    'ends_with' => ':attribute doit se terminer par l\'un des éléments suivants : :values.',
    'enum' => 'La valeur sélectionnée pour :attribute est invalide.',
    'exists' => 'La valeur sélectionnée pour :attribute est invalide.',
    'file' => ':attribute doit être un fichier.',
    'filled' => 'Le champ :attribute doit avoir une valeur.',
    'gt' => [
        'array' => ':attribute doit contenir plus de :value éléments.',
        'file' => ':attribute doit être plus grand que :value kilooctets.',
        'numeric' => ':attribute doit être supérieur à :value.',
        'string' => ':attribute doit contenir plus de :value caractères.',
    ],
    'gte' => [
        'array' => ':attribute doit contenir :value éléments ou plus.',
        'file' => ':attribute doit être supérieur ou égal à :value kilooctets.',
        'numeric' => ':attribute doit être supérieur ou égal à :value.',
        'string' => ':attribute doit contenir :value caractères ou plus.',
    ],
    'image' => ':attribute doit être une image.',
    'in' => ':attribute est invalide.',
    'in_array' => 'Le champ :attribute n\'existe pas dans :other.',
    'integer' => ':attribute doit être un nombre entier.',
    'ip' => ':attribute doit être une adresse IP valide.',
    'ipv4' => ':attribute doit être une adresse IPv4 valide.',
    'ipv6' => ':attribute doit être une adresse IPv6 valide.',
    'json' => ':attribute doit être une chaîne JSON valide.',
    'lt' => [
        'array' => ':attribute doit contenir moins de :value éléments.',
        'file' => ':attribute doit être inférieur à :value kilooctets.',
        'numeric' => ':attribute doit être inférieur à :value.',
        'string' => ':attribute doit contenir moins de :value caractères.',
    ],
    'lte' => [
        'array' => ':attribute ne doit pas contenir plus de :value éléments.',
        'file' => ':attribute doit être inférieur ou égal à :value kilooctets.',
        'numeric' => ':attribute doit être inférieur ou égal à :value.',
        'string' => ':attribute doit contenir moins de ou égal à :value caractères.',
    ],
    'mac_address' => ':attribute doit être une adresse MAC valide.',
    'max' => [
        'array' => ':attribute ne doit pas contenir plus de :max éléments.',
        'file' => ':attribute ne doit pas dépasser :max kilooctets.',
        'numeric' => ':attribute ne doit pas dépasser :max.',
        'string' => ':attribute ne doit pas dépasser :max caractères.',
    ],
    'mimes' => ':attribute doit être un fichier de type : :values.',
    'mimetypes' => ':attribute doit être un fichier de type : :values.',
    'min' => [
        'array' => ':attribute doit contenir au moins :min éléments.',
        'file' => ':attribute doit être d\'au moins :min kilooctets.',
        'numeric' => ':attribute doit être au moins :min.',
        'string' => ':attribute doit contenir au moins :min caractères.',
    ],
    'multiple_of' => ':attribute doit être un multiple de :value.',
    'not_in' => ':attribute est invalide.',
    'not_regex' => 'Le format de :attribute est invalide.',
    'numeric' => ':attribute doit être un nombre.',
    'present' => 'Le champ :attribute doit être présent.',
    'prohibited' => 'Le champ :attribute est interdit.',
    'prohibited_if' => 'Le champ :attribute est interdit lorsque :other est :value.',
    'prohibited_unless' => 'Le champ :attribute est interdit, sauf si :other est dans :values.',
    'prohibits' => 'Le champ :attribute interdit la présence de :other.',
    'regex' => 'Le format de :attribute est invalide.',
    'required' => 'Le champ :attribute est requis.',
    'required_array_keys' => 'Le champ :attribute doit contenir des entrées pour :values.',
    'required_if' => 'Le champ :attribute est requis.',
    'required_unless' => 'Le champ :attribute est requis, sauf si :other est dans :values.',
    'required_with' => 'Le champ :attribute est requis lorsque :values est présent.',
    'required_with_all' => 'Le champ :attribute est requis lorsque :values sont présents.',
    'required_without' => 'Le champ :attribute est requis lorsque :values n\'est pas présent.',
    'required_without_all' => 'Le champ :attribute est requis lorsque aucun des :values n\'est présent.',
    'same' => ':attribute et :other doivent correspondre.',
    'size' => [
        'array' => ':attribute doit contenir :size éléments.',
        'file' => ':attribute doit être de :size kilooctets.',
        'numeric' => ':attribute doit être :size.',
        'string' => ':attribute doit contenir :size caractères.',
    ],
    'starts_with' => ':attribute doit commencer par l\'un des éléments suivants : :values.',
    'string' => ':attribute doit être une chaîne.',
    'timezone' => ':attribute doit être une zone horaire valide.',
    'unique' => ':attribute a déjà été pris.',
    'uploaded' => ':attribute n\'a pas pu être téléchargé.',
    'url' => ':attribute doit être une URL valide.',
    'uuid' => ':attribute doit être un UUID valide.',


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
