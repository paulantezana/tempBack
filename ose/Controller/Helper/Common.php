<?php
	function requireToVar($file, $a)
	{
		ob_start();
		$parameter = $a;
		require($file);
		return ob_get_clean();
	}

	function exceptions_error_handler($severity, $message, $filename, $lineno)
	{
	  if (error_reporting() == 0) {
	    return;
	  }
	  if (error_reporting() & $severity) {
	    throw new ErrorException($message, 0, $severity, $filename, $lineno);
	  }
	}

	function ValidateController($controller)
	{
		if(!is_file(CONTROLLER_PATH . $_SESSION[CONTROLLER_GROUP] . "{$controller}Controller.php"))
		{
			return false;
		}

		return true;
	}

	function validateMethodController($controller, $method)
	{
		if(!method_exists($controller, $method))
			return false;
		return true;
	}

	class Result extends stdClass
	{
		public $success;
		public $errorMessage;

		function __construct()
		{
			$this->success = false;
			$this->errorMessage = '';
		}
	}

	class NumberFunction
	{
	    private static $UNIDADES = [
	        '',
	        'UN ',
	        'DOS ',
	        'TRES ',
	        'CUATRO ',
	        'CINCO ',
	        'SEIS ',
	        'SIETE ',
	        'OCHO ',
	        'NUEVE ',
	        'DIEZ ',
	        'ONCE ',
	        'DOCE ',
	        'TRECE ',
	        'CATORCE ',
	        'QUINCE ',
	        'DIECISEIS ',
	        'DIECISIETE ',
	        'DIECIOCHO ',
	        'DIECINUEVE ',
	        'VEINTE '
	    ];
	    private static $DECENAS = [
	        'VENTI',
	        'TREINTA ',
	        'CUARENTA ',
	        'CINCUENTA ',
	        'SESENTA ',
	        'SETENTA ',
	        'OCHENTA ',
	        'NOVENTA ',
	        'CIEN '
	    ];
	    private static $CENTENAS = [
	        'CIENTO ',
	        'DOSCIENTOS ',
	        'TRESCIENTOS ',
	        'CUATROCIENTOS ',
	        'QUINIENTOS ',
	        'SEISCIENTOS ',
	        'SETECIENTOS ',
	        'OCHOCIENTOS ',
	        'NOVECIENTOS '
	    ];
	    public static function StringFormat($number)
	    {
	        $converted = '';
	        $decimales = '';
	        $number = round($number, 2);
	        if (($number < 0) || ($number > 999999999)) {
	            return 'No es posible convertir el numero a letras';
	        }
	        $div_decimales = explode('.',$number);
	        if(count($div_decimales) > 1){
	            $number = $div_decimales[0];

	            $decNumberStr = (string) $div_decimales[1];
	            if(strlen($decNumberStr) == 1){
	                $decNumberStr .= '0';
	            }

	            $decimales = $decNumberStr . "/100";
	        }
	        else{
            	$decimales = " 00/100";
            }

	        $numberStr = (string) $number;
	        $numberStrFill = str_pad($numberStr, 9, '0', STR_PAD_LEFT);
	        $millones = substr($numberStrFill, 0, 3);
	        $miles = substr($numberStrFill, 3, 3);
	        $cientos = substr($numberStrFill, 6);
	        if (intval($millones) > 0) {
	            if ($millones == '001') {
	                $converted .= 'UN MILLON ';
	            } else if (intval($millones) > 0) {
	                $converted .= sprintf('%sMILLONES ', self::convertGroup($millones));
	            }
	        }
	        if (intval($miles) > 0) {
	            if ($miles == '001') {
	                $converted .= 'MIL ';
	            } else if (intval($miles) > 0) {
	                $converted .= sprintf('%sMIL ', self::convertGroup($miles));
	            }
	        }
	        if (intval($cientos) > 0) {
	            if ($cientos == '001') {
	                $converted .= 'UN ';
	            } else if (intval($cientos) > 0) {
	                $converted .= sprintf('%s ', self::convertGroup($cientos));
	            }
			}
			if($number == 0){
				$converted = 'CERO ';
			}

		   $valor_convertido = trim($converted) . ' CON ' . trim($decimales);
	        return trim($valor_convertido);
	    }
	    private static function convertGroup($n)
	    {
	        $output = '';
	        if ($n == '100') {
	            $output = "CIEN ";
	        } else if ($n[0] !== '0') {
	            $output = self::$CENTENAS[$n[0] - 1];
	        }
	        $k = intval(substr($n,1));
	        if ($k <= 20) {
	            $output .= self::$UNIDADES[$k];
	        } else {
	            if(($k > 30) && ($n[2] !== '0')) {
	                $output .= sprintf('%sY %s', self::$DECENAS[intval($n[1]) - 2], self::$UNIDADES[intval($n[2])]);
	            } else {
	                $output .= sprintf('%s%s', self::$DECENAS[intval($n[1]) - 2], self::$UNIDADES[intval($n[2])]);
	            }
	        }
	        return $output;
	    }
	}

	function FormatStandardDate(string $date){
	    if (!$date){
	        return '';
        }
        $expirationDate = date_create($date);
        return date_format($expirationDate,"Y-m-d");
    }

    function ValidateDNI($value)
    {
        if (is_numeric($value)) {
            return strlen($value) == 8;
        }

        return false;
    }

    function CharAt($string, $index){
        if($index < strlen($string)){
            return substr($string, $index, 1);
        }
        else{
            return -1;
        }
    }

    function ValidateRUC(string $value) : bool
    {
        if (strlen($value) !== 11){
            return false;
        }

        $value = trim((string)$value);
        $sum = 0;
        $x = 6;
        for ($i = 0; $i < strlen($value) - 1; $i++){
            if ( $i == 4 ) {
                $x = 8;
            }
            $digit = CharAt($value, $i) - '0';
            $x--;
            if ( $i==0 ) {
                $sum += ($digit*$x);
            } else {
                $sum += ($digit*$x);
            }
        }
        $diff = $sum % 11;
        $diff = 11 - $diff;
        if ($diff >= 10) {
            $diff = $diff - 10;
        }
        if ($diff == CharAt($value, strlen($value) - 1 ) - '0') {
            return true;
        }
        return false;
    }

    function ValidateIdentityDocumentNumber(string $number, string $type) {
		$res = new Result();
        switch ($type){
			case '-':
				if (preg_match('/^[\w-]{1,15}+$/',$number)){
					$res->success = true;
				}else{
					$res->errorMessage = 'El dato ingresado como numero de documento de identidad del receptor no cumple con el formato establecido';
				}
				break;
            case '6':
                if (ValidateRUC($number)){
                	$res->success = true;
                }else{
					$res->errorMessage = 'Número de RUC invalido';
				}
                break;
            case '1':
                if (ValidateDNI($number)){
                	$res->success = true;
                }else{
					$res->errorMessage = 'Número de DNI invalido';
				}
                break;
			case '0':
			case '4':
			case '7':
			case 'A':
			case 'B':
			case 'C':
			case 'D':
			case 'E':
				if (preg_match('/^[\w]{1,15}+$/',$number)){
					$res->success = true;
				}else{
					$res->errorMessage = 'El dato ingresado como numero de documento de identidad del receptor no cumple con el formato establecido';
				}
				break;
            default:
				$res->errorMessage = 'Este tipo de documento no fue reconocido por el sistema';
                break;
        }
        return $res;
    }

    Class ErrorCollector {
        private $error = [];
        private $message = "";
        private $separator = "|";

        private function getMessage(): string
        {
            $message = "";
            foreach ($this->error ?? [] as $key => $row){
                $message .= array_reduce(
                    $row['messages'] ?? [],
                    function ($a,$b){
                        return $a . $b . $this->separator;
                    },
                    ''
                );
            }
            foreach ($this->error ?? [] as $key => $row){
                if(isset($row['children'])){
                    foreach ($row['children'] ?? [] as $item){
                        foreach ($item ?? [] as $mm) {
                            $message .= array_reduce(
                                $mm['messages'] ?? [],
                                function ($a,$b){
                                    return $a . $b . $this->separator;
                                },
                                ''
                            );
                        }
                    }
                }
            }
            $this->message = trim(trim($message,$this->separator));
            return $this->message;
        }
        public function getResult()
        {
        	$res = new Result();
        	$res->errorMessage = $this->getMessage();
        	$res->error = $this->error;
			if (!(count($this->error)>0)){
				$res->success = true;
			}
        	return $res;
        }
        public function setSeparator(string $separator): void
        {
            $this->separator = $separator;
        }
        public function addError(string $key, string $message){
            if (isset($this->error[$key]['messages'])){
                $oldItem = $this->error[$key]['messages'];
                array_push($oldItem,$message);
                $this->error[$key]['messages'] = $oldItem;
            }else{
                $this->error[$key]['messages'] = [$message];
            }
        }
        public function addErrorRowChildren(string $parentName, $row, string $key, string $message){
            $item = $this->error[$parentName]['children'] ?? [];
            $row = '' . $row;
            $message = $parentName . ' - ' . $message;

            if (empty($item)){
                $this -> error [$parentName]['children'] = [
                    $row => [
                        $key => [
                            'messages' => [$message]
                        ]
                    ]
                ];
                return;
            }

            if(isset($item[$row])) {
                if (isset($item[$row][$key]['messages'])){
                    $oldItem = $item[$row][$key]['messages'];
                    array_push($oldItem,$message);
                    $item[$row][$key]['messages'] = $oldItem;
                }else{
                    $item[$row][$key]['messages'] = [ $message ];
                }
            } else {
                $item[$row][$key]['messages'] = [ $message ];
            }

            $this->error[$parentName]['children'] = $item;
        }
    }
	function ValidateFunctionRol($Conection,$module,$function,$redirection,$mensajeError){
		$queryValidate = $Conection->prepare("SELECT count(*) AS res FROM `permission_role` pr INNER JOIN `permissions` p ON pr.`id_permission`=p.`id_permission` WHERE pr.`id_rol`=:idRol AND p.module=:module AND function=:function");
		$queryValidate->bindParam(':idRol',$_SESSION[SESS_ROLE]);
		$queryValidate->bindParam(':module',$module);
		$queryValidate->bindParam(':function',$function);
        $queryValidate->execute();
		$dataPermission=$queryValidate->fetch();
		if ($dataPermission['res']>0) {
			return true;
		}else{
			$ruta=FOLDER_NAME.$redirection.'?error='.$mensajeError;
			if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
				//echo json_encode(array('result' => 'false','mesagge' => $ruta));
				echo $ruta;
				die();
				exit();
			}else{
				header("Location:".$ruta);
				die();
			}
		}
	}
	function RetrieveMessageError($code){
		$mensaje='';
		switch ($code) {
			case "500":
				$mensaje= "No tiene privilegios para esta accion. Contactese con el administrador";
				break;
			case "400":
				$mensaje= "No existe el comprobante";
				break;
		}
		return '<div class="row">
					<div class="alert alert-success" role="alert">
					<h4 class="alert-heading">Hubo un error</h4>
					<p>'.$mensaje.'</p>
				</div></div>';
	}

	function RoundCurrency(float $amount, int $precision = 2) {
        $amountRound = round($amount, $precision,PHP_ROUND_HALF_EVEN);
        $amountFormat = number_format((float)$amountRound, $precision,'.','');
        return $amountFormat;
    }
?>
