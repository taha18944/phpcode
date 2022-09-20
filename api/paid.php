<?php
    include('../datafiles/index.php');
    $request = json_decode(file_get_contents('php://input'));
    $notPaid = array();
    $query = "SELECT u.*,DATEDIFF(now(),transaction_date) as paid_days FROM users u WHERE package='PAID' AND is_deleted='N'";
    $dbobjx->query($query);
    $results = $dbobjx->resultset();
    $error=0;
    if ($dbobjx->rowCount() > 0) {
        foreach ($results as $row) {
            if ($row->type == 'Monthly') {
                $days = 33;
            }elseif ($row->type == 'Yearly') {
                $days = 368;
            }
            if($row->transaction_date == ''){
                echo response("1","User found",[]);
            }elseif($row->transaction_date != '') {
                if ($row->paid_days >= $days) {
                    $error=1;
                    array_push($notPaid, $row->id);
                }
                if ($error==1) {
                    $ids = implode(',', $notPaid);
                    $query = "UPDATE users SET package = 'FREE' WHERE id in ($ids)";
                    $dbobjx->query($query);
                    if($dbobjx->execute($query)){
                        echo response("1","User Updated to Free",$notPaid);
                    }
                }else{
                    echo response("0","No User found",[]);
                }
            }else{
                echo response("0","User Not found",[]);
            }
        }
    }