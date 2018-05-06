<?php

namespace ZfMetal\Datagrid\Builder;

class ColumnBuilder {

	/**
     *
     * @var array
     */
    private $config;

    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     *
     */
    private $entity;

    /**
     *
     * @var \Zend\Mvc\Application
     */
    private $application;

  	function __construct(\Zend\Mvc\Application $application)
    {
        $this->application = $application;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param array $config
     *
     * @return self
     */
    public function setConfig($config = array())
    {
        $this->config = $config;

        return $this;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEm()
    {
        return $this->em;
    }

    /**
     * @param \Doctrine\ORM\EntityManager $em
     *
     * @return self
     */
    public function setEm(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;

        return $this;
    }

    public function buildValue($key, $value = null)
    {
    	$config = $this->getColumnConfigFromValue($key); 

        if (empty($config))
            return $value ? (string)$value : null;

        $type = isset($config['type']) ? $config['type'] : 'string';

        $result = null;

        switch ($type) {
            case 'relational':
            $result = $this->getRelationalValue($config, $value);
            break;
            case 'datetime':
            $result = $this->getDatetimeValue($config, $value);
            break;
            case 'boolean':
            $result = $this->getBooleanValue($config, $value);
            break;
            default:
            $result = $value?(string)$value:null;
        }

        return $result;
    }

    public function getKeyFromValue($value){
    	foreach ($this->getConfig() as $index => $config) {

            if ((isset($config['displayName']) && $config['displayName'] == $value) || $index == $value)
                return $index;
        }

        return $value;
    }

    private function getColumnConfigFromValue($value)
    {
        foreach ($this->getConfig() as $index => $config) {

            if ((isset($config['displayName']) && $config['displayName'] == $value) || $index == $value)
                return $config;
        }

        return null;
    }

    private function getRelationalValue($config, $value = null)
    {
        if (!$value && !isset($config['default']))
            return null;

        if (!isset($config['field']) || !isset($config['entity']))
            throw new \Exception('failed config on getRelationalValue');

        $obj = null;

        $value = $value ? $value : $config['default'];

        if ($config['field'] == 'id')
            $obj = $this->getEm()->getReference($config['entity'], (int)$value);
        else
            $obj = $this->getEm()->getRepository($config['entity'])->findOneBy([$config['field'] => $value]);

        return $obj;
    }

    private function getDatetimeValue($config, $value = null)
    {
        $format = isset($config['format']) && !empty($config['format']) ? $config['format'] : 'Y-m-d H:i:s';

        if ($value)
            return \DateTime::createFromFormat($format, $value);

        $default = isset($config['default']) && !empty($config['default']) ? $config['default'] : null;

        switch ($default) {
            case 'now':
            return new \DateTime();
            case 'curdate':
            return new \DateTime(date('Y-m-d'));
        }

        return null;
    }

    private function getBooleanValue($config, $value = null)
    {
        if (isset($config['valueOfTrue']))
            return $config['valueOfTrue'] == $value ? true : false;
        elseif (isset($config['valueOfFalse']))
            return $config['valueOfFalse'] == $value ? false : true;

        return $value ? true : false;
    }
}
