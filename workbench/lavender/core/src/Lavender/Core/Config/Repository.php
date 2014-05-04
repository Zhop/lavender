<?php

namespace Lavender\Core\Config;

class Repository extends \Illuminate\Config\Repository
{

    /**
     * Get the specified configuration value.
     *
     * @todo   Cache certain configuration values.
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return parent::get($key, $default);
    }

    /**
     * Gets layout configuration for all loaded packages.
     *
     * @return array
     */
    public function getLayoutConfiguration()
    {
        $configuration = array();
        foreach ($this->packages as $namespace) {
            $layoutConfig = $this->get($namespace . '::layout');
            if ($layoutConfig) {
                $configuration[] = $layoutConfig;
            }
        }
        return $configuration;
    }

}
