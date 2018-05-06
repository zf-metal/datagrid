<?php
/**
 * Created by PhpStorm.
 * User: alejo
 * Date: 3/5/18
 * Time: 21:10
 */

namespace Test;


use Doctrine\ORM\EntityManager;
use Zend\Mvc\Application;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;
use \ZfMetal\Datagrid\Builder\ColumnBuilder;

class ColumnBuilderTest extends AbstractControllerTestCase
{

    public function getApplication()
    {
        $application = $this->getMockBuilder(Application::class)->disableOriginalConstructor()->getMock();
        return $application;
    }

    public function testBuildColumnsInstance()
    {
        $columnsBuilder = new ColumnBuilder($this->getApplication());

        $this->assertInstanceOf(ColumnBuilder::class, $columnsBuilder);
        return $columnsBuilder;
    }

    /**
     *
     * @depends testBuildColumnsInstance
     */
    public function testGetKey($columnsBuilder)
    {
        $config = [
            'name' => [
                'type' => 'string',
                'default' => "name",
                'displayName' => 'NAME'
            ],
        ];
        $actual = 'NAME';
        $expected = 'name';

        /**
         * @var ColumnBuilder $columnsBuilder
         */
        $columnsBuilder->setConfig($config);
        $this->assertSame($expected, $columnsBuilder->getKeyFromValue($actual));
    }

    /**
     *
     * @depends testBuildColumnsInstance
     */
    public function testBuildColumnNullValue($columnsBuilder)
    {
        $expected = null;

        /**
         * @var ColumnBuilder $columnsBuilder
         */
        $columnsBuilder->setConfig(array());
        $this->assertSame($expected, $columnsBuilder->buildValue('key', null));
    }

    /**
     *
     * @depends testBuildColumnsInstance
     */
    public function testBuildColumnStringValue($columnsBuilder)
    {
        $actual = 'A text';
        $expected = 'A text';

        /**
         * @var ColumnBuilder $columnsBuilder
         */
        $columnsBuilder->setConfig(array());
        $this->assertSame($expected, $columnsBuilder->buildValue('key', $actual));
    }

    /**
     *
     * @depends testBuildColumnsInstance
     */
    public function testBuildColumnDateWithNullValueAndNotDefaultValue($columnsBuilder)
    {
        $config = [
            'date' => [
                'type' => 'datetime',
                'format' => 'Y-m-d',
                //'default' => 'now'
            ]
        ];
        /**
         * @var ColumnBuilder $columnsBuilder
         */
        $columnsBuilder->setConfig($config);
        $this->assertSame(null, $columnsBuilder->buildValue('date', null));
    }

    /**
     *
     * @depends testBuildColumnsInstance
     */
    public function testBuildColumnDateWithNullValueAndDefaultNowValue($columnsBuilder)
    {
        $config = [
            'date' => [
                'type' => 'datetime',
                'format' => 'Y-m-d',
                'default' => 'now'
            ]
        ];

        /**
         * @var ColumnBuilder $columnsBuilder
         */
        $columnsBuilder->setConfig($config);
        $this->assertInstanceOf(\DateTime::class, $columnsBuilder->buildValue('date', null));
        $this->assertEquals((new \DateTime())->format('Y-m-d'), $columnsBuilder->buildValue('date', null)->format('Y-m-d'));
    }

    /**
     *
     * @depends testBuildColumnsInstance
     */
    public function testBuildColumnDateWithNullValueAndDefaultCurdateValue($columnsBuilder)
    {
        $config = [
            'date' => [
                'type' => 'datetime',
                'format' => 'Y-m-d',
                'default' => 'curdate'
            ]
        ];

        /**
         * @var ColumnBuilder $columnsBuilder
         */
        $columnsBuilder->setConfig($config);
        $this->assertInstanceOf(\DateTime::class, $columnsBuilder->buildValue('date', null));
        $this->assertEquals((new \DateTime())->format('Y-m-d'), $columnsBuilder->buildValue('date', null)->format('Y-m-d'));
    }

