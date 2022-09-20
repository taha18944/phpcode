<?php
    include('../datafiles/index.php');
    $request = json_decode(file_get_contents('php://input'));
    $expireUsers = array();
    $query = "SELECT u.id,u.username,u.email,DATEDIFF(now(),created_at) AS trial_time,(trial_period-DATEDIFF(now(),created_at)) as trial_period_left FROM users as u WHERE package = 'TRAIL' AND is_deleted = 'N'";
    $dbobjx->query($query);
    $results = $dbobjx->resultset();
    $error=0;
    if ($dbobjx->rowCount() > 0){
        foreach($results as $row){
            if($row->trial_period_left >= 30){
            	$error=1;
            	array_push($expireUsers, $row->id);
            }
        }
        if ($error==1) {
        	$ids = implode(',', $expireUsers);
        	$query = "UPDATE users SET package = 'FREE' WHERE id in ($ids)";
            $dbobjx->query($query);
            if($dbobjx->execute($query)){
        		echo response("1","User Updated to Free",$expireUsers);
            }
        }else{
    		echo response("0","No User found",[]);
        }
    }else{
        echo response("0","No User found",[]);
    }
    