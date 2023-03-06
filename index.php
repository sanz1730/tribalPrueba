<?php
//#.- Creamos la Sesion para poder guardar los datos 
    session_start();
    //unset($_SESSION['data']);

    //#- Variables que se cargan por default y si  no existe el dato lo crea
    $url = "https://api.chucknorris.io/jokes/random";
    $mensaje = '<br><b>Valor Insertado Correctamente</b>';
    if(!isset($_SESSION['data'])) $_SESSION['data'] = array();
    
//#.- Declaramos donde vamos a almacenar los datos de la API
    $api = curl_init();
    curl_setopt($api, CURLOPT_URL,$url);
    curl_setopt($api, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($api);

//#.- Pasamos el Json a array y vemos cuantas posiciones tiene los datos
    $array = json_decode($data,true);
    $countData = count($_SESSION['data']);
    
//#.- Preguntamos cuantas posiciones tiene, si llega tener menos de 25 agrega un dato si no se habra alcanzado el limite 
    if($countData < 25){
    //#.- a pesar que el Endpoint da un ID diferente, validamos que no venga alguno si no no insertara el nuevo registro en nuestro arreglo
        $search = array_search($array['id'],array_column($_SESSION['data'],'id'));
        if(is_bool($search)){
            array_push($_SESSION['data'],$array);
        }else{
            $mensaje = '<br><b>Recarga la pagina ya que el dato que se intenta insertar ya esta registrado </b>';
        }
    }else{
        $mensaje = '<br><b>Se ha alcanzado el limite de datos permitidos dentro del arreglo, en la parte de arriba nos regresa nuestro arreglo completamente lleno</b>';
        print_r($_SESSION['data']);
    }

    echo '<br>'.$mensaje.': (No. Posiciones: '.$countData.')';
    
//#.- Cerramos nuestra conexion de la API    
    curl_close($api);
?>