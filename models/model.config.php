<?php
class WCSJ
{

    private $_dialect = env['dialect'];
    private $_host = env['hostname'];
    private $_dbname = env['dbname'];
    private $_username = env['username'];
    private $_password = env['password'];
    public $db = null;

    public function _httpGet($url, $query)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.2) AppleWebKit/536.6 (KHTML, like Gecko) Chrome/20.0.1090.0 Safari/536.6');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'x-connexion-apiconnect:Bearer WlhsS2FHSkhZMmxQYVVwSlZYcEpNVTVwU1hOSmJsSTFZME5KTmtscmNGaFdRMG81TG1WNVNuZGhSemwxV2xOSk5rbHFRVFZPZWtGNVQwUlJNMDU2U1dsTVEwb3haRmRzYTBscWIybFpiVWsxVGtkSk1FNTZSWFJhVjFKcFdrTXdNRTFxVVhoTVZHc3pXV3BaZEZscVJUQk5WRTVxV21wYWJVNTZVVFJKYVhkcFdERTVjRnBEU1RaTlUzZHBZMjA1YzFwVFNUWlhNM05wWVZkUmFVOXFTWE5KYmtwMllrZFZhVTlwU2tSaFIxWjVXVEpvYkdSWVNXbE1RMHBtV0ROU2FXSkdPWGxhVjNob1pFZHNkbUp1VFdsUGJuTnBWa2RLYzFWdE9YTmFWV3hyU1dwdmVVeERTbFZaYlhoV1l6SldlVk5YVVdsUGFrVnpTVzVPTUZsWVVqRmplVWsyVFZneE9WaFRkMmxoVjBZd1NXcHZlRTU2UlhwUFJGVjZUbFJCZDB4RFNteGxTRUZwVDJwRk0wMVVUVFJQUkdzeFRVUkJjMGx0Y0RCaFUwazJTV3ByTlUxNVNqa3Vaa0l6Y2t3M2NUVkZMWGxDU1hGSFEyaGhURlEyU25CSVgxb3lZVEpZVW5kRFlrczRUVGhNZVZvNVRRPT0='
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    public function _httpPost($url, $data)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.2) AppleWebKit/536.6 (KHTML, like Gecko) Chrome/20.0.1090.0 Safari/536.6');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'x-connexion-apiconnect:Bearer WlhsS2FHSkhZMmxQYVVwSlZYcEpNVTVwU1hOSmJsSTFZME5KTmtscmNGaFdRMG81TG1WNVNuZGhSemwxV2xOSk5rbHFRVFZPZWtGNVQwUlJNMDU2U1dsTVEwb3haRmRzYTBscWIybFpiVWsxVGtkSk1FNTZSWFJhVjFKcFdrTXdNRTFxVVhoTVZHc3pXV3BaZEZscVJUQk5WRTVxV21wYWJVNTZVVFJKYVhkcFdERTVjRnBEU1RaTlUzZHBZMjA1YzFwVFNUWlhNM05wWVZkUmFVOXFTWE5KYmtwMllrZFZhVTlwU2tSaFIxWjVXVEpvYkdSWVNXbE1RMHBtV0ROU2FXSkdPWGxhVjNob1pFZHNkbUp1VFdsUGJuTnBWa2RLYzFWdE9YTmFWV3hyU1dwdmVVeERTbFZaYlhoV1l6SldlVk5YVVdsUGFrVnpTVzVPTUZsWVVqRmplVWsyVFZneE9WaFRkMmxoVjBZd1NXcHZlRTU2UlhwUFJGVjZUbFJCZDB4RFNteGxTRUZwVDJwRk0wMVVUVFJQUkdzeFRVUkJjMGx0Y0RCaFUwazJTV3ByTlUxNVNqa3Vaa0l6Y2t3M2NUVkZMWGxDU1hGSFEyaGhURlEyU25CSVgxb3lZVEpZVW5kRFlrczRUVGhNZVZvNVRRPT0='
        ));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    private function retrievesColumn($table, $alias)
    {
        $columnname = [];
        $tabColumn = $this->db->prepare("SHOW COLUMNS FROM $table");
        try {
            $tabColumn->execute();
            $tabColumn = $tabColumn->fetchAll();
            for ($i = 0; $i < count($tabColumn); $i++) {
                array_push($columnname, $tabColumn[$i]['Field']);
            }
            return implode(",", $columnname);
        } catch (PDOException $e) {
            $exc = new LogNotification([Date('d/m/Y, H:i:s')], ["SHOW COLUMNS FROM $table"], ['Failed'], [$e->getMessage()]);
            $this->onLog($exc, 2);
            return false;
            // die($e->getMessage());
        }
    }

    public function onSynchronization($tbValues = [], $indentified, $table)
    {
        if (is_array($tbValues) && (count($tbValues) > 0)) {
            $cls = $this->retrievesColumn($table, false);
            $tabvalues = [];
            if (strlen($cls) > 0) {
                $cls = substr($cls, strpos($cls, ',', 0) + 1);
                if ($cls) {
                    // array_push($tbValues, $indentified);
                    // array_push($tbValues, 0);
                    // array_push($tbValues, 0);
                    // array_push($tbValues, 1);
                    // array_push($tbValues, date('d/m/Y, H:i:s'));
                    foreach ($tbValues as $key => $value) {
                        $val = ("'" . $value . "'");
                        array_push($tabvalues, $val);
                    }
                    try {
                        $vls = implode(',', $tabvalues);
                        $req = $this->db->prepare("INSERT INTO $table ($cls) VALUES ($vls)");
                        var_dump($req);
                        $req->execute();
                        return 200;
                    } catch (PDOException $e) {
                        $exc = new LogNotification([Date('d/m/Y, H:i:s')], ["CRUD ERROR ON ADDING : $table"], ['Failed'], [$e->getMessage()]);
                        $this->onLog($exc, 2);
                        return 503; // violation constraint
                    }
                }
                return 500;
            }
            return 500;
        }
        return 500;
    }

    public function __construct()
    {
        $this->onInit();
    }

    public function __inst()
    {
        return $this;
    }

    function nettoyerCaracteresMalformes($chaine)
    {
        // Convertit la chaîne en UTF-8 si ce n'est pas déjà le cas
        if (!mb_check_encoding($chaine, 'UTF-8')) {
            $chaine = mb_convert_encoding($chaine, 'UTF-8', mb_detect_encoding($chaine));
        }

        // Remplace les caractères malformés par des points d'interrogation
        $chaine = mb_convert_encoding($chaine, 'UTF-8', 'UTF-8');

        return $chaine;
    }

    public function onInit()
    {
        if ($this->onConnexionToDB()) {
            return true;
        } else {
            $exc = new LogNotification([Date('d/m/Y, H:i:s')], ["Error on connecting to db table"], ['Failed'], [$this->_dbname, $this->_host]);
            $this->onLog($exc, 2);
            return false; // faild writting
        }
    }

    public function onFetchingOne($query, $tablename = null)
    {
        try {
            $req = $this->db->prepare($query);
            $req->execute();
            $req = $req->fetchAll();
            // var_dump($req[0]);
            return !empty($req) && count($req) > 0 ? $req : array();
        } catch (PDOException $e) {
            $exc = new LogNotification([Date('d/m/Y, H:i:s')], ["Error writting query in $tablename table"], ['Failed'], [$e->getMessage()]);
            $this->onLog($exc, 2);
            return array(); // faild writting
        }
    }

    public function onRunningQuery($query, $tablename)
    {
        try {
            $req = $this->db->prepare($query);
            $req->execute();
            return true; // done writting
        } catch (PDOException $e) {
            $exc = new LogNotification([Date('d/m/Y, H:i:s')], ["Error writting query in $tablename table"], ['Failed'], [$e->getMessage()]);
            $this->onLog($exc, 2);
            return false; // faild writting
        }
    }

    public function onConnexionToDB()
    {
        $host = $this->_host;
        $dialect = $this->_dialect;
        $options = [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', // Définit le jeu de caractères sur UTF-8 lors de la connexion
        ];
        if (1) {
            try {
                $conn = new PDO("$this->_dialect:host=$this->_host;dbname=$this->_dbname", "$this->_username", "$this->_password",$options);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->db = $conn;
                return true;
            } catch (PDOException $e) {
                $exc = new LogNotification([Date('d/m/Y, H:i:s')], ["Connexion to DB " . $this->_dbname], ['Failed'], [$e->getMessage()]);
                $this->onLog($exc, 2);
                return false;
            }
        } else return false;
    }

    public function onLog($array, $to)
    {
        $file = ($to === 1) ? 'log/ini.initialize.ini' : 'log/log.file.ini';
        $res = array();
        foreach ($array as $key => $val) {
            if (is_array($val)) {
                $res[] = "[$key]";
                foreach ($val as $skey => $sval) $res[] = (is_numeric($sval) ? $sval : '"' . $sval . '"');
            } else $res[] = "$key = " . (is_numeric($val) ? $val : '"' . $val . '"');
        }
        $res[] = '-------------------------------------------------------------' . PHP_EOL;
        $this->safefilerewrite(implode("\r\n", $res), $file);
    }

    private function safefilerewrite($dataToSave, $fileName)
    {
        $fp = null;
        try {
            if (file_exists($fileName)) {
                $fp = fopen($fileName, 'a++');
            } else {
                $fileName = "ini.initialize.ini";
                $fp = fopen($fileName, "a++");
            }
        } catch (\Throwable $th) {
            $fileName = "ini.initialize.ini";
            $fp = fopen($fileName, "a++");
        }
        if ($fp) {
            chmod($fileName, 0777);
            $startTime = microtime(TRUE);
            do {
                $canWrite = flock($fp, LOCK_EX);
                if (!$canWrite) usleep(round(rand(0, 100) * 1000));
            } while ((!$canWrite) and ((microtime(TRUE) - $startTime) < 5));
            if ($canWrite) {
                flock($fp, LOCK_UN);
                file_put_contents($fileName, $dataToSave . PHP_EOL, FILE_APPEND);
            }
            fclose($fp);
        }
    }
}
