<?php

namespace ZfMetal\Datagrid\Column;

/**
 * Description of Column
 *
 * @author cincarnato
 */
class CrudColumn extends ExtraColumn
{

    const type = "crud";

    protected $name = "ZfMetalCrudColumn";
    protected $side;
    protected $add = ["enable" => true, "htmltag" => "a", "class" => "btn btn-primary glyphicon glyphicon-plus", "value" => ""];
    protected $edit = ["enable" => true, "htmltag" => "a", "class" => "btn btn-primary glyphicon glyphicon-edit", "value" => ""];
    protected $del = ["enable" => true, "htmltag" => "a", "class" => "btn btn-danger glyphicon glyphicon-trash", "value" => ""];
    protected $view = ["enable" => true, "htmltag" => "a", "class" => "btn btn-success glyphicon glyphicon-list-alt", "value" => ""];
    protected $manager = ["enable" => false, "htmltag" => "a", "class" => "btn btn-success glyphicon glyphicon-asterisk", "value" => "", "action" => ""];
    protected $addAction;
    protected $editAction;
    protected $delAction;
    protected $viewAction;
    protected $managerAction;
    protected $filterActive = true;
    protected $filter;
    protected $gridId = null;
    protected $displayName = null;
    protected $authService = null;

    protected function isGranted($permission)
    {
        if (!empty($permission) && $permission != null && $this->authService && method_exists($this->authService, 'isGranted')) {
            return $this->authService->isGranted($permission);
        }
        return true;
    }

    protected function processDefaultAction()
    {
        $this->add["action"] = (empty($this->add["action"])) ? "onclick='" . \ZfMetal\Datagrid\C::F_ADD . $this->gridId . "()'" : $this->add["action"];
        $this->edit["action"] = (empty($this->edit["action"])) ? "onclick='" . \ZfMetal\Datagrid\C::F_EDIT . $this->gridId . "({{id}})'" : $this->edit["action"];
        $this->del["action"] = (empty($this->del["action"])) ? "onclick='" . \ZfMetal\Datagrid\C::F_DELETE . $this->gridId . "({{id}})'" : $this->del["action"];
        $this->view["action"] = (empty($this->view["action"])) ? "onclick='" . \ZfMetal\Datagrid\C::F_VIEW . $this->gridId . "({{id}})'" : $this->view["action"];
    }

    function __construct($name, $side, \ZfMetal\Datagrid\Options\CrudConfig $gridCrudConfig, $gridId, \ZfcRbac\Service\AuthorizationService $authService = null)
    {
        $this->setDisplayName($gridCrudConfig->getDisplayName());
        $this->authService = $authService;
        if ($name) {
            $this->name = $name;
        }
        $this->tdClass = $gridCrudConfig->getTdClass();
        $this->thClass = $gridCrudConfig->getThClass();

        $crudConfig["add"] = $gridCrudConfig->getAdd()->toArray();
        $crudConfig["edit"] = $gridCrudConfig->getEdit()->toArray();
        $crudConfig["del"] = $gridCrudConfig->getDel()->toArray();
        $crudConfig["view"] = $gridCrudConfig->getView()->toArray();
        $crudConfig["manager"] = $gridCrudConfig->getManager()->toArray();

        $this->gridId = $gridId;
        $this->setSide($side);

        (isset($crudConfig["add"])) ? $this->add = array_merge($this->add, $crudConfig["add"]) : null;
        (isset($crudConfig["edit"])) ? $this->edit = array_merge($this->edit, $crudConfig["edit"]) : null;
        (isset($crudConfig["del"])) ? $this->del = array_merge($this->del, $crudConfig["del"]) : null;
        (isset($crudConfig["view"])) ? $this->view = array_merge($this->view, $crudConfig["view"]) : null;
        (isset($crudConfig["manager"])) ? $this->manager = array_merge($this->manager, $crudConfig["manager"]) : null;

        $this->processDefaultAction();

        if ($this->add["enable"] && (!isset($this->add["permission"]) || $this->isGranted($this->add["permission"])) ) {
            $this->buildAddAction();
        }

        $this->originalValue = "";

        if ($this->view["enable"] && (!isset($this->view["permission"]) || $this->isGranted($this->view["permission"]))) {
            $this->originalValue .= $this->buildViewAction();
        }

        if ($this->edit["enable"]  && (!isset($this->edit["permission"]) || $this->isGranted($this->edit["permission"]))) {
            $this->originalValue .= $this->buildEditAction();
        }

        if ($this->manager["enable"] && (!isset($this->manager["permission"]) || $this->isGranted($this->manager["permission"]))) {
            $this->originalValue .= $this->buildManagerAction();
        }

        if ($this->del["enable"] && (!isset($this->del["permission"]) || $this->isGranted($this->del["permission"]))) {
            $this->originalValue .= $this->buildDelAction();
        }
    }

