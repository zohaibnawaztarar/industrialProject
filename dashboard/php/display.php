<?php
//Table Generation

function tableCustomersShow($conn) {
    $sql = "SELECT * FROM dbo.userDB";
    $resultsetLogin = sqlsrv_query($conn, $sql) or die("database error:". mysqli_error($conn));
    while( $record = sqlsrv_fetch_array($resultset,SQLSRV_FETCH_ASSOC) )  {
                                    echo '<tr>
                                        <th scope="row">
                                            ' . $record['userID'] . '
                                        </th>
                                        <td>
                                        ' . $record['fName'] . '
                                        </td>
                                        <td>
                                        ' . $record['userName'] . '
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

function tableOneCustomerShow($conn, $selected_id) {
    $sql = "SELECT * FROM dbo.userDB WHERE userID = $selected_id";
    $resultset = mysqli_query($conn, $sql) or die("database error:" . mysqli_error($conn));
    while ($record = mysqli_fetch_assoc($resultset)) {
                                    echo '<tr>
                                        <th scope="row">
                                            ' . $record['userID'] . '
                                        </th>
                                        <td>
                                        ' . $record['fName'] . '
                                        </td>
                                        <td>
                                        ' . $record['userName'] . '
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