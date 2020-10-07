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

    'accepted'             => 'la :attribute debe ser aceptado.',
    'active_url'           => 'la :attribute no es una URL válida.',
    'after'                => 'la :attribute debe ser una fecha posterior :date.',
    'after_or_equal'       => 'la :attribute debe ser una fecha posterior o igual a :date.',
    'alpha'                => 'la :attribute solo puede contener letras.',
    'alpha_dash'           => 'la :attribute solo puede contener letras, números y guiones.',
    'alpha_num'            => 'la :attribute solo puede contener letras y números.',
    'array'                => 'la :attribute debe ser una matriz.',
    'before'               => 'la :attribute debe ser una fecha antes :date.',
    'before_or_equal'      => 'la :attribute debe ser una fecha anterior o igual a :date.',
    'between'              => [
        'numeric' => 'la :attribute debe estar entre :min y :max.',
        'file'    => 'la :attribute debe estar entre :min y :max kilobytes.',
        'string'  => 'la :attribute debe estar entre :min y :max caracteres.',
        'array'   => 'la :attribute debe tener entre :min y :max artículos.',
    ],
    'boolean'              => 'la :attribute el campo debe ser verdadero o falso.',
    'confirmed'            => 'la :attribute la confirmación no coincide.',
    'date'                 => 'la :attribute no es una fecha válida.',
    'date_format'          => 'la :attribute no coincide con el formato :format.',
    'different'            => 'la :attribute y :other debe ser diferente.',
    'digits'               => 'la :attribute debe ser :digits dígitos.',
    'digits_between'       => 'la :attribute debe estar entre :min y :max dígitos.',
    'dimensions'           => 'la :attribute tiene dimensiones de imagen no válidas.',
    'distinct'             => 'la :attribute el campo tiene un valor duplicado.',
    'email'                => 'la :attribute Debe ser una dirección de correo electrónico válida.',
    'exists'               => 'El seleccionado :attribute no es válido.',
    'file'                 => 'la :attribute debe ser un archivo.',
    'filled'               => 'la :attribute el campo debe tener un valor.',
    'gt'                   => [
        'numeric' => 'la :attribute debe ser mayor que :value.',
        'file'    => 'la :attribute debe ser mayor que :value kilobytes.',
        'string'  => 'la :attribute debe ser mayor que :value characters.',
        'array'   => 'la :attribute debe ser mayor que :value items.',
    ],
    'gte'                  => [
        'numeric' => 'la :attribute debe ser mayor o igual :value.',
        'file'    => 'la :attribute debe ser mayor o igual :value kilobytes.',
        'string'  => 'la :attribute debe ser mayor o igual :value caracteres.',
        'array'   => 'la :attribute debe tener :value artículos o más.',
    ],
    'image'                => 'la :attribute debe ser una imagen.',
    'in'                   => 'El seleccionado :attribute no es válido.',
    'in_array'             => 'la :attribute el campo no existe en :other.',
    'integer'              => 'la :attribute debe ser un entero.',
    'ip'                   => 'la :attribute debe ser una dirección IP válida.',
    'ipv4'                 => 'la :attribute debe ser una dirección IPv4 válida.',
    'ipv6'                 => 'la :attribute debe ser una dirección IPv6 válida.',
    'json'                 => 'la :attribute debe ser una cadena JSON válida.',
    'lt'                   => [
        'numeric' => 'la :attribute debe ser menor que :value.',
        'file'    => 'la :attribute debe ser menor que :value kilobytes.',
        'string'  => 'la :attribute debe ser menor que :value caracteres.',
        'array'   => 'la :attribute debe tener menos de :value artículos.',
    ],
    'lte'                  => [
        'numeric' => 'la :attribute debe ser menor o igual :value.',
        'file'    => 'la :attribute debe ser menor o igual :value kilobytes.',
        'string'  => 'la :attribute debe ser menor o igual :value caracteres.',
        'array'   => 'la :attribute no debe tener más de :value artículos.',
    ],
    'max'                  => [
        'numeric' => 'la :attribute no puede ser mayor que :max.',
        'file'    => 'la :attribute no puede ser mayor que :max kilobytes.',
        'string'  => 'la :attribute no puede ser mayor que :max caracteres.',
        'array'   => 'la :attribute puede no tener más de :max artículos.',
    ],
    'mimes'                => 'la :attribute debe ser un archivo de tipo: :values.',
    'mimetypes'            => 'la :attribute debe ser un archivo de tipo: :values.',
    'min'                  => [
        'numeric' => 'la :attribute al menos debe ser :min.',
        'file'    => 'la :attribute al menos debe ser :min kilobytes.',
        'string'  => 'la :attribute al menos debe ser :min characters.',
        'array'   => 'la :attribute debe tener al menos :min artículos.',
    ],
    'not_in'               => 'El seleccionado :attribute no es válido.',
    'not_regex'            => 'la :attribute el formato no es válido.',
    'numeric'              => 'la :attribute Tiene que ser un número.',
    'present'              => 'la :attribute el campo debe estar presente.',
    'regex'                => 'la :attribute el formato no es válido.',
    'required'             => 'la :attribute Se requiere campo.',
    'required_if'          => 'la :attribute campo es obligatorio cuando :other is :value.',
    'required_unless'      => 'la :attribute el campo es obligatorio a menos que :other is in :values.',
    'required_with'        => 'la :attribute campo es obligatorio cuando :values está presente.',
    'required_with_all'    => 'la :attribute campo es obligatorio cuando :values está presente.',
    'required_without'     => 'la :attribute campo es obligatorio cuando :values no es presente.',
    'required_without_all' => 'la :attribute campo es obligatorio cuando ninguno de :values están presentes.',
    'same'                 => 'la :attribute and :other debe coincidir con.',
    'size'                 => [
        'numeric' => 'la :attribute debe ser :size.',
        'file'    => 'la :attribute debe ser :size kilobytes.',
        'string'  => 'la :attribute debe ser :size caracteres.',
        'array'   => 'la :attribute debe contener :size artículos.',
    ],
    'string'               => 'la :attribute debe ser una cadena.',
    'timezone'             => 'la :attribute debe ser una zona válida.',
    'unique'               => 'la :attribute ya se ha tomado.',
    'uploaded'             => 'la :attribute no se pudo cargar.',
    'url'                  => 'la :attribute el formato no es válido.',

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
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
