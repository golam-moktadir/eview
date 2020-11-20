<?php
$view_menu = $this->session->ses_view_menu_id;
$insert_menu = $this->session->ses_insert_menu_id;
$edit_menu = $this->session->ses_edit_menu_id;
$delete_menu = $this->session->ses_delete_menu_id;
$view_id = explode(",", $view_menu);
$insert_id = explode(",", $insert_menu);
$edit_id = explode(",", $edit_menu);
$delete_id = explode(",", $delete_menu);
?>
<?php if (in_array("18", $view_id) || in_array("all", $view_id)) { ?>
    <?php
    $menu_array = array();
    $menu_array["all"] = "All";
    $menu_array[""] = "";
    foreach ($menu_list as $info) {
        $menu_array[$info->record_id] = $info->menu_name;
    }
    ?>
    <table id="datatable" class="datatable table table-bordered table-hover">
        <thead>
            <tr>
                <th style="text-align: center;">SL</th>
                <th style="text-align: center;">Full Name</th>
                <th style="text-align: center;">E-mail</th>
                <th style="text-align: center;">Mobile</th>
                <th style="text-align: center;">Username</th>
                <!--<th style="text-align: center;">Password</th>-->
                <th style="text-align: center;">View Menu</th>
                <!--<th style="text-align: center;">Insert Menu</th>-->
                <th style="text-align: center;">Edit Menu</th>
                <th style="text-align: center;">Delete Menu</th>
                <th style="text-align: center;">Status</th>
                <!--<th style="text-align: center;">Action</th>-->
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 0;
            foreach ($all_value as $single_value) {
                if ($single_value->user_name != "admin") {
                    $count++;
                    $view_array = explode(",", $single_value->view_menu_id);
                    $insert_array = explode(",", $single_value->insert_menu_id);
                    $edit_array = explode(",", $single_value->edit_menu_id);
                    $delete_array = explode(",", $single_value->delete_menu_id);
                    ?>
                    <tr>
                        <td style="text-align: center;"><?php echo $count; ?></td>
                        <td style="text-align: center;"><?php echo $single_value->full_name; ?></td>
                        <td style="text-align: center;"><?php echo $single_value->email; ?></td>
                        <td style="text-align: center;"><?php echo $single_value->mobile; ?></td>
                        <td style="text-align: center;"><?php echo $single_value->user_name; ?></td>
                        <!--<td style="text-align: center;"><?php echo $single_value->password; ?></td>-->
                        <td style="text-align: center;">
                            <?php
                            foreach ($view_array as $arr) {
                                if ($menu_array[$arr] == "" || $menu_array[$arr] == "All") {
                                    echo $menu_array[$arr];
                                } else {
                                    echo $menu_array[$arr] . ", ";
                                }
                            }
                            ?>
                        </td>
            <!--                <td style="text-align: center;">
                        <?php
                        foreach ($insert_array as $arr) {
                            if ($menu_array[$arr] == "" || $menu_array[$arr] == "All") {
                                echo $menu_array[$arr];
                            } else {
                                echo $menu_array[$arr] . ", ";
                            }
                        }
                        ?>
                        </td> -->                    
                        <td style="text-align: center;">
                            <?php
                            foreach ($edit_array as $arr) {
                                if ($menu_array[$arr] == "" || $menu_array[$arr] == "All") {
                                    echo $menu_array[$arr];
                                } else {
                                    echo $menu_array[$arr] . ", ";
                                }
                            }
                            ?>
                        </td>
                        <td style="text-align: center;">
                            <?php
                            foreach ($delete_array as $arr) {
                                if ($menu_array[$arr] == "" || $menu_array[$arr] == "All") {
                                    echo $menu_array[$arr];
                                } else {
                                    echo $menu_array[$arr] . ", ";
                                }
                            }
                            ?>
                        </td>
                        <td style="text-align: center;">
                            <?php
                            if ($single_value->status == "1") {
                                echo "Active";
                                ?>
                                <button class="btn btn-warning" onclick="change_status('<?php echo $single_value->record_id; ?>', 0)" title="Inactive">
                                    <i class="fa fa-eye-slash"></i>
                                </button>
                                <?php
                            } else {
                                echo "Inactive";
                                ?>
                                <button class="btn btn-success" onclick="change_status('<?php echo $single_value->record_id; ?>', 1)"  title="Active">
                                    <i class="fa fa-eye"></i>
                                </button>
                            <?php } ?>
                        </td>
            <!--                <td style="text-align: center;">
                            <button class="btn btn-danger" onclick="delete_data('<?php echo $single_value->record_id; ?>')">
                                <i class="fa fa-trash-o"></i>
                            </button> 
                        </td>-->
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
<?php } ?>
