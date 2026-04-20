<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title"><h1>User Screen</h1></div>
        </div>
    </div>
    <div class="col-sm-7">
        <div class="page-header float-right">
            <div class="page-title">
                
            </div>
        </div>
    </div>
    <div class="col-sm-1">
        <a href="index1.php?filename=user_screen/create"><button type="submit" class="btn btn-success btn-sm"><i class="fa fa-plus-square"></i> Create</button></a>
    </div>
</div>

<div class="content mt-3">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table">
                            <thead>
                                <tr>
                                    <th>SNo</th>
                                    <th>User Screen</th>
                                    <th>Sub Screen Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i=0;
                                $sql = "SELECT * FROM sub_screen order by screen_id ASC";
                                $rows = $db->fetch_all_array($sql);
                                foreach($rows as $record)
                                {?>
                                    <tr>
                                        <td><?php echo $i=$i+1;?></td>
                                        <td><?php echo $record['screen_name'];?></td>
                                        <td><?php echo $record['sub_screen'];?></td>
                                        <td><?php if($record['status']=='1') {echo "Active";} else { echo "Inactive";}?></td>
                                        <td>
                                            <a href="index1.php?filename=user_screen/update&update_id=<?php echo $record['screen_id'];?>"><i class="fa fa-edit fa-pencil-square-o"></i></a>
                                            <a href="#" title="Delete" onClick="userscreen_delete('<?php echo $record['screen_id']; ?>');"><i class="fa fa-delete fa-trash-o"></i></a>
                                        </td>
                                    </tr>
                                    <?php
                                }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
