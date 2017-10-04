<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\data\Pagination;
use yii\widgets\LinkPager;

?>

<a href="<?= Url::toRoute("site/create")?>">Criar um novo aluno</a>

<?php $f = ActiveForm::begin([
    "method" => "get",
    "action" => Url::toRoute("site/view"),
    "enableClientValidation" => true,
]);
?>

<div class="form-group">
    <?= $f->field($form, "q")->input("search") ?>
</div>

<?= Html::submitButton("Buscar", ["class"=>"btn btn-primary"]) ?>

<?php $f->end() ?>

<h3><?= $search ?></h3>

<h3>Lista de Alunos</h3>
<table class="table table-bordered">
    <tr>
        <th>Id Aluno</th>
        <th>Nome</th>
        <th>Apelidos</th>
        <th>Classe</th>
        <th>Nota Final</th>
        <th></th>
        <th></th>
    </tr>
    <?php foreach($model as $row): ?>
    <tr>
        <td><?= $row->id_aluno ?></td>
        <td><?= $row->nome ?></td>
        <td><?= $row->apelidos ?></td>
        <td><?= $row->classe ?></td>
        <td><?= $row->nota_final ?></td>
        <td><a href="#">Editar</a></td>
        <td><a href="#">Excluir</a></td>
    </tr>
    <?php endforeach; ?>
</table>
<?=LinkPager::widget(["pagination" => $pages]);
        
    