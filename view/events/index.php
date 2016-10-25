<link rel="stylesheet" href="<?php echo CSS.'/style_events.css';?>"/>
<h1><?php echo isset($title)?$title:'Mes évènements'; ?><small>(<?php echo count($events);?>)</small></h1>
<div class='col-md-12'>
    <?php foreach ($events as $k => $v): 
        if($v->ln_users_events_accepted==1 && $v->users_users_id==$this->Session->User('users_id')): $color='#BCF5A9'; 
        elseif($v->ln_users_events_accepted<0 && $v->users_users_id==$this->Session->User('users_id')):$color='#F5A9A9'; 
        elseif($v->ln_users_events_accepted==2 && $v->users_users_id==$this->Session->User('users_id')):$color='#E7F875'; 
        else: $color='#A9BCF5'; endif;
    ?>
        <div class='col-md-3 block_event'>
            <a href="<?php echo Router::url('events/view/'.$v->events_id); ?>" class="event_item btn_events col-md-12">
                <div class="col-md-12 block_image_events image_view_events" style='border-left:5px solid <?php echo $color;?>'>
                    <?php if($v->events_image!=""){?>
                        <img src="<?php echo $v->events_image;?>" class="image_events"/>
                    <?php }else{?>
                        <img src="<?php echo IMG.'/polaroid.png';?>" class="image_events"/>
                    <?php } ?>
                </div>
                <div class="col-md-12">
                    <?php if(date("Ymd",strtotime($v->events_date_fin))== '19700101'){?>
                    Le <?php echo strftime('%d %B %Y à partir de %H:%M',strtotime($v->events_date_debut)); ?>
                    <?php }else{?>
                            Du <?php echo strftime('%d %B %Y %H:%M',strtotime($v->events_date_debut)); ?> au <?php echo strftime('%d %B %Y %H:%M',strtotime($v->events_date_fin)); ?>
                    <?php }?>
                    <br/>
                    <span class="title_events"><?php echo $v->events_libelle; ?></span><br/><br/>
                </div>
            </a>
        </div>
    <?php endforeach ?>
</div>