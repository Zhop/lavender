<?php

namespace Lavender\Layout;

use Illuminate\Support\ServiceProvider;

class LayoutServiceProvider extends ServiceProvider
{

    /**
     * Used for view injection.
     * @todo: Move this out of the service provider.
     */
    const INJECT_MODE_APPEND  = 0;
    const INJECT_MODE_REPLACE = 1;

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('lavender/layout');
    }

    /**
     * Gets a grouped layout configuration.
     *
     * @todo   Move this out of the service provider.
     * @return array
     */
    protected function getGroupedLayoutConfiguration()
    {
        $groupedConfig = array();
        foreach ($this->app['config']->getLayoutConfiguration() as $layoutConfig) {
            foreach ($layoutConfig as $view => $config) {
                if (!is_array($config)) {
                    // TODO: Handle this more gracefully?
                    throw new \Exception('Layout configuration should be an array.');
                }
                foreach ($config as $section => $children) {
                    if (!isset($groupedConfig[$view][$section])) {
                        $groupedConfig[$view][$section] = array();
                    }
                    $groupedConfig[$view][$section] += $children;
                }
            }
        }
        return $groupedConfig;
    }

    /**
     * Returns a view based on specified configuration options.
     *
     * @todo   Move this out of the service provider.
     * @param  string $name
     * @param  array $config
     * @return string|Illuminate\View\View
     */
    protected function getLayoutView($name, $config)
    {
        $view = \View::make($name);
        $injectMode = isset($config['mode']) ? $config['mode'] : self::INJECT_MODE_APPEND;
        switch ($injectMode) {
            case self::INJECT_MODE_APPEND:
                // Ewww...
                $view = '@parent' . PHP_EOL . $view;
        }
        return $view;
    }

    /**
     * Injects layout views.
     *
     * @todo   Move this out of the service provider.
     * @return LayoutServiceProvider
     */
    protected function injectLayoutViews()
    {
        foreach ($this->getGroupedLayoutConfiguration() as $viewName => $sections) {
            \View::composer($viewName, function($view) use ($sections) {
                foreach ($sections as $sectionName => $children) {
                    foreach ($children as $childName => $childConfig) {
                        $view->getEnvironment()->inject(
                            $sectionName,
                            $this->getLayoutView($childName, $childConfig)
                        );
                    }
                }
            });
        }
        return $this;
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->booting(function() {
            $this->injectLayoutViews();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

}
