<? $this->load->view('includes/header'); ?>
<? $this->load->view('includes/navbar'); ?>
<div class="container">
<div class="content" style="display:none">
  <div class="page-header">
    <h2>Cadastro de Clientes</h2>
  </div>
  <div class="row">
    <div class="span9 offset1">
      <table class="table table-striped table-bordered tablesorter" id="tcontacts">
        <thead>
          <tr>
            <th><i class="icon-tags"></i> ID</th>
            <th><i class="icon-user"></i> Name</th>
            <th><i class="icon-white"></i> Email</th>
            <th><i class="icon-envelope"></i>Endereco</th>
            <th><i class="icon-white"></i> Modelo</th>
            <th><i class="icon-white"></i> Entrada</th>
            <th><i class="icon-white"></i> data</th>
            <th><i class="icon-headphones"></i> Phone</th>
          </tr>
        </thead>
        <tbody>
        <? foreach($contacts as $contact): ?>
          <tr>
            <td><?=$contact['cid']; ?></td>
            <td><?=$contact['name']; ?></td>
            <td><?=$contact['email']; ?></td>
            <td><?=$contact['endereco'];?></td>
            <td><?=$contact['modelo']; ?></td>
            <td><?=$contact['entrada']; ?></td>
            <td><?=$contact['data']; ?></td>
            <td><?=$contact['phone']; ?></td>
          </tr>
          <? endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<script src="<?=base_url('js/jquery.js'); ?>"></script>
<script src="<?=base_url('js/jquery.tablesorter.js'); ?>"></script>
<script>
$(document).ready(function() {

  $('#tcontacts').tablesorter();

  $('.content').fadeIn(1000);
});
</script>
<? $this->load->view('includes/footer'); ?>
