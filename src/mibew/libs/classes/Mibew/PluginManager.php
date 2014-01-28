<?php
/*
 * Copyright 2005-2013 the original author or authors.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Mibew;

/**
 * Manage plugins
 */
class PluginManager
{
    /**
     * Contains all loaded plugins
     *
     * @var array
     */
    protected static $loadedPlugins = array();

    /**
     * Returns plugin object
     *
     * @param string $plugin_name
     * @return \Mibew\Plugin
     */
    public static function getPlugin($plugin_name)
    {
        if (empty(self::$loadedPlugins[$plugin_name])) {
            trigger_error(
                "Plugin '{$plugin_name}' does not initialized!",
                E_USER_WARNING
            );
        }

        return self::$loadedPlugins[$plugin_name];
    }

    /**
     * Returns associative array of loaded plugins.
     *
     * Key represents plugin's name and value contains Plugin object
     *
     * @return array
     */
    public static function getAllPlugins()
    {
        return self::$loadedPlugins;
    }

    /**
     * Loads plugins.
     *
     * The method checks dependences and plugin avaiulability before loading and
     * invokes Plugin::registerListeners() after loading.
     *
     * @param array $plugins_list List of plugins' names and configurations.
     *   For example:
     * <code>
     * $plugins_list = array();
     * $plugins_list[] = array(
     * 	'name' => 'plugin_name',      // Obligatory value
     * 	'config' => array(            // Pass to plugin constructor
     * 		'weight' => 100,
     * 		'some_configurable_value' => 'value'
     * 	)
     * )
     * </code>
     *
     * @see Plugin::registerListeners()
     */
    public static function loadPlugins($plugins_list)
    {
        // Add include path
        $include_path = get_include_path();
        $include_path .= empty($include_path) ? '' : PATH_SEPARATOR;
        set_include_path($include_path . realpath(MIBEW_FS_ROOT . "/plugins/"));

        // Load plugins
        $loading_queue = array();
        $offset = 0;
        foreach ($plugins_list as $plugin) {
            if (empty($plugin['name'])) {
                trigger_error("Plugin name undefined!", E_USER_WARNING);
                continue;
            }
            $plugin_name = $plugin['name'];
            $plugin_config = isset($plugin['config']) ? $plugin['config'] : array();

            // Build name of the plugin class
            $plugin_name_parts = explode('_', $plugin_name);
            $plugin_name_parts = array_map('ucfirst', $plugin_name_parts);
            $plugin_classname = '\\Mibew\\Plugin\\' . implode('', $plugin_name_parts);

            // Try to load plugin file
            if (!(include_once $plugin_name . "/" . $plugin_name . "_plugin.php")) {
                trigger_error("Cannot load plugin file!", E_USER_ERROR);
            }
            // Check plugin class name
            if (!class_exists($plugin_classname)) {
                trigger_error(
                    "Plugin class '{$plugin_classname}' is undefined!",
                    E_USER_WARNING
                );
                continue;
            }
            // Check if plugin extends abstract 'Plugin' class
            if ('Mibew\\Plugin' != get_parent_class($plugin_classname)) {
                $error_essage = "Plugin class '{$plugin_classname}' does not "
                    . "extend abstract '\\Mibew\\Plugin' class!";
                trigger_error($error_essage, E_USER_WARNING);
                continue;
            }

            // Check plugin dependences
            $plugin_dependences = call_user_func(array(
                $plugin_classname,
                'getDependences',
            ));
            foreach ($plugin_dependences as $dependence) {
                if (empty(self::$loadedPlugins[$dependence])) {
                    $error_essage = "Plugin '{$dependence}' was not loaded "
                        . "yet, but exists in '{$plugin_name}' dependences list!";
                    trigger_error($error_essage, E_USER_WARNING);
                    continue 2;
                }
            }

            // Add plugin to loading queue
            $plugin_instance = new $plugin_classname($plugin_config);
            if ($plugin_instance->initialized) {
                // Store plugin instance
                self::$loadedPlugins[$plugin_name] = $plugin_instance;
                $loading_queue[$plugin_instance->getWeight() . "_" . $offset] = $plugin_instance;
                $offset++;
            } else {
                trigger_error(
                    "Plugin '{$plugin_name}' was not initialized correctly!",
                    E_USER_WARNING
                );
            }
        }
        // Sort queue in order to plugins' weights
        uksort($loading_queue, 'strnatcmp');
        // Add events and listeners
        foreach ($loading_queue as $plugin) {
            $plugin->registerListeners();
        }
    }
}
