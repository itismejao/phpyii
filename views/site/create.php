<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>

<a href="<?= Url::toRoute("site/view")?>">Ir para a lista de Alunos</a>>

<h1>Criar Alumo</h1>
<h3><?= $msg ?></h3>
<?php $form = ActiveForm::begin([
    "method" => "post",
 'enableClientValidation' => true,
]);
?>
<div class="form-group">
 <?= $form->field($model, "nome")->input("text") ?>   
</div>

<div class="form-group">
 <?= $form->field($model, "apelidos")->input("text") ?>   
</div>

<div class="form-group">
 <?= $form->field($model, "classe")->input("text") ?>   
</div>

<div class="form-group">
 <?= $form->field($model, "nota_final")->input("text") ?>   
</div>

<?= Html::submitButton("Criar", ["class" => "btn btn-primary"]) ?>

<?php $form->end() ?>