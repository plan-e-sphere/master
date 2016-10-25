<link rel="stylesheet" href="<?php echo CSS.'/style_adresses.css';?>"/>
<div class="page-header">
	<h1><?php echo isset($title)?$title:'Mes adresses'; ?></h1>
</div>
<script>
    $(function(){
        $(".fa-pencil").click(function(){
            var adresseId = $(this).attr("adresseId");
            var userId = $(this).attr("userId");
            $("#modal"+adresseId).dialog({
                resizable: false,
                modal: true,
                title: "Modification d'une adresse",
                dialogClass: "no-close",
                draggable: false,
                closeText: "hide",
                width:500,
                buttons: {
                    "Modifier": function () {
                        $(this).dialog('close');
                        updateAdresse(adresseId,userId);
                    },
                    "Annuler": function () {
                        $(this).dialog('close');
                    }
                }
            });
        });
        
        $(".fa-trash").click(function(){
             var adresse = $(this).attr("name");
             var adresseId = $(this).attr("adresseId");
             var userId = $(this).attr("userId");
             $("#dialog-confirm").html("Voulez-vous vraiment supprimer l'adresse : " + adresse)
                    .dialog({
                resizable: false,
                modal: true,
                title: "Suppression",
                dialogClass: "no-close",
                draggable: false,
                closeText: "hide",
                buttons: {
                    "Oui": function () {
                        $(this).dialog('close');
                        deleteAdresse(adresseId,userId);
                    },
                    "Non": function () {
                        $(this).dialog('close');
                    }
                }
            });
        });
        
        $("#btnAdd").click(function(){
             $("#modalAdd").dialog({
                resizable: false,
                modal: true,
                title: "Ajouter une adresse",
                dialogClass: "no-close",
                draggable: false,
                closeText: "hide",
                width:500,
                buttons: {
                    "Ajouter": function () {
                        $(this).dialog('close');
                        addAdresse();
                    },
                    "Annuler": function () {
                        $(this).dialog('close');
                    }
                }
            });
        });
    });
    function deleteAdresse(adresseId, userId){
            $.ajax({
                method: "POST",
                url: "<?php echo Router::url('adresses/delete/'); ?>"+adresseId+"/"+userId,	
            })
            .done(function(request){
                $("#container_adresse").html(request);
                set_alert_message('success','L\'adresse a bien été supprimée');
            });
        };
        
        function addAdresse(){
            var adresse = {adresses_libelle:$("#inputadresses_libelle").val(),
                            adresses_num_voie:$("#inputadresses_num_voie").val(),
                            adresses_voie:$("#inputadresses_voie").val(),
                            adresses_cp:$("#inputadresses_cp").val(),
                            adresses_ville:$("#inputadresses_ville").val(),
                            adresses_pays:$("#inputadresses_pays").val()
                            };
            var json = JSON.stringify( adresse );
            $.ajax({
                method: "POST",
                url: "<?php echo Router::url('adresses/addAdresse/'); ?>"+json,	
            })
            .done(function(request){
                $("#container_adresse").html(request);
                set_alert_message('success','L\'adresse a bien été ajoutée');
            });
        };
        
        function updateAdresse(adresseId, userId){
            var adresse = {adresses_libelle:$("#inputadresses_libelle"+adresseId).val(),
                            adresses_num_voie:$("#inputadresses_num_voie"+adresseId).val(),
                            adresses_voie:$("#inputadresses_voie"+adresseId).val(),
                            adresses_cp:$("#inputadresses_cp"+adresseId).val(),
                            adresses_ville:$("#inputadresses_ville"+adresseId).val(),
                            adresses_pays:$("#inputadresses_pays"+adresseId).val()
                            };
            var json = JSON.stringify( adresse );
            $.ajax({
                method: "POST",
                url: "<?php echo Router::url('adresses/update/'); ?>"+adresseId+"/"+userId+"/"+json,	
            })
            .done(function(request){
                $("#container_adresse").html(request);
                set_alert_message('success','L\'adresse a bien été modifiée');
            });
        };
</script>
<div id="dialog-confirm"></div>
<a id="btnAdd" class="cursor-pointer">ajouter une adresse</a>
<div id='modalAdd' class='updateAdresse'>
            <form action="<?php echo Router::url('adresses/add'); ?>" method="post" class="form">
                    <div class="form-group col-md-12">
                            <label for="inputadresses_libelle" class="label">Libelle</label>
                            <input type="text" id="inputadresses_libelle" name="adresses_libelle" value="" class="form-control" placeholder="Libelle">
                    </div>
                    <div class="form-group col-md-2">
                            <label for="inputadresses_num_voie" class="label">N°</label>
                            <input type="text" id="inputadresses_num_voie" name="adresses_num_voie" value="" class="form-control" placeholder="N°">
                    </div>
                    <div class="form-group col-md-10">
                            <label for="inputadresses_voie" class="label">Nom de la voie</label>
                            <input type="text" id="inputadresses_voie" name="adresses_voie" value="" class="form-control" placeholder="Nom de la voie">
                    </div>
                    <div class="form-group col-md-4">
                            <label for="inputadresses_cp" class="label">Code Postal</label>
                            <input type="text" id="inputadresses_cp" name="adresses_cp" value="" class="form-control" placeholder="Code Postal">
                    </div>
                    <div class="form-group col-md-4">
                            <label for="inputadresses_ville" class="label">Ville</label>
                            <input type="text" id="inputadresses_ville" name="adresses_ville" value="" class="form-control" placeholder="Ville">
                    </div>
                    <div class="form-group col-md-4">
                            <label for="inputadresses_pays" class="label">Pays</label>
                            <input type="text" id="inputadresses_pays" name="adresses_pays" value="" class="form-control" placeholder="Pays">
                    </div>
            </form>
        </div>
<div id="container_adresse">
    <?php include("listeAdresses.php"); ?>
</div>