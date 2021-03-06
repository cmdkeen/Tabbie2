<?php
//frontend\assets\BallotAsset::register($this);

/* @var $this yii\web\View */
/* @var $debate \common\models\Debate */

use kartik\helpers\Html;

$speaks = Yii::t("app", "Speaker Points");
$rank = Yii::t("app", "Rank");
$total = Yii::t("app", "Total");
?>
<div class="tournamentlogo">
    <img src="<?= $tournament->logo ?>">
</div>
<div class="tournament">
    <?= Html::encode($tournament->fullname) ?>
</div>
<div class="predetails">
    <table>
        <tr>
            <th><?= Yii::t("app", "Debate ID") ?></th>
            <td><?= $debate->id ?></td>
        </tr>
        <tr>
            <th><?= Yii::t("app", "Room") ?></th>
            <td><?= ($debate->venue) ? Html::encode($debate->venue->name) : "" ?></td>
        </tr>
        <? if ($debate->getChair()): ?>
            <tr>
                <th><?= Yii::t("app", "Chair") ?></th>
                <td><?= Html::encode($debate->getChair()->name) ?></td>
            </tr>
        <? endif; ?>
        <?
        $panel = "";
        if ($debate->panel)
            $adjus = $debate->panel->getAdjudicators()->all();
        else
            $adjus = [];
        foreach ($adjus as $adj) {
            if ($debate->chair->id != $adj->id)
                $panel .= Html::encode($adj->getName($debate->panel->id) . ", ");
        }
        if (strlen($panel) > 0):
            ?>
            <tr>
                <th><?= Yii::t("app", "Adjudicators") ?></th>
                <td><?= substr($panel, 0, -2); ?></td>
            </tr>
        <? endif; ?>
    </table>
</div>

<div class="headline">
    <table>
        <? if ($round->infoslide): ?>
            <tr class="infoslide">
                <th><?= Yii::t("app", "InfoSlide") ?>:</th>
                <td>
                    <div><?= Html::encode($round->infoslide) ?></div>
                </td>
            </tr>
        <? endif; ?>
        <tr class="motion">
            <th><?= Yii::t("app", "Motion") ?>:</th>
            <td>
                <div><?= Html::encode($round->motion) ?></div>
            </td>
        </tr>
    </table>
</div>

<div class="table">
    <table cellpadding="0" cellspacing="0">
        <tr class="opening">
            <td>
                <table>
                    <tr>
                        <th colspan="2" class="pos"><?= Yii::t("app", "Opening Government") ?></th>
                        <td rowspan="2" class="value">
                            <div class="help"><?= $rank ?></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="team"><?= Yii::t("app", "Team") ?>
                            : <?= ($debate->og_team) ? Html::encode($debate->og_team->name) : "" ?></td>
                    </tr>
                    <tr>
                        <td><?= ($debate->og_team && $debate->og_team->speakerA) ? Html::encode($debate->og_team->speakerA->name) : "" ?></td>
                        <td class="value">
                            <div class="help"><?= $speaks ?></td>
                        <td class="rank" rowspan="2">
                            <div class="help"><?= $total ?></td>
                    </tr>
                    <tr>
                        <td><?= ($debate->og_team && $debate->og_team->speakerB) ? Html::encode($debate->og_team->speakerB->name) : "" ?></td>
                        <td class="value">
                            <div class="help"><?= $speaks ?></div>
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table>
                    <tr>
                        <th colspan="2" class="pos"><?= Yii::t("app", "Opening Opposition") ?></th>
                        <td rowspan="2" class="value">
                            <div class="help"><?= $rank ?></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="team"><?= Yii::t("app", "Team") ?>
                            : <?= ($debate->oo_team) ? Html::encode($debate->oo_team->name) : "" ?></td>
                    </tr>
                    <tr>
                        <td><?= ($debate->oo_team && $debate->oo_team->speakerA) ? Html::encode($debate->oo_team->speakerA->name) : "" ?></td>
                        <td class="value">
                            <div class="help"><?= $speaks ?></td>
                        <td class="rank" rowspan="2">
                            <div class="help"><?= $total ?></td>
                    </tr>
                    <tr>
                        <td><?= ($debate->oo_team && $debate->oo_team->speakerB) ? Html::encode($debate->oo_team->speakerB->name) : "" ?></td>
                        <td class="value">
                            <div class="help"><?= $speaks ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="closing">
            <td style="padding-top: 30px;">
                <table>
                    <tr>
                        <th colspan="2" class="pos"><?= Yii::t("app", "Closing Government") ?></th>
                        <td rowspan="2" class="value">
                            <div class="help"><?= $rank ?></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="team"><?= Yii::t("app", "Team") ?>
                            : <?= ($debate->cg_team) ? Html::encode($debate->cg_team->name) : "" ?></td>
                    </tr>
                    <tr>
                        <td><?= ($debate->cg_team && $debate->cg_team->speakerA) ? Html::encode($debate->cg_team->speakerA->name) : "" ?></td>
                        <td class="value">
                            <div class="help"><?= $speaks ?></td>
                        <td class="rank" rowspan="2">
                            <div class="help"><?= $total ?></td>
                    </tr>
                    <tr>
                        <td><?= ($debate->cg_team && $debate->cg_team->speakerB) ? Html::encode($debate->cg_team->speakerB->name) : "" ?></td>
                        <td class="value">
                            <div class="help"><?= $speaks ?></td>
                    </tr>
                </table>
            </td>
            <td style="padding-top: 30px;">
                <table>
                    <tr>
                        <th colspan="2" class="pos"><?= Yii::t("app", "Closing Opposition") ?></th>
                        <td rowspan="2" class="value">
                            <div class="help"><?= $rank ?></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="team"><?= Yii::t("app", "Team") ?>
                            : <?= ($debate->co_team) ? Html::encode($debate->co_team->name) : "" ?></td>
                    </tr>
                    <tr>
                        <td><?= ($debate->co_team && $debate->co_team->speakerA) ? Html::encode($debate->co_team->speakerA->name) : "" ?></td>
                        <td class="value">
                            <div class="help"><?= $speaks ?></td>
                        <td class="rank" rowspan="2">
                            <div class="help"><?= $total ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td><?= ($debate->co_team && $debate->co_team->speakerB) ? Html::encode($debate->co_team->speakerB->name) : "" ?></td>
                        <td class="value">
                            <div class="help"><?= $speaks ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
