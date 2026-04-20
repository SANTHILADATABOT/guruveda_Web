<?php
// ✅ Make sure session & DB are loaded
session_start();
include("config.php"); // your DB connection

// ✅ Fetch all records safely
$sql  = "SELECT * FROM user_creation WHERE delete_status != 1 ORDER BY user_id ASC";
$rows = $db->fetch_all_array($sql);
?>

<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title"><h1>User Creation<small> List</small></h1></div>
        </div>
    </div>
    <div class="col-sm-7">
        <div class="page-header float-right">
            <div class="page-title"></div>
        </div>
    </div>
    <div class="col-sm-1">
        <a href="index1.php?filename=user_creation/create">
            <button type="submit" class="btn btn-success btn-sm">
                <i class="fa fa-plus-square"></i> Create
            </button>
        </a>
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
                                    <th width="5%">SNo</th>
                                    <th width="17%">User Type</th>
                                    <th width="28%">Staff Name</th>
                                    <th width="28%">User Name</th>
                                    <th width="14%"><div align="center">Status</div></th>
                                    <th width="8%"><div align="center">Action</div></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $i = 0;

                                // ✅ Prevent empty or invalid loop
                                if (!empty($rows)) {
                                    foreach ($rows as $record) {
                                        $i++;
                                ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo get_user_type($record['user_type_id']); ?></td>
                                        <td><?php echo ucfirst($record['staff_name']); ?></td>
                                        <td><?php echo $record['user_name']; ?></td>

                                        <td align="center">
                                            <?php 
                                                if ($record['user_status'] == '1') {
                                                    echo "Active";
                                                } else {
                                                    echo "Inactive";
                                                }
                                            ?>
                                        </td>

                                        <td align="center">
                                            <a href="index1.php?filename=user_creation/update&update_id=<?php echo $record['user_id']; ?>">
                                                <i class="fa fa-edit fa-pencil-square-o"></i>
                                            </a>

                                            <?php if ($record['user_id'] > 1) { ?>
                                                <a href="#" title="Delete" onClick="usercreation_delete('<?php echo $record['user_id']; ?>');">
                                                    <i class="fa fa-delete fa-trash-o"></i>
                                                </a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php
                                    }
                                } else {
                                ?>
                                    <tr>
                                        <td colspan="6" align="center">No Records Found</td>
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
