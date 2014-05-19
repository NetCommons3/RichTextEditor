<?php
/**
 * RichTextEditor plugin bootstrap
 *
 * @author   Ryuji Masukawa <masukawa@nii.ac.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */
Configure::write('TinyMCE.editorOptions', array(
	'mode' => 'exact',
	'theme' => 'advanced',
	'language' => "ja",	// ほかの言語にも切り替えしなければならない。
	'width' => "500px",
	'height' => "300px",
	'theme_advanced_toolbar_location' => 'top',
	'theme_advanced_toolbar_align' => 'left',
	'theme_advanced_statusbar_location' => 'bottom',
	'theme_advanced_resizing' => true,
//	'plugins' => 'table',
//	'theme_advanced_buttons1' => 'bold,italic,strikethrough,|,bullist,numlist,|,table,|,formatselect,fontsizeselect,|,visualaid,code,fullscreen,help',
//	'theme_advanced_buttons2' => 'forecolor,backcolor,removeformat,|,link,unlink,image,charmap,|,search,replace,|,undo,redo',
));

if (class_exists('Purifier')) {
	Purifier::config('RichTextEditor', array(
			'Cache.SerializerPath' => APP . 'tmp' . DS . 'cache',
			'HTML.AllowedElements' => 'a, em, blockquote, p, strong, pre, code, span, div, ul, ol, li, img',
			'HTML.AllowedAttributes' => 'a.href, a.title, img.src, img.alt'
		)
	);
}
