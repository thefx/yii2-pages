<?php

namespace thefx\pages\controllers;

use thefx\pages\components\NestedTreeHelper;
use thefx\pages\models\Page;
use Yii;
use yii\caching\TagDependency;
use yii\db\Query;
use yii\filters\ContentNegotiator;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * PagesController implements the CRUD actions for Pages model.
 */
class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'only' => ['tree-move'],
                'formatParam' => '_format',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
//            'access' => [
//                'class' => AccessControl::class,
//                'rules' => [
//                    [
//                        'allow' => true,
//                        'matchCallback' => static function ($rule, $action) {
//                            return !Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin();
//                        }
//                    ],
//                ],
//            ],
        ];
    }

    public function beforeAction($action)
    {
        if ($action->id === 'tree-move') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    public function actions()
    {
        $id = (int) Yii::$app->request->get('id');

        return [
            'getpage' => [
                'class' => 'thefx\pages\actions\GetPageAction',
            ],
            'upload-image' => [
                'class' => 'vova07\imperavi\actions\UploadFileAction',
                'url' => '/upload/redactor/' . $id . '/',
                'path' => \Yii::getAlias("@webroot") . '/upload/redactor/' . $id,
                'unique' => true,
                'validatorOptions' => [
                    'maxWidth' => 2000,
                    'maxHeight' => 2000
                ]
            ],
            'get-uploaded-images' => [
                'class' => 'vova07\imperavi\actions\GetImagesAction',
                'url' => '/upload/redactor/' . $id . '/',
                'path' => \Yii::getAlias("@webroot") . '/upload/redactor/' . $id,
                'options' => ['only' => ['*.jpg', '*.jpeg', '*.png', '*.gif', '*.ico']],
            ]
        ];
    }

    public function actionIndex()
    {
        return $this->render('index', [
            'tree' => $this->pagesTree()
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate($parent_id = null)
    {
        $this->layout = $this->module->layoutPure;

        $model = new Page([
            'parent_id' => $parent_id ? (int) $parent_id : 1,
            'public' => 1,
            'create_user' => Yii::$app->user->id,
            'create_date' => date('Y-m-d H:i:s'),
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $parent = Page::findOne($model->parent_id);

            $model->appendTo($parent)->save();
//            $this->clearCache();
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $this->layout = $this->module->layoutPure;

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->update_user = Yii::$app->user->id;
            $model->update_date = date('Y-m-d H:i:s');

            $parent = Page::findOne($model->parent_id);

            if ($model->id != $model->getOldAttribute('id')) {
                $model->appendTo($parent);
            }

            $model->save();
//            $this->clearCache();
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete(); // delete node, children come up to the parent
//        $node11->deleteWithChildren(); // delete node and all descendants
        $this->clearCache();
        return $this->redirect(['index']);
    }

    /**
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionTreeMove()
    {
        $id = (int) $_POST['id'];
        $parent = $_POST['parent'];
        $oldParent = $_POST['old_parent'];
        $position = (int) $_POST['position'];
        $oldPosition = (int) $_POST['old_position'];

        $node = $this->findModel($id);

        $parentNode = ($parent === '#')
            ? $this->findModel(1)
            : $this->findModel($parent);

        $childrenNodes = $parentNode->getChildren()->all();

        if (isset($childrenNodes[$position])) {

            if ($position < $oldPosition || $parent != $oldParent) {
                $node->insertBefore($childrenNodes[$position]);
            } else {
                $node->insertAfter($childrenNodes[$position]);
            }

        } else {
            $node->appendTo($parentNode);
        }

        $node->setAttribute('parent_id', $parentNode->id);
        $node->save();
//        $this->clearCache();

        return $this->pagesTree();
    }

    public function pagesTree()
    {
        $pages = (new Query())
            ->from(Page::tableName())
            ->orderBy('lft')
            ->all();

        $treeArray = NestedTreeHelper::createPagesTree($pages);

        return $treeArray[0]->children;
    }

    /**
     * @param integer $id
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function clearCache()
    {
        TagDependency::invalidate(Yii::$app->cache, 'page');
        TagDependency::invalidate(Yii::$app->cache, 'breadcrumb');
    }
}
