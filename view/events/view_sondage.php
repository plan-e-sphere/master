<div class="col-md-6">
    <?php if ($lnUserEvent->ln_users_events_role=="createur"){?>
        <a href="<?php echo Router::url('sondages/newSondage/'.$events->events_id); ?>">Nouveau sondage</a>
    <?php } 
    foreach ($sondages as $k => $v):?>
    <div>
        <?php echo $v->sondages_libelle;?>
        <?php echo $v->sondages_request;?>
    </div>
    <?php endforeach;?>
</div>