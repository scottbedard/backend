<?php

namespace Bedard\Backend;

class Resource
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
    public static $model = null;

    /**
     * Resource route.
     *
     * @var string
     */
    public static $route = null;

    /**
     * Resource title.
     *
     * @var string
     */
    public static $title = null;
}
