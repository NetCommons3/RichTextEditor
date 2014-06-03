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
	public $helpers = array('TinyMCE.TinyMCE', 'Html');

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
		$this->__editorTinyMCE($options);
	}

/**
 * Adds a new editor to the script block in the head
 * Ajax対応版
 * @see http://www.tinymce.com/wiki.php/Configuration for a list of keys
 * @param mixed If array camel cased TinyMCE Init config keys, if string it checks if a config with that name exists
 * @return void
 * @throws OutOfBoundsException
 */
	private function __editorTinyMCE($options = array()) {
		if (is_string($options)) {
			if (isset($this->TinyMCE->configs[$options])) {
				$options = $this->TinyMCE->configs[$options];
			} else {
				throw new OutOfBoundsException(sprintf(__('Invalid TinyMCE configuration preset %s'), $options));
			}
		}
		$options = array_merge($this->_defaults, $options);
		$lines = '';

		foreach ($options as $option => $value) {
			$lines .= Inflector::underscore($option) . ' : "' . $value . '",' . "\n";
		}
		// remove last comma from lines to avoid the editor breaking in Internet Explorer
		$lines = rtrim($lines);
		$lines = rtrim($lines, ',');
		// Ajax対応
		if ($this->request->is('ajax')) {
			$base = $this->Html->url('/', true) . 'TinyMCE/js/tiny_mce/';
			$js = $base . 'tiny_mce_src.js';
			echo $this->Html->scriptBlock('if (typeof tinymce == "undefined") {
			$.ajaxSetup({async: false});$.getScript("' . $js . '", function(){
				tinymce.dom.Event.domLoaded = true;
				tinymce.baseURL = "' . $base . '";
			});$.ajaxSetup({async: true}); } tinymce.init({' . "\n" . $lines . "\n" . '});');
			return;
		}
		$this->Html->scriptBlock('tinymce.init({' . "\n" . $lines . "\n" . '});' . "\n", array('inline' => false));
	}

/**
 * beforeRender callback
 *
 * @param string $viewFile The view file that is going to be rendered
 *
 * @return void
 */
	public function beforeRender($viewFile) {
		$this->__beforeRenderTinyMCE($viewFile);
	}

/**
 * beforeRender callback
 * Ajax対応版
 * @param string $viewFile The view file that is going to be rendered
 *
 * @return void
 */
	private function __beforeRenderTinyMCE($viewFile) {
		$appOptions = Configure::read('TinyMCE.editorOptions');
		if ($appOptions !== false && is_array($appOptions)) {
			$this->_defaults = $appOptions;
		}
		if ($this->request->is('ajax')) {
			return;
		}
		$this->Html->script('/TinyMCE/js/tiny_mce/tiny_mce.js', array('inline' => false));
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
