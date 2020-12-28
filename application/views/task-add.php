 <div class="content-wrapper">
<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
	<div class="card">
	  <div class="card-body">
		<h4 class="card-title">Task</h4>
		<?=  form_open_multipart(base_url('task/add'),array('class'=>'forms-sample'));  ?>
		  <div class="row">
			<div class="col-md-12">
			  <div class="form-group">
				<label for="exampleInputtitle">Title<small class="mandetryfiled">*</small></label>
				<input type="text" class="form-control" id="exampleInputtitle" name="title" required="true">
			  </div>
		    </div>
			
		  </div>
		  <div class="row">
			<div class="col-md-12">
			  <div class="form-group">
				<label>Task Description</label>
				<textarea rows="10" name="description" class="form-control">
                   
                </textarea>
				
			  </div>
            </div>
		  </div>
		  <button type="submit" class="btn btn-primary mr-2">Submit</button>
		<?= form_close(); ?>
	  </div>
	</div>
  </div>
</div>
</div>