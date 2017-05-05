Back to .. [Manager](../manager.md)
# ManagerRender

This Helper allows us to render a manager editor.

### Parameters:
* @param \ZfMetal\Datagrid\Manager $manager  

### Return:
* @return string manager rendered

### Invoke:
* ManagerRender

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

