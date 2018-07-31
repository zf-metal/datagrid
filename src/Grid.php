<?php

namespace ZfMetal\Datagrid;

use \Zend\Paginator\Paginator;
use ZfMetal\Datagrid\Column\ExtraColumn;
use ZfMetal\Datagrid\Column\CrudColumn;

/**
 * Main Class for GRID
 *
 * @author cincarnato
 */
class Grid
{

//Instance to Render
    const INSTANCE_GRID = "grid";
    const INSTANCE_VIEW = "view";
    const INSTANCE_FORM = "form";
    const INSTANCE_EXPORT_TO_EXCEL = "exportToExcel";
    const INSTANCE_IMPORT_FROM_CSV = "importFromCsv";
    const INSTANCE_GET_IMPORT_EXAMPLE = "getImportExample";
    const INSTANCES = [
        self::INSTANCE_GRID, self::INSTANCE_VIEW, self::INSTANCE_FORM, self::INSTANCE_EXPORT_TO_EXCEL, self::INSTANCE_IMPORT_FROM_CSV, self::INSTANCE_GET_IMPORT_EXAMPLE
    ];
    const MULTI_SEARH_ID = "_multisearch";

    /**
     * Data source of grid
     *
     * @var \ZfMetal\Datagrid\Source\SourceInterface
     */
    protected $source;

    /**
     *
     * @var \Zend\Mvc\Plugin\FlashMessenger\FlashMessenger
     */
    protected $flashMessenger;

    /**
     * HTTP REQUEST FROM APPLICATION-MVCEVENT
     *
     * @var \Zend\Mvc\MvcEvent
     */
    protected $mvcevent;

    /**
     * HTTP REQUEST FROM APPLICATION-MVCEVENT
     *
     * @var \Zend\Http\Request
     */
    protected $request;

    /**
     * RouteMatch FROM APPLICATION-MVCEVENT
     *
     * @var \Zend\Router\RouteMatch
     */
    protected $routeMatch;

    /**
     * Number of Page (paginator)
     *
     * @var integer
     */
    protected $page;

    /**
     * Grid's Paginator
     *
     * @var \Zend\Paginator\Paginator
     */
    protected $paginator;

    /**
     * Basic and unprocessed records of the grid
     *
     * @var Array
     */
    protected $data;

    /**
     *
     *
     * @var Array
     */
    protected $row;

    /**
     * A factory for columns
     *
     * @var \ZfMetal\Datagrid\Factory\ColumnFactory
     */
    protected $columnFactory;

    /**
     * A factory for formFilter
     *
     * @var \ZfMetal\Datagrid\Factory\FormFilterFactory
     */
    protected $formFilterFactory;

    /**
     * A columns collection
     *
     * @var array
     */
    protected $columns = array();

    /**
     * Columns Priority
     *
     * @var array
     */
    protected $columnsPriority = array();

    /**
     * A extra columns collection
     *
     * @var array
     */
    protected $extraColumns = array();

    /**
     * Crud column
     *
     * @var \ZfMetal\Datagrid\Column\CrudColumn
     */
    protected $crudColumn = array();

    /**
     * Filter by multiple field with and
     *
     * @var \ZfMetal\Datagrid\Filters
     */
    protected $filters;

    /**
     * Find by multiple field with or
     *
     * @var \ZfMetal\Datagrid\Search
     */
    protected $search;

    /**
     * Define instance to render
     *
     * @var type
     */
    protected $instance = self::INSTANCE_GRID;

    /**
     * CRUD
     *
     * @var \ZfMetal\Datagrid\Crud
     */
    protected $crud;

    /**
     * Grid Options
     *
     * @var \ZfMetal\Datagrid\Options\GridOptions
     */
    protected $options;

    /**
     * Template a renderzar.
     *
     * @var string
     */
    protected $template = "default";

    /**
     * Defined if the Grid has been prepared
     *
     * @var type
     */
    protected $ready = false;

    /**
     * Order
     *
     * @var \ZfMetal\Datagrid\Sort
     */
    protected $sort;

    /**
     *
     * @var type
     */
    protected $formFilters;

