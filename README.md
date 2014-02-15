Yii EJEditable Extension
==============================

(Work in progress...)<br>
_EJEditable_ is a Yii extension wrapping the jQuery Plugin [Jeditable](https://github.com/tuupola/jquery_jeditable "Jeditable on GitHub") from 
[Mika Tuupola](https://github.com/tuupola "Mika Tuupola on GitHub"). 
Jeditable is an inplace editor plugin that allows you to click and edit the contents of various html elements.



###Requirements
Tested with Yii 1.1.9, should work with Yii 1.1 or above.

###Usage

#### Files
Extract the zip file and place the contents inside your `protected/extensions` folder.

#### Usage Example 1 (basic - with textfield)
Call the widget in your view file that contains the editable elements to be.
In our example the file `protected/views/category/view.php` contains elements with the class _editable_, 
which we want to make editable. For this we place the following code into the view file:
```php
Yii::app()->clientScript->registerCoreScript('jquery');
$this->widget('ext.EJEditable.EJEditable', array(
	'selector'=>'.editable',
	'url'=>Yii::app()->createUrl('category/updateAttribute'),
	'options'=>array(
		'indicator'=>CHtml::image(Yii::app()->createUrl('my_assets/images/indicator.gif')),
	)
));
```

- `selector`: a jQuery selector that is used to identify the elements that are to be made editable.
See the [jQuery Documentation](http://api.jquery.com/category/selectors/ "jQuery - Selectors") for a list of possible selectors.
- `url`: the url to the action that handles the POST request and updates the attribute.
- `options`: additional options for the Jeditable plugin. 
For a list of possible options see the [Jeditable Project Page](http://www.appelsiini.net/projects/jeditable "Jeditable - Project Page").

This extension provides the action 'UpdateAttributeAction' that we can use in the controller `ptotected/controllers/CategoryController.php` to handle the POST request:
```php
public function actions()
{
	...,
	'updateAttribute' => array(
		'class' => 'ext.EJEditable.actions.UpdateAttributeAction',
	),
  );
}
```

Of course you can implement and use your own action to handle the POST request.<br>
Note: Don't forget to add the action to the `accessRules()` in your controller.


#### Usage Example 2 (with dropDown)
To use a dropdown for edıtıng, we initiate the widget with the following additional options:
```php
$this->widget('ext.EJEditable.EJEditable', array(
	'selector'=>'.editable',
	'url'=>Yii::app()->createUrl('category/updateAttribute'),
	'options'=>array(
		'data'=> "'1':'Category 1', '2':'Category 2', '3':'Category 3', 'selected':'2'",
		'type'=>'select',
		'submit'=>'OK',
	)
));

Note the last entry. With value of ‘selected’ in array you can tell Jeditable which option should be selected by default.

#### Usage Example 3 (in CGridView)

We can make the cells in a CGridView editable in the following way:
```php
// Initialize the widget
$this->widget('ext.EJEditable.EJEditable', array(
	'url'=>url('category/updateAttribute'),
	'selector'=>'.editable_column',
));
// The CGridView:
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'category-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'afterAjaxUpdate'=>'js:function(id, data) { init_editable(".editable_column"); }', // make cells editable again
	'columns'=>array(
		'id',
		'name'=>array(
			'class'=>'ext.EJEditable.components.DataColumn',
			'name'=>'name',
			'evaluateHtmlOptions'=>true,
			'htmlOptions'=>array('class'=>'"editable_column"', 'data-attribute'=>'"name"', 'id'=>'"{$data->id}"'),
		),
		'description'=>array(
			'class'=>'ext.EJEditable.components.DataColumn',
			'name'=>'description',
			'evaluateHtmlOptions'=>true,
			'htmlOptions'=>array('class'=>'"editable_column"', 'data-attribute'=>'"description"', 'id'=>'"{$data->id}"'),
		),
		...
	),
));
```

###Resources
* [Yii Extension Page](http://www.yiiframework.com/extension/ejeditable/ "ejeditable - Yii Extension Page")
* [GitHub Page](https://github.com/c-cba/yii-ejeditable "yii-ejeditable - GitHub Page")
* [Jeditable Project Page](http://www.appelsiini.net/projects/jeditable "Jeditable - Project Page")
* [Jeditable Demo Page](http://www.appelsiini.net/projects/jeditable/default.html "Jeditable - Demo Page")
