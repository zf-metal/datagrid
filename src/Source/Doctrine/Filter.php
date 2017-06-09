<?php

namespace ZfMetal\Datagrid\Source\Doctrine;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query\Expr;
use ZfMetal\Datagrid\Filter as DatagridFilter;

/**
 * Description of Filter
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class Filter {

    const LOGICAL_OPERATOR_AND = "and";
    const LOGICAL_OPERATOR_OR = "or";

     /**
     * QueryBuilder
     * 
     * @var \Doctrine\ORM\QueryBuilder
     */
    protected $qb;
    
     /**
     * logicalOperator
     * 
     * @var string
     */
    protected $logicalOperator = self::LOGICAL_OPERATOR_AND;

    /**
     * @param QueryBuilder $qb
     */
    public function __construct(QueryBuilder $qb, $logicalOperator = null) {
        $this->qb = $qb;
        if ($logicalOperator) {
            $this->setLogicalOperator($logicalOperator);
        }
    }

    function getLogicalOperator() {
        return $this->logicalOperator;
    }

    function setLogicalOperator($logicalOperator) {
        if ($logicalOperator != self::LOGICAL_OPERATOR_AND and $logicalOperator != self::LOGICAL_OPERATOR_OR) {
            throw new Exception("Logical Operator must be 'and' or 'or'");
        } else {
            $this->logicalOperator = $logicalOperator;
        }
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getQueryBuilder() {
        return $this->qb;
    }

    public function applyFilter(\ZfMetal\Datagrid\Filter $filter, $key) {
        $qb = $this->getQueryBuilder();
        $ra = $this->qb->getRootAliases()[0];
        $colname = $filter->getColumn()->getName();


        $colString = $ra . "." . $colname;

        //toreview for more filters in the same column
        $valueParameterName = ":" . $colname . $key;

        $value = $filter->getValue();


        $expr = new Expr();

        switch ($filter->getOperator()) {
            case DatagridFilter::LIKE:
                $where = $expr->like($colString, $valueParameterName);
                $qb->setParameter($valueParameterName, '%' . $value . '%');
                break;
            case DatagridFilter::LIKE_LEFT:
                $where = $expr->like($colString, $valueParameterName);
                $qb->setParameter($valueParameterName, '%' . $value);
                break;
            case DatagridFilter::LIKE_RIGHT:
                $where = $expr->like($colString, $valueParameterName);
                $qb->setParameter($valueParameterName, $value . '%');
                break;
            case DatagridFilter::NOT_LIKE:
                $where = $expr->notLike($colString, $valueParameterName);
                $qb->setParameter($valueParameterName, '%' . $value . '%');
                break;
            case DatagridFilter::NOT_LIKE_LEFT:
                $where = $expr->notLike($colString, $valueParameterName);
                $qb->setParameter($valueParameterName, '%' . $value);
                break;
            case DatagridFilter::NOT_LIKE_RIGHT:
                $where = $expr->notLike($colString, $valueParameterName);
                $qb->setParameter($valueParameterName, $value . '%');
                break;
            case DatagridFilter::EQUAL:
                $where = $expr->eq($colString, $valueParameterName);
                $qb->setParameter($valueParameterName, $value);
                break;
            case DatagridFilter::NOT_EQUAL:
                $where = $expr->neq($colString, $valueParameterName);
                $qb->setParameter($valueParameterName, $value);
                break;
            case DatagridFilter::GREATER_EQUAL:
                $where = $expr->gte($colString, $valueParameterName);
                $qb->setParameter($valueParameterName, $value);
                break;
            case DatagridFilter::GREATER:
                $where = $expr->gt($colString, $valueParameterName);
                $qb->setParameter($valueParameterName, $value);
                break;
            case DatagridFilter::LESS_EQUAL:
                $where = $expr->lte($colString, $valueParameterName);
                $qb->setParameter($valueParameterName, $value);
                break;
            case DatagridFilter::LESS:
                $where = $expr->lt($colString, $valueParameterName);
                $qb->setParameter($valueParameterName, $value);
                break;
            case DatagridFilter::BETWEEN:
                $minParameterName = ':' . str_replace('.', '', $colString . '0');
                $maxParameterName = ':' . str_replace('.', '', $colString . '1');
                $where = $expr->between($colString, $minParameterName, $maxParameterName);
                $qb->setParameter($minParameterName, $value[0]);
                $qb->setParameter($maxParameterName, $value[1]);
                break;
            default:
                throw new \InvalidArgumentException('This operator is currently not supported: ' . $filter->getOperator());
                break;
        }

        if (!empty($where)) {
            if ($this->logicalOperator == self::LOGICAL_OPERATOR_AND) {
                $qb->andWhere($where);
            } else if ($this->logicalOperator == self::LOGICAL_OPERATOR_OR) {
                $qb->orWhere($where);
            }
        }
    }

}
