CTrashBinBehavior
=================

Adds an ability to mark model as deleted and restore it when needed.

Installing and configuring
--------------------------

### Preparing model

There should be an attribute in the model to store deletion flag. For example, "isRemoved".

### Attaching behavior

~~~
[php]
function behaviors()
{
	return array(
		'trash'=>array(
			'class'=>'ext.yiiext.behaviors.model.trashBin.ETrashBinBehavior',
			// Deletion flag table column name (required)
			'trashFlagField'=>'isRemoved',
			// Value that is written to $trashFlagField when model is deleted
			// Default is 1
			'removedFlag'=>1,
			// Value that is written to $trashFlagField when model is restored
			// Default is 0
			'restoredFlag'=>0,
		),
	);
}
~~~

### Requirements
[Yii Framework 1.1.4](http://www.yiiframework.com/)

API
---

### remove()
Mark model as deleted.

~~~
[php]
$user=User::model()->findByPk(1);
$user->remove();
~~~

### restore()
Restore deleted model.

~~~
[php]
// Since deleted models are ignored by default we have to show all models:
User::model()->withRemoved();
// or just turn off behavior completely
User::model()->disableBehavior('trash');

$user=User::model()->findByPk(1);

// if you turned behavior off, don't forget to turn it back on
User::model()->enableBehavior('trash');

$user->restore();
~~~

### getIsRemoved()
Tells if model is marked as deleted.

~~~
[php]
$user1=User::model()->withRemoved()->findByPk(1);
echo $user1->getIsRemoved() ? 'status=removed' : 'status=normal';
$user2=User::model()->withRemoved()->findByPk(2);
echo $user2->isRemoved ? 'status=removed' : 'status=normal';
}
~~~

### withRemoved()
Allows to search for deleted models.

~~~
[php]
$users=User::model()->withRemoved()->findAll();
~~~