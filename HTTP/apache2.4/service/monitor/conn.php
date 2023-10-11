<?php

function conn()
{
    $cf = [
        'ipClient' => 'localhost',
        'ipServer' => '10.124.100.234',
        'driver' => 'ODBC Driver 17 for SQL Server',
        'user' => '',
        'password' => '',
		'database' => 'FAPP',
        'table' => 'TB_FGT_App_User_Access',
        'column' => 'id',
    ];

    sqlsrv_configure('WarningsReturnAsErrors', 0);

    $connection = sqlsrv_connect(
        $cf['ipServer'],
        [
            //"Driver" => $cf['driver'],
            "Database" => $cf['database'],
            "UID" => $cf['user'],
            "PWD" => $cf['password']
        ]
    );

    if ($connection) {

        $query = 'SELECT TOP 1 ' . $cf["column"] . ' FROM ' . $cf["table"] . ' ORDER BY NEWID()';
        $result = sqlsrv_query($connection, $query);

        if ($result) {

            $res = [];
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $res[] = $row[$cf["column"]];
            }

            sqlsrv_close($connection);

            $msg = "Conexao bem sucedida! - ID: " . $res[0];
            //file_put_contents('conn.log', date("Y-m-d H:i:s") . ' - '.$cf['ipClient'].' > '.$cf['ipServer'].': ' . $msg . "\n", FILE_APPEND);
            return $msg;

        }

        $msg = trim(str_replace('\'', '', (sqlsrv_errors())[0]['message']));
        file_put_contents('conn.log', date("Y-m-d H:i:s") . ' - ' . $cf['ipClient'] . ' > ' . $cf['ipServer'] . ': ' . $msg . "\n", FILE_APPEND);
        return $msg;

    }

    $msg = trim(str_replace('\'', '', (sqlsrv_errors())[0]['message']));
    file_put_contents('conn.log', date("Y-m-d H:i:s") . ' - ' . $cf['ipClient'] . ' > ' . $cf['ipServer'] . ': ' . $msg . "\n", FILE_APPEND);
    return $msg;

    //return sqlsrv_errors();

}

fopen("conn.log", "a");
conn();
echo file_get_contents('conn.log');

?>