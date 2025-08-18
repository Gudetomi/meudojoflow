<?php

return [

    'accepted'             => 'O campo :attribute deve ser aceito.',
    'active_url'           => 'O campo :attribute não é uma URL válida.',
    'after'                => 'O campo :attribute deve ser uma data posterior a :date.',
    'after_or_equal'       => 'O campo :attribute deve ser uma data posterior ou igual a :date.',
    'alpha'                => 'O campo :attribute deve conter apenas letras.',
    'alpha_num'            => 'O campo :attribute deve conter apenas letras e números.',
    'array'                => 'O campo :attribute deve ser um array.',
    'before'               => 'O campo :attribute deve ser uma data anterior a :date.',
    'before_or_equal'      => 'O campo :attribute deve ser uma data anterior ou igual a :date.',
    'between'              => [
        'numeric' => 'O campo :attribute deve estar entre :min e :max.',
        'file'    => 'O campo :attribute deve ter entre :min e :max kilobytes.',
        'string'  => 'O campo :attribute deve ter entre :min e :max caracteres.',
        'array'   => 'O campo :attribute deve ter entre :min e :max itens.',
    ],
    'boolean'              => 'O campo :attribute deve ser verdadeiro ou falso.',
    'confirmed'            => 'A confirmação do campo :attribute não confere.',
    'date'                 => 'O campo :attribute não é uma data válida.',
    'email'                => 'O campo :attribute deve ser um endereço de e-mail válido.',
    'integer'              => 'O campo :attribute deve ser um número inteiro.',
    'max'                  => [
        'string'  => 'O campo :attribute não pode ser maior que :max caracteres.',
    ],
    'min'                  => [
        'string'  => 'O campo :attribute deve ter pelo menos :min caracteres.',
    ],
    'required'             => 'O campo :attribute é obrigatório.',
    'unique'               => 'O campo :attribute já está em uso.',

    'attributes' => [], // Aqui você pode mapear nomes mais amigáveis (ex: 'email' => 'E-mail')

];
