<?= $this->extend('_partials/template') ?>

<?= $this->section('s-body') ?>
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>List Invoice</h4>
                <a href="<?= base_url('home/c_inv') ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i></a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Pelanggan</th>
                                <th>Note</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($invoice as $inv)  : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $inv['name_full'] ?></td>
                                <td><?= $inv['note'] ?></td>
                                <td><?= $inv['date_at'] ?></td>
                                <td>
                                    <button type="button" data-id="<?= $inv['invoice_id'] ?>" class="btn btn-danger btn-sm btn-delete"><i class="fas fa-trash"></i></button>
                                    <a href="<?= base_url('export/pdf/'.$inv['code_invoice']) ?>" target="_blank" class="btn btn-primary btn-sm btn-pdf"><i class="fas fa-file-pdf"></i></a>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    $(document).ready(function(){
        $(".btn-delete").click(function(){
            var id = $(this).data('id');
            Swal.fire({
                title   :   "Yakin Mau Dihapus ?",
                text    :   "Jika dihapus data tidak bisa dikembalikan",
                icon    :   "warning",
                showCancelButton : true
            }).then((value)=>{
                $.ajax({
                    url     :   "<?= base_url('api/deleteInvoice') ?>",
                    type    :   "POST",
                    dataType:   "JSON",
                    data    :   {id:id},
                    success :   (res)=>{
                        if(res.success === true){
                            Swal.fire('Sukses',res.data,'success').then((value)=>{
                                if(value.isConfirmed){
                                    location.reload();
                                }
                            });
                        }else{
                            Swal.fire('Gagal',res.data,'error').then((value)=>{
                                if(value.isConfirmed){
                                    location.reload();
                                }
                            });
                        }
                    }
                })
            });
        });
    });
</script>
<?= $this->endSection() ?>