<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "adjudicator".
 *
 * @property integer              $id
 * @property integer              $tournament_id
 * @property integer              $active
 * @property integer              $user_id
 * @property integer              $strength 0-9
 * @property integer              $society_id
 * @property integer              $can_chair
 * @property integer              $are_watched
 * @property Tournament           $tournament
 * @property User                 $user
 * @property Society              $society
 * @property AdjudicatorInPanel[] $adjudicatorInPanels
 * @property Panel[]              $panels
 * @property Team[]               $teams
 */
class Adjudicator extends \yii\db\ActiveRecord {

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return 'adjudicator';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['tournament_id', 'user_id', 'society_id'], 'required'],
			[['tournament_id', 'active', 'user_id', 'strength', 'can_chair', 'are_watched', 'society_id'], 'integer']
		];
	}

	/**
	 * @inheritdoc
	 * @return CommentQuery
	 */
	public static function find() {
		return new VTAQuery(get_called_class());
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'id' => Yii::t('app', 'ID'),
			'tournament_id' => Yii::t('app', 'Tournament ID'),
			'active' => Yii::t('app', 'Active'),
			'user_id' => Yii::t('app', 'User ID'),
			'strength' => Yii::t('app', 'Strength'),
			'societyName' => Yii::t('app', 'Society Name'),
			'can_chair' => Yii::t('app', 'can Chair'),
			'are_watched' => Yii::t('app', 'are Watched'),
			'society_id' => Yii::t('app', 'Society'),
		];
	}

	public function getName() {
		return $this->user->name;
	}

	public function getSocietyName() {
		return $this->society->fullname;
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getTournament() {
		return $this->hasOne(Tournament::className(), ['id' => 'tournament_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUser() {
		return $this->hasOne(User::className(), ['id' => 'user_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getAdjudicatorInPanels() {
		return $this->hasMany(AdjudicatorInPanel::className(), ['adjudicator_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getStrikedTeams() {
		return $this->hasMany(Team::className(), ['id' => 'team_id'])
		            ->viaTable('team_strike', ['adjudicator_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getStrikedAdjudicators() {
		return $this->hasMany(Adjudicator::className(), ['id' => 'adjudicator_id'])
		            ->viaTable('adjudicator_strike', ['adjudicator_id1' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getPanels() {
		return $this->hasMany(Panel::className(), ['id' => 'panel_id'])
		            ->viaTable('adjudicator_in_panel', ['adjudicator_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getInSocieties() {
		return $this->hasMany(InSociety::className(), ['id' => 'user_id']);
	}

	public function getSociety() {
		return $this->hasOne(Society::className(), ['id' => 'society_id']);
	}

	/**
	 * @param type $id
	 *
	 * @return type
	 */
	public static function translateStrength($id = null) {
		$table = [
			0 => Yii::t("app", 'Not Rated'),
			1 => Yii::t("app", 'Bad Judge'),
			2 => Yii::t("app", 'Can Judge'),
			3 => Yii::t("app", 'Decent Judge'),
			4 => Yii::t("app", 'Average Judge'),
			5 => Yii::t("app", 'High Potential'),
			6 => Yii::t("app", 'Chair'),
			7 => Yii::t("app", 'Good Chair'),
			8 => Yii::t("app", 'Breaking Chair'),
			9 => Yii::t("app", 'Chief Adjudicator'),
		];
		return ($id !== null) ? $table[$id] : $table;
	}

	public static function starLabels($id = null) {
		$table = [
			0 => "label label-danger",
			1 => "label label-danger",
			2 => "label label-warning",
			3 => "label label-warning",
			4 => "label label-info",
			5 => "label label-info",
			6 => "label label-primary",
			7 => "label label-primary",
			8 => "label label-success",
			9 => "label label-success",
		];

		return ($id !== null) ? $table[$id] : $table;
	}

	public static function getCSSStrength($id = null) {
		return "st" . $id;
	}

	/**
	 * Sort comparison function based on strength
	 *
	 * @param Adjudicator $a
	 * @param Adjudicator $b
	 *
	 * @return boolean
	 */
	public static function compare_strength($a, $b) {
		$as = $a->strength;
		$bs = $b->strength;
		return ($as < $bs) ? 1 : (($as > $bs) ? -1 : 0);
	}

}
