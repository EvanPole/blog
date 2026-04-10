<?php

namespace Azuriom\Plugin\Blog\Providers;

use Azuriom\Extensions\Plugin\BasePluginServiceProvider;
use Azuriom\Models\Permission;
use Azuriom\Plugin\Blog\Models\Post;
use Illuminate\Database\Eloquent\Relations\Relation;

class BlogServiceProvider extends BasePluginServiceProvider
{
    public function boot(): void
    {
        $this->loadViews();
        $this->loadTranslations();
        $this->loadMigrations();
        $this->registerRouteDescriptions();
        $this->registerAdminNavigation();

        Permission::registerPermissions([
            'blog.admin' => 'blog::admin.permission',
        ]);

        Relation::morphMap(['blog.posts' => Post::class]);
    }

    protected function routeDescriptions(): array
    {
        return [
            'blog.index' => trans('blog::messages.title'),
        ];
    }

    protected function adminNavigation(): array
    {
        return [
            'blog' => [
                'name' => trans('blog::admin.title'),
                'icon' => 'bi bi-pencil-square',
                'permission' => 'blog.admin',
                'route' => 'blog.admin.posts.index',
                'items' => [
                    'blog.admin.posts.index' => trans('blog::admin.posts.title'),
                    'blog.admin.settings' => trans('blog::admin.settings.title'),
                ],
            ],
        ];
    }
}
