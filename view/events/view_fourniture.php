<script>
	function ajout_fourniture(id_fourniture, id_user){
		$.ajax({
			method: "POST",
			url: "<?php echo Router::url('fournitures/ajoutFourniture/'); ?>"+id_fourniture+"/"+id_user,
		})
		.done(function(){
			$( '#ma_liste' ).load( "<?php echo Router::url('fournitures/listFournitureUser/'.$events->events_id.'/'.$this->Session->User('users_id')) ?>");
		});
	};
	
	function sup_fourniture(id, idFourniture){
		$.ajax({
			method: "POST",
			url: "<?php echo Router::url('fournitures/supFourniture/'); ?>"+id,
		})
		.done(function(){
			$( '#ma_liste' ).load( "<?php echo Router::url('fournitures/listFournitureUser/'.$events->events_id.'/'.$this->Session->User('users_id')) ?>");
			$("#fournitureRestante"+idFourniture).load("<?php echo Router::url('fournitures/getQteFounitureRestante/'); ?>"+idFourniture);
		});
	};
	
	function update_fourniture(id, idFourniture){
		$.ajax({
			method: "POST",
			url: "<?php echo Router::url('fournitures/supFourniture/'); ?>"+id,
		})
		.done(function(){
			$( '#ma_liste' ).load( "<?php echo Router::url('fournitures/listFournitureUser/'.$events->events_id.'/'.$this->Session->User('users_id')) ?>");
			$("#fournitureRestante"+idFourniture).load("<?php echo Router::url('fournitures/getQteFounitureRestante/'); ?>"+idFourniture);
		});
	};
	
	$(function() {
		$( '#ma_liste' ).load( "<?php echo Router::url('fournitures/listFournitureUser/'.$events->events_id.'/'.$this->Session->User('users_id')) ?>",function() {});
	});
	
	function updateQte(id, input, idFourniture){
		var quantite = $("#"+input).val();
		$.ajax({
			method: "POST",
			url: "<?php echo Router::url('fournitures/updateQuantite/'); ?>"+id+"/"+quantite+"/"+idFourniture,
		})
		.done(function(){
			$("#fournitureRestante"+idFourniture).load("<?php echo Router::url('fournitures/getQteFounitureRestante/'); ?>"+idFourniture);
			$( '#ma_liste' ).load( "<?php echo Router::url('fournitures/listFournitureUser/'.$events->events_id.'/'.$this->Session->User('users_id')) ?>");
		});
	};
	
	function updateDetail(id, input, idFourniture){
		var detail = $("#"+input).val();
		if(detail==""){
			detail="-";
		}
			$.ajax({
				method: "POST",
				url: "<?php echo Router::url('fournitures/updateDetail/'); ?>"+id+"/"+detail+"/"+idFourniture,
			})
			.done(function(){
				$( '#ma_liste' ).load( "<?php echo Router::url('fournitures/listFournitureUser/'.$events->events_id.'/'.$this->Session->User('users_id')) ?>");
			});

	};
	
	function listUser(idFourniture){
		$("#listeUserContainer").load("<?php echo Router::url('fournitures/listUsersQteFourniture/'); ?>"+idFourniture);
		$('#fournitureUser').on('show.bs.modal', function (e) {
			 $('#myInput').focus();
		})
	}
	
	function modalUpdate(idFourniture, idUser){
		$("#modalUpdateContainer").load("<?php echo Router::url('fournitures/formUpdateFourniture/'); ?>"+idFourniture+"/"+idUser);
		$("#modalDetailContainer").load("<?php echo Router::url('fournitures/listUsersQteFourniture/'); ?>"+idFourniture);
		$('#fournitureUpdate').on('show.bs.modal', function (e) {
			 $('#myInput').focus();
		})
	}
</script>
<h2>Gestion des fournitures</h2> 
<div class="col-md-6">
	<h3>Les fournitures de l'évènement</h3>
	<table>
		<tr>
			<th class="tdFourniture"></th>
			<th class="tdFourniture">Libelle</th>
			<th class="tdFourniture">Quantité totale</th>
			<th class="tdFourniture">Quantité manquante</th>
		</tr>
<?php foreach ($fournitures as $k => $v): ?>
	<tr class="trFourniture">
		<td class="tdFourniture">
			<button type="button" class="btn btn-default"
				onclick="listUser(<?php echo $v->fournitures_id;?>);" data-toggle="modal" data-target="#fournitureUser"> Détail
			</button></td>
		<td class="tdFourniture"><?php echo $v->fournitures_libelle;?></td>
		<td class="tdFourniture"><?php echo $v->fournitures_quantite.$v->fournitures_unite; ?></td> 
		<td class="tdFourniture"><span id="fournitureRestante<?php echo $v->fournitures_id;?>"><?php echo $v->quantiteRestante;?></span><?php echo $v->fournitures_unite; ?></td>
		<td class="tdFourniture"><a onclick="ajout_fourniture(<?php echo $v->fournitures_id;?>, <?php echo $this->Session->User('users_id');?>)"><img src="<?php echo IMG.'/caddie.png';?>" class="icone_btn"/></a></td>
	</tr>
<?php endforeach ?>
	</table>
</div>
<div class="col-md-6">
	<h3>Ma liste de fournitures</h3>
	<div id="ma_liste">
	</div>
</div>

<!-- Modal detail -->
<div class="modal fade" id="fournitureUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Détail de la fourniture</h4>
			</div>
			<div class="modal-body row" id="listeUserContainer">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
			</div>
		</div>
	</div>
 </div>
 
 <!-- Modal update -->
<div class="modal fade" id="fournitureUpdate" tabindex="-1" role="dialog" aria-labelledby="modalLabelUpdate" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="modalLabelUpdate">Update</h4>
			</div>
			<div class="modal-body row" id="modalUpdateContainer">
			</div>
			<div class="modal-body row" id="modalDetailContainer">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Valider</button>
			</div>
		</div>
	</div>
 </div>