    /**
     *
     * @var \ZfMetal\Datagrid\Form\MultiSearch
     */
    protected $formSearch;

    #TOREVIEW
    /**
     * @var \ZfcRbac\Service\AuthorizationService
     */
    protected $authService;

    #TOREVIEW
    protected $tableClass;

    /**
     * Construct
     *
     * @param \Zend\Mvc\MvcEvent $mvcevent
     */
    public function __construct(\Zend\Mvc\MvcEvent $mvcevent, \ZfMetal\Datagrid\Options\GridOptionsInterface $options, \Zend\Mvc\Plugin\FlashMessenger\FlashMessenger $flashMessenger,  \ZfcRbac\Service\AuthorizationService $authService = null)
    {
        $this->setMvcevent($mvcevent);

        $this->setOptions($options);

        $this->setTemplate($options->getTemplateDefault());

        $this->flashMessenger = $flashMessenger;

        $this->authService = $authService;
    }

    public function prepare()
    {

        if (!isset($this->source)) {
            throw new \ZfMetal\Datagrid\Exception\SourceException();
        }


        //CRUD - (Actualmente Define la instancia)
        $this->processCrudActions();


        //CRUD CONFIGURE
        $this->crudConfigure();

        //IF THE INSTANCE IS NOT GRID, RETURN NOW
        if ($this->getInstance() !== self::INSTANCE_GRID) {
            $this->ready = true;
            //  return $this;
        }

        //Extract and generate source columns
        $this->buildColumns();

        //Extract and generate source columns
        $this->orderColumnsByPriority();

        //Filters
        $this->generateFormFilters();
        $this->buildFilters();
        $this->getSource()->setFilters($this->getFilters());
        $this->getSource()->setSearch($this->getSearch());

        //Order (SORT)
        $this->prepareSort();

        //Prepare Source
        $this->getSource()->prepare();

        //EXPORT
        $this->processExports();

        //Import
        $this->processImports();

        //Paginator
        $this->preparePaginator();

        //Data
        $this->data = $this->paginator->getCurrentItems();
        $this->processData();

        //Extra Columns (todo)
        $this->mergeExtraColumn();

        //Order Columns..Need review to enable
        //$this->processOrderColumn();
        $this->ready = true;
        return $this;
    }

    function getMvcevent()
    {
        return $this->mvcevent;
    }

    function setMvcevent(\Zend\Mvc\MvcEvent $mvcevent)
    {
        $this->mvcevent = $mvcevent;
    }

    function getSort()
    {
        return $this->sort;
    }

    function setSort(\ZfMetal\Datagrid\Sort $sort)
    {
        $this->sort = $sort;
    }

    function getFlashMessenger()
    {
        return $this->flashMessenger;
    }

    function getServiceExportToExcel()
    {
        return $this->serviceExportToExcel;
    }

    function setServiceExportToExcel(\ZfMetal\Datagrid\Service\ExportToExcel $serviceExportToExcel)
    {
        $this->serviceExportToExcel = $serviceExportToExcel;
        return $this;
    }

    #CONFIG

    /**
     *
     * @return \ZfMetal\Datagrid\Options\GridOptions
     */
    public function getOptions()
    {
        return $this->options;
    }

    public function setOptions(\ZfMetal\Datagrid\Options\GridOptionsInterface $options)
    {
        $this->options = $options;
    }

    function getColumnsConfig()
    {
        return $this->getOptions()->getColumnsConfig();
    }

    function getColumnConfig($columnName)
    {
        if (key_exists($columnName, $this->getOptions()->getColumnsConfig())) {
            return $this->getOptions()->getColumnsConfig()[$columnName];
        }
        return [];
    }

    function setColumnsConfig(Array $columnsConfig)
    {
        $this->getOptions()->setColumnsConfig($columnsConfig);
    }

    function mergeColumnsConfig(Array $columnsConfig)
    {
        $this->getOptions()->mergeColumnsConfig($columnsConfig);
    }

    function getCrudConfig()
    {
        return $this->getOptions()->getCrudConfig();
    }

