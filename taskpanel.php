<table class="ui table">
<thead><tr><th colspan="2">Tasks Panel</th></tr></thead>
<tbody>
<tr>
    <td>
    <div>
        <p>
        <strong>Issues/Concerns</strong>
        <?php  
            //$totalIsscount = checkMyTransCount("all",$arrRoles, 1);
            //$myIssues = checkMyTransCount("completed",$arrRoles, 1);
            $totalIsscount = chkTrnsCnt("all",1);
            $myIssues = chkTrnsCnt("completed", 1);

            if($totalIsscount != 0){
            $Percentage = ($myIssues / $totalIsscount) * 100;
            $issuepercent = round($Percentage,2)."%";
            }else{
                $issuepercent = 0;
            }

            //echo $issuepercent;
        ?>
        <span class="pull-right text-muted"><?php echo $myIssues." out of ".$totalIsscount." Completed"; ?></span>
        </p>

        <div class="progress progress-striped active" >
            <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="<?php echo $issuepercent; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $issuepercent; ?>">
            
            </div>
        </div>
    </div>
    </td>
</tr>
<tr>
    <td>
    <div>
        <p>
        <?php  
            //$totalReqcount = checkMyTransCount("all",$arrRoles, 2);
            //$myRequest = checkMyTransCount("completed",$arrRoles, 2);
            $totalReqcount = chkTrnsCnt("all", 2);
            $myRequest = chkTrnsCnt("completed", 2);

            if($totalReqcount != 0){
            $Percentage = ($myRequest / $totalReqcount) * 100;
            $requestpercent = round($Percentage, 2)."%";
            }
            else{
                $requestpercent = 0;
            }    
        ?>
        <strong>Requests</strong>
        <span class="pull-right text-muted"><?php echo $myRequest." out of ".$totalReqcount." Completed"; ?></span>
        </p>
        <div class="progress progress-striped active" >
            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="<?php echo $requestpercent; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $requestpercent; ?>">
            </div>
        </div>
    </div>
    </td>
</tr>
<tr>
    <td>
    <div>
        <p>
        <?php  
            //$totalcount = checkMyTransCount("all",$arrRoles, "");
            //$myIssReq = checkMyTransCount("completed",$arrRoles, "");
            $totalcount = chkTrnsCnt("all","");
            $myIssReq = chkTrnsCnt("completed", "");        

            if ($totalcount != 0) {
            $Percentage = ($myIssReq / $totalcount) * 100;
            $IssReqpercent = round($Percentage, 2)."%";
            }
            else{
                $IssReqpercent = 0;
            }
        ?>
        <strong>Completed Requests and Issues</strong>
        <span class="pull-right text-muted"><?php echo $myIssReq." out of ".$totalcount." Completed"; ?></span>
        </p>
        <div class="progress progress-striped active" >
            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $IssReqpercent; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $IssReqpercent; ?>">
            
            </div>
        </div>
    </div>
    </td>
</tr>
</tbody>
    
</table>