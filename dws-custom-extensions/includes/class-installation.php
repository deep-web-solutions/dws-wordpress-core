<?php

namespace Deep_Web_Solutions\Core;
use Deep_Web_Solutions\Custom_Extensions;

if (!defined( 'ABSPATH')) { exit; }

/**
 * Provides an "installation" function to this MU-plugin.
 *
 * @since   1.0.0
 * @version 1.3.4
 * @author  Antonius Cezar Hegyes <a.hegyes@deep-web-solutions.de>
 *
 * @see     DWS_Root
 */
final class DWS_Installation extends DWS_Root {
	//region FIELDS AND CONSTANTS

	/**
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @var     string      INSTALL_ACTION      The name of the AJAX action on which the 'installation' should occur.
	 */
	const INSTALL_ACTION = 'dws_install_custom_extensions';

	/**
	 * @since   1.3.4
	 * @version 1.3.4
	 *
	 * @var     string  INSTALL_OPTION  The name of the option stored in the database which indicates whether the
	 *                                  core has been installed or not.
	 */
	const INSTALL_OPTION = 'dws_installed-core-option';

	//endregion

	//region INHERITED FUNCTIONS

	/**
	 * @since   1.0.0
	 * @version 1.3.4
	 *
	 * @see     DWS_Root::define_hooks()
	 *
	 * @param   DWS_WordPress_Loader    $loader
	 */
	protected function define_hooks($loader) {
		$loader->add_action('wp_ajax_' . self::INSTALL_ACTION, $this, 'run_installation', PHP_INT_MIN);
		$loader->add_action('admin_notices', $this, 'add_install_update_admin_notice', PHP_INT_MAX);
		$loader->add_action('dws_main_page', $this, 'add_reinstall_admin_notice', PHP_INT_MAX);
	}

	//endregion

	/**
	 * Gathers all installable classes and runs their installation. This is a very expensive operation,
	 * so it should only be triggered by an admin by AJAX.
	 *
	 * @since   1.0.0
	 * @version 1.2.0
	 */
	public static function run_installation() {
		if (wp_doing_ajax() && !DWS_Permissions::has('administrator')) {
			return;
		}

		foreach (get_declared_classes() as $declared_class) {
			if (!in_array('Deep_Web_Solutions\Core\DWS_Installable', class_implements($declared_class))) {
				continue;
			}

			try {
				$class           = new \ReflectionClass($declared_class);
				$install_version = $class->getMethod('get_version')->invoke(null);

				if (get_option($class->getName() . '_install_version') !== $install_version) {
					$class->getMethod('install')->invoke(null);
					update_option($class->getName() . '_install_version', $install_version);
				}
			} catch (\ReflectionException $exception) { /* literally impossible currently */ }
		}

		$current_version = get_option(self::INSTALL_OPTION, false);
		if(!$current_version){
			add_option(self::INSTALL_OPTION, Custom_Extensions::get_version());
		} else {
			update_option(self::INSTALL_OPTION, Custom_Extensions::get_version());
		}

		die;
	}

	/**
	 * Adds a notice on the admin pages once the DWS core has been copied in the filesystem. This notice indicates
	 * that the core should be installed. It also provides a link to the installation.
	 *
	 * @author  Dushan Terzikj  <d.terzikj@deep-web-solutions.de>
	 *
	 * @since   1.3.4
	 * @version 1.3.4
	 */
	public function add_install_update_admin_notice(){
		if(DWS_Permissions::has('administrator')){
			$current_version = get_option(self::INSTALL_OPTION, false);
			$link_to_install = add_query_arg('action', self::INSTALL_ACTION, admin_url('admin-ajax.php'));
			$html = "";
			if(!$current_version){
				$html .= '<div class="notice notice-warning" style="padding-bottom: 10px !important;">
					<p>' . __('DWS Wordpress core has been detected! Please click on Install to install it', DWS_CUSTOM_EXTENSIONS_LANG_DOMAIN) . '</p>
					<a href="'. $link_to_install .'"><button class="button button-primary button-large">' . __('Install', DWS_CUSTOM_EXTENSIONS_LANG_DOMAIN) . '</button></a>
				</div>';
			} else if($current_version != Custom_Extensions::get_version()){
				$html .= '<div class="notice notice-warning" style="padding-bottom: 10px !important;">
					<p>' . __('Looks like a newer version of the core is available. Update it here!',
				              DWS_CUSTOM_EXTENSIONS_LANG_DOMAIN) . '</p>
					<a href="'. $link_to_install .'"><button class="button button-primary button-large">' . __('Update', DWS_CUSTOM_EXTENSIONS_LANG_DOMAIN) . '</button></a>
				</div>';
			}


			echo $html;
		}
	}

	public function add_reinstall_admin_notice(){
		if(DWS_Permissions::has('administrator')){
			$link_to_reinstall = add_query_arg('action', self::INSTALL_ACTION, admin_url('admin-ajax.php'));
			$html = '<div class="notice notice-warning" style="padding-bottom: 10px !important;">
					<h3>Reinstall</h3>
					<p>' . __('Do you want to reinstall the core?', DWS_CUSTOM_EXTENSIONS_LANG_DOMAIN) . '</p>
					<a href="'. $link_to_reinstall .'"><button class="button button-primary button-large">' . __('Reinstall', DWS_CUSTOM_EXTENSIONS_LANG_DOMAIN) . '</button></a>
				</div>';
			echo $html;
		}
	}
}