    protected function buildAddAction()
    {
        $this->addAction = " <" . $this->add["htmltag"] . " class='" . $this->add["class"] . "' " . $this->add["action"] . " >" . $this->add["value"] . "</" . $this->add["htmltag"] . ">";
        return $this->addAction;
    }

    protected function buildEditAction()
    {
        $this->editAction = " <" . $this->edit["htmltag"] . " class='" . $this->edit["class"] . "' " . $this->edit["action"] . " >" . $this->edit["value"] . "</" . $this->edit["htmltag"] . ">";
        return $this->editAction;
    }

    protected function buildDelAction()
    {
        $this->delAction = " <" . $this->del["htmltag"] . " class='" . $this->del["class"] . "' " . $this->del["action"] . " >" . $this->del["value"] . "</" . $this->del["htmltag"] . ">";
        return $this->delAction;
    }

    protected function buildViewAction()
    {
        $this->viewAction = " <" . $this->view["htmltag"] . " class='" . $this->view["class"] . "' " . $this->view["action"] . " >" . $this->view["value"] . "</" . $this->view["htmltag"] . ">";
        return $this->viewAction;
    }

    protected function buildManagerAction()
    {
        $this->managerAction = " <" . $this->manager["htmltag"] . " class='" . $this->manager["class"] . "' " . $this->manager["action"] . " >" . $this->manager["value"] . "</" . $this->manager["htmltag"] . ">";
        return $this->managerAction;
    }

    public function __toString()
    {
        return $this->getDisplayName();
    }

    public function getSide()
    {
        return $this->side;
    }

    public function setSide($side)
    {
        if ($side == "left" || $side == "right") {
            $this->side = $side;
        } else {
            throw new Exception("The side must be 'left' or 'right'");
        }
    }

    public function getFilterActive()
    {
        return $this->filterActive;
    }

    public function setFilterActive($filterActive)
    {
        $this->filterActive = $filterActive;
    }

    public function getFilter()
    {
        return $this->filter;
    }

    public function setFilter($filter)
    {
        $this->filter = $filter;
    }

    public function getOriginalValue()
    {
        return $this->originalValue;
    }

    public function setOriginalValue($originalValue)
    {
        $this->originalValue = $originalValue;
    }

    function getEdit()
    {
        return $this->edit;
    }

    function getDel()
    {
        return $this->del;
    }

    function getView()
    {
        return $this->view;
    }

    function setEdit($edit)
    {
        $this->edit = $edit;
    }

    function setDel($del)
    {
        $this->del = $del;
    }

    function setView($view)
    {
        $this->view = $view;
    }

    function getAdd()
    {
        return $this->add;
    }

    function setAdd($add)
    {
        $this->add = $add;
    }

    function getMananger()
    {
        return $this->mananger;
    }

    function setMananger($mananger)
    {
        $this->mananger = $mananger;
        return $this;
    }

    function getDisplayName()
    {
        if (!$this->displayName) {
            if ($this->getAddAction()) {
                return $this->getAddAction();
            } else {
                return '';
            }

        }
        return $this->displayName;
    }

    function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
        return $this;
    }

    function getAddAction()
    {
        return $this->addAction;
    }

    function getEditAction()
    {
        return $this->editAction;
    }

    function getDelAction()
    {
        return $this->delAction;
    }

    function getViewAction()
    {
        return $this->viewAction;
    }

    function getManagerAction()
    {
        return $this->managerAction;
    }

    function setAddAction($addAction)
    {
        $this->addAction = $addAction;
        return $this;
    }

    function setEditAction($editAction)
    {
        $this->editAction = $editAction;
        return $this;
    }

    function setDelAction($delAction)
    {
        $this->delAction = $delAction;
        return $this;
    }

    function setViewAction($viewAction)
    {
        $this->viewAction = $viewAction;
        return $this;
    }

    function setManagerAction($managerAction)
    {
        $this->managerAction = $managerAction;
        return $this;
    }

}

?>
