<?php

namespace ZfMetal\Datagrid;

/**
 * Description of Manager
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class Manager {

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;
    protected $customKey;
    protected $gridOptions;
    protected $entity;
    protected $form;
    protected $formResult;

    function __construct(\Doctrine\ORM\EntityManager $em, $customKey, $gridOptions, $entity, $form, $formResult) {
        $this->em = $em;
        $this->customKey = $customKey;
        $this->gridOptions = $gridOptions;
        $this->entity = $entity;
        $this->form = $form;
        $this->formResult = $formResult;
    }
    
    function getEm() {
        return $this->em;
    }

    function getCustomKey() {
        return $this->customKey;
    }

    function getGridOptions() {
        return $this->gridOptions;
    }

    function getEntity() {
        return $this->entity;
    }

    function getForm() {
        return $this->form;
    }

    function getFormResult() {
        return $this->formResult;
    }




}
