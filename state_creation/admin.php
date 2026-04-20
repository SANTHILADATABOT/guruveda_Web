<div class="breadcrumbs">
    <div class="col-sm-4">
	    <div class="page-header float-left">
            <div class="page-title">
                <h1>State Creation<small> List</small></h1>
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
	    <a href="index1.php?filename=state_creation/create"><button type="submit" class="btn btn-success btn-sm"><i class="fa fa-plus-square"></i> Create</button></a>
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
                                    <th width="43%">State Name</th>
                                    <th width="43%">State Code</th>
                                    <th width="10%"><div align="center">Action</div></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sql = "SELECT * FROM state_creation where delete_status!='1' order by state_id ASC";
                                $rows = $db->fetch_all_array($sql);
                                foreach($rows as $record)
                                {?>
                                    <tr>
                                        <td><?php echo $i=$i+1; ?></td>
                                        <td><?php echo $record['state_name']; ?></td>
                                        <td><?php echo $record['state_code'];?></td>
                                        <td align="center">
                                        	<a href="index1.php?filename=state_creation/update&update_id=<?php echo $record['state_id'];?>"><i class="fa fa-edit fa-pencil-square-o"></i></a>&nbsp;&nbsp;
                                        	<a href="#" title="Delete" onClick="state_creation_delete('<?php echo $record['state_id']; ?>');"><i class="fa fa-delete fa-trash-o"></i></a>
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