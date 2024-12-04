<?php
class ProveidorBase{
   
    //taula proveidors
    protected $a_camps_proveidors = array(); //araay con todos los campos que se quieren modificar y al hacer el Desa se borra
    private $a_postFuncionProveidors= array(); //para llamar a las funciones despues de modifecar
    private $a_preFuncionProveidors= array(); //para llamar a las funciones antes de modifecar/interta
    protected $idProveidor; //identificador unic del proveidor                  
    protected $nomProveidor; //Nom del proveidor
    protected $emailProveidor; // string email del proveidor
    protected $contrasenyaProveidor; // string contrasenya del proveidor    
    protected $localitzadorProveidor;// string
    protected $nomFacturacioProveidor;// string Nom de facturacio
    protected $direccioFacturacioProveidor;//varchar(255) - Direccio de facturacio
    protected $cpFacturacioProveidor; //varchar(255) - Codi Postal de facturacio
    protected $poblacioFacturacioProveidor; //varchar(255) - Població de facturacio
    protected $provinciaFacturacioProveidor;//varchar(255) - Provincia de facturacio
    protected $codiPaisFacturacioProveidor;//varchar(2) - Codi ISO del PAIS
    protected $paisFacturacioProveidor;//varchar(255) - Pais de facturacio
    protected $cifFacturacioProveidor;// string CIF
    protected $telProveidor;//varchar(255= - Telefon del proveidor
    protected $tokenProveidor;//varchar 255 tokenProveidor
    protected $idUsuariModificacio;// Camp de control
    protected $idUsuariCreacio; //Camp de control
    protected $dataModificacio;//Camp de control
    protected $dataCreacio;//Camp de control
    protected $idEmpresa;
    protected $correuFacturacioProveidor;
    protected $flagActiuProveidor; //int - default 1 -> Per saber si estan actiu o no  0=NO actiu o BAIXA, 1=Actiu
    protected $longitudComptaComptableProveidor; // int
    protected $idFormaPagament;
    protected $dia1Pagament;//varchar(255)
    protected $dia2Pagament;//varchar(255)    
    protected $compteBancariProveidor;//varchar(255)
    protected $codiComptableProveidor;
    protected $dataBaixaProveidor;
    protected $comentarisProveidor;//mediumtext

    
    //Variables internes
    private $filtroEmpresa=1;//siempre filtra por empresa si no quieres hay que ponerla en 0
    protected $resultat;
    protected $errorMysql;
    protected $sql_query;
    protected $db; 
    protected $msgError;
    protected $tipusError;

    protected $resultatSet;
    protected $table_bbdd;
    protected $postFuncion;
    protected $preFuncion;

    function reset($valor=0){
        if(!$valor){
            $this->a_camps_proveidors= array();
            $this->idProveidor=0;  
            $this->nomProveidor='';
            $this->emailProveidor=''; 
            $this->contrasenyaProveidor='';
            $this->localitzadorProveidor='';
            $this->nomFacturacioProveidor='';
            $this->direccioFacturacioProveidor='';
            $this->cpFacturacioProveidor='';
            $this->poblacioFacturacioProveidor='';
            $this->provinciaFacturacioProveidor='';
            $this->codiPaisFacturacioProveidor='';
            $this->paisFacturacioProveidor='';
            $this->cifFacturacioProveidor='';
            $this->telProveidor='';
            $this->tokenProveidor='';
            $this->idEmpresa=0;
            $this->correuFacturacioProveidor='';
            $this->flagActiuProveidor=0;
            $this->longitudComptaComptableProveidor=0;
            $this->idFormaPagament=0;
            $this->dia1Pagament='';
            $this->dia2Pagament='';   
            $this->compteBancariProveidor='';
            $this->codiComptableProveidor='';
            $this->dataBaixaProveidor='';
            $this->comentarisProveidor='';
        }

        

        $this->idUsuariModificacio=0;
        $this->idUsuariCreacio=0; 
        $this->dataModificacio='';
        $this->dataCreacio='';


        $this->errorMysql = '';
        $this->msgError = '';
        $this->sql_query = '';
        $this->tipusError='';
        //para set
        $this->resultatSet=false;
        $this->table_bbdd='';
        $this->postFuncion='';
        $this->preFuncion='';

    }

