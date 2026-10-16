<?php

/*
 * Messages de validation en français (Étape 10.1).
 * Les clés absentes de ce fichier retombent automatiquement sur l'anglais
 * (APP_FALLBACK_LOCALE=en).
 */
return [
    'required' => 'Le champ :attribute est obligatoire.',
    'string' => 'Le champ :attribute doit être une chaîne de caractères.',
    'email' => 'Le champ :attribute doit être une adresse e-mail valide.',
    'unique' => 'Cette valeur du champ :attribute est déjà utilisée.',
    'confirmed' => 'La confirmation du champ :attribute ne correspond pas.',
    'file' => 'Le champ :attribute doit être un fichier.',
    'mimes' => 'Le champ :attribute doit être un fichier de type : :values.',
    'uploaded' => 'Le téléversement du champ :attribute a échoué (fichier trop volumineux ?).',
    'max' => [
        'string' => 'Le champ :attribute ne doit pas dépasser :max caractères.',
        'file' => 'Le fichier :attribute ne doit pas dépasser :max Ko.',
    ],
    'min' => [
        'string' => 'Le champ :attribute doit contenir au moins :min caractères.',
    ],
    'attributes' => [
        'title' => 'titre',
        'file' => 'fichier',
        'name' => 'nom',
        'email' => 'adresse e-mail',
        'password' => 'mot de passe',
        'query' => 'recherche',
    ],
];
