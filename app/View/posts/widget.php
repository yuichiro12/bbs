<form action="/posts/upload" method="post" enctype="multipart/form-data" id="uploader">
  <input type="file" name="image">
  <?= csrf_token() ?>
</form>

<div class="modal fade" id="modal_box" data-url="/posts/preview">
  <div class="modal-dialog post-modal-dialog">
    <div class="modal-content post-modal-content">
      <div class="box_inner">
      </div>
	  <br/>
      <div class="text-center">
		<a class="btn btn-primary" data-dismiss="modal" href="#">閉じる</a>
	  </div>
    </div>
  </div>
</div>
