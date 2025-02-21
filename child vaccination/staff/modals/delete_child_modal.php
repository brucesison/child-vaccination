<div class="modal fade" id="delete_child" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-secondary" id="exampleModalLabel">Delete child</h5>
        </div>
        <div class="modal-body">
            Are you sure you want to delete this child?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <a class="btn btn-danger" href="delete/delete_child.php?child_id=<?php echo $child['child_id']; ?>"><i class="fas fa-fw fa-trash mr-1"></i>Delete</a>
        </div>
        </div>
    </div>
</div>