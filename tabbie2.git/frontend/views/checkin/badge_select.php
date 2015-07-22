<?php
	/**
	 * badge_select.php File
	 *
	 * @package  Tabbie2
	 * @author   jareiter
	 * @version
	 */
	use kartik\widgets\ActiveForm;
	use kartik\helpers\Html;

	$this->title = Yii::t('app', 'Generate Badges');
	/** @var \common\models\Tournament $tournament */
	$tournament = $this->context->_getContext();
	$this->params['breadcrumbs'][] = ['label' => $tournament->fullname, 'url' => ['tournament/view', "id" => $tournament->id]];
	$this->params['breadcrumbs'][] = $this->title;
?>
<div id="barcodeForm">
	<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

	<? if ($tournament->badge): ?>
		<div class="row">
			<div class="col-xs-12">
				<img src="<?= $tournament->getBadge() ?>" width="300px">
			</div>
		</div>
	<? endif; ?>

	<div class="row">
		<div class="col-xs-2">
			<?= Html::label("Badge Background:", "badge"); ?>
		</div>
		<div class="col-xs-10">
			<?= Html::fileInput("badge", '') ?>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-2">
			<?= Html::label("Use Background:", "use"); ?>
		</div>
		<div class="col-xs-10">
			<?= Html::checkbox("use", true) ?>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-2">
			<?= Html::label("Paper Format", "paper"); ?>
		</div>
		<div class="col-xs-10">
			<?= Html::dropDownList("paper", "A6", ["A4" => "A4 (2x2)", "A6" => "A6 (1)"]) ?>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-2">
			<?= Html::label("Paper Margin", "margin"); ?>
		</div>
		<div class="col-xs-10">
			<?= Html::textInput("margin", "4") ?>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-2">
			<?= Html::label("Paper Border CSS", "border"); ?>
		</div>
		<div class="col-xs-10">
			<?= Html::textInput("border", "1px solid white") ?>
		</div>
	</div>
	<br>

	<div class="form-group">
		<?= Html::submitButton(Yii::t('app', 'Print Badges'),
			[
				'class' => 'btn btn-success',
			]) ?>
	</div>
	<?php ActiveForm::end(); ?>
</div>