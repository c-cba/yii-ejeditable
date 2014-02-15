<?php

/**
 * Yii extension wrapping the jQuery Plugin "Jeditable" from Mika Tuupola
 * {@link http://www.appelsiini.net/projects/jeditable}
 * 
 * @author C.Yildiz (aka c@cba) <c@cba-solutions.org>
 *
 */
Yii::import('zii.widgets.jui.CJuiWidget');

/**
 * Base class.
 */
class EJEditable extends CJuiWidget
{
	/**
	 * @var string a unique identifier for this EJEditable instance 
	 * (to allow for multiple widgets in one page).
	 */
	public $id = "";
	/**
	 * @var string the 'url', first parameter for the Jeditable plugin.
	 */
	public $url;
	/**
	 * @var string the identifier of the editable elements.
	 */
	public $selector = ".editable";
	/**
	 * @var boolean whether or not all data-attributes of the editable elements should be added to the POST request 
	 * (by being concatenated to the "submitdata" parameter of the Jeditable plugin)
	 */
	public $submit_data_attributes = true;
	/**
	 * @var array the options for the Jeditable plugin
	 */
	public $editable_options = array();

	public function init()
	{
		// Put together options for jeditable
		$editable_options_default = array(
			'placeholder'=>'',
			'select'=>true, // the value of the input field will be selected
		);
		$par = array_merge($editable_options_default, $this->editable_options);
		$this->editable_options = $par;
		
		if(empty($this->url)) $this->url = $this->controller->createUrl('updateAttribute');
		
		$cs = Yii::app()->getClientScript();
		$assets = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . '/assets');
		$cs->registerScriptFile($assets . '/js/jquery.jeditable.mini.js'); 	
		// ^--- old jeidtable script from 2012, works with Yii 1.1.9
		
		//$cs->registerScriptFile($assets . '/js/jquery.jeditable.js'); 	
		// ^--- new jeditable script from 2014 (GitHub), "callback" parameter did not work with Yii 1.1.9
		// ^--- cba-todo: test and use this with newest Yii version...

		parent::init();
	}

	/**
	 * Run this widget.
	 * This method registers necessary javascript and renders the needed HTML code.
	 */
	public function run()
	{
		$id = $this->id;
		$jsoptions = CJavaScript::encode($this->editable_options, true);
		
		// recursively merge `data_attr` into `options` with $.extend(true,...)
		$extend_submitdata_code = "";
		if($this->submit_data_attributes) {
			$extend_submitdata_code = "
				var data_attr = {'submitdata':{}};
				$.each($(this).data(), function(i,e) {
					data_attr['submitdata'][i] = e;
				});
				$.extend(true, options, data_attr); 
			";
		}
		
		$jscode = "function init_editable_$id() {
			$('{$this->selector}').each( function(item) {
				var url = '{$this->url}';
				var options = {$jsoptions};
				{$extend_submitdata_code}
				$(this).editable(url, options);
			});
		}";
		Yii::app()->getClientScript()->registerScript(__CLASS__ . "_$id", $jscode, CClientScript::POS_HEAD);
		
		// Register js-code that initializes editables when page has loaded and is ready
		Yii::app()->clientScript->registerScript(
			"init_editable_$id",
			"init_editable_$id(); ",
			CClientScript::POS_READY
		);
	}
}
