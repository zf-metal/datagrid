<?php
use Zend\Mvc\Application;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use Zend\Form\Annotation as Annotation;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint as UniqueConstraint;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Created by PhpStorm.
 * User: afurgeri
 * Date: 9/6/18
 * Time: 17:06
 */
class ImportFromCsvTest extends AbstractControllerTestCase
{

    public function getApplication()
    {
        $application = $this->getMockBuilder(Application::class)->disableOriginalConstructor()->getMock();
        return $application;
    }

    public function getColumnBuilder()
    {
        $columnBuilder = new \ZfMetal\Datagrid\Builder\ColumnBuilder($this->getApplication());
        return $columnBuilder;
    }

    public function getEntityManager()
    {
        $entityManager = $this->getMockBuilder(\Doctrine\ORM\EntityManager::class)->disableOriginalConstructor()->getMock();
        return $entityManager;
    }

    public function testCreateNewInstanceClass()
    {

        $importCsv = new \ZfMetal\Datagrid\Service\ImportFromCsv(array(), $this->getApplication(), $this->getColumnBuilder());
        $this->assertInstanceOf(\ZfMetal\Datagrid\Service\ImportFromCsv::class, $importCsv);

        return $importCsv;
    }

    /**
     * @depends testCreateNewInstanceClass
     */
    public function testImportFromCsvMethodGetColumnsName($importCsv)
    {
        /**
         * @var $importCsv \ZfMetal\Datagrid\Service\ImportFromCsv
         */

        $expect = array(
            'id',
            'name'
        );

        $file = fopen(__DIR__ . '/foo.csv', "r");
        $this->invokeMethod($importCsv, 'getColumnNamesFromFile', array($file));
        fclose($file);

        $this->assertJsonStringEqualsJsonString(json_encode($expect), json_encode($importCsv->getColumnNames()));

        return $importCsv;
    }

    /**
     * @depends testImportFromCsvMethodGetColumnsName
     */
    public function testImportFromCsvMethodGetFieldNamesFromConfig($importCsv){
        /**
         * @var $importCsv \ZfMetal\Datagrid\Service\ImportFromCsv
         */

        $columnsConfig = array(
                'id' => [
                    'default' => null,
                ],
                'name' => [
                    'displayName' => 'name',
                    'default' => null,
                ],
                'address' => [
                    'displayName' => 'address',
                    'default' => null,
                ],
        );

        $expect = array(
            'id',
            'name',
            'address'
        );

        $importCsv->setColumnsConfig($columnsConfig);

        $this->invokeMethod($importCsv, 'getFieldNamesFromConfig', array());

        $this->assertJsonStringEqualsJsonString(json_encode($expect), json_encode($importCsv->getFieldNames()));

        return $importCsv;

    }

    /**
     * @depends testImportFromCsvMethodGetFieldNamesFromConfig
     */
    public function testImportFromCsvMethodValidateColumnsName($importCsv){
        /**
         * @var $importCsv \ZfMetal\Datagrid\Service\ImportFromCsv
         */

        $importCsv->setColumnNames(array(
            'id',
            'name'
        ));

        $importCsv->setFieldNames(array(
            'id',
            'name',
            'address'
        ));

        $this->invokeMethod($importCsv, 'validateColumnsName', array());
        $this->assertTrue(true);
        return $importCsv;
    }

    /**
     * @depends testImportFromCsvMethodGetFieldNamesFromConfig
     * @expectedException \ZfMetal\Datagrid\Exception\NotMatchFieldException
     */
    public function testImportFromCsvMethodValidateColumnsNameExpectException($importCsv){
        /**
         * @var $importCsv \ZfMetal\Datagrid\Service\ImportFromCsv
         */

        $importCsv->setColumnNames(array(
            'id',
            'name',
            'address'
        ));

        $importCsv->setFieldNames(array(
            'id',
            'name'
        ));

        $this->invokeMethod($importCsv, 'validateColumnsName', array());
        $this->assertTrue(true);
        return $importCsv;
    }

    private function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}

class EntityTest
{
}

class EntityTestRepository
{

}