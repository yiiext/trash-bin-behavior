CTrashBinBehavior
=================

Добавляет возможность удалять модели в корзину и восстанавливать их.

Установка и настройка
---------------------

### Подготовка модели
В модели должен быть выделен атрибут для статуса удаления.
Например: "isRemoved"

### Подключить поведение к модели

~~~
[php]
function behaviors()
{
	return array(
		'trash'=>array(
			'class'=>'ext.yiiext.behaviors.model.trashBin.ETrashBinBehavior',
			// Имя столбца где хранится статус удаления (обязательное свойство)
			'trashFlagField'=>'isRemoved',
			// Значение которое устанавливается при удалении в поле $trashFlagField
			// По умолчанию 1
			'removedFlag'=>1,
			// Значение которое устанавливается при восстановлении в поле $trashFlagField
			// По умолчанию 0
			'restoredFlag'=>0,
		),
	);
}
~~~

### Минимальные требования
[Yii Framework 1.1.4](http://www.yiiframework.com/)

API
---

### remove()
Удаляем модель в корзину.

~~~
[php]
$user=User::model()->findByPk(1);
$user->remove();
~~~

### restore()
Восстанавливаем модель из корзины.

~~~
[php]
// Так как при включенном поведении удаленные модели игнорируются,
// нужно включить поиск удаленных моделей
User::model()->withRemoved();
// или на время поиска выключить поведение
User::model()->disableBehavior('trash');

$user=User::model()->findByPk(1);

// Включаем снова поведение если выключали.
User::model()->enableBehavior('trash');

$user->restore();
~~~

### getIsRemoved()
Проверяем удалена ли модель в корзину.

~~~
[php]
$user1=User::model()->withRemoved()->findByPk(1);
echo $user1->getIsRemoved() ? 'status=removed' : 'status=normal';
$user2=User::model()->withRemoved()->findByPk(2);
echo $user2->isRemoved ? 'status=removed' : 'status=normal';
}
~~~

### withRemoved()
Включаем поиск удаленных записей только при следующем запросе.

~~~
[php]
$users=User::model()->withRemoved()->findAll();
~~~