<?php

namespace ZfMetal\Datagrid\Source\Doctrine;

use \DoctrineORMModule\Form\Annotation\AnnotationBuilder as DoctrineAnnotationBuilder;

/**
 * Description of Crud
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
trait CrudTrait {



    /**
     * Datagrid Entity Name
     * 
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $repository;

    /**
     * Form to add or edit
     * 
     * @var type
     */
    protected $form;

    /**
     * Form to add or edit
     * 
     * @var type
     */
    protected $crudForm;

    function getForm() {
        if (!isset($this->form)) {
            $this->buildForm();
        }
        return $this->form;
    }

    function setForm($form) {
        $this->form = $form;
    }

    public function buildForm($id = null) {
        $builder = new DoctrineAnnotationBuilder($this->getEm());
        $form = $builder->createForm($this->entityName);
        $form->setHydrator(new \DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity($this->getEm()));
        $this->form = $form;
    }

    public function getCrudForm($id = null) {
        if (!isset($this->crudForm)) {
            $this->crudForm = clone $this->getForm();
      
        if ($id) {
            $record = $this->getEm()->getRepository($this->entityName)->find($id);
        } else {
            $record = new $this->entityName;
        }

        $this->crudForm->setObject($record);
        $this->crudForm->setAttribute('method', 'post');
        $this->crudForm->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'submit',
                'class' => 'btn btn-success'
            )
        ));

        $this->crudForm->bind($record);
        }
        return $this->crudForm;
    }



    function getRepository() {
        if (isset($this->repository)) {
            $this->setRepository($this->getEm()->getRepository($this->getEntityName()));
        }
        return $this->repository;
    }

    function setRepository(\Doctrine\ORM\EntityRepository $repository) {
        $this->repository = $repository;
        return $this;
    }

    public function delRecord($id) {
        try {
            $record = $this->getEm()->getRepository($this->entityName)->find($id);
            $this->getEm()->remove($record);
            $this->getEm()->flush();
        } catch (Exception $ex) {
            return false;
        }
        return true;
    }

    public function viewRecord($id) {
        $record = $this->getEm()->getRepository($this->entityName)->find($id);
        return $record;
    }

    public function updateRecord($id, $data) {
        $crudForm = $this->getCrudForm($id);

        $crudForm->setData($data);

        if ($crudForm->isValid()) {
            $record = $crudForm->getObject();
            //Aqui deberia crear un evento en forma de escucha
            $argv = array('record' => $record, 'form' => $crudForm, 'data' => $data);
            $this->getEventManager()->trigger(__FUNCTION__ . '_before', $this, $argv);
            try {
                $this->getEm()->persist($record);
                $this->getEm()->flush();
            } catch (Exception $ex) {
                return false;
            }
            $this->getEventManager()->trigger(__FUNCTION__ . '_post', $this, $argv);
            return true;
        } else {
            return false;
        }
    }

    public function saveRecord($aData) {
        $crudForm = $this->getCrudForm();

        $crudForm->setData($aData);

        if ($crudForm->isValid()) {
            $record = $crudForm->getObject();
            $argv = array('record' => $record, 'form' => $crudForm, 'data' => $aData);
            $this->getEventManager()->trigger(__FUNCTION__ . '_before', $this, $argv);
            $this->getEm()->persist($record);
            $this->getEm()->flush();
            $argv["record"] = $record;
            $this->getEventManager()->trigger(__FUNCTION__ . '_post', $this, $argv);
            return true;
        } else {
            return false;
        }
    }

}
