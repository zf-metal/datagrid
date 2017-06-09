<?php

namespace ZfMetal\Datagrid\Source\Doctrine;

/**
 * Description of Search
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class Search {

    /**
     * Description
     * 
     * @var \Doctrine\ORM\QueryBuilder
     */
    protected $qb;

    /**
     * where
     * 
     * @var string
     */
    protected $where = "";

    function getQb() {
        return $this->qb;
    }

    function __construct(\Doctrine\ORM\QueryBuilder $qb) {
        $this->qb = $qb;
    }
    
    protected function getRa(){
           return $this->getQb()->getRootAliases()[0];
    }
    
    protected function getName($filter){
          return $this->getRa() . "." . $filter->getColumn()->getName();
          
    }
    
    protected function getRelationalName($filter){
          return $this->getAlias($filter). "." . $filter->getColumn()->getMultiSearchProperty();
          
    }
    
    protected function getAlias($filter){
          return $filter->getColumn()->getName();
          
    }
      
    protected function getValueParameterName($filter){
          return ':ms_' . $filter->getColumn()->getName();
          
    }

    function applySearch(\ZfMetal\Datagrid\Search $search) {

        if ($search->count()) {

            $expr = new \Doctrine\ORM\Query\Expr();


            /* @var $filter \ZfMetal\Datagrid\Filter */
            foreach ($search as $filter) {

                $this->getQb()->setParameter($this->getValueParameterName($filter), '%' . $filter->getValue() . '%');

                if ($filter->getRelational()) {
                    
                    if ($filter->getColumn()->getMultiSearchProperty()) {
                        
                        $this->getQb()->leftJoin($this->getName($filter), $this->getAlias($filter));
                        $this->where .= $expr->like($this->getRelationalName($filter), $this->getValueParameterName($filter)) . " OR ";
                    
                        
                    } else {
                        
                        throw new \Exception('Column ' . $this->getAlias($filter) . ' multiSearchProperty must be configure in columnConfig');
                    
                    }
                    
                } else {

                    $this->where .= $expr->like($this->getName($filter), $this->getValueParameterName($filter)) . " OR ";
                }
            }
            $this->where = trim($this->where, " OR ");
            $this->getQb()->andWhere($this->where);
        }
    }

}