    function setCrudConfig(Array $crudConfig)
    {
        $this->getOptions()->setCrudConfig($crudConfig);
    }

    public function getRecordPerPage()
    {
        return $this->recordPerPage;
    }

    public function setRecordsPerPage($recordsPerPage)
    {
        $this->getOptions()->setRecordsPerPage($recordsPerPage);
    }

    #<-CONFIG
    #SOURCE

    /**
     * Get Source of grid
     *
     * @return \ZfMetal\Datagrid\Source\SourceInterface
     */
    function getSource()
    {
        return $this->source;
    }

    /**
     * Set Source of grid
     *
     * @param \ZfMetal\Datagrid\Source\SourceInterface $source Source of grid
     * @return \ZfMetal\Datagrid\Source\SourceInterface
     */
    function setSource(\ZfMetal\Datagrid\Source\SourceInterface $source)
    {
        $this->source = $source;

        return $this->source;
    }

    #<-SOURCE
    #COLUMNS

    protected function orderColumnsByPriority()
    {
        asort($this->columnsPriority);
        $this->columns = array_merge($this->columnsPriority, $this->columns);
    }

    protected function buildColumns()
    {
        $sourceColumnsName = $this->getSource()->pullColumns();

        foreach ($sourceColumnsName as $name) {
            $this->createColumn($name);
        }
    }

    protected function createColumn($name)
    {
        $this->columns[$name] = $this->getColumnFactory()->create($name, $this->getColumnConfig($name));
        $this->columnsPriority[$name] = $this->columns[$name]->getPriority();
    }

    function getColumnFactory()
    {
        if (!isset($this->columnFactory)) {
            $this->setColumnFactory(new Factory\ColumnFactory);
        }
        return $this->columnFactory;
    }

    function setColumnFactory(\ZfMetal\Datagrid\Factory\ColumnFactory $columnFactory)
    {
        $this->columnFactory = $columnFactory;
    }

    #<-COLUMNS

    protected function crudConfigure()
    {
        if ($this->getOptions()->getCrudConfig()->getEnable() === true) {
            $this->addCrudColumn($this->getOptions()->getCrudConfig()->getName(), $this->getOptions()->getCrudConfig()->getSide(), $this->getOptions()->getCrudConfig());
        }
    }

    protected function processExports()
    {
        if ($this->getInstance() == self::INSTANCE_EXPORT_TO_EXCEL) {
            $this->getSource()->exportToExcel($this->getOptions()->getExportConfig()->getExportToExcel()->getKey());
        }
    }

    protected function processImports()
    {
        if ($this->getInstance() == self::INSTANCE_IMPORT_FROM_CSV) {
            $result = $this->getSource()->importFromCsv($this->getOptions()->getImportConfig()->getImportFromCsv()->getKey(), $this->getCrud()->getRecord());
            if($result['status'] == 'ok')
                $this->flashMessenger->addSuccessMessage($result['message']);
            else
                $this->flashMessenger->addWarningMessage($result['message']);
            $this->setInstance(self::INSTANCE_GRID);
        }
        if ($this->getInstance() == self::INSTANCE_GET_IMPORT_EXAMPLE) {
            $this->getSource()->getImportExample($this->getOptions()->getImportConfig()->getImportFromCsv()->getKey());
        }
    }

    protected function preparePaginator()
    {
        $this->paginatorAdapter = $this->getSource()->execute();
        $this->paginator = new Paginator($this->paginatorAdapter);
        $this->paginator->setDefaultItemCountPerPage($this->getOptions()->getRecordsPerPage());
        $this->paginator->setCurrentPageNumber($this->getPage());
    }

    public function getForm()
    {
        return $this->getSource()->getForm();
    }

    #CRUD

    public function getCrudForm()
    {
        return $this->getCrud()->getCrudForm();
    }

    protected function processCrudActions()
    {
        $this->setInstance($this->getCrud()->crudActions());
    }

    function getCrud()
    {
        if (!isset($this->crud)) {
            $this->crud = $this->buildCrud();
        }
        return $this->crud;
    }

