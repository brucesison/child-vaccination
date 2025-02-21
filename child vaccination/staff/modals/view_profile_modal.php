<div class="modal fade" id="view_parent_pic" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <input type="hidden" name="user_id" value="<?php echo $parent['user_id']; ?>">
        <div class="modal-body bg-light rounded py-3 px-0">
          <div class="container-fluid p-0">
            <div class="row">
              <div class="col-md-12">
                <img src="<?php echo htmlspecialchars($parent['profile_image']); ?>" class="col-12 img-fluid rounded"/>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>