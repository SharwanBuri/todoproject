  <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Task List</h3>
            </div>
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Task</h4>
                    </p>
                    <table class="table">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Title</th>
                          <th>Created</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
					  <?php if(!empty($tasks)){
						  $i=1;
						  foreach($tasks as $task){?>
                        <tr>
                          <td><?=$i;?></td>
                          <td><?=$task->title;?></td>
                          <td>
						  <?=date('d',strtotime($task->created));?> <?=date('M',strtotime($task->created));?>, <?=date('yy',strtotime($task->created));?>
						  </td>
                          <td>
						  <?php if($task->is_active==1){?>
						  <label class="badge badge-success">Done</label>
						  <?php }else{?>
						  <label class="badge badge-danger">Pending</label>
						  <?php }?>
						  </td>
                          <td>
						  <?php if($task->is_active==1){?>
							<a href="<?=base_url()?>status/<?=$task->id?>/<?='task'?>/0" data-toggle="tooltip" data-placement="top" title="Pending"  class="" ><i class="mdi mdi-close" aria-hidden="true"></i></a>
							
							<?php }else{?>
							<a href="<?=base_url()?>status/<?=$task->id?>/<?='task'?>/1" data-toggle="tooltip" data-placement="top" title="Done"  class="" ><i class="mdi mdi-check" aria-hidden="true"></i></a>
							<?php }?>
							<a href="<?=base_url();?>task/edit/<?=$task->id;?>" data-toggle="tooltip" data-placement="top" title="Edit" ><i class="mdi mdi-pencil" style="color:green;padding: 5px;"></i></a>
							<a href="<?=base_url();?>task/view/<?=$task->id;?>" data-toggle="tooltip" data-placement="top" title="Edit" ><i class="mdi mdi-eye" style="color:green;padding: 5px;"></i></a>
							 <a data-toggle="tooltip" data-placement="top" title="Delete" href="<?=base_url()?>delete/<?=$task->id?>/<?='task'?>/icon"  class="DeleteButton" id="remove<?=$task->id;?>"><i class="mdi mdi-delete" style="color:red;padding: 5px;"></i></a>
                           
						  </td>
                        </tr>
					  <?php $i++; }}?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            
            </div>
          </div>