    /**
    * Constructor que Carrega les propietats de l'object amb els valors de la id passada o sino es passa res es reseteja l'objecte.
    * @param int $idProveidor , identificador que volem carregar.
    * @param obj $db, link de la bbdd
    * @return void
    */
    public function __construct($db,$idProveidor=0){
        if(!esEnter($idProveidor)){die('[ERROR a Proveidor.class] $idProveidor ha de ser un int');}//validació de tipus
        if(!($db instanceof Db)){die("[ERROR a Proveidor.class] l'objecte Db no s'ha passat al contructor o no es correcte");}//validació de tipus
        $this->db = $db;//desem la connexió a la bbdd
        //carreguem les dades de l'entrada o inicialitzem
        
        if($idProveidor!=0) { $this->carregaDades($idProveidor);}
        else {$this->reset();}
    }

    public function __destruct(){}

    /*
     *  TOTS els GET i SET dels camps!!
     * 
     */
    public function set($camp, $valor){
        $valor=trim($valor);
        if(!$this->table_bbdd) $this->table_bbdd="proveidors";
        switch ($camp) {
            //id no es modifica al fer insert ni update
            case "idProveidor":  $tipoValor="enter"; if(esTipo($tipoValor,$valor)) {$this->$camp = $valor;return TRUE;}else { $this->msgError="El valor ".$valor." del camp ".$camp." no és $tipoValor"; } break; 
            //la resta de camps
            case "nomProveidor": $tipoValor="string"; if(esTipo($tipoValor,$valor)){ $this->resultatSet= TRUE;}else{$this->msgError="El valor ".$valor." del".$camp." no és $tipoValor";}break;
            case "emailProveidor": $tipoValor="string"; if(esTipo($tipoValor,$valor)){ $this->resultatSet= TRUE;}else{$this->msgError="El valor ".$valor." del".$camp." no és $tipoValor";}break;
            case "contrasenyaProveidor": $tipoValor="string"; if(esTipo($tipoValor,$valor)){ $this->resultatSet= TRUE;}else{$this->msgError="El valor ".$valor." del".$camp." no és $tipoValor";}break;
            case "localitzadorProveidor": $tipoValor="string"; if(esTipo($tipoValor,$valor)){ $this->resultatSet= TRUE;}else{$this->msgError="El valor ".$valor." del".$camp." no és $tipoValor";}break;
            case "nomFacturacioProveidor": $tipoValor="string"; if(esTipo($tipoValor,$valor)){ $this->resultatSet= TRUE;}else{$this->msgError="El valor ".$valor." del".$camp." no és $tipoValor";}break;
            case "direccioFacturacioProveidor": $tipoValor="string"; if(esTipo($tipoValor,$valor)){ $this->resultatSet= TRUE;}else{$this->msgError="El valor ".$valor." del".$camp." no és $tipoValor";}break;
            case "cpFacturacioProveidor": $tipoValor="string"; if(esTipo($tipoValor,$valor)){ $this->resultatSet= TRUE;}else{$this->msgError="El valor ".$valor." del".$camp." no és $tipoValor";}break;
            case "poblacioFacturacioProveidor": $tipoValor="string"; if(esTipo($tipoValor,$valor)){ $this->resultatSet= TRUE;}else{$this->msgError="El valor ".$valor." del".$camp." no és $tipoValor ";}break;
            case "provinciaFacturacioProveidor": $tipoValor="string"; if(esTipo($tipoValor,$valor)){ $this->resultatSet= TRUE;}else{$this->msgError="El valor ".$valor." del".$camp." no és $tipoValor ";}break;
            case "codiPaisFacturacioProveidor": $tipoValor="string"; if(esTipo($tipoValor,$valor)){ $this->resultatSet= TRUE;}else{$this->msgError="El valor ".$valor." del".$camp." no és $tipoValor ";}break;
            case "paisFacturacioProveidor": $tipoValor="string"; if(esTipo($tipoValor,$valor)){ $this->resultatSet= TRUE;}else{$this->msgError="El valor ".$valor." del".$camp." no és $tipoValor ";}break;
            case "cifFacturacioProveidor": $tipoValor="string"; if(esTipo($tipoValor,$valor)){ $this->resultatSet= TRUE;}else{$this->msgError="El valor ".$valor." del".$camp." no és $tipoValor";}break;
            case "telProveidor": $tipoValor="string"; if(esTipo($tipoValor,$valor)){ $this->resultatSet= TRUE;}else{$this->msgError="El valor ".$valor." del".$camp." no és $tipoValor";}break;
            case "tokenProveidor": $tipoValor="string"; if(esTipo($tipoValor,$valor)){ $this->resultatSet= TRUE;}else{$this->msgError="El valor ".$valor." del".$camp." no és $tipoValor";}break;
            case "correuFacturacioProveidor": $tipoValor="string"; if(esTipo($tipoValor,$valor)){ $this->resultatSet= TRUE;}else{$this->msgError="El valor ".$valor." del".$camp." no és $tipoValor";}break;
            case "idEmpresa":$tipoValor="enter"; if(esTipo($tipoValor,$valor)){$this->resultatSet= TRUE;}else{$this->msgError="El camp ".$camp." no és ".$tipoValor;}break;
            case "flagActiuProveidor":$tipoValor="enter"; if(esTipo($tipoValor,$valor)){$this->resultatSet= TRUE;}else{$this->msgError="El camp ".$camp." no és ".$tipoValor;}break;
            case "longitudComptaComptableProveidor":$tipoValor="enter"; if(esTipo($tipoValor,$valor)){$this->resultatSet= TRUE;}else{$this->msgError="El camp ".$camp." no és ".$tipoValor;}break;            
            case "idFormaPagament": $tipoValor="enter"; if(esTipo($tipoValor,$valor)){ $this->resultatSet= TRUE;}else{$this->msgError="El valor ".$valor." del".$camp." no és $tipoValor";}break;
            case "dia1Pagament": $tipoValor="string"; if(esTipo($tipoValor,$valor)){ $this->resultatSet= TRUE;}else{$this->msgError="El valor ".$valor." del".$camp." no és $tipoValor";}break;
            case "dia2Pagament": $tipoValor="string"; if(esTipo($tipoValor,$valor)){ $this->resultatSet= TRUE;}else{$this->msgError="El valor ".$valor." del".$camp." no és $tipoValor";}break; 
            case "compteBancariProveidor": $tipoValor="string"; if(esTipo($tipoValor,$valor)){ $this->resultatSet= TRUE;}else{$this->msgError="El valor ".$valor." del".$camp." no és $tipoValor";}break;
            case "codiComptableProveidor": $tipoValor="string"; if(esTipo($tipoValor,$valor)){ $this->resultatSet= TRUE;}else{$this->msgError="El valor ".$valor." del".$camp." no és $tipoValor";}break;
            case "dataBaixaProveidor": $tipoValor="date"; if(esTipo($tipoValor,$valor)){ $this->resultatSet= TRUE;}else{$this->msgError="El valor ".$valor." del".$camp." no és $tipoValor";}break;
            case "comentarisProveidor": $tipoValor="string"; if(esTipo($tipoValor,$valor)){ $this->resultatSet= TRUE;}else{$this->msgError="El valor ".$valor." del".$camp." no és $tipoValor";}break;            

            //variables internes
            case 'filtroEmpresa':$tipoValor="enter"; if(esTipo($tipoValor,$valor)){$this->$camp=$valor; return TRUE;}else{$this->msgError="El camp ".$camp." no és ".$tipoValor;}break;
                        
            default : $this->msgError="No hi ha el camp";

        }
        if($this->resultatSet==TRUE){
            if($this->table_bbdd =='proveidors' && (!in_array($camp,$this->a_camps_proveidors))){
                $this->a_camps_proveidors[]=$camp;
                if ($this->postFuncion && !in_array($this->postFuncion, $this->a_postFuncionProveidors)) $this->a_postFuncionProveidors[] = $this->postFuncion;
                if ($this->preFuncion && !in_array($this->preFuncion, $this->a_preFuncionProveidors)) $this->a_preFuncionProveidors[] = $this->preFuncion;
            }/* elseif($this->table_bbdd=='llocsEntregaProveidor' && (!in_array($camp,$this->a_camps_llocsEntregaProveidor))){
                $this->a_camps_llocsEntregaProveidor[]=$camp;
                if ($this->preFuncion && !in_array($this->preFuncion, $this->a_prePostFuncionLlocsEntrega)) $this->a_prePostFuncionLlocsEntrega[] = $this->preFuncion;
            } */
            $this->$camp = $valor;
            $this->resultatSet=false;
            $this->table_bbdd='';
            $this->postFuncion='';
            $this->preFuncion='';
            return TRUE;
        }
        $this->resultatSet=false;
        $this->table_bbdd='';
        $this->postFuncion='';
        $this->preFuncion='';
        return FALSE;
    }
    function postFuncionSet($a_postFuncion,$postFuncion){
        if ($postFuncion && !in_array($postFuncion, $this->$a_postFuncion)) $this->$a_postFuncion[] = $postFuncion;         
    }
    /* funcio generica per GET */
    public function get($camp) {
        return $this->$camp;
    }
    public function get_errorMysql(){return $this->errorMysql;}
    public function get_msgError(){return $this->msgError;}
    public function get_sql_query(){return $this->sql_query;}
    public function get_resultat(){return $this->resultat; }
    public function get_idProveidor(){return (int)$this->idProveidor;}
    public function get_tipusError(){ return $this->tipusError;}

