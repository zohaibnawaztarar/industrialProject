<?php
//Table Generation
function tableCustomersShow($conn, $userID) {
    $sql = "SELECT * FROM dbo.userDB WHERE userID='$userID'";
    $resultsetLogin = sqlsrv_query($conn, $sql) or die(print_r(sqlsrv_errors(), true));

        while ($record = sqlsrv_fetch_array($resultsetLogin, SQLSRV_FETCH_ASSOC)) {
            echo '<tr>
                    <th scope="row">
                        ' . $record['userName'] . '
                    </th>
                    <td>
                        ' . $record['fName'] . '
                    </td>
                    <td>
                        ' . $record['userEmail'] . '
                    </td>
                    <td>
                        ' . $record['userZipcode'] . '
                    </td>
                   </tr>';
    }
}
?>