<?php
/**
 * \TestPost class file.
 *
 * @author Veaceslav Medvedev <slavcopost@gmail.com>
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

/**
 * Class TestPost
 *
 * Attributes:
 * @property int $id
 * @property string $title
 * @property int $user_id
 * @property bool $removed
 *
 * Relations:
 * @property TestUser $user
 *
 * Behaviors:
 * @method \TestPost remove()
 * @method \TestPost restore()
 * @method \TestPost withRemoved()
 *
 * Core
 * @method \TestPost find()
 * @method \TestPost findByPk()
 *
 * @author Veaceslav Medvedev <slavcopost@gmail.com>
 * @version 0.1
 */
class TestPost extends CActiveRecord
{
	/**
	 * @param string $className
	 * @return \TestPost
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'post';
	}

	public function behaviors()
	{
		return array(
			'trash' => array(
				'class' => 'ETrashBinBehavior',
			),
		);
	}

	public function relations()
	{
		return array(
			'user' => array(self::BELONGS_TO, 'TestUser', 'user_id'),
		);
	}

	public function rules()
	{
		return array(
			array('title', 'required'),
		);
	}
}