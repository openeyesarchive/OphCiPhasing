<?php
/**
 * OpenEyes
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2013
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2008-2011, Moorfields Eye Hospital NHS Foundation Trust
 * @copyright Copyright (c) 2011-2013, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */

/**
 * This is the model class for table "ophciphasing_reading".
 *
 * @property integer $id
 * @property integer $element_id
 * @property integer $side
 * @property integer $value
 * @property string $measurement_timestamp

 */
class OphCiPhasing_Reading extends BaseActiveRecord
{
	const RIGHT = 0;
	const LEFT = 1;

	/**
	 * Returns the static model of the specified AR class.
	 * @return OphCiPhasing_Reading the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ophciphasing_reading';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
				array('side, value, measurement_timestamp', 'required'),
				array('value', 'numerical'),
				array('id, element_id, side, value, measurement_timestamp', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
				'element' => array(self::BELONGS_TO, 'Element_OphCiPhasing_IntraocularPressure', 'element_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
				'id' => 'ID',
				'element_id' => 'Element',
				'value' => 'Reading',
				'measurement_timestamp' => 'Time',
				'side' => 'Side',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id,true);
		return new CActiveDataProvider(get_class($this), array(
				'criteria'=>$criteria,
		));
	}

	/**
	 * check the time entry is valid
	 *
	 * @return bool
	 */
	public function beforeValidate()
	{
		if (!preg_match("/^(([01]?[0-9])|(2[0-3])):?[0-5][0-9]$/", $this->measurement_timestamp)) {
			$this->addError('measurement_timestamp','Invalid ' . $this->getAttributeLabel('measurement_timestamp'));
		}
		return parent::beforeValidate();
	}
}
