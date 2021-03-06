<?php

namespace ZfMetal\Datagrid\Factory;

/**
 * Description of FormFilter
 *
 * @author Cristian Incarnato <cristian.cdi@gmail.com>
 */
class FormFilterFactory {

    const FORM_FILTER_NAME = 'ZfMetal_Grid_Form_Filter_';

    protected $gridId;
    protected $multiFilterConfig;

    function __construct($gridId, \ZfMetal\Datagrid\Options\MultiFilterConfig $multiFilterConfig) {
        $this->gridId = $gridId;
        $this->multiFilterConfig = $multiFilterConfig;
    }

    public function create($form, $page, $data) {
        $formName = self::FORM_FILTER_NAME . $this->gridId;
        $form->setName($formName);
        $form->setAttribute('method', 'get');

        foreach ($form as $key => $element) {

            /* @var $element \Zend\Form\Element */
            
            //Verificamos si el campo fue deshabilitado por config
            if (in_array($element->getName(), $this->getMultiFilterConfig()->getPropertiesDisabled())) {
                $form->remove($element->getName());
            } else {

                $element->setAttribute("required", false);

                if ($element instanceof \DoctrineModule\Form\Element\ObjectSelect) {
                    $element->setOption("display_empty_item", true);
                    $element->setOption("empty_item_label", "---");
                    $element->setAttribute('class', 'form-control');
                    $element->setEmptyOption("---");
                }

                if (preg_match("/hidden/i", $element->getAttribute("type")) && $element->getName() == 'id') {
                    $newElement = new \Zend\Form\Element\Text('id');
                    $form->remove($element->getName());
                    $form->add($newElement);
                }

                if (preg_match("/password/i", $element->getAttribute("type"))) {
                    $form->remove($element->getName());
                }

                if (preg_match("/text/i", $element->getAttribute("type"))) {
                    $element->setAttribute('class', 'form-control');
                }

                if (preg_match("/select/i", $element->getAttribute("type"))) {
                    $element->setAttribute('class', 'form-control');
                }


                if (preg_match("/textarea/i", $element->getAttribute("type"))) {
                    $name = $element->getName();
                    $newElement = new \Zend\Form\Element\Text($name);
                    $newElement->setLabel($name);
                    $newElement->setAttribute('class', 'form-control');
                    $form->remove($element->getName());
                    $form->add($newElement);
                }

                if (preg_match("/number/i", $element->getAttribute("type"))) {
                    $name = $element->getName();
                    $newElement = new \Zend\Form\Element\Text($name);
                    $newElement->setLabel($name);
                    $newElement->setAttribute('class', 'form-control');
                    $form->remove($element->getName());
                    $form->add($newElement);
                }


                if (preg_match("/email/i", $element->getAttribute("type"))) {
                    $name = $element->getName();
                    $newElement = new \Zend\Form\Element\Text($name);
                    $newElement->setLabel($name);
                    $newElement->setAttribute('class', 'form-control');
                    $form->remove($element->getName());
                    $form->add($newElement);
                }

                if (preg_match("/date/i", $element->getAttribute("type"))) {
                    $name = $element->getName();
                    $newElement = new \Zend\Form\Element\Text($name);
                    $newElement->setLabel($name);
                    $newElement->setAttribute('class', 'form-control');
                    $form->remove($element->getName());
                    $form->add($newElement);
                }

                if (preg_match("/checkbox/i", $element->getAttribute("type"))) {
                    $name = $element->getName();

                    $newElement = new \Zend\Form\Element\Select($name);
                    $newElement->setOptions(array(
                        'value_options' => array(0 => "false", 1 => "true"),
                        'empty_option' => ''
                    ));
                    $newElement->setLabel($name);
                    $newElement->setAttribute('class', 'form-control');
                    $form->remove($element->getName());
                    $form->add($newElement);
                }


                if (preg_match("/file/i", $element->getAttribute("type"))) {
                    $form->remove($element->getName());
                }

                $element->setOption("description", null);
            }
        }

        $form->add(array(
            'name' => 'page',
            'attributes' => array(
                'type' => 'hidden',
                'value' => $page
            )
        ));

        $form->add(array(
            'name' => 'submitbtn',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Filtrar',
                'class' => 'btn btn-success',
            )
        ));

        $form->add(array(
            'name' => 'resetbtn',
            'type' => 'Zend\Form\Element\Button',
            'options' => [
                'label' => "Reset"
            ],
            'attributes' => array(
                'value' => 'Reset',
                'class' => 'btn btn-default',
                'onclick' => \ZfMetal\Datagrid\C::F_FILTER_CLEAN . $formName . '(false)'
            )
        ));

        $form->add(array(
            'name' => 'resetsubmitbtn',
            'type' => 'Zend\Form\Element\Button',
            'options' => [
                'label' => "Reset & Submit"
            ],
            'attributes' => array(
                'value' => 'Reset & Submit',
                'class' => 'btn btn-default',
                'onclick' => \ZfMetal\Datagrid\C::F_FILTER_CLEAN . $formName . '(true)'
            )
        ));



        $form->setData($data);
        return $form;
    }

    function getGridId() {
        return $this->gridId;
    }

    function getMultiFilterConfig() {
        return $this->multiFilterConfig;
    }

}
