<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "in_society".
 *
 * @property integer $user_id
 * @property integer $society_id
 * @property string  $starting
 * @property string  $ending
 * @property Society $society
 * @property User    $username
 */
class InSociety extends \yii\db\ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'in_society';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['user_id', 'society_id', 'starting'], 'required'],
			[['user_id', 'society_id'], 'integer'],
			[['starting', 'ending'], 'safe']
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'user_id'    => Yii::t('app', 'User') . ' ' . Yii::t('app', 'ID'),
			'society_id' => Yii::t('app', 'Society') . ' ' . Yii::t('app', 'ID'),
			'starting'   => Yii::t('app', 'Starting'),
			'ending'     => Yii::t('app', 'Ending'),
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getSociety()
	{
		return $this->hasOne(Society::className(), ['id' => 'society_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUser()
	{
		return $this->hasOne(User::className(), ['id' => 'user_id']);
	}

}