    function buildCrud()
    {
        return new \ZfMetal\Datagrid\Crud($this->source, $this->getPost(), $this->getFlashMessenger(), $this->getOptions());
    }

    function setCrud($crud)
    {
        $this->crud = $crud;
    }

    public function addCrudColumn($name = null, $side = "left", $crudConfig = [])
    {
        $this->crudColumn = new CrudColumn($name, $side, $crudConfig, $this->getId(),$this->authService);
        $this->crudColumn->setFilterActive(false);
        if ($side == "left") {
            array_unshift($this->extraColumns, $this->crudColumn);
        } else if ($side == "right") {
            array_push($this->extraColumns, $this->crudColumn);
        }
    }

    #<-CRUD
    #MVCEVENT

    public function getRoute()
    {
        return $this->getMvcevent()->getRouteMatch()->getMatchedRouteName();
    }

    public function getQuery($param = null)
    {
        if ($param) {
            return $this->getMvcevent()->getRequest()->getQuery($param, null);
        } else {
            return $this->getMvcevent()->getRequest()->getQuery();
        }
    }

    public function getParam($param)
    {
        return $this->getMvcevent()->getRequest()->getParam($param);
    }

    public function getPost()
    {
        return array_merge_recursive(
            $this->getMvcevent()->getRequest()->getPost()->toArray(), $this->getMvcevent()->getRequest()->getFiles()->toArray()
        );
    }

    public function getPage()
    {
        if (!$this->page) {
            $page = $this->getMvcevent()->getRequest()->getQuery('page');
            if ($page) {
                $this->setPage($page);
            } else {
                $this->setPage(1);
            }
        }
        return $this->page;
    }

    public function setPage($page)
    {
        $this->page = $page;
    }

    public function getQueryArray()
    {
        $query = $this->getQuery();
        $return = array();
        foreach ($query as $key => $value) {
            $return[$key] = $value;
        }
        return $return;
    }

    #<-MVCEVENT
    #SORT

    public function prepareSort()
    {
        $query = $this->getQuery();
        if ($query["sortBy"] && $query["sortDirection"]) {

            $column = $this->columns[$query["sortBy"]];

            $this->sort = new \ZfMetal\Datagrid\Sort();
            $this->sort->setBy($query["sortBy"]);
            $this->sort->setDirection($query["sortDirection"]);
            $this->sort->setColumn($column);
            $this->source->setSort($this->sort);
        }
    }

    #<-SORT
    #FILTERS

    public function buildFilters()
    {
        //Multi Filter
        $this->filters = new \ZfMetal\Datagrid\Filters();
        if ($this->getOptions()->getMultiFilterConfig()->getEnable() and count($this->getQuery())) {
            //Multi Filter
            foreach ($this->getQuery() as $key => $value) {
                $name = str_replace("f_", "", $key);
                if ($value != "") {
                    if (key_exists($name, $this->columns)) {
                        $filter = new \ZfMetal\Datagrid\Filter($this->columns[$name], $value);
                        $this->filters->addFilter($filter);
                    }
                }
            }
        }
        //Multi Search
        $this->search = new \ZfMetal\Datagrid\Search();

        $multiSearchKey = $this->getMultiSearhKey();
        if ($this->getOptions()->getMultiSearchConfig()->getEnable() and $this->getQuery($multiSearchKey)) {

            $multiSearchValue = $this->getQuery($multiSearchKey);

            foreach ($this->getOptions()->getMultiSearchConfig()->getPropertiesEnabled() as $property) {

                if (key_exists($property, $this->columns)) {
                    $filter = new \ZfMetal\Datagrid\Filter($this->columns[$property], $multiSearchValue);
                    $this->search->addSearch($filter);
                }
            }
        }
    }

    public function getMultiSearhKey()
    {
        return $this->getOptions()->getGridId() . self::MULTI_SEARH_ID;
    }

    protected function generateFormFilters()
    {
        $this->formFilters = $this->getFormFilterFactory()->create(clone $this->source->getForm(), $this->getPage(), $this->getQuery());
    }