    /**
    * Retorna un array multidimensional amb totes les entrades amb el filtre i el limit dels paràmetres
    * 
    * @param string $filtre , SQL que s'empalmarà despres del select * from TAULA
    * @param string $ordre , per dir per quin camp vols ordenar
    * @param string $limit , limit per la query
    *
    * @return Array , array amb tots els Ids coincidents amb el filtre / return 0 di no hi ha resultats
    */
    public function getIds($filtre=0,$ordre=0,$limit=0,$group=0){
        if(!$filtre) $filtre='';
        if ($this->filtroEmpresa) {
            if (isset($_SESSION['SESSIO_' . CONF_DB_BBDD . '_idEmpresa']) && $_SESSION['SESSIO_' . CONF_DB_BBDD . '_idEmpresa'] > 0) {
                if ($filtre) {
                    $filtre .= ' and ';
                }
                $filtre.= ' (idEmpresa =' . $_SESSION['SESSIO_' . CONF_DB_BBDD . '_idEmpresa'].' or idEmpresa = 0 )';
            }
        }
        if($filtre) $filtre=' where '.$filtre;
        $this->sql_query="select idProveidor from proveidors $filtre";
        if($group) {$this->sql_query .= " GROUP BY ".$group;}
        if($ordre) {$this->sql_query .= " ORDER BY ".$ordre;}
        if($limit) {$this->sql_query .= " limit ".$limit;}
        $this->resultat = $this->db->select($this->sql_query);
        return $this->resultat;
    }

