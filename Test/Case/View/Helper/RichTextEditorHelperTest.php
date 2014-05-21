<?php
/**
 * RichTextEditorHelper Test Case
 *
 * @author   Ryuji Masukawa <masukawa@nii.ac.jp>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('View', 'View');
App::uses('Helper', 'View');
App::uses('RichTextEditorHelper', 'RichTextEditor.View/Helper');
App::uses('HtmlHelper', 'View/Helper');

/**
 * Summary for RichTextEditorHelper Test Case
 */
class RichTextEditorHelperTest extends CakeTestCase {

/**
 * @var array
 * @access public
 */
	public $configs = array(
		'simple' => array(
			'mode' => 'textareas',
			'theme' => 'simple',
			'editor_selector' => 'mceSimple'
		),
		'advanced' => array(
			'mode' => 'textareas',
			'theme' => 'advanced',
			'editor_selector' => 'mceAdvanced'
		)
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$View = new View();
		$this->RichTextEditor = new RichTextEditorHelper($View);
		$this->RichTextEditor->Html = $this->getMock('HtmlHelper', array('script'), array($View));
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->RichTextEditor);

		parent::tearDown();
	}

/**
 * testEditor
 *
 * @return void
 * @access public
 */
	public function testEditor() {
		$this->RichTextEditor->Html->expects($this->any())
			->method('scriptBlock')
			->with(
				'<script type="text/javascript">
				//<![CDATA[
				tinymce.init({
				theme : "advanced"
				});

				//]]>
				</script>',
				array('inline' => false));
		$this->RichTextEditor->editor(array('theme' => 'advanced'));

		$this->RichTextEditor->Html->expects($this->any())
			->method('scriptBlock')
			->with(
				'<script type="text/javascript">
				//<![CDATA[
				tinymce.init({
				mode : "textareas",
				theme : "simple",
				editor_selector : "mceSimple"
				});

				//]]>
				</script>',
				array('inline' => false));
		$this->RichTextEditor->setConfig($this->configs);
		$this->RichTextEditor->editor('simple');

		$this->expectException('OutOfBoundsException');
		$this->RichTextEditor->editor('invalid-config');
	}

/**
 * testEditor with app wide options
 *
 * @return void
 * @access public
 */
	public function testEditorWithDefaults() {
		$this->assertTrue(Configure::write('TinyMCE.editorOptions', array('height' => '100px')));

		$this->RichTextEditor->Html->expects($this->any())
			->method('scriptBlock')
			->with(
				'<script type="text/javascript">
				//<![CDATA[
				tinymce.init({
				height : "100px",
				theme : "advanced"
				});

				//]]>
				</script>',
				array('inline' => false));
		$this->RichTextEditor->beforeRender('test.ctp');
		$this->RichTextEditor->editor(array('theme' => 'advanced'));

		$this->RichTextEditor->Html->expects($this->any())
			->method('scriptBlock')
			->with(
				'<script type="text/javascript">
				//<![CDATA[
				tinymce.init({
				height : "50px"
				});

				//]]>
				</script>',
				array('inline' => false));
		$this->RichTextEditor->editor(array('height' => '50px'));
	}

/**
 * testBeforeRender
 *
 * @return void
 * @access public
 */
	public function testBeforeRender() {
		$this->RichTextEditor->Html->expects($this->any())
			->method('script')
			->with(
				'/TinyMCE/js/tiny_mce/tiny_mce.js',
				array('inline' => false));
		$this->RichTextEditor->beforeRender('test.ctp');
	}

}
