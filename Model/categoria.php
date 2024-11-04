<?php

//<fileHeader>
  
//</fileHeader>

class Categoria extends TRecord
{
    const TABLENAME  = 'categoria';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}
    

    
    
    
    //<classProperties>
  
    //</classProperties>
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        //<onBeforeConstruct>
  
        //</onBeforeConstruct>
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
        //<onAfterConstruct>
  
        //</onAfterConstruct>
    }

    
    /**
     * Method getProdutos
     */
    public function getProdutos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('categoria_id', '=', $this->id));
        return Produto::getObjects( $criteria );
    }

    
    public function set_produto_categoria_to_string($produto_categoria_to_string)
    {
        if(is_array($produto_categoria_to_string))
        {
            $values = Categoria::where('id', 'in', $produto_categoria_to_string)->getIndexedArray('id', 'id');
            $this->produto_categoria_to_string = implode(', ', $values);
        }
        else
        {
            $this->produto_categoria_to_string = $produto_categoria_to_string;
        }

        $this->vdata['produto_categoria_to_string'] = $this->produto_categoria_to_string;
    }

    public function get_produto_categoria_to_string()
    {
        if(!empty($this->produto_categoria_to_string))
        {
            return $this->produto_categoria_to_string;
        }
        
        $values = Produto::where('categoria_id', '=', $this->id)->getIndexedArray('categoria_id','{categoria->id}');
        return implode(', ', $values);
    }

    /**
     * Method onBeforeDelete
     */
    public function onBeforeDelete()
    {
        //<onBeforeDeleteCode>
  
        //</onBeforeDeleteCode>

        if(Produto::where('categoria_id', '=', $this->id)->first())
        {
            throw new Exception("Não é possível deletar este registro pois ele está sendo utilizado em outra parte do sistema");
        }
        
    }
    
    //<userCustomFunctions>
  
    //</userCustomFunctions>
}

