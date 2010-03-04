<?php
/**
 * CTrashBinBehavior class file.
 *
 * Trash bin behavior for models.
 *
 * @author Veaceslav Medvedev <slavcopost@gmail.com>
 * @link http://code.google.com/p/yiiext/source/browse/#svn/trunk/app/extensions/CTrashBinBehavior
 *
 * @version 0.1
 */
class CTrashBinBehavior extends CActiveRecordBehavior {
    /**
     * @var string The name of the table where data stored.
     * Required to set on init behavior. No defaults.
     */
    public $trashFlagField = NULL;
    /**
     * @var mixed The value to set for removed model.
     * Default is 1.
     */
    public $removedFlag = 1;
    /**
     * @var mixed The value to set for restored model.
     * Default is 0.
     */
    public $restoredFlag = 0;
    /**
     * @var bool If except removed model in find results.
     * Default is FALSE
     */
    public $findRemoved = FALSE;

    protected $withRemoved = FALSE;

    public function attach($owner) {
        // Check required var trashFlagField
        if (!is_string($this->trashFlagField) || empty($this->trashFlagField)) {
            throw new CException(Yii::t('CEAV', 'Required var "{class}.{property}" not set.',
                array('{class}' => get_class($this), '{property}' => 'trashFlagField')));
        }
        parent::attach($owner);
    }

    /**
     * Remove model in trash bin.
     *
     * @return CActiveRecord
     */
    public function remove() {
        $this->getOwner()->{$this->trashFlagField} = $this->removedFlag;
        return $this->getOwner();
    }
    
    /**
     * Restore removed model from trash bin.
     *
     * @return CActiveRecord
     */
    public function restore() {
        $this->getOwner()->{$this->trashFlagField} = $this->restoredFlag;
        return $this->getOwner();
    }

    /**
     * Check if model is removed in trash bin.
     *
     * @return bool
     */
    public function isRemoved() {
        return $this->getOwner()->{$this->trashFlagField} == $this->removedFlag;
    }

    /**
     * Disable excepting removed models for next search.
     *
     * @return CActiveRecord
     */
    public function withRemoved() {
        $this->withRemoved = TRUE;
        return $this->getOwner();
    }

    /**
     * Add condition to query for filter removed models.
     *
     * @return CActiveRecord
     */
    public function filterRemoved() {
        $this->getOwner()
            ->getDbCriteria()
            ->addCondition($this->trashFlagField . ' != "' . $this->removedFlag . '"');
        return $this->getOwner();
    }

    /**
     * Add condition before find, for except removed models.
     *
     * @param CEvent
     */
    public function beforeFind(CEvent $event) {
        if ($this->getEnabled() && !$this->findRemoved && !$this->withRemoved) {
            $this->filterRemoved();
        }
        !$this->withRemoved || $this->withRemoved = FALSE;
        parent::beforeFind($event);
    }
    
}
