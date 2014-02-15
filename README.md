Yii EJEditable Extension
==============================

_EJEditable_ is a Yii extension wrapping the jQuery Plugin [Jeditable](https://github.com/tuupola/jquery_jeditable "Jeditable on GitHub") from 
[Mika Tuupola](https://github.com/tuupola "Mika Tuupola on GitHub"). 
Jeditable is an inplace editor plugin that allows you to click and edit the contents of various html elements.



###Requirements
Tested with Yii 1.1.9, should work with Yii 1.1 or above.

###Usage

#### Files
Extract the zip file and place the contents inside your `protected/extensions` folder.

#### Usage Example 1 (Basic)
Call the widget in your view file that contains the editable elements to be.
In our example the file `protected/views/category/view.php` contains elements with the class `editable`, 
which we want to make editable. For this we put the following code into the view file:
```php
Yii::app()->clientScript->registerCoreScript('jquery');
$this->widget('ext.EJEditable.EJEditable', array(
	'selector'=>'.editable',
	'url'=>Yii::app()->createUrl('category/updateAttribute'),
));
```

- `selector`: a jQuery selector that is used to identify the elements that are to be made editable.
See the [jQuery Documentation](http://api.jquery.com/category/selectors/ "jQuery - Selectors") for a list of possible selectors.
- `url`: the url to the action that handles the POST request and updates the attribute.

This extension provides the action 'UpdateAttributeAction' that we can use in the file `ptotected/controllers/CategoryController.php` like this:
```
public function actions()
{
	...,
	'updateAttribute' => array(
		'class' => 'ext.EJEditable.actions.UpdateAttributeAction',
	),
  );
}
```

Of course you can implement and use your own action to handle the POST request.


###Resources
* [Yii Extension Page](http://www.yiiframework.com/extension/ejeditable/ "ejeditable - Yii Extension Page")
* [GitHub Page](https://github.com/c-cba/yii-ejeditable "yii-ejeditable - GitHub Page")
