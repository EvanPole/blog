<?php

return [
    'title' => 'Blog',

    'posts' => [
        'title' => 'Articles',
        'edit' => 'Modifier l\'article #:post',
        'create' => 'Créer un article',
    ],

    'fields' => [
        'slug' => 'Slug',
        'published_at' => 'Date de publication',
        'is_published' => 'Publié',
        'search_image' => 'Rechercher une image...',
        'no_image' => 'Aucune image trouvée.',
        'upload_image' => 'Ajouter une image à la médiathèque',
    ],

    'status' => [
        'published' => 'Publié',
        'draft' => 'Brouillon',
    ],

    'permission' => 'Gérer le Blog',

    'settings' => [
        'title' => 'Paramètres',
        'openai_key' => 'Clé API OpenAI',
        'openai_key_info' => 'Obtenez votre clé API sur platform.openai.com',
        'openai_model' => 'Modèle',
    ],

    'ai' => [
        'title' => 'Générer avec l\'IA',
        'generate' => 'Générer avec l\'IA',
        'topic' => 'Sujet',
        'topic_placeholder' => 'Décrivez l\'article que vous souhaitez générer...',
        'language' => 'Langue',
        'no_key' => 'Veuillez configurer votre clé API OpenAI dans les paramètres du blog.',
        'api_error' => 'Une erreur est survenue lors de l\'appel à l\'API IA.',
        'parse_error' => 'Impossible de lire la réponse de l\'IA.',
    ],
];