    /**
     *
     * @depends testBuildColumnsInstance
     */
    public function testBuildColumnDateWithSpecificDate($columnsBuilder)
    {
        $config = [
            'date' => [
                'type' => 'datetime',
                'format' => 'Y-m-d',
            ]
        ];
        $actual = '2018-04-01';

        /**
         * @var ColumnBuilder $columnsBuilder
         */
        $columnsBuilder->setConfig($config);
        $this->assertInstanceOf(\DateTime::class, $columnsBuilder->buildValue('date', $actual));
        $this->assertSame('2018-04-01', $columnsBuilder->buildValue('date', $actual)->format('Y-m-d'));
    }

    /**
     *
     * @depends testBuildColumnsInstance
     */
    public function testBuildColumnBooleanWithNullValue($columnsBuilder)
    {
        $config = [
            'active' => [
                'type' => 'boolean',
            ]
        ];

        /**
         * @var ColumnBuilder $columnsBuilder
         */
        $columnsBuilder->setConfig($config);
        $this->assertTrue($columnsBuilder->buildValue('active', 'any'));
        $this->assertFalse($columnsBuilder->buildValue('active', null));
    }

    /**
     *
     * @depends testBuildColumnsInstance
     */
    public function testBuildColumnBooleanWithValueOfTrue($columnsBuilder)
    {
        $config = [
            'active' => [
                'type' => 'boolean',
                'valueOfTrue' => 1
            ]
        ];

        /**
         * @var ColumnBuilder $columnsBuilder
         */
        $columnsBuilder->setConfig($config);
        $this->assertTrue($columnsBuilder->buildValue('active', 1));
        $this->assertFalse($columnsBuilder->buildValue('active', 2));
    }

    /**
     *
     * @depends testBuildColumnsInstance
     */
    public function testBuildColumnBooleanWithValueOfFalse($columnsBuilder)
    {
        $config = [
            'active' => [
                'type' => 'boolean',
                'valueOfFalse' => 1
            ]
        ];

        /**
         * @var ColumnBuilder $columnsBuilder
         */
        $columnsBuilder->setConfig($config);
        $this->assertFalse($columnsBuilder->buildValue('active', 1));
        $this->assertTrue($columnsBuilder->buildValue('active', 2));
    }

    /**
     *
     * @depends testBuildColumnsInstance
     */
    public function testBuildColumnRelationalByReference($columnsBuilder)
    {
        $mockedEm = $this->getMockBuilder(EntityManager::class)
            ->setMethods(['getReference'])
            ->getMock();

        $user = new EntityTest();

        $mockedEm->expects($this->once())
            ->method('getReference')
            ->with(EntityTest::class, 1)
            ->will($this->returnValue($user));

        $config = [
            'entity' => [
                'type' => 'relational',
                'entity' => EntityTest::class,
                'field' => 'id'
            ]
        ];

        /**
         * @var ColumnBuilder $columnsBuilder
         */
        $columnsBuilder->setConfig($config);
        $columnsBuilder->setEm($mockedEm);
        $this->assertSame($user, $columnsBuilder->buildValue('entity', 1));
    }

    /**
     *
     * @depends testBuildColumnsInstance
     */
    public function testBuildColumnRelationalByFind($columnsBuilder)
    {
        $mockedEm = $this->getMockBuilder(EntityManager::class)
            ->setMethods(['getRepository'])
            ->getMock();

        $mockedRepository = $this->getMockBuilder(EntityTestRepository::class)
            ->setMethods(['findOneBy'])
            ->getMock();

        $mockedEm->expects($this->once())
            ->method('getRepository')
            ->with(EntityTest::class)
            ->will($this->returnValue($mockedRepository));

        $user = new EntityTest();

        $mockedRepository->expects($this->once())
            ->method('findOneBy')
            ->with(['name' => 'value'])
            ->will($this->returnValue($user));

        $config = [
            'entity' => [
                'type' => 'relational',
                'entity' => EntityTest::class,
                'field' => 'name'
            ]
        ];

        /**
         * @var ColumnBuilder $columnsBuilder
         */
        $columnsBuilder->setConfig($config);
        $columnsBuilder->setEm($mockedEm);
        $this->assertSame($user, $columnsBuilder->buildValue('entity', 'value'));
    }
}

class EntityTest
{
}

class EntityTestRepository
{

}