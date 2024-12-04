<?php
class Proveidor extends \ProveidorBase 
{
    function reset($valor = 0)
    {
        parent::reset($valor);
    }
    public function set($camp, $valor)
    {
        $valor = trim($valor);
        
        switch ($camp) {
                //campos nuevos
                //idCliete //idProjecte
        }
        
        return  parent::set($camp, $valor);
    }

}
  