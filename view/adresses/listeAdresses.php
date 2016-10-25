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
    });
</script>
<?php
    foreach ($adresses as $k => $v) {
    ?>
        <div class="adresse col-md-4">
            <div class="col-md-1">
                <i class="fa fa-pencil cursor-pointer" aria-hidden="true" name="<?php echo $v->adresses_libelle; ?>" userId="<?php echo $v->adresses_users_id; ?>" adresseId="<?php echo $v->adresses_id; ?>"></i><br/>
                <i class="fa fa-trash cursor-pointer" aria-hidden="true" name="<?php echo $v->adresses_libelle; ?>" userId="<?php echo $v->adresses_users_id; ?>" adresseId="<?php echo $v->adresses_id ?>"></i>
            </div>
            <div class="col-md-11">
                <b><?php echo $v->adresses_libelle; ?></b><br/>
                <?php echo $v->adresses_num_voie; ?>
                <?php echo $v->adresses_voie; ?>
                <?php echo $v->adresses_cp; ?>
                <?php echo $v->adresses_ville; ?>
                <?php echo $v->adresses_pays; ?>
            </div>
        </div>
        <div id='modal<?php echo $v->adresses_id; ?>' class='updateAdresse'>
            <form action="<?php echo Router::url('adresses/add'); ?>" method="post" class="form">
                    <div class="form-group col-md-12">
                            <label for="inputadresses_libelle" class="label">Libelle</label>
                            <input type="text" id="inputadresses_libelle<?php echo $v->adresses_id; ?>" name="adresses_libelle" value="<?php echo $v->adresses_libelle; ?>" class="form-control" placeholder="Libelle">
                    </div>
                    <div class="form-group col-md-2">
                            <label for="inputadresses_num_voie" class="label">N°</label>
                            <input type="text" id="inputadresses_num_voie<?php echo $v->adresses_id; ?>" name="adresses_num_voie" value="<?php echo $v->adresses_num_voie; ?>" class="form-control" placeholder="N°">
                    </div>
                    <div class="form-group col-md-10">
                            <label for="inputadresses_voie" class="label">Nom de la voie</label>
                            <input type="text" id="inputadresses_voie<?php echo $v->adresses_id; ?>" name="adresses_voie" value="<?php echo $v->adresses_voie; ?>" class="form-control" placeholder="Nom de la voie">
                    </div>
                    <div class="form-group col-md-4">
                            <label for="inputadresses_cp" class="label">Code Postal</label>
                            <input type="text" id="inputadresses_cp<?php echo $v->adresses_id; ?>" name="adresses_cp" value="<?php echo $v->adresses_cp; ?>" class="form-control" placeholder="Code Postal">
                    </div>
                    <div class="form-group col-md-4">
                            <label for="inputadresses_ville" class="label">Ville</label>
                            <input type="text" id="inputadresses_ville<?php echo $v->adresses_id; ?>" name="adresses_ville" value="<?php echo $v->adresses_ville; ?>" class="form-control" placeholder="Ville">
                    </div>
                    <div class="form-group col-md-4">
                            <label for="inputadresses_pays" class="label">Pays</label>
                            <input type="text" id="inputadresses_pays<?php echo $v->adresses_id; ?>" name="adresses_pays" value="<?php echo $v->adresses_pays; ?>" class="form-control" placeholder="Pays">
                    </div>
            </form>
        </div>
    <?php
    } ?>