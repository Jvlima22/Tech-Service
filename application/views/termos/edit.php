<?php $this->load->view('layout/sidebar'); ?>


<!-- Main Content -->
<div id="content">

    <?php $this->load->view('layout/navbar'); ?>

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo base_url('termos'); ?>">Termos</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo $titulo; ?></li>
            </ol>
        </nav>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <form method="post">
                    <div class="row">
                        <div class="col-9 mb-3">
                            <label for="">Título</label>
                            <input type="text" name="titulo" class="form-control" value="<?= $termo->titulo ?>">
                        </div>
                        <div class="col-12">
                            <label for="">Descrição</label>
                            <textarea id="summernote" name="descricao"><?= $termo->descricao ?></textarea>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end my-3">
                        <button class="btn btn-primary btn-sm"><i class="fas fa-save"></i> Salvar</button>
                        <a title="Voltar" href="<?= base_url('termos'); ?>" class="btn btn-success btn-sm ml-2">Voltar</a>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->