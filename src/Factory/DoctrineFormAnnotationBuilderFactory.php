<?php

namespace ZfMetal\Datagrid\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use \DoctrineORMModule\Form\Annotation\AnnotationBuilder;

class DoctrineFormAnnotationBuilderFactory implements FactoryInterface {

    public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL) {

        $factory = new \Zend\Form\Factory();
        $inputFilterFactory = new \Zend\InputFilter\Factory();
        $filterChain = new \Zend\Filter\FilterChain();
        $validatorChain = new \Zend\Validator\ValidatorChain();

        $filterChain->setPluginManager($container->get('FilterManager'));
        $validatorChain->setPluginManager($container->get('ValidatorManager'));

        $inputFilterFactory->setDefaultFilterChain($filterChain);
        $inputFilterFactory->setDefaultValidatorChain($validatorChain);

        $factory->setFormElementManager($container->get('FormElementManager'));
        $factory->setInputFilterFactory($inputFilterFactory);

        if ($options['entityManager']) {
            $em = $container->get($options['entityManager']);
        } else {
            $em = $container->get('doctrine.entitymanager.orm_default');
        }


        $builder = new AnnotationBuilder($em);
        $builder->setFormFactory($factory);

        return $builder;
    }

}
