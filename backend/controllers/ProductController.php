<?php

namespace backend\controllers;

use backend\base\BackController;
use backend\models\search\ProductImgSearch;
use Yii;
use common\models\Product;
use common\models\ProductImg;
use backend\models\search\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;


use yii\imagine\Image;
use Imagine\Image\Box;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends BackController
{
    /**
     * {@inheritdoc}
     */
    // public function behaviors()
    // {
    //     return [
    //         'verbs' => [
    //             'class' => VerbFilter::className(),
    //             'actions' => [
    //                 'delete' => ['POST'],
    //             ],
    //         ],
    //     ];
    // }

    public function actionMultiple()
    {
        $upload = new ProductImg();
        $products = Product::find()->andWhere(['status' => 1])->all();

        if ($upload->load(Yii::$app->request->post())) {
            $upload->image = UploadedFile::getInstances($upload, 'image');
            if ($upload->image && $upload->validate()) {
                $fullPath = Yii::getAlias('@frontend/web/storage/products/');
                if (!file_exists(Url::to($fullPath))) {
                    mkdir(Url::to($fullPath), 0777, true);
                }
                foreach ($upload->image as $image) {
                    $model = new ProductImg();
                    $model->product_id = $upload->product_id;
                    $model->image = time() . rand(100, 999) . '.' . $image->extension;
                    if ($model->save(false)) {
                        $image->saveAs($fullPath . $model->image);
                        $imgPath = $fullPath . $model->image;

                        $img = Image::getImagine()->open($imgPath);

                        // $size = $img->getSize();
                        $ratio = 1 / 1;

                        $width = 200;
                        $height = round($width / $ratio);

                        $box = new Box($width, $height);
                        // $img->resize($box)->save($imgPath);
                    }
                }
                return $this->redirect(['multiple']);
            }
        }

        $searchModel = new ProductImgSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render(
            'multiple',
            [
                'upload' => $upload,
                'products' => ArrayHelper::map($products, 'id', 'name'),
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ]
        );
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $images = ProductImg::find()->andWhere(['product_id' => $id])->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'images' => $images,
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();
        $upload = new ProductImg();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $upload->image = UploadedFile::getInstances($model, 'images');
            if ($upload->image) {
                $fullPath = Yii::getAlias('@frontend/web/storage/products/');
                if (!file_exists(Url::to($fullPath))) {
                    mkdir(Url::to($fullPath), 0777, true);
                }
                foreach ($upload->image as $image) {
                    $img_model = new ProductImg();
                    $img_model->product_id = $model->id;
                    $img_model->image = time() . rand(100, 999) . '.' . $image->extension;
                    if ($img_model->save(false)) {
                        $image->saveAs($fullPath . $img_model->image);
                        $imgPath = $fullPath . $img_model->image;

                        $size = Image::getImagine()->open($imgPath)->getSize();
                        $img = Image::getImagine()->open($imgPath);

                        $ratio = 1 / 1;
                        $width = $size->getWidth();
                        $height = round($width / $ratio);
                        $box = new Box($width, $height);
                        // $img->resize($box)->save($imgPath);
                    }
                }
                // return $this->redirect(['multiple']);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            // 'upload' => $upload
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $upload = new ProductImg();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $upload->image = UploadedFile::getInstances($model, 'images');
            if ($upload->image) {
                $fullPath = Yii::getAlias('@frontend/web/storage/products/');
                if (!file_exists(Url::to($fullPath))) {
                    mkdir(Url::to($fullPath), 0777, true);
                }
                foreach ($upload->image as $image) {
                    $img_model = new ProductImg();
                    $img_model->product_id = $model->id;
                    $img_model->image = time() . rand(100, 999) . '.' . $image->extension;
                    if ($img_model->save(false)) {
                        $image->saveAs($fullPath . $img_model->image);
                        $imgPath = $fullPath . $img_model->image;

                        $size = Image::getImagine()->open($imgPath)->getSize();
                        $img = Image::getImagine()->open($imgPath);

                        $ratio = 1 / 1;
                        $width = $size->getWidth();
                        $height = round($width / $ratio);
                        $box = new Box($width, $height);
                        // $img->resize($box)->save($imgPath);
                    }
                }
                // return $this->redirect(['multiple']);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {


        $img_models = ProductImg::find()->andWhere(['product_id' => $id])->all();
        $fullPath = Yii::getAlias('@frontend/web/storage/products/');

        foreach ($img_models as $ms) {

            $imgPath = $fullPath . $ms->image;
            unlink($imgPath);
            $ms->delete();
        }
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
