<?php

//<fileHeader>
  
//</fileHeader>

class Produto extends TRecord
{
    const TABLENAME  = 'produto';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}
    

    
    
    private $categoria;
    
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
        parent::addAttribute('quantidade');
        parent::addAttribute('categoria');
        parent::addAttribute('valor');
        parent::addAttribute('categoria_id');
        //<onAfterConstruct>
  
        //</onAfterConstruct>
    }

    /**
     * Method set_categoria
     * Sample of usage: $var->categoria = $object;
     * @param $object Instance of Categoria
     */
    public function set_categoria(Categoria $object)
    {
        $this->categoria = $object;
        $this->categoria_id = $object->id;
    }
    
    /**
     * Method get_categoria
     * Sample of usage: $var->categoria->attribute;
     * @returns Categoria instance
     */
    public function get_categoria()
    {
        
        // loads the associated object
        if (empty($this->categoria))
            $this->categoria = new Categoria($this->categoria_id);
        
        // returns the associated object
        return $this->categoria;
    }
    
    /**
     * Method getMovimentacaos
     */
    public function getMovimentacaos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('produto_id', '=', $this->id));
        return Movimentacao::getObjects( $criteria );
    }

    
    public function set_movimentacao_tipo_movimentacao_to_string($movimentacao_tipo_movimentacao_to_string)
    {
        if(is_array($movimentacao_tipo_movimentacao_to_string))
        {
            $values = TipoMovimentacao::where('id', 'in', $movimentacao_tipo_movimentacao_to_string)->getIndexedArray('nome', 'nome');
            $this->movimentacao_tipo_movimentacao_to_string = implode(', ', $values);
        }
        else
        {
            $this->movimentacao_tipo_movimentacao_to_string = $movimentacao_tipo_movimentacao_to_string;
        }

        $this->vdata['movimentacao_tipo_movimentacao_to_string'] = $this->movimentacao_tipo_movimentacao_to_string;
    }

    public function get_movimentacao_tipo_movimentacao_to_string()
    {
        if(!empty($this->movimentacao_tipo_movimentacao_to_string))
        {
            return $this->movimentacao_tipo_movimentacao_to_string;
        }
        
        $values = Movimentacao::where('produto_id', '=', $this->id)->getIndexedArray('tipo_movimentacao_id','{tipo_movimentacao->nome}');
        return implode(', ', $values);
    }

    
    public function set_movimentacao_produto_to_string($movimentacao_produto_to_string)
    {
        if(is_array($movimentacao_produto_to_string))
        {
            $values = Produto::where('id', 'in', $movimentacao_produto_to_string)->getIndexedArray('id', 'id');
            $this->movimentacao_produto_to_string = implode(', ', $values);
        }
        else
        {
            $this->movimentacao_produto_to_string = $movimentacao_produto_to_string;
        }

        $this->vdata['movimentacao_produto_to_string'] = $this->movimentacao_produto_to_string;
    }

    public function get_movimentacao_produto_to_string()
    {
        if(!empty($this->movimentacao_produto_to_string))
        {
            return $this->movimentacao_produto_to_string;
        }
        
        $values = Movimentacao::where('produto_id', '=', $this->id)->getIndexedArray('produto_id','{produto->id}');
        return implode(', ', $values);
    }

    /**
     * Method onBeforeDelete
     */
    public function onBeforeDelete()
    {
        //<onBeforeDeleteCode>
  
        //</onBeforeDeleteCode>

        if(Movimentacao::where('produto_id', '=', $this->id)->first())
        {
            throw new Exception("Não é possível deletar este registro pois ele está sendo utilizado em outra parte do sistema");
        }
        
    }
    
    //<userCustomFunctions>
  
    //</userCustomFunctions>
}

