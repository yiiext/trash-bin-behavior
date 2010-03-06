CTrashBinBehavior
=================

Добавляет возможность удалять модели в корзину и восстанавливать их.

Установка и настройка
---------------------

### Подготовка модели
В модели должен быть выделен атрибут для статуса удаления.

### Подключить поведение к модели

~~~
[php]
function behaviors() {
    return array(
        'trash' => array(
            'class' => 'ext.yiiext.behaviors.model.trashBin.ETrashBinBehavior',
            // Имя столбца где хранится статус удаления (обязательное свойство)
            'trashFlagField' => 'trash',
            // Значение которое устанавливается при удалении в поле $trashFlagField
            // По умолчанию 1
            'removedFlag' => '1',
            // Значение которое устанавливается при восстановлении в поле $trashFlagField
            // По умолчанию 0
            'restoredFlag' => '0',
        )
    );
}
~~~

### Минимальные требования
[Yii Framework 1.0.12](http://www.yiiframework.com/)

Методы
------

### remove()
Удаляем модель в корзину.

~~~
[php]
$user = User::model()->findByPk(1);
$user->remove();
~~~

### restore()
Восстанавливаем модель из корзины.

~~~
[php]
// Так как при поиске удаленные модели игнорируются,
// нужно на время поиска выключить поведение
User::model()->disableBehavior('trash');

$user = User::model()->findByPk(1);
$user->restore();


// Включаем снова поведение.
User::model()->enableBehavior('trash');
~~~

### isRemoved()
Проверяем удалена ли модель.

~~~
[php]
User::model()->disableBehavior('trash');
$users = User::model()->findAll();
foreach ($users as $user) {
  echo $user->isRemoved() ? 'status=removed' : 'status=normal';
}
User::model()->enableBehavior('trash');
~~~

### withRemoved()
Отключаем исключения удаленных записей из поиска.

~~~
[php]
$users = User::model()->withRemoved()->findAll();
~~~

Подсказка
---------
При включенном поведении при поиске игнорируются модели со статусом удаления,
поэтому если нужно найти модели включая модели из корзины, нужно выключить
на время поиска поведение.
