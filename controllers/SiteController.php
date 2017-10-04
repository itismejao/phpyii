<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\ValidarFormulario;
use app\models\ValidarFormularioAjax;
use yii\widgets\ActiveForm;
use app\models\FormAlunos;
use app\models\Alunos;
use app\models\FormSearch;
use yii\helpers\Html;
use yii\data\Pagination;



class SiteController extends Controller
{
    public function actionView(){
       $form = new FormSearch;
       $search = null;
       if($form->load(Yii::$app->request->get())){
           if($form->validate()){
               $search = Html::encode($form->q);
               $table = Alunos::find()
                       ->where(["like","id_aluno",$search])
                       -orWhere(["like","nome",$search])
                       ->orWhere(["like","apelidos",$search]);
               $count = clone $table;
               $pages = new Pagination([
                   "pageSize" => 2, //qtd de registros por pagina
                   "totalCount" => $count->count()                     
                   ]);
               $model = $table
                       ->offset($pages->offset)
                       ->limit($pages->limit)
                       ->all();
           } else {
                $form->getErrors();
            }
       } else {
                $table = Alunos::find();
                $count = clone $table;
                $pages = new Pagination([
                   "pageSize" => 2, //qtd de registros por pagina
                   "totalCount" => $count->count(),              
                   ]);
                 $model = $table
                       ->offset($pages->offset)
                       ->limit($pages->limit)
                       ->all();
            }
        /* $table = new Alunos;
        $model = $table->find()->all();
        
        $form = new FormSearch;
        $search = null;
        if($form->load(Yii::$app->request->get())){
            if($form->validate()){
                $search = Html::encode($form->q);
                $query = "SELECT * FROM alunos WHERE id_aluno LIKE '%$search%' OR";
                $query .= " nome LIKE '%$search%' OR apelidos LIKE '%$search%'";
                $model = $table->findBySql($query)->all();
            } else {
                $form->getErrors();
            }
        }*/
        return $this->render("view",["model"=>$model,"form" => $form, "search" => $search,"pages" => $pages]);
    }
    public function actionCreate(){
        $model = new FormAlunos();
        $msg = null;
        if($model->load(Yii::$app->request->post())){
            if($model->validate()){
                $table = new Alunos;
                $table->nome = $model->nome;
                $table->apelidos = $model->apelidos;
                $table->classe = $model->classe;
                $table->nota_final = $model->nota_final;
                if ($table->insert()){
                    $msg = "Registro guardado corretamente!";
                    $model->nome = null;
                    $model->apelidos = null;
                    $model->classe = null;
                    $model->nota_final = null;
                } else {
                    $msg = "Ocorreu um erro ao inserir registro!";
                }
            } else {
                $model->getErrors();
            }
        }
        return $this->render("create",['model'=>$model,'msg' => $msg]);
    }
    
    public function actionSaudar($get = "Teste"){
        $mensagem = "Olá, mundo!";
        return $this->render("saudar",["mensagem" => $mensagem, "get" => $get]);
    }
    
    public function actionFormulario($mensagem = null){
        return $this->render("formulario", ["mensagem" => $mensagem]);
    }
    
    public function actionRequest(){
        $mensagem = null;
        if (isset($_REQUEST["nome"])){
            $mensagem = "Nome enviado corretamente!".$_REQUEST["nome"];
        }
        $this->redirect(["site/formulario", "mensagem" => $mensagem]);
    }
    
    public function actionValidarformulario(){
        $model = new ValidarFormulario;
        if($model->load(Yii::$app->request->post())){
            if($model->validate()){
                //por exemplo, consultar em uma base de dados
            } else {
                $model->getErrors();
            }
        }
        return $this->render("validarformulario",["model" => $model]);
    }
    
    public function  actionValidarformularioajax(){
        $model = new ValidarFormularioAjax;
        $msg = null;
        
        if($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if($model->load(Yii::$app->request->post())){
            if($model->validate()){
                //Por exemplo uma consulta no banco de dados
                $msg = "Formulario Enviado corretamente!";
                $model->nome = null;
                $model->email = null;
            } else {
                $model->getErrors();
            }
        }
        
        return $this->render("validarformularioajax", ['model' => $model,'msg' => $msg]);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
