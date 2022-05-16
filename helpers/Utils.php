<?php
class Utils
{
    public static function createLog($idUser, $description){
        $log = new LogGeneral();
        $log->setIdUsuario($idUser);
        $log->setDescripcion($description);
        return $log->create();
    }

    /*    

    public static function contentPrivilegios($idComponente){        
        if ($_SESSION['id_usuario'] == 1) //Admin
        {
             return true;
        }
        else
        {
            $result = false;
            foreach ($_SESSION['objetos'] as $value) {
                if($value == $idComponente){
                    $result = true;
                    break;
                }
            }
            return $result;           
        }
    }

    public static function uploadAsyncFile() {
        $result = false;
        if (array_key_exists('HTTP_X_FILE_NAME', $_SERVER) && array_key_exists('CONTENT_LENGTH', $_SERVER)) {
            $fileName = md5(uniqid())."---".$_SERVER['HTTP_X_FILE_NAME'];
            $contentLength = $_SERVER['CONTENT_LENGTH'];
        } else throw new Exception("Error retrieving headers");

        $path = 'uploadFiles/';
        if (!$contentLength > 0) {
            throw new Exception('No file uploaded!');
        }
        file_put_contents(
            $path . $fileName,
            file_get_contents("php://input")
        );        
       // chmod($path.$fileName, 0777);
        
        if($fileName)
        {
            $result = $fileName;
        }        
        return $result;
    }    

    public static function nombreEstado($idEstado){
        $estado = new Estado();
        $estado->setIdEstado($idEstado);
        $estado->getOne();
        return $estado->getNombre();
    }

    public static function addHitorial ($radicado,$descripcion,$usuario){
        $result = false;
        $historial = new Historial();        
        $historial->setIdRadicado($radicado);
        $historial->setDescripcion($descripcion);
        $historial->setIdUsuario($usuario);
        $historial = $historial->create();
        if ($historial){
            $result = $historial;
        }        
        return $result;
    }

    public static function urlSimec(){
        if(strpos($_SERVER['REMOTE_ADDR'], ipLocal) === false){
            $result = simecPublico;            
        } else {
            $result = simecLocal;
        }
        return $result;
    }

    public static function fechaHora($fechaHora){
        $fechaHora = explode(" ", $fechaHora);
        return $fechaHora;
    }

    public static function remitenteDestinatario($tipoRadicado,$idRemitente,$idDestinatario){
        switch($tipoRadicado){
            case 1:
                //Remitente - usuario
                $remitente = new UsuarioExterno();
                $remitente->setId($idRemitente);
                $remitente->getOne();
                //Destinatario - ente
                $destinatario = new Ente();
                $destinatario->setIdEnte($idDestinatario);
                $destinatario->getOne();
                //Respuesta
                $remitenteDestinatario = array($remitente->getNombre(),$destinatario->getNombre());
                break;
            case 2:
                //Remitente - ente
                $remitente = new Ente();
                $remitente->setIdEnte($idRemitente);
                $remitente->getOne();
                //Destinatario - usuario
                $destinatario = new UsuarioExterno();
                $destinatario->setId($idDestinatario);
                $destinatario->getOne();                
                break;    
            case 3:
                //Remitente - usuario
                $remitente = new UsuarioExterno();
                $remitente->setId($idRemitente);
                $remitente->getOne();
                //Destinatario - usuario
                $destinatario = new UsuarioExterno();
                $destinatario->setId($idDestinatario);
                $destinatario->getOne();
                break;        
        }
        $remitenteDestinatario = array($remitente->getNombre(),$destinatario->getNombre());
        return $remitenteDestinatario;
    }      
*/
}
