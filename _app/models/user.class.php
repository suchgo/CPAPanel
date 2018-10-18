<?php
session_start();
include  $_SERVER['DOCUMENT_ROOT'].'/_app/functions/functions.php';
$GLOBALS['error_db_user'];
$GLOBALS['error_log_user'];

class User
{ 

  private $conn;

  
  public function __construct()
  {
    $database = new Database();
    $db = $database->dbConnection();
    $this->conn = $db;
  }
  
  public function __destruct()
  {
    $this->db = null;
  }

  public function runQuery($sql)
  {
    $stmt = $this->conn->prepare($sql);
    return $stmt;
  }

  public function lasdID()
  {
  $stmt = $this->conn->lastInsertId();
  return $stmt;
  }

  public function getUserInfo()
  {
    try
    {  
      $stmt = $this->runQuery("SELECT * FROM users WHERE id=:id ");
      $stmt->execute(array(':id' => $_SESSION['user_session']));
      $userRow = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $userRow;
    }
    catch(PDOException $e)
    {
      echo 'Ошибка. Что-то не так... Свяжитесь с администратором!';
    }     
  }

  public function addNewOffer()
  {
    try{
		$offer_id = $_POST['offer_id'];
		$tag_name = $_POST['tag_name'];
		$ref_offer = $_POST['ref_offer'];
		$stmt = $this->runQuery("SELECT name FROM offers WHERE id=:id");
		$stmt->execute(array(':id' => $offer_id));
		$offerName = $stmt->fetch(PDO::FETCH_ASSOC);
		$currentOfferName = $offerName['name']."(".$tag_name.")";
		foreach ($this->getUserInfo() as $userName);
		$destDir=$_SERVER['DOCUMENT_ROOT']."/users/".$userName['username']."/offers/".$currentOfferName;
		$sourceDir=$_SERVER['DOCUMENT_ROOT']."/mainOffers/".$offerName['name'];
		$user_db_path='http://'.$_SERVER['SERVER_NAME']."/users/".$userName['username']."/offers/".$currentOfferName."/mails.txt";
		$user_log_path='http://'.$_SERVER['SERVER_NAME']."/users/".$userName['username']."/offers/".$currentOfferName."/log_mails.txt";
		$jetSwapLinkMain = 'var prskey="<get(key)>"; <dls(http://'.$_SERVER['SERVER_NAME']."/users/".$userName['username']."/offers/".$currentOfferName."/".$offerName['name'].".txt?nocache=<rndr(1:999999)>)>";
		$jetSwapLinkTraffic = 'var prskey="<get(key)>"; <dls(http://'.$_SERVER['SERVER_NAME']."/users/".$userName['username']."/offers/".$currentOfferName."/".$offerName['name']."_traffic.txt?nocache=<rndr(1:999999)>)>";
		$jetSwapLinkActivity = 'var prskey="<get(key)>"; <dls(http://'.$_SERVER['SERVER_NAME']."/users/".$userName['username']."/offers/".$currentOfferName."/".$offerName['name']."_activity.txt?nocache=<rndr(1:999999)>)>";
		$fileName = $destDir.'/'.$offerName['name']; // имя файла
		$stmt = $this->runQuery("SELECT source_id FROM user_offers WHERE source_id=:id");
		$stmt->execute(array(':id' => $offer_id));
		$value = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt1 = $this->runQuery("SELECT offer_name FROM user_offers WHERE offer_name=:offer_name");
		$stmt1->execute(array(':offer_name' => $currentOfferName));
		$value1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
		if(strpos($tag_name, ' ')!== false){
			echo "space";
		}
		else if(count($value) >= 2){
			echo "limit";
		}
		else if(count($value1)>= 1) {
			echo "duplicate";
		}
		else {
			if ((!empty($offer_id) && $offer_id !== '-') && !empty($ref_offer) && !empty($tag_name)) {
				$stmt = $this->runQuery("INSERT INTO user_offers (offer_name, source_id, ref_offer, user_id, jetswap_link_main, jetswap_link_traffic, jetswap_link_activity, user_db_path, user_log_path) 
										VALUES (:offer_name, :source_id, :ref_offer, :user_id, :jetswap_link_main, :jetswap_link_traffic, :jetswap_link_activity, :user_db_path, :user_log_path)");
				$stmt->bindValue(":offer_name", $currentOfferName);
				$stmt->bindValue(":source_id",   $offer_id);
				$stmt->bindValue(":ref_offer",  $ref_offer);
				$stmt->bindValue(":user_id", $_SESSION['user_session']);
				$stmt->bindValue(":jetswap_link_main", $jetSwapLinkMain);
				$stmt->bindValue(":jetswap_link_traffic", $jetSwapLinkTraffic);
				$stmt->bindValue(":jetswap_link_activity", $jetSwapLinkActivity);
				$stmt->bindValue(":user_db_path", $user_db_path);
				$stmt->bindValue(":user_log_path", $user_log_path);
				$stmt->execute();
				if (!file_exists($destDir)) {
					mkdir($destDir, 0755, true);
				}
				$dirIterator = new RecursiveDirectoryIterator($sourceDir, RecursiveDirectoryIterator::SKIP_DOTS);
				$iterator    = new RecursiveIteratorIterator($dirIterator, RecursiveIteratorIterator::SELF_FIRST);
				foreach ($iterator as $object) {
					$destPath = $destDir . DIRECTORY_SEPARATOR . $iterator->getSubPathName();
					($object->isDir()) ? mkdir($destPath) : copy($object, $destPath);
				}
				//main file
				$line=1; // номер строки, которую нужно изменить
				$replace='var ourSiteLink="http://cpapanel.vibrax6t.beget.tech/users/'.$userName['username'].'/offers/'.$currentOfferName.'/admin.php";'; // на что нужно изменить
				$filename = $fileName.'.txt'; // имя файла
				$file = file($filename);
				$file[$line-1] = $replace.PHP_EOL;
				file_put_contents($filename, join('', $file));
				$line=2; // номер строки, которую нужно изменить
				$replace='var refLink="'.$ref_offer.'";'; // на что нужно изменить
				$file = file($filename);
				$file[$line-1] = $replace.PHP_EOL;
				file_put_contents($filename, join('', $file));
				//activity
				$line=1; // номер строки, которую нужно изменить
				$replace='var ourSiteLink="http://cpapanel.vibrax6t.beget.tech/users/'.$userName['username'].'/offers/'.$currentOfferName.'/activity.php";'; // на что нужно изменить
				$filename = $fileName.'_activity.txt'; // имя файла
				$file = file($filename);
				$file[$line-1] = $replace.PHP_EOL;
				file_put_contents($filename, join('', $file));
				//traffic
				$line=1; // номер строки, которую нужно изменить
				$replace='var refLink="'.$ref_offer.'";'; // на что нужно изменить
				$filename = $fileName.'_traffic.txt'; // имя файла
				$file = file($filename);
				$file[$line-1] = $replace.PHP_EOL;
				file_put_contents($filename, join('', $file));
				echo "ok";
			}
		}
    }
    catch(PDOException $e)
    {
      echo 'Ошибка. Что-то не так... Свяжитесь с администратором!';
    }     
  }

  public function getListOffers()
  {
    try
    {  
      $stmt = $this->runQuery("SELECT * FROM offers");
      $stmt->execute();
      $getListOffers = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return $getListOffers;

    }
    catch(PDOException $e)
    {
      echo 'Ошибка. Что-то не так... Свяжитесь с администратором!';
    }     
  }

  public function getUserOffers(){
      try{
          $stmt = $this->runQuery("SELECT * FROM user_offers WHERE user_id=:id");
          $stmt->bindValue(":id", $_SESSION['user_session']);
          $stmt->execute();
          $getUserOffers = $stmt->fetchAll(PDO::FETCH_ASSOC);
          return $getUserOffers;
      }
      catch(PDOException $e){
          echo 'Ошибка. Что-то не так... Свяжитесь с администратором!';
      }
  }
  
	public function deleteUserOffers(){
		try{
			$idForDell=$_POST['id'];
			$stmt = $this->runQuery("SELECT offer_name FROM user_offers WHERE user_id=:id AND id=:idForDell");
			$stmt->bindValue(":id", $_SESSION['user_session']);
			$stmt->bindValue(":idForDell", $idForDell);
			$stmt->execute();
			$currentOfferName = $stmt->fetch(PDO::FETCH_ASSOC);
			foreach ($this->getUserInfo() as $userName);
			$destDir=$_SERVER['DOCUMENT_ROOT']."/users/".$userName['username']."/offers/".$currentOfferName['offer_name'];
			$iterator = new RecursiveIteratorIterator(
				new RecursiveDirectoryIterator($destDir),
				RecursiveIteratorIterator::CHILD_FIRST
			);

			foreach ($iterator as $path) {
			  if ($path->isDir()) {
				 rmdir((string)$path);
			  } else {
				 unlink((string)$path);
			  }
			}
			rmdir($destDir);
			$stmt = $this->runQuery("DELETE FROM user_offers WHERE user_id=:id AND id=:idForDell");
			$stmt->bindValue(":id", $_SESSION['user_session']);
			$stmt->bindValue(":idForDell", $idForDell);
			$stmt->execute();
			echo "ok";
		}
		catch(PDOException $e){
			echo 'Ошибка. Что-то не так... Свяжитесь с администратором!';
		}
	}
  
  public function getCurrentOfferInfo()
  {
    try
    {
		$offerID = $_GET['id'];
		$stmt = $this->runQuery("SELECT * FROM user_offers WHERE user_id=:id AND id=:offerID");
		$stmt->bindValue(":id", $_SESSION['user_session']);
		$stmt->bindValue(":offerID", $offerID);
		$stmt->execute();
		$currentOfferRow = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $currentOfferRow;
    }
    catch(PDOException $e)
    {
      echo 'Ошибка. Что-то не так... Свяжитесь с администратором!';
    }     
  }
  
  public function getScriptTimeWork()
  {
    try
    {
		foreach ($this->getCurrentOfferInfo() as $currentOfferRow);
		$stmt = $this->runQuery("SELECT * FROM offers WHERE id=:offerID");
		$stmt->bindValue(":offerID", $currentOfferRow['source_id']);
		$stmt->execute();
		$currentOfferRow = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $currentOfferRow;
    }
    catch(PDOException $e)
    {
      echo 'Ошибка. Что-то не так... Свяжитесь с администратором!';
    }     
  }
  
  //Добавляем базу 
  public function addBase() {

    try {

        if(isset($_POST['addBase'])){
            $offerID = $_GET['id'];
			$stmt = $this->runQuery("SELECT * FROM user_offers WHERE user_id=:id AND id=:offerID");
            $stmt->bindValue(":id", $_SESSION['user_session']);
			$stmt->bindValue(":offerID", $offerID);			
            $stmt->execute();   
            $contents = $stmt->fetch(PDO::FETCH_ASSOC);
			$filepath = $contents['user_db_path'];
			$textarea_db = $_POST['db_mails'];
			$filepathCut = str_replace("http://cpapanel.vibrax6t.beget.tech", "", $filepath);
			$filename = $_SERVER['DOCUMENT_ROOT'].$filepathCut;
			$fp = fopen($filename, 'w+');
			fwrite($fp, $textarea_db);
			fclose($fp);
			echo "<div class='alert bg-teal' role='alert'><em class='fa fa-lg fa-file-o'>&nbsp;</em>База успешно обновлена!<a href='#'' class='pull-right'><em class='fa fa-lg fa-close'></em></a></div>";
		}
	}
    catch(PDOException $e)
    {
      echo "<div class='alert bg-denger' role='alert'><em class='fa fa-lg fa-warning'>&nbsp;</em>Произошла ошибка. Обратитесь к администратору!<a href='#'' class='pull-right'><em class='fa fa-lg fa-close'></em></a></div>";
    }

  }

  //Показываем базу 
  public function userBase() {

    try {
		$offerID = $_GET['id'];
		$stmt = $this->runQuery("SELECT * FROM user_offers WHERE user_id=:id AND id=:offerID");
		$stmt->bindValue(":id", $_SESSION['user_session']);
		$stmt->bindValue(":offerID", $offerID);        
		$stmt->execute();   
		$contents = $stmt->fetch(PDO::FETCH_ASSOC);
		if($contents['user_db_path']!=''){
			if($filecontent = file_get_contents($contents['user_db_path']) !== false)
				return file_get_contents($contents['user_db_path']);
			$GLOBALS['error_db_user'] = true;
		}
		else
			$GLOBALS['error_db_user'] = true;
	}
		catch(PDOException $e)
		{
		echo 'Ошибка. Что-то не так... Свяжитесь с администратором!';
		}   

  }
  
  public function clearLog() {

    try {

        if(isset($_POST['clearLog'])){
            $offerID = $_GET['id'];
			$stmt = $this->runQuery("SELECT * FROM user_offers WHERE user_id=:id AND id=:offerID");
            $stmt->bindValue(":id", $_SESSION['user_session']);
			$stmt->bindValue(":offerID", $offerID);			
            $stmt->execute();   
            $contents = $stmt->fetch(PDO::FETCH_ASSOC);
			$filepath = $contents['user_log_path'];
			$textarea_db = '';
			$filepathCut = str_replace("http://cpapanel.vibrax6t.beget.tech", "", $filepath);
			$filename = $_SERVER['DOCUMENT_ROOT'].$filepathCut;
			$fp = fopen($filename, 'w+');
			fwrite($fp, $textarea_db);
			fclose($fp);
			echo "<div class='alert bg-teal' role='alert'><em class='fa fa-lg fa-file-o'>&nbsp;</em>Логи успешно очищены!<a href='#'' class='pull-right'><em class='fa fa-lg fa-close'></em></a></div>";
		}
	}
    catch(PDOException $e)
    {
      echo "<div class='alert bg-denger' role='alert'><em class='fa fa-lg fa-warning'>&nbsp;</em>Произошла ошибка. Обратитесь к администратору!<a href='#'' class='pull-right'><em class='fa fa-lg fa-close'></em></a></div>";
    }

  }
  
  //Показываем логи 
  public function logBase() {

    try {
		$offerID = $_GET['id'];
		$stmt = $this->runQuery("SELECT * FROM user_offers WHERE user_id=:id AND id=:offerID");
		$stmt->bindValue(":id", $_SESSION['user_session']);
		$stmt->bindValue(":offerID", $offerID);        
		$stmt->execute();   
		$contents = $stmt->fetch(PDO::FETCH_ASSOC);
		if($contents['user_log_path']!=''){
			if($filecontent = file_get_contents($contents['user_log_path']) !== false)
				return file_get_contents($contents['user_log_path']);
			$GLOBALS['error_log_user'] = true;
		}
		else
			$GLOBALS['error_log_user'] = true;
	}
		catch(PDOException $e)
		{
		echo 'Ошибка. Что-то не так... Свяжитесь с администратором!';
		}   

  }

  public function doLogin($username,$password)
  {
    try
    {
      if($username == "") 
        $error[] = "<div class='alert bg-danger' role='alert'><em class='fa fa-lg fa-warning'>&nbsp;</em>Введите логин!<a href='#'' class='pull-right'><em class='fa fa-lg fa-close'></em></a></div>";
      else if($password == "") 
        $error[] = "<div class='alert bg-danger'  role='alert'><em class='fa fa-lg fa-warning'>&nbsp;</em>Введите пароль!<a href='#'' class='pull-right'><em class='fa fa-lg fa-close'></em></a></div>";
      else{

        $stmt = $this->runQuery("SELECT * FROM users WHERE username =:username");
        $stmt->bindValue(":username", $username);            
        $stmt->execute();  
        $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
        if($stmt->rowCount() == 1)
        {
          if($password == $userRow['password'])
          {
            $_SESSION['user_session']  = $userRow['id'];
            $this->redirect('/');
          }
          else
          {
            echo "<div class='alert bg-danger'  role='alert'><em class='fa fa-lg fa-warning'>&nbsp;</em>Неверный пароль!<a href='#'' class='pull-right'><em class='fa fa-lg fa-close'></em></a></div>";
          }
        } 
        else {
          echo "<div class='alert bg-danger'  role='alert'><em class='fa fa-lg fa-warning'>&nbsp;</em>Неверный логин или пароль!<a href='#'' class='pull-right'><em class='fa fa-lg fa-close'></em></a></div>";
        }

      } 
      $this->getError($error);
    }
    catch(PDOException $e)
    {
      echo 'Ошибка. Что-то не так... Свяжитесь с администратором!';
    }        
  }


  public function getError($error)
  {
    if(isset($error)) 
    {
      foreach($error as $error) 
      {
        echo $error;
      }
    }
    return true;
  }


  public function is_loggedin()
  {
    if(isset($_SESSION['user_session']))
    {
      return true;
    }
  }


  
  public function redirect($url)
  {
      echo '<script>window.location.href = "'.$url.'"</script>';
  }
  
  public function doLogout()
  {
    session_destroy();
    unset($_SESSION['user_session']);
    $this->redirect('/');
    return true;
  }
  
}
