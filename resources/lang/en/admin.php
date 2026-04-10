<?php

return [
    'title' => 'Blog',

    'posts' => [
        'title' => 'Posts',
        'edit' => 'Edit post #:post',
        'create' => 'Create post',
    ],

    'fields' => [
        'slug' => 'Slug',
        'published_at' => 'Published at',
        'is_published' => 'Published',
        'search_image' => 'Search an image...',
        'no_image' => 'No image found.',
        'upload_image' => 'Upload an image to the media library',
    ],

    'status' => [
        'published' => 'Published',
        'draft' => 'Draft',
    ],

    'permission' => 'Manage Blog',

    'settings' => [
        'title' => 'Settings',
        'openai_key' => 'OpenAI API Key',
        'openai_key_info' => 'Get your API key from platform.openai.com',
        'openai_model' => 'Model',
    ],

    'ai' => [
        'title' => 'Generate with AI',
        'generate' => 'Generate with AI',
        'topic' => 'Topic',
        'topic_placeholder' => 'Describe the article you want to generate...',
        'language' => 'Language',
        'no_key' => 'Please configure your OpenAI API key in the blog settings.',
        'api_error' => 'An error occurred while calling the AI API.',
        'parse_error' => 'Unable to parse the AI response.',
    ],
];
