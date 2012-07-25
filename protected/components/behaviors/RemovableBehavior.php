<?php

/**
 * 
 * RemovableBehavior is a behavior class to give active records behavior to flag
 * a record as removed.
 * 
 * @property CActiveRecord $owner The owner active record that this behavior is attached to.
 * @property boolean $enabled Whether this behavior is enabled.
 * 
 * @author Petra Barus <petra.barus@gmail.com>
 * @package application.components.behaviors
 */
class RemovableBehavior extends CBehavior {

        /**
         * Constants of the flags.
         */
        const IS_NOT_REMOVED = 0;
        const IS_REMOVED = 1;

        /**
         * @var string the attribute name that stores the remove flag.
         */
        public $flagAttribute = 'isRemoved';

        /**
         *
         * @var string the attribute name that stores
         */
        public $flaggedTimeAttribute = 'removedTime';

        /**
         * Trash the owner.
         * This will mark the flag attribute of the {@link owner} as removed 
         * and update the flagged time attribute as current time.
         * @return boolean whether the operation is successful.
         */
        public function trash() {
                $this->owner->setAttribute($this->flagAttribute, self::IS_REMOVED);
                $this->owner->setAttribute($this->flaggedTimeAttribute, new CDbExpression('NOW()'));
                $this->owner->saveAttributes(array($this->flagAttribute, $this->flaggedTimeAttribute));
                return true;
        }

        /**
         * Trash the owner.
         * This will mark the flag attribute of the {@link owner} as unremoved 
         * and update the flagged time attribute as null.
         * @return boolean whether the operation is successful.
         */
        public function untrash() {
                $this->owner->setAttribute($this->flagAttribute, self::IS_NOT_REMOVED);
                $this->owner->setAttribute($this->flaggedTimeAttribute, new CDbExpression('NULL'));
                $this->owner->saveAttributes(array($this->flagAttribute, $this->flaggedTimeAttribute));
                return true;
        }

}