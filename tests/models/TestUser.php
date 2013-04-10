<?php
/**
 * TestUser class file.
 *
 * @author Veaceslav Medvedev <slavcopost@gmail.com>
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

/**
 * Class TestUser
 *
 * @property int $id
 * @property string $name
 *
 * Relations:
 * @property TestPost[] $posts
 *
 * Core
 * @method \TestUser with()
 * @method \TestUser find()
 * @method \TestUser findByPk()
 *
 * @author Veaceslav Medvedev <slavcopost@gmail.com>
 * @version 0.1
 */
class TestUser extends CActiveRecord
{
	/**
	 * @param string $className
	 * @return \TestUser
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'user';
	}

	public function relations()
	{
		return array(
			'posts' => array(self::HAS_MANY, 'TestPost', 'user_id'),
		);
	}
}