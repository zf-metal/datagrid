<?php

namespace ZfMetal\Datagrid\Source;

use ZfMetal\Datagrid\Source\AbstractSource;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrinePaginatorAdapter;
use \Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;

class DoctrineSource extends AbstractSource implements SourceInterface {

    use \ZfMetal\Datagrid\Source\Doctrine\CrudTrait;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * Datagrid Entity Name
     * 
     * @var string
     */
    protected $entityName;

    /**
     * Entity key
     * 
     * @var string
     */
    protected $entityKey = 'u';

    /**
     * Description
     * 
     * @var \Doctrine\ORM\QueryBuilder
     */
    protected $qb;

    /**
     * Description
     * 
     * @var type
     */
    protected $paginator;

    /**
     *
     * @var \ZfMetal\Datagrid\Service\ExportToExcel 
     */
    protected $serviceExportToExcel;

    /**
     *
     * @var \ZfMetal\Datagrid\Service\ImportFromCsv
     */
    protected $serviceImportFromCsv;

    /**
     * Doctrine Source Construct
     *
     * @param \Doctrine\ORM\EntityManager $em 
     * @param string $entityName 
     * @param \Doctrine\ORM\QueryBuilder $qb 
     */
    function __construct(\Doctrine\ORM\EntityManager $em, $entityName, $qb = null) {
        $this->setEm($em);
        $this->setEntityName($entityName);
        if (isset($qb)) {
            $this->setQb($qb);
        }
    }

    function getServiceExportToExcel() {
        return $this->serviceExportToExcel;
    }

    function setServiceExportToExcel(\ZfMetal\Datagrid\Service\ExportToExcel $serviceExportToExcel) {
        $this->serviceExportToExcel = $serviceExportToExcel;
        return $this;
    }

    /**
     * @return \ZfMetal\Datagrid\Service\ImportFromCsv
     */
    public function getServiceImportFromCsv()
    {
        return $this->serviceImportFromCsv;
    }

    /**
     * @param \ZfMetal\Datagrid\Service\ImportFromCsv $serviceImportFromCsv
     * @return $this
     */
    public function setServiceImportFromCsv($serviceImportFromCsv)
    {
        $this->serviceImportFromCsv = $serviceImportFromCsv;
        return $this;
    }


    public function getEm() {
        if (!isset($this->em)) {
            throw new \ZfMetal\Datagrid\Exception\EntityManagerNoSetException();
        }
        return $this->em;
    }

    public function setEm(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
        return $this;
    }

    public function getEntityName() {
        if (!isset($this->entityName)) {
            throw new \Exception("No EntityName set");
        }
        return $this->entityName;
    }

    public function setEntityName($entityName) {
        $this->entityName = $entityName;
        return $this;
    }



    protected function createQb() {
        $this->qb = $this->getEm()->createQueryBuilder()->select($this->getEntityKey())->from($this->getEntityName(), $this->getEntityKey());
    }

    protected function extractEntityFromQb() {
        if (isset($this->qb)) {
            $this->entityName = $this->qb->getRootEntities()[0];
            $this->entityKey = $this->qb->getRootAliases()[0];
            return true;
        }
        return false;
    }

    public function getQb() {
        if (!isset($this->qb)) {
            $this->createQb();
        }
        return $this->qb;
    }

    public function setQb(\Doctrine\ORM\QueryBuilder $qb) {
        $this->qb = $qb;
        if ($this->entityName != $this->getQb()->getRootEntities()[0]) {
            throw new \Exception("EntityName is diferent to RootEntity in QueryBuilder");
        }
    }

    function getEntityKey() {
        return $this->entityKey;
    }

    function setEntityKey($entityKey) {
        $this->entityKey = $entityKey;
    }

    public function prepare() {
        //1-ApplyFilters
        $this->applyFilters();

        //2-ApplySearch
        $this->applySearch();

        //3-ApplyOrder
        $this->applySort();
    }

    public function execute() {

        //4-Paginator
        $this->paginator = new DoctrinePaginatorAdapter(new DoctrinePaginator($this->getQb()));

        return $this->paginator;
    }

    function exportToExcel($configKey) {
        $this->getServiceExportToExcel()->run($this->getEm(), $this->getEntityName(), $this->getQb(), $configKey);
    }

    function importFromCsv($configKey,$file) {
        return $this->getServiceImportFromCsv()->run($this->getEm(), $this->getEntityName(), $file, $configKey);
    }

    function getImportExample($configKey) {
        $this->getServiceImportFromCsv()->getImportExample($this->getEm(), $this->getEntityName(), $configKey);
    }

    public function pullColumns() {
        $rp = $this->getEm()->getClassMetadata($this->entityName)->getReflectionProperties();
        return array_keys($rp);
    }

    public function applyFilters() {
        $doctrineFilter = new \ZfMetal\Datagrid\Source\Doctrine\Filter($this->getQb());
        if (is_a($this->getFilters(), "\ZfMetal\Datagrid\Filters")) {
            foreach ($this->getFilters() as $key => $filter) {
                $doctrineFilter->applyFilter($filter, $key);
            }
        }
    }

    public function applySearch() {
        $doctrineSearch = new \ZfMetal\Datagrid\Source\Doctrine\Search($this->getQb());
        $doctrineSearch->applySearch($this->getSearch());
    }

    public function applySort() {
        if (isset($this->sort) && $this->sort instanceof \ZfMetal\Datagrid\Sort) {
            $ra = $this->getQb()->getRootAliases();
            $ro = $ra[0] . ".";

            if ($this->sort->getColumn()->getType() == 'relational') {
                $this->getQb()->leftJoin($ro . $this->sort->getColumn()->getName(), 't');
                $this->getQb()->orderBy('t.' . $this->sort->getColumn()->getOrderProperty(), $this->sort->getDirection());
            } else {
                $this->getQb()->orderBy($ro . $this->sort->getBy(), $this->sort->getDirection());
            }
        }
    }

}
