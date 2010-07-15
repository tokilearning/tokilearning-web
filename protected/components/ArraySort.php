<?php

/**
 * ArraySort class file.
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
 * ArraySort represents information relevant to sorting arrays.
 *
 * When data needs to be sorted according to one or several attributes,
 * we can use ArraySort to represent the sorting information and generate
 * appropriate hyperlinks that can lead to sort actions.
 *
 * When creating an ArraySort instance, you need to specify {@link keys} of the
 * array. You can use ArraySort to generate hyperlinks by calling {@link link}.
 * You can also use ArraySort to modify a {@link CDbCriteria} instance by
 * calling {@link applyOrder} so that it can cause the query results to be
 * sorted according to the specified attributes.
 *
 * @author			Chris Yates <chris.l.yates@gmail.com>
 * @copyright 	Copyright (c) 2010 PBM Web Development - All Rights Reserved
 * @package			arrayDataProvider
 */
class ArraySort extends CSort {

    /**
     * @var array List of keys in the array.
     */
    public $keys;
    /**
     * @var array list of attributes that are allowed to be sorted.
     * By default, this property is an empty array, which means all attributes in
     * the array are allowed to be sorted.
     *
     * Note: attribute names may not contain spaces and should not contain '-' or
     * '.' characters because they are used as {@link separators}.
     */
    public $attributes = array();
    private $_directions;

    /**
     * Constructor.
     * @param array The keys (attributes) of the data.
     */
    public function __construct($keys) {
        $this->keys = $keys;
    }

    /**
     * @return string The order-by keys represented by this sort object.
     */
    public function getOrderBy() {
        $directions = $this->getDirections();
        if (empty($directions))
            return $this->defaultOrder;
        else {
            $orders = array();
            foreach ($directions as $attribute => $descending) {
                $definition = $this->resolveAttribute($attribute);
                if (is_array($definition)) {
                    if (isset($definition['asc'], $definition['desc']))
                        $orders[] = $descending ? $definition['desc'] : $definition['asc'];
                    else
                        throw new CException(Yii::t('yii', 'Virtual attribute {name} must specify "asc" and "desc" options.', array('{name}' => $attribute)));
                }
                else if ($definition !== false)
                    $orders[] = $definition . ($descending ? ' DESC' : '');
            }
            return implode(', ', $orders);
        }
    }

    /**
     * Resolves the attribute label for the specified attribute.
     * @param string the attribute name.
     * @return string the attribute label
     */
    public function resolveLabel($attribute) {
        return CModel::generateAttributeLabel($attribute);
    }

    /**
     * Returns the real definition of an attribute given its name.
     * The resolution is based on {@link attributes} and {@link keys}.
     * When {@link attributes} is an empty array, if the name refers to a key of
     * the array and the name is returned back.
     * When {@link attributes} is not empty, if the name refers to an attribute
     * declared in {@link attributes} the corresponding virtual attribute
     * definition is returned.
     * In all other cases, false is returned, meaning the name does not refer to a
     * valid attribute.
     * @param string the attribute name that the user requests to sort on
     * @return mixed the attribute name or the virtual attribute definition.
     * False if the attribute cannot be sorted.
     */
    public function resolveAttribute($attribute) {
        if ($this->attributes !== array())
            $attributes = $this->attributes;
        else if ($this->keys !== null)
            $attributes = $this->keys;
        else
            return false;
        foreach ($attributes as $name => $definition) {
            if (is_string($name)) {
                if ($name === $attribute)
                    return $definition;
            }
            else if ($definition === $attribute)
                return $attribute;
        }
        return false;
    }

}