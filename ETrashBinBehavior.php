<?php
/**
 * ETrashBinBehavior class file.
 *
 * @author Veaceslav Medvedev <slavcopost@gmail.com>
 * @link http://code.google.com/p/yiiext/
 * @license http://www.opensource.org/licenses/mit-license.php
 */

/**
 * ETrashBinBehavior allows you to remove the model in the trash bin and restore them when need.
 *
 * @property CActiveRecord $owner
 * @method CActiveRecord getOwner()
 *
 * @author Veaceslav Medvedev <slavcopost@gmail.com>
 * @version 0.3
 * @package yiiext.behaviors.model.trashBin
 * @since 1.1.4
 */
class ETrashBinBehavior extends CActiveRecordBehavior
{
	/**
	 * @var string The name of the table where data stored.
	 * Defaults to "removed".
	 */
	public $trashFlagField = 'removed';
	/**
	 * @var mixed The value to set for removed model.
	 * Default is 1.
	 */
	public $removedFlag=1;
	/**
	 * @var mixed The value to set for restored model.
	 * Default is 0.
	 */
	public $restoredFlag=0;
	/**
	 * @var bool If except removed model in find results.
	 * Default is false.
	 */
	public $findRemoved=false;
	/**
	 * @var bool The flag to disable filter removed models in the next query.
	 */
	protected $_withRemoved=false;

	/**
	 * Set value for trash field.
	 *
	 * @param mixed $value
	 * @return CActiveRecord
	 */
	public function setTrashFlag($value)
	{
		$owner=$this->getOwner();
		$owner->setAttribute($this->trashFlagField, $value==$this->removedFlag?$this->removedFlag:$this->restoredFlag);
		
		return $owner;
	}
	/**
	 * Remove model in trash bin.
	 *
	 * @return CActiveRecord
	 */
	public function remove()
	{
		return $this->setTrashFlag($this->removedFlag);
	}
	/**
	 * Restore removed model from trash bin.
	 *
	 * @return CActiveRecord
	 */
	public function restore()
	{
		return $this->setTrashFlag($this->restoredFlag);
	}
	/**
	 * Check if model is removed in trash bin.
	 *
	 * @return bool
	 */
	public function getIsRemoved()
	{
		return $this->getOwner()->getAttribute($this->trashFlagField)==$this->removedFlag;
	}
	/**
	 * Disable excepting removed models for next search.
	 *
	 * @return CActiveRecord
	 */
	public function withRemoved()
	{
		$this->_withRemoved=true;
		return $this->getOwner();
	}
	/**
	 * Add condition to query for filter removed models.
	 *
	 * @return CActiveRecord
	 * @since 1.1.4
	 */
	public function filterRemoved()
	{
		$owner=$this->getOwner();
		$criteria=$owner->getDbCriteria();
		$column = $owner->getDbConnection()->quoteColumnName($owner->getTableAlias().'.'.$this->trashFlagField);
		$criteria->addCondition($column.'!='.CDbCriteria::PARAM_PREFIX.CDbCriteria::$paramCount);
		$criteria->params[CDbCriteria::PARAM_PREFIX.CDbCriteria::$paramCount++]=$this->removedFlag;

		return $owner;
	}
	/**
	 * Add condition before find, for except removed models.
	 *
	 * @param CEvent
	 */
	public function beforeFind($event)
	{
		if(!$this->findRemoved && !$this->_withRemoved)
			$this->filterRemoved();

		$this->_withRemoved=false;
	}
}
