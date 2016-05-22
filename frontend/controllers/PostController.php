<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use common\models\Post;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * Class PostController
 * @package frontend\controllers
 */
class PostController extends Controller
{
    /** @var integer $limit */
    public $limit = 2;

    /** @var $loggedUser */
    public $loggedUser;

    public function init()
    {
        $this->loggedUser = \Yii::$app->user->identity;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['index'],
                        'roles'   => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['user'],
                    ]
                ],
            ]
        ];
    }

    /**
     * Action for render post list
     * @return string
     */
    public function actionIndex()
    {
        $this->view->title = 'Post List';

        /** @var Post $posts */
        $posts = new Post;

        /** @var $request */
        $request = \Yii::$app->request;
        $category = $request->get('category');

        /** @var ActiveDataProvider $dataProvider */
        $dataProvider = $posts->createQuery($this->limit, $category);

        return $this->render('index', [
            'listDataProvider' => $dataProvider,
            'loggedUser'       => $this->loggedUser
        ]);
    }

    /**
     * Action for view post
     *
     * @param $id
     * @return string
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        /** @var Post $model */
        $model = $this->findModel($id);

        if ($model->unvisible !== Post::STATUS_UNVISIBLE || $model->moderated !== Post::STATUS_MODERATED) {
            throw new ForbiddenHttpException('No access');
        }

        return $this->render('view', [
            'model'      => $model,
            'loggedUser' => $this->loggedUser
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        /** @var Post $model */
        $model = new Post();

        if ($model->load(Yii::$app->request->post())) {
            /** @var UploadedFile $image */
            $image = UploadedFile::getInstance($model, 'image');
            $path = $model->prepareUploadFile($image);

            if ($model->save()) {
                $image->saveAs($path);
                $model->linkCategory($model->categories);

                Yii::$app->getSession()->setFlash('success', 'Post was successfully created');

                return $this->refresh();
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        /** @var Post $model */
        $model = $this->findModel($id);

        if ($model->created_by !== $this->loggedUser->id) {
            throw new ForbiddenHttpException('No access');
        }

        if ($model->load(\Yii::$app->request->post())) {

            /** @var UploadedFile $image */
            $image = UploadedFile::getInstance($model, 'image');

            if (!is_null($image)) {
                $path = $model->prepareUploadFile($image);
            }

            if ($model->save()) {
                if(!is_null($image) && isset($path)) {
                    $image->saveAs($path);
                }

                $model->linkCategory($model->categories);

                Yii::$app->getSession()->setFlash('success', 'Post was successfully created');

                return $this->refresh();
            }
        } else {
            $model->loadCategories();

            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
