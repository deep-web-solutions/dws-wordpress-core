<?php

namespace Deep_Web_Solutions\Admin\Settings;

if (!defined('ABSPATH')) { exit; }

/**
 * Interface for interacting with a settings framework.
 *
 * @since   2.0.0
 * @version 2.0.0
 * @author  Fatine Tazi <f.tazi@deep-web-solutions.de>
 */
interface DWS_Adapter {
    //region METHODS

    /**
     * @since   2.0.0
     * @version 2.0.0
     *
     * @param   string  $page_title
     * @param   string  $menu_title
     * @param   string  $capability
     * @param   string  $menu_slug
     * @param   array   $other
     *
     * @return  false|array Returns false or the array of parameters the chosen framework takes.
     */
    public static function register_settings_page($page_title, $menu_title, $capability, $menu_slug, $other = array());

    /**
     * @since   2.0.0
     * @version 2.0.0
     *
     * @param   string  $parent_slug
     * @param   string  $page_title
     * @param   string  $menu_title
     * @param   string  $capability
     * @param   string  $menu_slug
     * @param   array   $other
     *
     * @return  false|array Returns false or the array of parameters the chosen framework takes.
     */
    public static function register_settings_subpage($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $other = array());

    /**
     * @since   2.0.0
     * @version 2.0.0
     *
     * @param   string  $key
     * @param   string  $title
     * @param   string  $location
     * @param   array   $other
     */
    public static function register_options_page_group($key, $title, $location, $other = array());

    /**
     * @since   2.0.0
     * @version 2.0.0
     *
     * @param   string  $group_id
     * @param   string  $key
     * @param   string  $type
     * @param   array   $parameters
     * @param   string  $location
     */
    public static function register_options_group_field($group_id, $key, $type, $parameters, $location);

    //TODO: ignore everything from here on

    /**
     * @since   2.0.0
     * @version 2.0.0
     *
     * @param   string  $parent_id
     * @param   array   $parameters
     * @param   null    $location
     */
    public static function register_settings_field($parent_id, $parameters, $location);

    /**
     * @since   2.0.0
     * @version 2.0.0
     *
     * @param   string  $field_id
     * @param   string  $location
     */
    public static function get_field_value($field_id, $location);

    //endregion
}