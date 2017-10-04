<?php

use yii\helpers\Url;
use yii\helpers\Html;

?>

<h1>Formulário<h1>
<h3><?= $mensagem ?></h3>
<?= Html::beginForm(
         Url::toRoute("site/request"), //action
                                "get", //metodo
            ['class' => 'form-inline'] //options
        );
?>

<div class="form-group">
    <?= Html::label("Nome: ", "nome") ?>
    <?= Html::textInput("nome",null, ["class" => "form-control"]) ?>
</div>
        
<?= Html::submitInput("Enviar Nome", ["class" => "btn btn-primary"]) ?>
        
        
<?= Html::endForm() ?>