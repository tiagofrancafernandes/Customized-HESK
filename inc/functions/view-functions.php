<?php

use Jenssegers\Blade\Blade;

if (!defined('HESK_REALPATH_PATH')) {
    define('HESK_REALPATH_PATH', realpath(__DIR__ . '/../..'));
}

if (!defined('VIEWS_DIR')) {
    define('VIEWS_DIR', HESK_REALPATH_PATH . '/views');
}

if (!defined('VIEWS_CACHE_DIR')) {
    define('VIEWS_CACHE_DIR', HESK_REALPATH_PATH . '/cache/views-cache');
}

if (!function_exists('views_dir')) {
    /**
     * function views_dir
     *
     * @return string
     */
    function views_dir(): string
    {
        if (defined('VIEWS_DIR')) {
            return trim(rtrim(VIEWS_DIR, '/\\'));
        }

        return trim(rtrim(HESK_REALPATH_PATH . '/views', '/\\'));
    }
}

if (!function_exists('views_cache_dir')) {
    /**
     * function views_cache_dir
     *
     * @return string
     */
    function views_cache_dir(): string
    {
        if (defined('VIEWS_CACHE_DIR')) {
            return trim(rtrim(VIEWS_CACHE_DIR, '/\\'));
        }

        return trim(rtrim(HESK_REALPATH_PATH . '/cache/views-cache', '/\\'));
    }
}

if (!function_exists('blade')) {
    /**
     * function blade
     *
     * @return Blade
     */
    function blade(): Blade
    {
        return new Blade(
            views_dir(),
            views_cache_dir(),
        );
    }
}

if (!function_exists('view_path')) {
    /**
     * function view_path
     *
     * @param string $view
     * @return string
     */
    function view_path(string $view): string
    {
        $view = rtrim($view, '\.view\.php');

        return implode(
            '/',
            array_filter([
                trim(rtrim(views_dir(), '/\\')),
                trim(rtrim($view, '/\\')) . '.view.php',
            ]),
        );
    }
}

if (!function_exists('view_content')) {
    /**
     * function view_content
     *
     * @param string $view
     * @param array $data
     * @param bool $return
     *
     * @return ?string
     */
    function view_content(
        string $view,
        array $data = [],
        bool $return = true,
    ): ?string {
        extract($data);
        $path = view_path($view);
        $content = function () use ($path) {
            return require $path;
        };

        $content = $content();

        $content = rtrim($content, '1');

        if ($return) {
            return $content;
        }

        echo $content;

        return null;
    }
}

if (!function_exists('blade_view')) {
    /**
     * function blade_view
     *
     * @param string $view
     * @param array $data
     * @param bool $render
     *
     * @render Blade|string
     */
    function blade_view(
        string $view,
        array $data = [],
        bool $render = false,
    ): Blade|string {
        $blade = blade()->make($view, $data);

        if (!$render) {
            return $blade;
        }

        return $blade->render();
    }
}

if (!function_exists('view_render')) {
    /**
     * function view_render
     *
     * @param string $view
     * @param array $data
     *
     * @return void
     */
    function view_render(
        string $view,
        array $data = [],
    ): void {
        echo blade_view($view, $data, true);
    }
}
