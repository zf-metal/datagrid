<?php

namespace ZfMetal\Datagrid\Form;

class MultiSearch extends \Zend\Form\Form {

    const FORM_SEARCH_NAME = 'ZfMetal_Grid_Form_Search_';

    public function __construct($gridId, $multiSearchKey) {
        parent::__construct(self::FORM_SEARCH_NAME . $gridId);
        $this->setAttribute('method', 'get');
        $this->setAttribute('id', self::FORM_SEARCH_NAME . $gridId);

        $this->add(array(
            'name' => $multiSearchKey,
            'attributes' => array(
                'type' => 'text',
            )
        ));
    }

}
