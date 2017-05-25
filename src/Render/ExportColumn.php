<?php

namespace ZfMetal\Datagrid\Render;

class ExportColumn {

    public function render($entity, \ZfMetal\Datagrid\Column\AbstractColumn $column = null, $config = array()) {
        if (!$entity && !$column) {
            throw new \Exception('Algo anda mal, la entidad o la columna no pueden ser nulos');
        }

        $type = $column->getType();

        $result = '';
        switch ($type) {
            case 'string':
            case 'string':
            case 'integer':
                $result = $this->getString($entity, $column->getName());
                break;
            case 'date':
            case 'time':
            case 'datetime':
                $result = $this->getDate($entity, $column->getName(), $config['format']);
                break;
            case 'relational':
                $result = $this->getRelational($entity, $column->getName(), $config['field']);
                break;
        }
        return $result;
    }

    private function getString($entity, $name) {
        $getMethod = $this->buildGedMethod($name);
        return $entity->$getMethod();
    }
    
    private function getDate($entity, $name, $format = 'Y-m-d'){
        $getMethod = $this->buildGedMethod($name);
        return $entity->$getMethod()->format($format);
    }

    private function getRelational($entity, $name, $field){
        $getMethod = $this->buildGedMethod($name);
        $getField = $this->buildGedMethod($field);
        return $entity->$getMethod()->$getField();
    }

    private function buildGedMethod($name) {
        return 'get' . ucfirst($name);
    }

}
