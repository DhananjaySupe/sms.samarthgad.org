<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa fa-file-video-o"></i> <?=$this->lang->line('panel_title')?></h3>
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li class="active"><?=$this->lang->line('menu_gmeetliveclass')?></li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <?php
                if((($siteinfos->school_year == $this->session->userdata('defaultschoolyearID')) || ($this->session->userdata('usertypeID') == 1)) && permissionChecker('gmeetliveclass_add')) { ?>
                    <h5 class="page-header">
                        <a href="<?php echo base_url('gmeetliveclass/add') ?>">
                            <i class="fa fa-plus"></i> 
                            <?=$this->lang->line('add_title')?>
                        </a>
                    </h5>
                <?php } ?>

                <div id="hide-table">
                    <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
                        <thead>
                            <tr>
                                <th class="col-lg-1"><?=$this->lang->line('slno')?></th>
                                <th class="col-lg-2"><?=$this->lang->line('gmeetliveclass_title')?></th>
                                <th class="col-lg-2"><?=$this->lang->line('gmeetliveclass_date')?></th>
                                <th class="col-lg-1"><?=$this->lang->line('gmeetliveclass_classes')?></th>
                                <th class="col-lg-1"><?=$this->lang->line('gmeetliveclass_section')?></th>
                                <th class="col-lg-2"><?=$this->lang->line('gmeetliveclass_host')?></th>
                                <th class="col-lg-1"><?=$this->lang->line('gmeetliveclass_status')?></th>
                                <?php if(permissionChecker('gmeetliveclass_edit') || permissionChecker('gmeetliveclass_delete') || permissionChecker('gmeetliveclass_view')) { ?>
                                <th class="col-lg-2"><?=$this->lang->line('action')?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(customCompute($gmeetliveclasses)) {$i = 1; foreach($gmeetliveclasses as $gmeetliveclass) { ?>
                                <tr>
                                    <td data-title="<?=$this->lang->line('slno')?>">
                                        <?php echo $i; ?>
                                    </td>
                                    <td data-title="<?=$this->lang->line('gmeetliveclass_title')?>">
                                        <?php echo $gmeetliveclass->title; ?>
                                    </td>
                                    <td data-title="<?=$this->lang->line('gmeetliveclass_date')?>">
                                         <?=date("d M Y h:i A", strtotime($gmeetliveclass->date))?>
                                    </td>
                                    <td data-title="<?=$this->lang->line('gmeetliveclass_classes')?>">
                                          <?=isset($classes[$gmeetliveclass->classesID]) ? $classes[$gmeetliveclass->classesID] : ''?>
                                    </td>
                                    <td data-title="<?=$this->lang->line('gmeetliveclass_section')?>">
                                           <?php 
                                            if($gmeetliveclass->sectionID) {
                                                echo $sections[$gmeetliveclass->sectionID];
                                            } else if(isset($classSections[$gmeetliveclass->classesID])) {
                                                echo implode(', ', $classSections[$gmeetliveclass->classesID]);
                                            } ?>
                                    </td>
                                    <td data-title="<?=$this->lang->line('gmeetliveclass_host')?>">
                                        <?php echo $gmeetliveclass->host; ?>
                                    </td>
                                    <td data-title="<?=$this->lang->line('gmeetliveclass_status')?>">
                                           <?php if($gmeetliveclass->status == 5) {  ?> 
                                                <p class='text-center text-black bg-yellow'><?=$this->lang->line('gmeetliveclass_pending')?></p>
                                            <?php } elseif ($gmeetliveclass->status == 10) { ?> 
                                                <p class='text-center text-black bg-blue'><?=$this->lang->line('gmeetliveclass_cancel')?></p>
                                            <?php } elseif ($gmeetliveclass->status == 15) { ?>
                                                <p class='text-center text-black bg-green'><?=$this->lang->line('gmeetliveclass_start')?></p>
                                            <?php } else { ?> 
                                                <p class='text-center text-black bg-red'><?=$this->lang->line('gmeetliveclass_finished')?></p>
                                            <?php } ?>
                                    </td>
                                    <?php if(($siteinfos->school_year == $this->session->userdata('defaultschoolyearID')) || ($this->session->userdata('usertypeID') == 1)) { 
                                        if(permissionChecker('gmeetliveclass_edit') || permissionChecker('gmeetliveclass_delete') || permissionChecker ('gmeetliveclass_view')) { ?>
                                    <td data-title="<?=$this->lang->line('action')?>">
                                        <?php if(($gmeetliveclass->status == 15) && permissionChecker('gmeetliveclass_view')) { ?>
                                            
                                            <a class="btn btn-success btn-xs mrg" href="<?=$gmeetliveclass->url?>" data-placement="top" data-toggle="tooltip" data-original-title="<?=$this->lang->line('gmeetliveclass_join')?>" target="_blank"> <i class="fa fa-video-camera"></i> </a>
                                            <?php }
                                            echo btn_edit('gmeetliveclass/edit/'.$gmeetliveclass->gmeetliveclassID, $this->lang->line('edit'));
                                            echo btn_delete('gmeetliveclass/delete/'.$gmeetliveclass->gmeetliveclassID, $this->lang->line('delete'));
                                        ?>
                                    </td>
                                    <?php } } ?>
                                </tr>
                            <?php $i++; } }?>
                        </tbody>
                    </table>
                </div>
            </div> <!-- col-sm-12 -->
        </div><!-- row -->
    </div><!-- Body -->
</div><!-- /.box -->