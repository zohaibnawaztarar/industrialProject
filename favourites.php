 <!-- Get list of favourite procedures for user-->
<?php


    
    $sql = 'SELECT * FROM dbo.bmDB WHERE UserID=?';
    $UserID = 2;
    # run sql query on already set up database connection with custom parameters
    $result = sqlsrv_query($conn, $sql, $params);

    $rows_count = 0;
    #returns error if required.
    if ($result == FALSE) {
        echo '<h1 class="display-3 pb-5 text-center">Databse Query Error!</h1>';
        die(print_r(sqlsrv_errors(), true));
    }
    else {
        #return if no results from query.
        if (sqlsrv_has_rows($result) == 0) {
            echo '<h1 class="display-3 pb-5 text-center">No results found!</h1>';
            echo '<h1 class="display-3 pb-5 text-center"><br><br><br></h1>';
        }
        else {
            #display formatted query results on frontend.
            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                $rows_count++;
                ?>
                <div class="card my-3">
                    <div class="row no-gutters">
                        <div class="col">
                            <div class="card-body">
                                <h4 class="card-title">
                                    <?php echo $row['providerName']; ?><br>
                                    <?php echo $row['dRGDescription']; ?>
                                </h4>
                                <h3 class="card-title mb-2">
                                    $
                                    <?php echo round($row['averageTotalPayments']); ?>
                                </h3>
                                <p class="card-text">
                                    <?php echo $row['providerCity']; ?>
                                </p>
                                <form action="hospitalDetails.php" method="GET">
                                    <input type='hidden' name="providerId"
                                           value="<?php echo $row['providerId']; ?>">
                                    <?php
                                        if (empty($row['dRGCode'])) { $dRGCode = $dRGInput; }
                                        else { $dRGCode = $row['dRGCode']; }
                                    ?>
                                    <input type='hidden' name="dRGCode" value="<?php echo $dRGCode; ?>">
                                    <button class="btn btn-success buy-btn mx-1 m-auto" type="buy">
                                        <i class="fas fa-info-circle"></i> View more information
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }
        }
    }
    sqlsrv_free_stmt($result);

 ?>

</div>