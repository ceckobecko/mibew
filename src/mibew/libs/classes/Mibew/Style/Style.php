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

namespace Mibew\Style;

/**
 * Base class for styles
 */
abstract class Style
{
    /**
     * Styles configuration array or NULL by default
     *
     * @var array|NULL
     */
    protected $cachedConfigurations = null;

    /**
     * This value is used to store name of a style
     *
     * @var string
     */
    protected $styleName;

    /**
     * Contains cached results of the \Mibew\Style\StyleInterface::getStyleList
     * method. The lists are keyed by the $root_dir argument of the method.
     *
     * @var array
     * @see \Mibew\Style\StyleInterface::getStyleList
     */
    protected static $cachedStyleLists = array();

    /**
     * Object constructor
     *
     * @param string $style_name Name of the style
     */
    public function __construct($style_name)
    {
        $this->styleName = $style_name;
    }

    /**
     * Returns name of the style related with the object
     *
     * @return string Name of the style
     */
    public function name()
    {
        return $this->styleName;
    }

    /**
     * Loads configurations of the style. The results is cached in the class
     * instance.
     *
     * @return array Style configurations
     * @throws \RuntimeException
     */
    public function configurations()
    {
        $config_file = MIBEW_FS_ROOT . '/' . $this->filesPath() . '/config.ini';

        // Check if configurations already loaded. Do not do the job twice.
        if (is_null($this->cachedConfigurations)) {
            // Set empty value for configuration array
            $this->cachedConfigurations = array();

            // Try to read configuration file
            if (!is_readable($config_file)) {
                throw new \RuntimeException('Cannot read configuration file');
            }

            // Load configurations from file, merge it with default configs and
            // cache the result.
            $loaded_config = parse_ini_file($config_file, true);
            $default_config = $this->defaultConfigurations();
            $this->cachedConfigurations = $loaded_config + $default_config;
        }

        return $this->cachedConfigurations;
    }

    /**
     * Builds base path for style files. This path is relative Mibew root and
     * does not contain neither leading nor trailing slash.
     *
     * @return string Base path for style files
     */
    abstract public function filesPath();

    /**
     * Gets names of styles which are located in the $root_dir.
     *
     * @param string $root_dir Root styles directory
     * @return array List of styles' names
     */
    protected static function getStyleList($root_dir)
    {
        // Check if styles list is already stored in the cache
        if (!isset(self::$cachedStyleLists[$root_dir])) {
            // Build list of styles for the specified root directory.
            $style_list = array();
            if ($handle = opendir($root_dir)) {
                while (false !== ($file = readdir($handle))) {
                    if (preg_match("/^\w+$/", $file) && is_dir("$root_dir/$file")) {
                        $style_list[$file] = $file;
                    }
                }
                closedir($handle);
            }

            // Cache the list
            self::$cachedStyleLists[$root_dir] = $style_list;
        }

        return self::$cachedStyleLists[$root_dir];
    }

    /**
     * Returns array of default configurations for concrete style object. This
     * method uses "Template method" design pattern.
     *
     * @return array Default configurations of the style
     */
    abstract protected function defaultConfigurations();
}
