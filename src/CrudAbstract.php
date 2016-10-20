<?php
/**
 * This file is part of Vegas package.
 *
 * Default usage:
 * <code>
 * use My\Forms\My as MyForm;
 * * use My\Models\My as MyModel;
 * class MyController extends Controller\Crud {
 *      protected $formName = MyForm::class;    // default form used by CRUD
 *      protected $modelName = MyModels::class;  // default model used by CRUD
 * }
 * </code>
 *
 * @author Arkadiusz Ostrycharz <aostrycharz@amsterdam-standard.pl>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage http://vegas-cmf.github.io
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Vegas\Crud;

use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Url;
use Phalcon\Mvc\View;
use Vegas\Crud\Exception\NotConfiguredException;
use Vegas\Crud\Exception;
use Vegas\Mvc\ControllerAbstract;

/**
 * Class Crud
 * @package Vegas\Mvc\Controller
 */
abstract class CrudAbstract extends ControllerAbstract
{
    /**
     * Controller initialization block
     */
    public function initialize()
    {
        $this->dispatcher->getEventsManager()->attach('view:notFoundView', function ($event, View $view, $filePath) {
            if (!in_array($this->dispatcher->getActionName(), ['new', 'edit', 'show', 'index'])) {
                return false;
            }

            if ($view->getCurrentRenderLevel() == View::LEVEL_ACTION_VIEW) {
                $templatePath = implode(DIRECTORY_SEPARATOR, [dirname(__FILE__)]);

                $view->setViewsDir($templatePath);
                $view->setRenderLevel(View::LEVEL_ACTION_VIEW);
                $view->render('View', $this->dispatcher->getActionName());

            }
            return true;
        });
    }

    use HooksTrait;

    /**
     * Default success message
     *
     * @var string
     */
    protected $successMessage = 'Action has been successful.';

    /**
     * Form class name
     *
     * @var string
     */
    protected $formName;

    /**
     * Model class name
     *
     * @var string
     */
    protected $modelName;

    /**
     * Array of fields names that will be used in index action
     *
     * @var array
     */
    protected $indexFields = [];

    /**
     * Array of fields names that will be used in show action
     *
     * @var array
     */
    protected $showFields = [];

    /**
     * Initializes scaffolding
     *
     * @throws NotConfiguredException
     */
    protected function initializeScaffolding()
    {
        if (!$this->isConfigured()) {
            throw new NotConfiguredException();
        }

        $this->scaffolding->setModelName($this->modelName);
        $this->scaffolding->setFormName($this->formName);
    }

    /**
     * @return bool
     * @internal
     */
    protected function isConfigured()
    {
        return ($this->di->has('scaffolding') && !empty($this->modelName) && !empty($this->formName));
    }

    /**
     * Displays records list.
     */
    public function indexAction()
    {
        $this->initializeScaffolding();

        $paginator = $this->scaffolding->doPaginate($this->request->get('page', 'int', 1));
        $this->view->page = $paginator->getPaginate();
        $this->view->fields = $this->indexFields;
    }

    /**
     * Displays record details.
     */
    public function showAction($id)
    {
        $this->initializeScaffolding();

        $this->beforeRead();
        $this->view->record = $this->scaffolding->doRead($id);
        $this->view->fields = $this->showFields;
        $this->afterRead();
    }

    /**
     * Displays form for new record
     */
    public function newAction()
    {
        $this->initializeScaffolding();

        $this->beforeNew();
        $this->view->form = $this->scaffolding->getForm();
        $this->afterNew();
    }

    /**
     * Creates new record
     *
     * @return mixed
     */
    public function createAction()
    {

        $this->initializeScaffolding();
        $this->checkRequest();

        try {
            $this->beforeCreate();
            $this->scaffolding->doCreate($this->request->getPost());
            $this->flash->success($this->successMessage);
            return $this->afterCreate();
        } catch (Exception $e) {
            $this->flash->error($e->getMessage());
            $this->afterCreateException();
        }

        return $this->dispatcher->forward(['action' => 'new']);
    }

    /**
     * Displays form for existing record
     *
     * @param $id
     */
    public function editAction($id)
    {
        $this->initializeScaffolding();

        $this->beforeRead();
        $this->view->record = $this->scaffolding->doRead($id);
        $this->afterRead();

        $this->beforeEdit();
        $this->view->form =  $this->scaffolding->getForm($this->view->record);
        $this->afterEdit();
    }

    /**
     * Updates existing record indicated by its ID
     *
     * @param $id
     * @return mixed
     */
    public function updateAction($id)
    {
        $this->initializeScaffolding();
        $this->checkRequest();

        try {
            $this->beforeRead();
            $this->view->record = $this->scaffolding->doRead($id);
            $this->afterRead();

            $this->beforeUpdate();
            $this->scaffolding->doUpdate($id, $this->request->getPost());
            $this->flash->success($this->successMessage);
            return $this->afterUpdate();
        } catch (Exception $e) {
            $this->flash->error($e->getMessage());
            $this->afterUpdateException();
        }

        return $this->dispatcher->forward(['action' => 'edit']);
    }

    /**
     * Checks if request was send using POST method
     *
     * @throws Exception\PostRequiredException
     */
    protected function checkRequest()
    {
        if (!$this->request->isPost()) {
            throw new Exception\PostRequiredException();
        }
    }

    /**
     * Deletes existing record by its ID
     *
     * @param $id
     * @return mixed
     */
    public function deleteAction($id)
    {
        $this->initializeScaffolding();

        try {
            $this->beforeRead();
            $this->view->record = $this->scaffolding->doRead($id);
            $this->afterRead();

            $this->beforeDelete();
            $this->scaffolding->doDelete($id);
            $this->flash->success($this->successMessage);
            return $this->afterDelete();
        } catch (Exception $e) {
            $this->flash->error($e->getMessage());
            return $this->afterDeleteException();
        }
    }
}
