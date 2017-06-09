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
            case 'text':
            case 'integer':
                $result = $this->getString($entity, $column->getName());
                break;
            case 'boolean':
                $result = $this->getBoolean($entity, $column->getName(), $config['valueWhenTrue'], $config['valueWhenFalse']);
                break;
            case 'date':
            case 'time':
            case 'datetime':
                $result = $this->getDate($entity, $column->getName(), $config['format']);
                break;
            case 'relational':
                $result = $this->getRelational($entity, $column->getName(), isset($config['field']) ? $config['field'] : '');
                break;
        }
        return $result;
    }

    private function getString($entity, $name) {
        $getMethod = $this->buildGedMethod($name);
        return (string) $entity->$getMethod();
    }

    private function getBoolean($entity, $name, $valueWhenTrue, $valueWhenFalse) {
        $getMethod = $this->buildGedMethod($name);
        $result = $entity->$getMethod();
        if ($result == false) {
            return $valueWhenFalse;
        } else {
            return $valueWhenTrue;
        }
        return "";
    }

    private function getDate($entity, $name, $format = 'Y-m-d') {
        $getMethod = $this->buildGedMethod($name);
        $date = $entity->$getMethod();
        if (is_a($date, "DateTime")) {
            return (string) $date->format($format);
        }
        return "";
    }

    private function getRelational($entity, $name, $field) {
        $getMethod = $this->buildGedMethod($name);
        if ($field) {
            $getField = $this->buildGedMethod($field);
            $relationalObject = $entity->$getMethod();
            if ($relationalObject and method_exists($relationalObject, $getField)) {
                return $relationalObject->$getField();
            } else {
                return "";
            }
        }
        return (string) $entity->$getMethod();
    }

    private function buildGedMethod($name) {
        return 'get' . ucfirst($name);
    }

}
