<?php

namespace App\Backend\Resources;

use Bedard\Backend\Resource;

class PostResource extends Resource
{
    /**
     * Resource icon.
     *
     * See https://lucide.dev/
     *
     * @var string
     */
    public static $icon = 'smile';
  
    /**
     * The model corresponding to this resource.
     *
     * @var string
     */
    public static $model = \App\Models\Post::class;

    /**
     * Resource route.
     *
     * @var string
     */
    public static $route = 'posts';

    /**
     * Resource title.
     *
     * @var string
     */
    public static $title = 'Posts';
}