    /**
    * Carrega les propietats de l'objecte amb els valors de l'entrada amb l'identificador
    * 
    * @param int $idProveidor , entrada de la que volem la informació. Si zero carreguem id de l'objecte
    *
    * @return bool , true si ha carregat l'entrada, false si no(p.ex. no existeix l'entrada)
    */
    public function carregaDades($idProveidor=0){
        if($idProveidor) {if(!$this->set('idProveidor',$idProveidor)) return FALSE;}
        if($this->idProveidor){
            $this->sql_query = "SELECT * from proveidors WHERE idProveidor=" . $this->idProveidor . ";";
            $result = $this->db->query($this->sql_query);
            if($fila=$this->db->fetch_object($result)){
            
                $propietats = get_object_vars($fila);
                foreach( array_keys( $propietats ) as $propietat ){
                    
                        $this->$propietat = ($propietats[$propietat]);
                }
                return true;
            }else{
                $this->msgError="resultat buit"; 
                $this->errorMysql= 'Error '.$this->db->error(); 
                die('[ERROR a Proveidor.class] $idProveidor no existeix');
            }
        }else{
            die('[ERROR a Proveidor.class] idProveidor: $idProveidor ha de ser un valor');
        }
        return false;
    }
    function desa(){
          if (!$this->idProveidor) {
            if($this->insereix()) return TRUE;
        } else {
         $SQL='';
         if (count($this->a_camps_proveidors)) {
            foreach ($this->a_camps_proveidors as $camp) {
                      if ($SQL) $SQL .= ',';
                      $SQL .= $camp . ' = "' . addslashes($this->$camp) . '"';
            }
            $SQL .= ',idUsuariModificacio="' . $_SESSION['SESSIO_' . CONF_DB_BBDD . '_idUsuari'] . '"';
            $SQL .= ',dataModificacio=now()';
            $this->sql_query = 'UPDATE proveidors set '.$SQL.' where idProveidor='.$this->idProveidor;
            if($this->db->query($this->sql_query)){ 
                return true;                
            }else{
                $this->errorMysql= 'error '.$this->db->error(); 
                $this->msgError='Error en modificar ';
            }
         }   
        }return false;
    }

