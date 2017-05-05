Back to .. [Manager](../manager.md)
# ManagerBuilder 

This Plugin allows us to generate a manager editor.

### Parameters:
* @param string $customKey  customKey configuration of ZfMetal\Datagrid
* @param object $entity Doctrine Entity

### Return:
* @return \ZfMetal\Datagrid\Manager

### Invoke:
* managerBuilder

### Example:
```
        $id = $this->params("id");
        $entity = null;
        if ($id) {
            $entity = $this->getEm()->getRepository(self::ENTITY)->find($id);
        }
        $manager = $this->managerBuilder('demo-entity-cliente', $entity);
        return ["manager" => $manager];
       
```


