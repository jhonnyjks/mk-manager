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

    'accepted' => 'O :attribute deve ser aceito.',
    'active_url' => 'O :attribute não é uma URL válida.',
    'after' => 'O :attribute deve ser uma data depois de :date.',
    'after_or_equal' => 'O :attribute deve ser uma data depois ou igual a :date.',
    'alpha' => 'O :attribute deve conter apenas letras.',
    'alpha_dash' => 'O :attribute deve conter apenas letras, números, traços e sublinhados.',
    'alpha_num' => 'O :attribute deve conter apenas letras e números.',
    'array' => 'O :attribute deve ser um array.',
    'before' => 'O :attribute deve ser uma data antes de :date.',
    'before_or_equal' => 'O :attribute deve ser uma data antes ou igual a :date.',
    'between' => [
        'numeric' => 'O :attribute deve estar entre :min e :max.',
        'file' => 'O :attribute deve estar entre :min e :max kilobytes.',
        'string' => 'O :attribute deve estar entre :min e :max caracteres.',
        'array' => 'O :attribute deve conter entre :min e :max itens.',
    ],
    'boolean' => 'O campo :attribute deve ser Verdadeiro ou Falso.',
    'confirmed' => 'O campo :attribute não é igual.',
    'date' => 'A :attribute não é uma data válida.',
    'date_equals' => 'O :attribute deve ser uma data igual a :date.',
    'date_format' => 'O :attribute não está no formato :format.',
    'different' => 'O :attribute e :other devem ser diferentes.',
    'digits' => 'O :attribute deve ter :digits digitos.',
    'digits_between' => 'O :attribute deve estar entre :min e :max digitos.',
    'dimensions' => 'O :attribute tem dimensões inválidas para imagem.',
    'distinct' => 'O :attribute field has a duplicate value.',
    'email' => 'O :attribute deve ser a valid email address.',
    'exists' => 'O selected :attribute is invalid.',
    'file' => 'O :attribute deve ser a file.',
    'filled' => 'O :attribute field must have a value.',
    'gt' => [
        'numeric' => 'O :attribute deve ser greater than :value.',
        'file' => 'O :attribute deve ser greater than :value kilobytes.',
        'string' => 'O :attribute deve ser greater than :value characters.',
        'array' => 'O :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'O :attribute deve ser greater than or equal :value.',
        'file' => 'O :attribute deve ser greater than or equal :value kilobytes.',
        'string' => 'O :attribute deve ser greater than or equal :value characters.',
        'array' => 'O :attribute must have :value items or more.',
    ],
    'image' => 'O :attribute deve ser an image.',
    'in' => 'O selected :attribute is invalid.',
    'in_array' => 'O :attribute field does not exist in :other.',
    'integer' => 'O :attribute deve ser an integer.',
    'ip' => 'O :attribute deve ser a valid IP address.',
    'ipv4' => 'O :attribute deve ser a valid IPv4 address.',
    'ipv6' => 'O :attribute deve ser a valid IPv6 address.',
    'json' => 'O :attribute deve ser a valid JSON string.',
    'lt' => [
        'numeric' => 'O :attribute deve ser less than :value.',
        'file' => 'O :attribute deve ser less than :value kilobytes.',
        'string' => 'O :attribute deve ser less than :value characters.',
        'array' => 'O :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'O :attribute deve ser less than or equal :value.',
        'file' => 'O :attribute deve ser less than or equal :value kilobytes.',
        'string' => 'O :attribute deve ser less than or equal :value characters.',
        'array' => 'O :attribute must not have more than :value items.',
    ],
    'max' => [
        'numeric' => 'O :attribute may not be greater than :max.',
        'file' => 'O :attribute may not be greater than :max kilobytes.',
        'string' => 'O :attribute may not be greater than :max characters.',
        'array' => 'O :attribute may not have more than :max items.',
    ],
    'mimes' => 'O :attribute deve ser a file of type: :values.',
    'mimetypes' => 'O :attribute deve ser a file of type: :values.',
    'min' => [
        'numeric' => 'O :attribute deve ser at least :min.',
        'file' => 'O :attribute deve ser at least :min kilobytes.',
        'string' => 'O :attribute deve ser at least :min characters.',
        'array' => 'O :attribute must have at least :min items.',
    ],
    'not_in' => 'O selected :attribute is invalid.',
    'not_regex' => 'O :attribute format is invalid.',
    'numeric' => 'O :attribute deve ser a number.',
    'present' => 'O :attribute field deve ser present.',
    'regex' => 'O :attribute format is invalid.',
    'required' => 'O :attribute field is required.',
    'required_if' => 'O :attribute field is required when :other is :value.',
    'required_unless' => 'O :attribute field is required unless :other is in :values.',
    'required_with' => 'O :attribute field is required when :values is present.',
    'required_with_all' => 'O :attribute field is required when :values are present.',
    'required_without' => 'O :attribute field is required when :values is not present.',
    'required_without_all' => 'O :attribute field is required when none of :values are present.',
    'same' => 'O :attribute and :other must match.',
    'size' => [
        'numeric' => 'O :attribute deve ser :size.',
        'file' => 'O :attribute deve ser :size kilobytes.',
        'string' => 'O :attribute deve ser :size characters.',
        'array' => 'O :attribute must contain :size items.',
    ],
    'starts_with' => 'O :attribute must start with one of the following: :values',
    'string' => 'O :attribute deve ser a string.',
    'timezone' => 'O :attribute deve ser a valid zone.',
    'unique' => 'O :attribute has already been taken.',
    'uploaded' => 'O :attribute failed to upload.',
    'url' => 'O :attribute format is invalid.',
    'uuid' => 'O :attribute deve ser a valid UUID.',

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
    | O following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