    /**
    * Retorna un array multidimensional amb TOTES les entrades amb el filtre i el limit dels paràmetres
    * 
    * @param string $filtre , SQL que s'empalmarà despres del select * from TAULA
    * @param string $ordre , per dir per quin camp vols ordenar
    * @param string $limit , limit per la query
    *
    * @return Array , array amb TOTS ELS CAMPS coincidents amb el filtre / return 0 di no hi ha resultats
    */
    function llista($filtre=0,$ordre=0,$limit=0){
        if(!$filtre) $filtre='';
        if ($this->filtroEmpresa) {
            if (isset($_SESSION['SESSIO_' . CONF_DB_BBDD . '_idEmpresa']) && $_SESSION['SESSIO_' . CONF_DB_BBDD . '_idEmpresa'] > 0) {
                if ($filtre) {
                    $filtre .= ' and ';
                }
                $filtre.= ' (idEmpresa =' . $_SESSION['SESSIO_' . CONF_DB_BBDD . '_idEmpresa'].' OR idEmpresa = 0 )';
            }
        }
        if($filtre) $filtre=' where '.$filtre;
        $this->sql_query="select * from proveidors $filtre";
        if($ordre) {$this->sql_query .= " ORDER BY ".$ordre;}
        if($limit) {$this->sql_query .= " limit ".$limit;}
        //echo $this->sql_query;
        $this->resultat = $this->db-> select($this->sql_query);
        return $this->resultat;
    }
    function extreu(){
		$this->reset();
		if($fila=$this->db->fetch_object($this->resultat)){
			$propietats = get_object_vars($fila);
			foreach( array_keys( $propietats ) as $propietat ){
				$this->$propietat = $propietats[$propietat];
			}
		}else $this->idProveidor=0;
		return($this->idProveidor);
	}
    function insereix(){
        if(!in_array('idEmpresa',$this->a_camps_proveidors) ){
            if(!defined(CONF_MULTIEMPRESA_PROVEIDOR) || !CONF_MULTIEMPRESA_PROVEIDOR) $this->set('idEmpresa',$_SESSION['SESSIO_' . CONF_DB_BBDD . '_idEmpresa']);
        }
        if($this->nomProveidor){
            // $this->set('tokenProveidor',$this->generarToken());
            $this->set('codiComptableProveidor',($this->maxCodiComptableProveidor()+1));
            $SQL='';
            foreach ($this->a_camps_proveidors as $camp) {
                      if ($SQL) $SQL .= ',';
                      $SQL .= $camp . ' = "' . addslashes($this->$camp) . '"';
            } 
            $idUsuariCreacio=$_SESSION['SESSIO_' . CONF_DB_BBDD . '_idUsuari'];
            //Creem un localitzador alfanueric aleatori
            $SQL .= ",idUsuariCreacio='$idUsuariCreacio'";
            $SQL .= ',dataCreacio= now()';
            $SQL .= ",idUsuariModificacio='$idUsuariCreacio'";
            $SQL .= ',dataModificacio=now()';
            $SQL = "INSERT INTO proveidors SET ".$SQL;
            $this->sql_query=$SQL;
            $this->db->query($this->sql_query);
            if($this->idProveidor= $this->db->get_ultima_mysql_insert_id()){return TRUE;}
            else {$this->msgError="no s'ha pogut afegir el proveidor";$this->errorMysql= $this->db->error();}
        }else{$this->msgError="falta el camp de nom proveidor";}
        return false;
    }

