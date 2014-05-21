<?php
/**
 * RichTextEditor Helper
 *
 * @author   Ryuji Masukawa <masukawa@nii.ac.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */
App::uses('AppHelper', 'View/Helper');

class RichTextEditorHelper extends AppHelper {

/**
 * Other helpers used by FormHelper
 *
 * @var array
 */
	public $helpers = array('TinyMCE.TinyMCE');

/**
 * Configuration
 *
 * @var array
 */
	public $configs = array();

/**
 * Default values
 *
 * @var array
 */
	protected $_defaults = array();

/**
 * Adds a new editor to the script block in the head
 *
 * @see http://www.tinymce.com/wiki.php/Configuration for a list of keys
 * @param mixed If array camel cased TinyMCE Init config keys, if string it checks if a config with that name exists
 * @return void
 */
	public function editor($options = array()) {
		$this->TinyMCE->editor($options);
	}

/**
 * beforeRender callback
 *
 * @param string $viewFile The view file that is going to be rendered
 *
 * @return void
 */
	public function beforeRender($viewFile) {
		$this->TinyMCE->beforeRender($viewFile);
	}

/**
 * set config
 *
 * @param array $configs
 *
 * @return void
 */
	public function setConfig($configs) {
		if (!empty($configs) && is_array($configs)) {
			$this->TinyMCE->configs = $configs;
		}
	}

}
