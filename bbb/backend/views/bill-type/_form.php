<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $model backend\models\BillType */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="bill-type-form">

    <?php $form = ActiveForm::begin([
	'id'=>$model->formName(),
    ]); ?>

    <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="itemModalLabel"><i class="fa fa-table"></i> ประเภทบิล</h4>
    </div>

    <div class="modal-body">
	<?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
        <?= $form->field($model, 'type')->hiddenInput()->label(FALSE) ?>

    </div>
    <div class="modal-footer" style="background: #f3f3f3;">
	    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'บันทึก') : Yii::t('app', 'บันทึก'), ['class' => $model->isNewRecord ? 'btn btn-success btn-block' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php 
    $modal = isset($modal)?$modal:'bill-type-grid-pjax';
?>
<?php  \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
<script>
setTimeout(function(){
    $("#billtype-name").focus(); 
},1000);    
// JS script
$('form#<?= $model->formName()?>').on('beforeSubmit', function(e) {
    var $form = $(this);
    $.post(
        $form.attr('action'), //serialize Yii2 form
        $form.serialize()
    ).done(function(result) {
        if(result.status == 'success') {
            <?= SDNoty::show('result.message', 'result.status')?>
            if(result.action == 'create') {
                //$(\$form).trigger('reset');
                $(document).find('#<?= $modal?>').modal('hide');
                $.pjax.reload({container:'#bill-type-grid-pjax'});
            } else if(result.action == 'update') {
                $(document).find('#<?= $modal?>').modal('hide');
                $.pjax.reload({container:'#bill-type-grid-pjax'});
            }
        } else {
            <?= SDNoty::show('result.message', 'result.status')?>
        } 
    }).fail(function() {
        <?= SDNoty::show("'" . SDHtml::getMsgError() . "Server Error'", '"error"')?>
        console.log('server error');
    });
    return false;
});
</script>
<?php  \richardfan\widget\JSRegister::end(); ?>