    function elimina(){
        if($this->idProveidor){
            if(class_exists('ComandaProveidor')){
                $comandaProveidor = new ComandaProveidor($this->db);
                if($comandaProveidor->numComandaProveidor('idProveidor=' . $this->idProveidor)){
                    $this->msgError=T_PROVEIDOR_ERROR_ESBORRAR_COMANDA;
                    return false;
                }
            }
            if(class_exists('AlbaraProveidor')){
                $albaraProveidor = new AlbaraProveidor($this->db);
                if($albaraProveidor->numAlbaraProveidor('idProveidor=' . $this->idProveidor)){
                    $this->msgError=T_PROVEIDOR_ERROR_ESBORRAR_ALBARA;
                    return false;
                }
            }
            if(class_exists('FacturaProveidor')){
                $facturaProveidor = new FacturaProveidor($this->db);
                if($facturaProveidor->numFacturaProveidor('idProveidorFacturaProveidor=' . $this->idProveidor)){
                    $this->msgError=T_PROVEIDOR_ERROR_ESBORRAR_FACTURA;
                    return false;
                }
            }
           
            // if($numUsuaris) {
            //     $this->msgError="El proveidor està relacionada amb algunn Usuari";
            //     $this->tipusError="info";
            //     return false;
            // }
            $this->sql_query="DELETE from proveidors WHERE idProveidor=$this->idProveidor";
            if($this->db->query($this->sql_query)){
                if(class_exists('Producte')){
                    $producteTMP = new Producte($this->db);
                    if($producteTMP->getIdsPreusProductesProveidors('idProveidor='. $this->idProveidor)){
                        while($producteTMP->extreu()){
                            $producteTMP2 = new Producte($this->db);
                            $producteTMP2->set('idPreuProveidor',$producteTMP->get('idPreuProveidor'));
                            $producteTMP2->eliminaPreuProveidor();
                        }
                    }
                }
                return true;
            }else{ $this->errorMysql= $this->db->error(); $this->msgError="no se ha podido eliminar el proveedor";}
        }else{$this->msgError = "falta identificador";}
        return FALSE;
    }

    function numProveidors($filtre=0){
        if(!$filtre) $filtre='';
        if ($this->filtroEmpresa) {
            if (isset($_SESSION['SESSIO_' . CONF_DB_BBDD . '_idEmpresa']) && $_SESSION['SESSIO_' . CONF_DB_BBDD . '_idEmpresa'] > 0) {
                if ($filtre) {
                    $filtre .= ' and ';
                }
                $filtre.= ' (idEmpresa =' . $_SESSION['SESSIO_' . CONF_DB_BBDD . '_idEmpresa'].' or idEmpresa = 0 )';
            }
        }
        if($filtre) $filtre=' where '.$filtre;
            $this->sql_query="SELECT count(idProveidor) as numTotal from proveidors $filtre";
            $this->resultat=$this->db->query($this->sql_query);
            if($fila=@$this->db->fetch_object($this->resultat)) $numTotal=$fila->numTotal;
            else $numTotal=0;
            //echo $this->db->error();
            return($numTotal);
    }

    function maxCodiComptableProveidor($filtre=0){
        if(!$filtre) $filtre='';
        if ($this->filtroEmpresa) {
            if (isset($_SESSION['SESSIO_' . CONF_DB_BBDD . '_idEmpresa']) && $_SESSION['SESSIO_' . CONF_DB_BBDD . '_idEmpresa'] > 0) {
                if ($filtre) $filtre .= ' and ';                
                $filtre.= ' (idEmpresa =' . $_SESSION['SESSIO_' . CONF_DB_BBDD . '_idEmpresa'].' or idEmpresa = 0 )';
            }
        }
        if ($filtre) $filtre .= ' and ';                
        $filtre.= ' codiComptableProveidor like "400%"';
        if($filtre) $filtre=' where '.$filtre;
            $this->sql_query="SELECT max(codiComptableProveidor) as numTotal from proveidors $filtre";
            $this->resultat=$this->db->query($this->sql_query);
            if($fila=@$this->db->fetch_object($this->resultat)) $numTotal=$fila->numTotal;
            else $numTotal=0;
            //echo $this->db->error();
            return($numTotal);
    }

    function generarToken(){
        $key=generarTokenCodigo();
        $numProveidors=$this->numProveidors("WHERE tokenProveidor='".$key."'");
        while($numProveidors>0){
            $key=generarTokenCodigo();
            $numProveidors=$this->numProveidors("WHERE tokenProveidor='".$key."'");
        }
        return $key;
    }

}