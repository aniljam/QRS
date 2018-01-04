<div class="ui pink ribbon label">Active Transactions</div>
    <table class="ui sortable celled striped table">
    <thead>
    <tr>
    <th>Id</th>
    <th>Type</th>
    <th>Date</th>
    <th>Category</th>
    <th>Sub-Category</th>
    <th>Created By</th>
    <th>Status</th>
    <th></th>   
    </tr>
    </thead>
    <tbody>
        <?php
        if(isset($_GET[type])){
            $addFilter = "AND transservtypeid = '$_GET[type]'";
        }

        //if Role is Employee
        if(in_array(4, getMyRoles($_SESSION[uID]))){
            //$prms = Array($_SESSION[uID]);
            $createdFilter = "AND tbl_transactions.transby = '$_SESSION[uID]'";
        }
        //if Role is HR Specialist --check assigned category
        if(in_array(3, getMyRoles($_SESSION[uID])) && $_SESSION[mycatid] != ""){
            //$prms = Array($_SESSION[mycatid]);
            $assignedFilter = "AND tbl_transactions.transcat = '$_SESSION[mycatid]'";
        }
        

        $selAc = $db->WithTotalCount()->rawQuery("SELECT * FROM tbl_transactions LEFT JOIN tbl_servicetype ON 
                                                    tbl_transactions.transservtypeid = tbl_servicetype.servtypeid LEFT JOIN 
                                                    tbl_category ON tbl_transactions.transcat = tbl_category.catid LEFT JOIN 
                                                    tbl_subcategory ON tbl_transactions.transsubcat = tbl_subcategory.subcatid
                                                    LEFT JOIN tbl_users ON tbl_transactions.transby = tbl_users.userid LEFT JOIN 
                                                    tbl_status ON tbl_transactions.transstat = tbl_status.statid
                                                    WHERE transid != 0 
                                                    $createdFilter $assignedFilter $addFilter ORDER BY transid ASC",$prms);

        echo $db->getLastQuery();
        foreach ($selAc as $key => $value) {
       
        ?>
        <tr>
        <td><?php echo $value[transid]; ?></td>
        <td><?php echo $value[servtypedesc]; ?></td>
        <td><?php echo date("F j, Y,  h:i A",strtotime($value[transdatetime])) ?></td>
        <td><?php echo $value[catdesc]; ?></td>
        <td><?php echo $value[subcatdesc]; ?></td>
        <td><?php echo $value[fullname]; ?></td>
        <td><?php echo $value[statdesc]; ?></td>
        <td><a href="details.php?QRSid=<?php echo $value['transid'];?>">VIEW</a></td>
        </tr>
    <?php } 

        //echo $db->totalCount;
    ?>
    </tbody>
    </table>