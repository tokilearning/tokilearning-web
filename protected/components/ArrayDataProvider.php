<?php

/**
 * Array Data Provider class file.
 * @author			Chris Yates <chris.l.yates@gmail.com>
 * @copyright 	Copyright (c) 2010 PBM Web Development - All Rights Reserved
 * @package			arrayDataProvider
 *
 * Copyright © 2010 by PBM Web Development
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * Redistributions of source code must retain the above copyright notice, this
 * list of conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice,
 * this list of conditions and the following disclaimer in the documentation
 * and/or other materials provided with the distribution.
 *
 * Neither the name of PBM Web Development nor the names of its contributors may
 * be used to endorse or promote products derived from this software without
 * specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 */

/**
 * Array Data Provider Class.
 * The array can be an array of associative arrays:
 * <pre>
 * array(
 *   array('atomic_number'=>1, 'symbol'=>'H',  'name'=>'Hydrogen'),
 *   array('atomic_number'=>2, 'symbol'=>'He', 'name'=>'Helium'),
 *   array('atomic_number'=>3, 'symbol'=>'Li', 'name'=>'Lithium'),
 * );
 * </pre>
 * where the data is accessed using the keys of the associative arrays as
 * attribute names.
 *
 * <b>Note:</b> Attribute names (keys) <i>must be</i> valid
 * {@link http://www.php.net/manual/en/language.variables.basics.php PHP variable names}.
 *
 * The array can also be an associative array or a simple array:
 * <pre>
 * array(
 *   'H' => 'Hydrogen',
 *   'He' => 'Helium',
 *   'Li' => 'Lithium',
 * );
 * or
 * array(
 *   'Hydrogen',
 *   'Helium',
 *   'Lithium',
 * );
 * </pre>
 * where the data is accessed using the attribute names 'key' and 'value', where
 * for the simple array '_key_' will be numeric (the array is transformed
 * internally to an array of associative arrays).
 * @package			arrayDataProvider
 */
class ArrayDataProvider extends CDataProvider {

    /**
     * @var string the name of key attribute for the array. If not set,
     * it means the keys of the array will be used (Note: even for an associative
     * array the keys are numeric due to the internal translation to an array of
     * associative arrays).
     */
    public $keyAttribute;
    private $_array = array();
    private $_criteria;

    /**
     * @param array The data
     * @return ArrayDataProvider
     * @see setArray()
     */
    public function __construct($array) {
        if (!is_array($array)) {
            throw new CException(Yii::t('adp', 'Data must be an array'));
        } elseif (!empty($array)) {
            $test = array_shift($array);
            array_unshift($array, $test);
            if (!is_array($test)) {
                $_array = array();
                foreach ($array as $key => $value) {
                    $_array['key'] = $key;
                    $_array['value'] = $value;
                } // foreach
                $array = $_array;
            }
            $this->_array = $array;

            $this->sort = new ArraySort(array_keys(array_shift($array)));
        }
    }

    /**
     * @return CDbCriteria the query criteria
     */
    public function getCriteria() {
        if ($this->_criteria === null)
            $this->_criteria = new CDbCriteria;
        return $this->_criteria;
    }

    /**
     * @return CDbCriteria the query criteria
     */
    public function getArray() {
        return $this->_array;
    }

    /**
     * @param mixed the query criteria. This can be either a CDbCriteria object or
     * an array representing the criteria.
     */
    public function setCriteria($value) {
        $this->_criteria =
                $value instanceof CDbCriteria ? $value : new CDbCriteria($value);
    }

    /**
     * Fetches the data.
     * @return array list of data items
     */
    protected function fetchData() {
        $criteria = clone $this->getCriteria();
        if (($pagination = $this->getPagination()) !== false) {
            $pagination->setItemCount($this->getTotalItemCount());
            $pagination->applyLimit($criteria);
        }
        if (($sort = $this->getSort()) !== false) {
            $sort->applyOrder($criteria);
            $this->sort($criteria->order);
        }

        return array_slice($this->_array, $criteria->offset, $criteria->limit);
    }

    /**
     * Fetches the data item keys.
     * @return array list of data item keys.
     */
    protected function fetchKeys() {
        $data = $this->fetchData();
        if (isset($this->keyAttribute)) {
            $keys = array();
            foreach ($data as $datum) {
                $keys[] = $datum[$this->keyAttribute];
            } // foreach
        } else {
            $keys = array_keys($data);
        }
        return $keys;
    }

    /**
     * Calculates the total number of data items.
     * @return integer the total number of data items.
     */
    protected function calculateTotalItemCount() {
        return count($this->array);
    }

    /**
     * Sorts the array according to the criteria
     * @param string The keys to sort by
     */
    private function sort($orders) {
        if (!empty($orders)) {
            $orders = explode(',', $orders);
            $directions = $attributes = array();
            foreach ($orders as $orderBy) {
                $orderBy = explode(' ', $orderBy);
                $attributes[] = $orderBy[0];
                $directions[] = (isset($orderBy[1]) ? SORT_DESC : SORT_ASC);
            } // foreach

            $sortArgs = array();
            foreach ($attributes as $index => $attribute) {
                $$attribute = array();
                foreach ($this->_array as $key => $row) {
                    ${$attribute}[$key] = $row[$attribute];
                }
                $sortArgs[] = &$$attribute;
                $sortArgs[] = &$directions[$index];
            } // foreach
            $sortArgs[] = &$this->_array;
            call_user_func_array('array_multisort', $sortArgs);
        }
    }

}
