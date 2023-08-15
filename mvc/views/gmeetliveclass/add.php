
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-file-video-o"></i> <?=$this->lang->line('panel_title')?></h3>
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li><a href="<?=base_url("gmeetliveclass/index")?>"><?=$this->lang->line('menu_gmeetliveclass')?></a></li>
            <li class="active"><?=$this->lang->line('menu_add')?> <?=$this->lang->line('menu_gmeetliveclass')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-10">
                <form class="form-horizontal" role="form" method="post">
                    <?php
                        if(form_error('title'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="title" class="col-sm-2 control-label">
                            <?=$this->lang->line("gmeetliveclass_title")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="title" name="title" value="<?=set_value('title')?>" >
                        </div>
                        <span class="col-sm-4 control-label">

                            <?php echo form_error('title'); ?>
                        </span>
                    </div>

                    <?php
                        if(form_error('date'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="dob" class="col-sm-2 control-label">
                            <?=$this->lang->line("gmeetliveclass_date")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <input autocomplete="false" type="text" class="form-control datetimepicker" id="date" name="date" value="<?=set_value('date')?>">
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('date'); ?>
                        </span>
                    </div>

                            <?php
                        if(form_error('duration'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="class_title_id" class="col-sm-2 control-label">
                            <?=$this->lang->line("gmeetliveclass_duration")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" id="duration" name="duration" value="<?=set_value('duration')?>" >
                        </div>
                        <span class="col-sm-4 control-label">

                            <?php echo form_error('duration'); ?>
                        </span>
                    </div>

                <?php
                        if(form_error('classesID'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="classesID" class="col-sm-2 control-label">
                            <?=$this->lang->line("gmeetliveclass_classes")?> <span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <?php
                                $classArray = array(0 => $this->lang->line("gmeetliveclass_select_class"));
                                foreach ($classes as $classa) {
                                    $classArray[$classa->classesID] = $classa->classes;
                                }
                                echo form_dropdown("classesID", $classArray, set_value("classesID"), "id='classesID' class='form-control select2'");
                            ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('classesID'); ?>
                        </span>
                    </div>

                    <?php
                        if(form_error('sectionID'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="sectionID" class="col-sm-2 control-label">
                            <?=$this->lang->line("gmeetliveclass_section")?>
                        </label>

                        <div class="col-sm-6">
                            <?php
                                $sectionArray = array(0 => $this->lang->line("gmeetliveclass_select_section"));
                                if(customCompute($sections)) {
                                    foreach ($sections as $section) {
                                        $sectionArray[$section->sectionID] = $section->section;
                                    }
                                }
                                echo form_dropdown("sectionID", $sectionArray, set_value("sectionID"), "id='sectionID' class='form-control select2'");
                            ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('sectionID'); ?>
                        </span>
                    </div>

                    <?php
                        if(form_error('status'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="bloodgroup" class="col-sm-2 control-label">
                            <?=$this->lang->line("gmeetliveclass_status")?><span class="text-red">*</span>
                        </label>
                        <div class="col-sm-6">
                            <?php
                                $status = array(
                                    '0' => $this->lang->line('gmeetliveclass_select_status'),
                                    '5' => $this->lang->line('gmeetliveclass_pending'),
                                    '10' => $this->lang->line('gmeetliveclass_cancel'),
                                    '15' => $this->lang->line('gmeetliveclass_start'),
                                    '20' => $this->lang->line('gmeetliveclass_finished'),
                                );
                                echo form_dropdown("status", $status, set_value("status"), "id='status' class='form-control select2'");
                            ?>
                        </div>
                        <span class="col-sm-4 control-label">
                            <?php echo form_error('status'); ?>
                        </span>
                    </div>

                <?php
                if (form_error('url'))
                    echo "<div class='form-group has-error' >";
                else
                    echo "<div class='form-group' >";
                ?>
                <label for="url" class="col-sm-2 control-label">
                    <?= $this->lang->line("gmeetliveclass_gmeet_url") ?> <span class="text-red">*</span>
                </label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="url" name="url"
                           value="<?= set_value('url') ?>">
                </div>
                <span class="col-sm-4 control-label">

                            <?php echo form_error('url'); ?>
                        </span>
            </div>

                    <?php
                        if(form_error('description'))
                            echo "<div class='form-group has-error' >";
                        else
                            echo "<div class='form-group' >";
                    ?>
                        <label for="description" class="col-sm-2 control-label">
                            <?=$this->lang->line("gmeetliveclass_description")?>
                        </label>
                        <div class="col-sm-8">
                            <textarea class="form-control" id="description" name="description" ><?=set_value('description')?></textarea>
                        </div>
                        <span class="col-sm-2 control-label">
                                <?php echo form_error('description'); ?>
                        </span>
                    </div>



                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <input type="submit" class="btn btn-success" value="<?=$this->lang->line("add_gmeetliveclass")?>" >
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    "use strict";
    $(document).ready(function() {
        $('#description').jqte();
    });

    $('#date').datetimepicker({
        format: 'DD-MM-YYYY hh:mm A'
    });

    $('#classesID').change(function(event) {
        var classesID = $(this).val();
        if(classesID === '0') {
            $('#sectionID').val(0);
        } else {
            $.ajax({
                async: false,
                type: 'POST',
                url: "<?=base_url('gmeetliveclass/sectioncall')?>",
                data: "id=" + classesID,
                dataType: "html",
                success: function(data) {
                   $('#sectionID').html(data);
                }
            });
        }
    });


</script>