    function getFormFilterFactory()
    {
        if (!isset($this->formFilterFactory)) {
            $this->setFormFilterFactory(new Factory\FormFilterFactory($this->getId(), $this->getOptions()->getMultiFilterConfig()));
        }
        return $this->formFilterFactory;
    }

    function setFormFilterFactory(\ZfMetal\Datagrid\Factory\FormFilterFactory $formFilterFactory)
    {
        $this->formFilterFactory = $formFilterFactory;
    }

    public function getFormFilters()
    {
        return $this->formFilters;
    }

    public function setFormFilters($formFilters)
    {
        $this->formFilters = $formFilters;
    }

    function getFormSearch()
    {
        if (!$this->formSearch) {
            $this->formSearch = new \ZfMetal\Datagrid\Form\MultiSearch($this->getId(), $this->getMultiSearhKey());
            $this->formSearch->setData($this->getQuery());
        }
        return $this->formSearch;
    }

    function getFilters()
    {
        return $this->filters;
    }

    function setFilters(type $filters)
    {
        $this->filters = $filters;
    }

    function getSearch()
    {
        return $this->search;
    }

    #<-FILTERS

    protected function processData()
    {

        foreach ($this->data as $record) {
            if (is_array($record)) {
                $this->row[] = $record;
            } else if (is_object($record)) {
                if ($record instanceof \stdClass) {
                    $this->row[] = (array)$record;
                } else {
                    //Process Data Columns
                    foreach ($this->columns as $column) {
                        $method = "get" . ucfirst($column->getName());
                        $item[$column->getName()] = $record->$method();
                    }
                    //Process Data ExtraColumns
                    foreach ($this->extraColumns as $ExtraColumn) {
                        if ($ExtraColumn->getType() == 'custom') {
                            continue;
                        }
                        $item[$ExtraColumn->getName()] = $ExtraColumn->processData($item);
                    }
                    $this->row[] = $item;
                }
            }
        }
    }

    public function addCustomColumn($name, $helper, $side = "left")
    {

        $columnConfig = $this->getColumnConfig($name);
        $columnConfig["type"] = "custom";
        $extraColumn = $this->getColumnFactory()->create($name, $columnConfig);

        if ($side != "left" && $side != "right") {
            throw new \Exception("Side must be 'left' or 'right'");
        }

        if ($side == "left") {
            $extraColumn->setSide("left");
            array_unshift($this->extraColumns, $extraColumn);
        } else if ($side == "right") {
            $extraColumn->setSide("right");
            array_push($this->extraColumns, $extraColumn);
        }
        return $extraColumn;
    }

    public function addExtraColumn($name, $originalValue, $side = "left", $filter = false)
    {

        $columnConfig = $this->getColumnConfig($name);
        $columnConfig["type"] = "extra";
        $extraColumn = $this->getColumnFactory()->create($name, $columnConfig);

        $extraColumn->setOriginalValue($originalValue);
        $extraColumn->setFilterActive($filter);

        if ($side != "left" && $side != "right") {
            throw new Exception("Side must be 'left' or 'right'");
        }

        if ($side == "left") {
            $extraColumn->setSide("left");
            array_unshift($this->extraColumns, $extraColumn);
        } else if ($side == "right") {
            $extraColumn->setSide("right");
            array_push($this->extraColumns, $extraColumn);
        }
        return $extraColumn;
    }

    protected function mergeExtraColumn()
    {
        foreach ($this->extraColumns as $ExtraColumn) {
            if ($ExtraColumn->getSide() == "left") {
                array_unshift($this->columns, $ExtraColumn);
            } else if ($ExtraColumn->getSide() == "right") {
                array_push($this->columns, $ExtraColumn);
            }
        }
    }

    public function getId()
    {
        return $this->getOptions()->getGridId();
    }

    public function setId($id)
    {
        if (preg_match('/\s/', $id)) {
            throw new Exception("Id can't contain spaces");
        }
        $this->getOptions()->setGridId($id);
    }

    public function getRow()
    {
        return $this->row;
    }

    public function getTableClass()
    {
        return $this->tableClass;
    }

    public function setTableClass($tableClass)
    {
        $this->tableClass = $tableClass;
    }

