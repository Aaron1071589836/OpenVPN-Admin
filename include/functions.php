<?php

  function getMigrationSchemas() {
    return [ 0, 5 ];
  }

  function updateSchema($bdd, $newKey) {
    if ($newKey === 0) {
      $req_string = 'INSERT INTO `application` (sql_schema) VALUES (?)';
    }
    else {
      $req_string = 'UPDATE `application` SET `sql_schema` = ?';
    }

    $req = $bdd->prepare($req_string);
    $req->execute(array($newKey));
  }

  function printError($str) {
    echo '<div class="alert alert-danger" role="alert">' . $str . '</div>';
  }

  function printSuccess($str) {
    echo '<div class="alert alert-success" role="alert">' . $str . '</div>';
  }

  function isInstalled($bdd) {
    $req = $bdd->prepare("SHOW TABLES LIKE 'admin'");
    $req->execute();

    if(!$req->fetch())
      return false;

    return true;
  }

  function hashPass($pass) {
    return password_hash($pass, PASSWORD_DEFAULT);
  }

  function passEqual($pass, $hash) {
    return password_verify($pass, $hash);
  }
/**
	 * 复制文件夹
	 * @param $source
	 * @param $dest
	 */
	function copydir($source, $dest){
		if (!file_exists($dest)) mkdir($dest);
		$handle = opendir($source);
		while (($item = readdir($handle)) !== false) {
			if ($item == '.' || $item == '..') continue;
			$_source = $source . '/' . $item;
			$_dest = $dest . '/' . $item;
			if (is_file($_source)) copy($_source, $_dest);
			if (is_dir($_source)) copydir($_source, $_dest);
		}
		closedir($handle);
	}
	function addFileToZip($path,$zip){
		$handler=opendir($path); //打开当前文件夹由$path指定。
		while(($filename=readdir($handler))!==false){
			if($filename != "." && $filename != ".."){//文件夹文件名字为'.'和‘..’，不要对他们进行操作
				if(is_dir($path."/".$filename)){// 如果读取的某个对象是文件夹，则递归
					addFileToZip($path."/".$filename, $zip);
				}else{ //将文件加入zip对象
					$zip->addFile($path."/".$filename);
				}
			}
		}
		@closedir($path);
	}	
?>
