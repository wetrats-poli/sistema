<?php

class Constants
{
    //DATABASE DETAILS
    static $DB_SERVER="auth-db213.hstgr.io";
    static $DB_NAME="u418844475_wtr";
    static $USERNAME="u418844475_wtr";
    static $PASSWORD="wetrats2019";

    //STATEMENTS
    static $SQL_SELECT_TREINOS="SELECT * FROM treinos ORDER BY data ASC";
}
class Treinos
{
    /*******************************************************************************************************************************************/
    /*
       1.CONNECT TO DATABASE.
       2. RETURN CONNECTION OBJECT
    */
    public function connect()
    {
        $con=new mysqli(Constants::$DB_SERVER,Constants::$USERNAME,Constants::$PASSWORD,Constants::$DB_NAME);
        if($con->connect_error)
        {
            // echo "Unable To Connect"; - For debug
            return null;
        }else
        {
            //echo "Connected"; - For debug
            return $con;
        }
    }
    /*******************************************************************************************************************************************/
    /*
       1.SELECT FROM DATABASE.
    */
    public function select()
    {
        $con=$this->connect();
        if($con != null)
        {
            $result=$con->query(Constants::$SQL_SELECT_TREINOS);
            if($result->num_rows>0)
            {
                $treinos=array();
                while($row=$result->fetch_array())
                {
                    array_push($treinos, array("id"=>$row['id'],"data"=>$row['data'],
                    "nome_foto"=>$row['nome_foto'],"treino"=>$row['treino'],
                    "serie_controle"=>$row['serie_controle'],"tipo"=>$row['tipo']));
                }
                print(json_encode(array_reverse($treinos)));
            }else
            {
                print(json_encode(array("PHP EXCEPTION : CAN'T RETRIEVE FROM MYSQL. ")));
            }
            $con->close();

        }else{
            print(json_encode(array("PHP EXCEPTION : CAN'T CONNECT TO MYSQL. NULL CONNECTION.")));
        }
    }
}
$treinos=new Treinos();
$treinos->select();

//end

?>