    function getInstance()
    {
        return $this->instance;
    }

    function setInstance($instance)
    {
        if (in_array($instance, self::INSTANCES)) {
            $this->instance = $instance;
        } else {
            throw new \Exception("Instance " . $instance . " not exist");
        }
    }

    function getAddBtn()
    {
        return $this->addBtn;
    }

    function setAddBtn($addBtn)
    {
        $this->addBtn = $addBtn;
    }

    function getColumnFilter()
    {
        return $this->columnFilter;
    }

    function setColumnFilter($columnFilter)
    {
        $this->columnFilter = $columnFilter;
    }

    function getColumnOrder()
    {
        return $this->columnOrder;
    }

    function setColumnOrder($columnOrder)
    {
        $this->columnOrder = $columnOrder;
    }

    function getOrderBy()
    {
        return $this->orderBy;
    }

    function getOrderDirection()
    {
        return $this->orderDirection;
    }

    /**
     * @return string $template
     */
    function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param string $template
     */
    function setTemplate($template)
    {
        $this->template = $template;
    }

    function getPaginator()
    {
        return $this->paginator;
    }

    function setPaginator(\Zend\Paginator\Paginator $paginator)
    {
        $this->paginator = $paginator;
    }

    function getColumns()
    {
        return $this->columns;
    }

    function getColumn($name)
    {
        if (key_exists($name, $this->columns)) {
            return $this->columns[$name];
        }
        return null;
    }

    function getCrudColumn()
    {
        return $this->crudColumn;
    }

    function setCrudColumn($crudColumn)
    {
        $this->crudColumn = $crudColumn;
    }

    function getRecordDetail()
    {
        return $this->crud->getRecord();
    }

    public function __toString()
    {
        return "toStringGrid";
    }

    public function get_f_list()
    {
        return \ZfMetal\Datagrid\C::F_LIST . $this->getId();
    }

    public function get_f_add()
    {
        return \ZfMetal\Datagrid\C::F_ADD . $this->getId();
    }

    public function get_f_delete()
    {
        return \ZfMetal\Datagrid\C::F_DELETE . $this->getId();
    }

    public function get_f_edit()
    {
        return \ZfMetal\Datagrid\C::F_EDIT . $this->getId();
    }

    public function get_f_view()
    {
        return \ZfMetal\Datagrid\C::F_VIEW . $this->getId();
    }

    public function get_f_pagination()
    {
        return \ZfMetal\Datagrid\C::F_PAGINATION . $this->getId();
    }

    public function get_f_search()
    {
        return \ZfMetal\Datagrid\C::F_SEARCH . $this->getId();
    }

    public function get_f_filter()
    {
        return \ZfMetal\Datagrid\C::F_FILTER . $this->getId();
    }

    public function get_f_export_to_excel()
    {
        return \ZfMetal\Datagrid\C::F_EXPORT_TO_EXCEL . $this->getId();
    }

    public function get_f_import_from_csv()
    {
        return \ZfMetal\Datagrid\C::F_IMPORT_FROM_CSV . $this->getId();
    }

    public function get_f_get_import_example()
    {
        return \ZfMetal\Datagrid\C::F_GET_IMPORT_EXAMPLE . $this->getId();
    }

    public function get_f_export_to_csv()
    {
        return \ZfMetal\Datagrid\C::F_EXPORT_TO_CSV . $this->getId();
    }

    public function get_title_form()
    {
        if ($this->getCrud()->getAction() == "add" || $this->getCrud()->getAction() == "addSubmit") {
            return $this->getOptions()->getTitleAdd();
        }
        if ($this->getCrud()->getAction() == "edit" || $this->getCrud()->getAction() == "editSubmit") {
            return $this->getOptions()->getTitleEdit();
        }
    }

    /**
     * @return \ZfcRbac\Service\AuthorizationService
     */
    public function getAuthService()
    {
        return $this->authService;
    }

    /**
     * @param \ZfcRbac\Service\AuthorizationService $authService
     */
    public function setAuthService($authService)
    {
        $this->authService = $authService;
    }


}
