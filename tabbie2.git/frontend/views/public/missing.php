<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\TournamentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Missing User');
$tournament = $this->context->_getContext();
$this->params['breadcrumbs'][] = ['label' => $tournament->fullname, 'url' => ['tournament/view', "id" => $tournament->id]];
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS
$.pjax.defaults.timeout = false;
$("#pjax_poll").on("pjax:end", function() {
   setTimeout(function(){ reload(); }, 10000)
});
function reload()
{
    $.pjax.reload({container:"#pjax_poll"});
};
setTimeout(function(){ reload(); }, 10000)
JS;

$this->registerJs($script
);

if ($tournament->isTabMaster(Yii::$app->user->id)) {
	$this->context->menuItems = [
		['label' => \kartik\helpers\Html::icon("refresh") . "&nbsp;" . 'Reload', 'url' => 'javascript:reload()'],
		['label' => \kartik\helpers\Html::icon("fire") . "&nbsp;" . Yii::t("app", 'Mark missing as inactive'), 'url' => ["public/mark-missing", "tournament_id" => $tournament->id, "accessToken" => $tournament->accessToken], "linkOptions" => ["class" => ""]],
	];
}

?>

<? \yii\widgets\Pjax::begin(["id" => "pjax_poll"]) ?>
	<div id="tournament-missing">
		<div class="row">
			<div class="col-xs-12 text-center">
				<h1>Missing Participants</h1>

				<p>If you are on this list, this means you are not checked in and you will NOT be on the draw!</p>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6 text-center">
				<table class="table">
					<tr>
						<th colspan="2" class="text-center"><?= Yii::t("app", "Speakers") ?></th>
					</tr>
					<? foreach ($teams as $team): ?>
						<tr>
							<?
							if (isset($team->speakerA->name)) {
								echo '<td>' . Html::a($team->speakerA->name, ["user/view", "id" => $team->speakerA->id]) . '</td>';
							}
							if (isset($team->speakerB->name)) {
								echo '<td>' . Html::a($team->speakerB->name, ["user/view", "id" => $team->speakerB->id]) . '</td>';
							}
							?>
						</tr>
					<? endforeach; ?>
				</table>
			</div>
			<div class="col-sm-6 text-center">
				<table class="table">
					<tr>
						<th class="text-center"><?= Yii::t("app", "Adjudicators") ?></th>
					</tr>
					<? foreach ($adjudicators as $adj): ?>
						<tr>
							<td><?= Html::a($adj->user->name, ["user/view", "id" => $adj->user->id]) ?></td>
						</tr>
					<? endforeach; ?>
				</table>
			</div>
		</div>
	</div>
<? \yii\widgets\Pjax::end() ?>