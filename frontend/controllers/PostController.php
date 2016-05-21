<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use common\models\Post;
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
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model'      => $this->findModel($id),
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
            $img_parts = (explode(".", $image->name));

            $model->image = Yii::$app->security->generateRandomString() . "." . end($img_parts);
            $path = $model->getImagePath($model->image);

            $model->src = $model->image;

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
     */
    public function actionUpdate($id)
    {
        /** @var Post $model */
        $model = $this->findModel($id);

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('success', 'Post was successfully updated');

            return $this->refresh();
        } else {
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
