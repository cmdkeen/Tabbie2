<?php

namespace common\models;

use kartik\checkbox\CheckboxX;
use kartik\rating\StarRating;
use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/**
 * This is the model class for table "answer".
 *
 * @property integer    $id
 * @property integer    $question_id
 * @property integer    $feedback_id
 * @property string     $value
 * @property Question   $question
 * @property Feedback[] $feedback
 */
class Answer extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'answer';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['question_id', 'feedback_id'], 'required'],
			[['question_id', 'feedback_id'], 'integer'],
			[['value'], 'string']
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id'          => Yii::t('app', 'Answer') . ' ' . Yii::t('app', 'ID'),
			'feedback_id' => Yii::t('app', 'Feedback') . ' ' . Yii::t('app', 'ID'),
			'question_id' => Yii::t('app', 'Question') . ' ' . Yii::t('app', 'ID'),
			'value'       => Yii::t('app', 'Value'),
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getQuestion()
	{
		return $this->hasOne(Question::className(), ['id' => 'question_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getFeedback()
	{
		return $this->hasOne(Feedback::className(), ['id' => 'feedback_id']);
	}

	public function renderLabel($group, $q_id)
	{
		return '<label class="control-label" for="' . Html::encode($this->getName($group, $q_id)) . '">' . Html::encode($this->question->text) . '</label>';
	}

	public function getName($group, $q_id)
	{
		return "Answer[" . $group . "][" . $q_id . "]";
	}

	/**
	 * @param ActiveForm $form
	 *
	 * @return string
	 */
	public function renderField($group, $q_id)
	{
		//<input id="answer-value" class="form-control" name="Answer[value]" type="text">
		$element = null;
		switch ($this->question->type) {
			case Question::TYPE_INPUT:
				$element = Html::textInput($this->getName($group, $q_id), $this->value, [
					"class" => "form-control",
				]);
				break;
			case Question::TYPE_NUMBER:
				$element = MaskedInput::widget([
					'name' => $this->getName($group, $q_id),
					'mask'          => '9',
					"class"         => "form-control",
					'clientOptions' => ['repeat' => 2, 'greedy' => false]
					/** @todo Make repeat aka digits variable */
				]);
				break;
			case Question::TYPE_TEXT:
				$element = Html::textarea($this->getName($group, $q_id), $this->value, [
					"class" => "form-control",
				]);
				break;
			case Question::TYPE_STAR:
				$element = StarRating::widget([
					"name" => $this->getName($group, $q_id),
					"id"   => "Answer_$group" . "_$q_id",
					"pluginOptions" => [
						"stars" => 5,
						"min"   => 0,
						"max"   => 5,
						"step"  => 1,
						"size"  => "md",
					],
				]);
				break;
			case Question::TYPE_CHECKBOX:
				$selection = json_decode($this->question->param);
				$element = Html::checkboxList("Answer[$group][" . $q_id . "]", null, $selection, [
					"id" => "Answer_$group" . "_" . $q_id,
					'class' => 'checkboxlist',
					'itemOptions' => [],
				]);
				break;
		}

		return $element;
	}

	public function renderHelp()
	{
		$element = "";
		if (isset($this->question->help)) {
			$element = Html::tag("p", $this->question->help, [
					"class" => "help-block"
			]);
		}
		return $element;
	}
}
