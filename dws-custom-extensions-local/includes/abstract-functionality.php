<?php

namespace Deep_Web_Solutions\Local\Core;
use Deep_Web_Solutions\Admin\Settings\DWS_Settings_Pages;
use Deep_Web_Solutions\Core\DWS_Functionality_Template;

if (!defined('ABSPATH')) { exit; }

/**
 * The core functionality template tailored to the needs of local extensions.
 *
 * @since   1.0.0
 * @version 2.0.0
 * @author  Antonius Cezar Hegyes <a.hegyes@deep-web-solutions.de>
 *
 * @see     DWS_Functionality_Template
 */
abstract class DWS_Local_Functionality_Template extends DWS_Functionality_Template {
	//region INHERITED FUNCTIONS

	/**
	 * @since   1.0.0
	 * @version 2.0.0
	 *
	 * @see     DWS_Functionality_Template::local_configure()
	 */
	protected function local_configure() {
		$this->children_settings_filter = DWS_Settings_Pages::get_page_groups_fields_hook(DWS_Local_Admin::LOCAL_OPTIONS_SLUG);

		if (!empty(self::get_parent())) {
			$this->settings_filter = $this->children_settings_filter;
		} else {
			$this->settings_filter = DWS_Settings_Pages::get_page_groups_hook(DWS_Local_Admin::LOCAL_OPTIONS_SLUG);
		}
	}

	/**
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @see     DWS_Functionality_Template::get_language_domain()
	 *
	 * @return  string
	 */
	public static function get_language_domain() {
		return DWS_CUSTOM_EXTENSIONS_LOCAL_LANG_DOMAIN . '_custom';
	}

	//endregion
}