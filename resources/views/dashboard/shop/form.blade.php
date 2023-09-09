<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog modal-lg" role="document">
        <form action="" method="post" class="form-horizontal form-modal" enctype="multipart/form-data">
            @csrf
            @method('post')
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="name" class="col-lg-2 col-lg-offset-1 control-label">Nama Perusahaan</label>
                        <div class="col-lg-6">
                            <input type="text" name="name" class="form-control" id="name" required autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="contact" class="col-lg-2 col-lg-offset-1 control-label">Contact</label>
                        <div class="col-lg-6">
                            <input type="text" name="contact" class="form-control" id="contact" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="address" class="col-lg-2 col-lg-offset-1 control-label">Alamat</label>
                        <div class="col-lg-6">
                            <textarea name="address" class="form-control" id="address" rows="3" required></textarea>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="logo_path" class="col-lg-2 col-lg-offset-1 control-label">Logo Perusahaan</label>
                        <div class="col-lg-4">
                            <input type="file" name="logo_path" class="form-control" id="logo_path" 
                            onchange="preview('.tampil-logo', this.files[0])">
                            <span class="help-block with-errors"></span>
                            <br>
                            <div class="tampil-logo"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="member_card_path" class="col-lg-2 col-lg-offset-1 control-label">Kartu Member</label>
                        <div class="col-lg-4">
                            <input type="file" name="member_card_path" class="form-control" id="member_card_path"
                            onchange="preview('.tampil-kartu-member', this.files[0], 300)">
                            <span class="help-block with-errors"></span>
                            <br>
                            <div class="tampil-kartu-member"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="disc" class="col-lg-2 col-lg-offset-1 control-label">Diskon Member</label>
                        <div class="col-lg-2">
                            <input type="number" name="disc" class="form-control" id="disc" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bill_type" class="col-lg-2 col-lg-offset-1 control-label">Tipe Nota</label>
                        <div class="col-lg-2">
                            <select name="bill_type" class="form-control" id="bill_type" required>
                                <option value="1">Nota Kecil</option>
                                <option value="2">Nota Besar</option>
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-flat btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    <button type="button" class="btn btn-sm btn-flat btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

