<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
            	<h1>Accounting Year Creation<small> List</small></h1>
            </div>
        </div>
    </div>
    <div class="col-sm-7">
        <div class="page-header float-right">
            <div class="page-title">
                
            </div>
        </div>
    </div>
    <div class="col-sm-1">
        <a href="index1.php?filename=academic_year/create"><button type="submit" class="btn btn-success btn-sm"><i class="fa fa-plus-square"></i> Create</button></a>
    </div>
</div>

<div class="content mt-3">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                    
                    <table id="bootstrap-data-table" class="table" width="100%">
                        <thead>
                            <tr>
                                <th width="4%">SNo</th>
                                <th width="43%">Account Year</th>
                                <th width="43%">Status</th>
                                <th width="10%"><div align="center">Action</div></th>
                            </tr>
                        </thead>
                    <tbody>
                    <?php 
                    $i=0;
                    $sql = "SELECT * FROM account_year where delete_status!='1' order by accyear_id ASC";
                    $rows = $db->fetch_all_array($sql);
                    foreach($rows as $record)
                    {?>
                            <tr>
                                <td><?php echo $i=$i+1;?></td>
                                <td><?php echo $record['from_year']."-".$record['to_year'];?></td>
                                <td><?php if($record['accountyear_status']=='1') {?><img src="images/tick.png" width="25" height="25"  onClick="status_academic_year_update_wrong('<?php echo $record['accyear_id']; ?>','0')" style="cursor:pointer"><?php }  else{?><img src="images/deletes.png" width="25" height="25" onClick="status_academic_year_update_tick('<?php echo $record['accyear_id'];?>','1')" style="cursor:pointer"><?php }?></td>
                                <td align="center">
                                    <a href="index1.php?filename=academic_year/update&update_id=<?php echo $record['accyear_id'];?>"><i class="fa fa-edit fa-pencil-square-o"></i></a></td>
                                    
                            </tr>
                        <?php } ?>
                   	 </tbody>
                    </table>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>