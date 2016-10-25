<link rel="stylesheet" href="<?php echo CSS.'/style_faq.css';?>"/>

<script type="text/javascript">
		
	$(function(){
		$(".question").click( function(){
			var id = $(this).attr('id');
			var taille = $("#"+id+"_size").css('height');
                        $(".rep").css("height","0px");
			if ($("#"+id+"_rep").css('height') <="0px") {
                                $("#"+id+"_rep").css("height",taille);
			}else{
				$("#"+id+"_rep").css("height","0px");
			}
		}
		)});
</script>
<div class="contenu">
    	<span id="haut"><strong>F.A.Q.</strong></span>
        <?php if($this->Session->user('users_statut')=="admin"):?>
        <a href="<?php echo Router::url('faqs/newFaq'); ?>" class="btn btn-default"> + </a><br /> <br />
        <?php endif ?>
	<?php foreach($faqs as $k=>$v):?>
            <div class="titre"><span><?php echo $v->name;?></span></div>
            <br/>
            <?php foreach($v->faqs as $p=>$o):?>
            <div>
                <div><span id="<?php echo $o->faqs_id; ?>" class="question"><span><?php echo $o->faqs_request; ?></span></span>
                
                <?php if($this->Session->user('users_statut')=="admin"):?>
                    <a href="<?php echo Router::url('faqs/updateFaq/'.$o->faqs_id.'/update'); ?>" class="btn btn-default"><i class="fa fa-pencil"></i></a>
                    <button type="button" class="btn btn-default"
			data-toggle="popover" title="Êtes-vous sûr ?" data-html="true" data-trigger="click"
			data-content="<a href='<?php echo Router::url('faqs/delete/'.$o->faqs_id); ?>'><button type='button' class='btn btn-default'>Supprimer</button></a>" 
			data-placement="bottom"><i class="fa fa-trash"></i>
                    </button>
		<?php endif;?>
                </div>
                <div id="<?php echo $o->faqs_id; ?>_rep" class="rep">
                    <div id="<?php echo $o->faqs_id; ?>_size"><?php echo $o->faqs_answer; ?></div>
                </div>
            </div>
            <br/>
            <?php endforeach;?>
        <?php endforeach;?>
                
	
	
</div>
<br/><br/>