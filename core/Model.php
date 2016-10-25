<?php
class Model{
	
	static $connections = array(); 

	public $conf = 'default';
	public $table = false; 
	public $db; 
	public $primaryKey = 'id'; 
	public $id; 
	public $errors = array();
	public $form; 
	public $validate = array();

	/**
	* Permet d'initialiser les variable du Model
	**/
	public function __construct(){
		// Nom de la table
		if($this->table === false){
			$this->table = strtolower(get_class($this)).'s'; 
		}
		
		// Connection à la base ou récupération de la précédente connection
		$conf = Conf::$databases[$this->conf];
		if(isset(Model::$connections[$this->conf])){
			$this->db = Model::$connections[$this->conf];
			return true; 
		}
		try{
			$pdo = new PDO(
				'mysql:host='.$conf['host'].';dbname='.$conf['database'].';',
				$conf['login'],
				$conf['password'],
				array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
			);
			$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);

			Model::$connections[$this->conf] = $pdo; 
			$this->db = $pdo; 
		}catch(PDOException $e){
			if(Conf::$debug >= 1){
				die($e->getMessage()); 
			}else{
				die('Impossible de se connecter à la base de donnée'); 
			}
		}	 
	}

	/**
	* Permet de valider des données
	* @param $data données à valider 
	**/
	function validates($data){
		$errors = array(); 
		foreach($this->validate as $k=>$v){
				if(!isset($data->$k)){
					$errors[$k] = $v['message']; 
				}else{
					if($v['rule'] == 'notEmpty'){
						if(empty($data->$k)){
							$errors[$k] = $v['message']; 
						}
					}elseif(!preg_match('/^'.$v['rule'].'$/',$data->$k)){
						$errors[$k] = $v['message'];
					}
				}
		}
		$this->errors = $errors; 
		if(isset($this->Form)){
			$this->Form->errors = $errors; 
		}
		if(empty($errors)){
			return true;
		}
		return false;
	}



	/**
	* Permet de récupérer plusieurs enregistrements
	* @param $req Tableau contenant les éléments de la requête
	**/
	public function find($req = array()){
		$sql = 'SELECT ';
                if(isset($req['distinct'])){
                    $sql .= 'DISTINCT ';
                }
		if(isset($req['fields'])){
			if(is_array($req['fields'])){
				$sql .= implode(', ',$$req['fields']);
			}else{
				$sql .= $req['fields']; 
			}
		}else{
			$sql.='*';
		}

		$sql .= ' FROM '.$this->table.' as '.get_class($this).' ';

		// Liaison
		if(isset($req['join'])){
			foreach($req['join'] as $k=>$v){
				$sql .= 'LEFT JOIN '.$k.' ON '.$v.' '; 
			}
		}

		// Construction de la condition
		if(isset($req['conditions'])){
			$sql .= 'WHERE ';
			if(!is_array($req['conditions'])){
				$sql .= $req['conditions']; 
			}else{
				$cond = array(); 
				foreach($req['conditions'] as $k=>$v){
					if(!is_numeric($v)){
						$v = '"'.$v.'"'; 
					}
					
					$cond[] = "$k=$v";
				}
				$sql .= implode(' AND ',$cond);
			}
		}
                
                if(isset($req['group'])){
			$sql .= ' GROUP BY '.$req['group'];
		}
                
		if(isset($req['order'])){
			$sql .= ' ORDER BY '.$req['order'];
		}

                

		if(isset($req['limit'])){
			$sql .= ' LIMIT '.$req['limit'];
		}
		$pre = $this->db->prepare($sql); 
		//debug($sql);
		$pre->execute();
		return $pre->fetchAll(PDO::FETCH_OBJ);
	}

	/**
	* Alias permettant de retrouver le premier enregistrement
	**/
	public function findFirst($req){
		return current($this->find($req)); 
	}

	/**
	* Vérifie l'existence de l'id en base
	**/
	public function exist($id){
		$res=$this->findCount($this->primaryKey."=".$id);
		if ($res>0){
			$result=true;
		}else{
			$result=false;
		}
		
		return $result;
	}
	
	/**
	* Récupère le nombre d'enregistrement
	**/
	public function findCount($conditions){
		$res = $this->findFirst(array(
			'fields' => 'COUNT('.$this->primaryKey.') as count',
			'conditions' => $conditions
			));
		return $res->count;  
	}

	/**
	* Permet de récupérer un tableau indexé par primaryKey et avec name pour valeur
	**/
	function findList($req = array()){
		if(!isset($req['fields'])){
			$req['fields'] = $this->primaryKey.',name';
		}
		$d = $this->find($req); 
		$r = array(); 
		foreach($d as $k=>$v){
			$r[current($v)] = next($v); 
		}
		return $r; 
	}

	/**
	* Permet de supprimer un enregistrement
	* @param $id ID de l'enregistrement à supprimer
	**/	
	public function deleteAll($req = array()){
		$sql = "DELETE FROM {$this->table} WHERE ";
		if(!is_array($req['conditions'])){
			$sql .= $req['conditions']; 
		}else{
			$cond = array(); 
			foreach($req['conditions'] as $k=>$v){
				if(!is_numeric($v)){
					$v = '"'.$v.'"'; 
				}
				
				$cond[] = "$k=$v";
			}
			$sql .= implode(' AND ',$cond);
		}
		$this->db->query($sql); 
	}
	
	/**
	* Permet de supprimer plusieurs enregistrement
	* @param $id ID de l'enregistrement à supprimer
	**/	
	public function delete($id){
		$sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = $id";
		$this->db->query($sql); 
	}

	/**
	* Permet de sauvegarder des données
	* @param $data Données à enregistrer
	**/
	public function save($data){
		$key = $this->primaryKey;
		$fields =  array();
		$d = array(); 
		foreach($data as $k=>$v){
			if($k!=$this->primaryKey){
				$fields[] = "$k=:$k";
				$d[":$k"] = $v; 
			}elseif(!empty($v)){
				$fields[] = "$k=:$k";
				$d[":$k"] = $v;
			}
		}
		if(is_array($data)){
			if(isset($data[$key])){
				$data_key=$data[$key];
			}
		}else{
			if(isset($data->$key)){
				$data_key=$data->$key;
			}
		}
		if(isset($data_key) && !empty($data_key) && $this->findCount(array($key=>$data_key))>0){
			$sql = 'UPDATE '.$this->table.' SET '.implode(',',$fields).' WHERE '.$key.'=:'.$key;
			$this->id = $data_key; 
			$action = 'update';
		} else{
			$sql = 'INSERT INTO '.$this->table.' SET '.implode(',',$fields);
			$action = 'insert'; 
		}
		
		
		$pre = $this->db->prepare($sql); 
		// debug($sql);
		$pre->execute($d);
		if($action == 'insert'){
			$this->id = $this->db->lastInsertId(); 
		}
	}

}