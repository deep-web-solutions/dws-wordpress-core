<?php

namespace Deep_Web_Solutions\Admin\ACF;
use Deep_Web_Solutions\Core\DWS_Permissions;
use Deep_Web_Solutions\Core\Permissions_Base;

if (!defined('ABSPATH')) { exit; }

/**
 * The custom DWS permissions needed to enhance the ACF library.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Cezar Hegyes <a.hegyes@deep-web-solutions.de>
 *
 * @see     Permissions_Base
 * @see     DWS_Permissions
 */
final class Permissions extends Permissions_Base {
	const CAN_EDIT_GALLERY_FIELD = DWS_Permissions::CAPABILITY_PREFIX . 'edit_acf_gallery_field';
} Permissions::maybe_initialize_singleton('agdsgrhgehiue');