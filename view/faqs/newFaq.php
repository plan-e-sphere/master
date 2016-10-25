<link rel="stylesheet" href="<?php echo CSS.'/style_faq.css';?>"/>
<div class="contenu">
        <form action="<?php echo Router::url('faqs/addFaq/'.$faq->faqs_id) ; ?>" method="post" class="form">
            <input type="hidden" name="faqs_id" value="<?php echo $faq->faqs_id; ?>">
            <div class="form-group col-md-12">
                <label for="inputfaqs_request" class="label">Question <span class="red">*</span></label>
                    <span id="inputfaqs_request_error" class="error_form"></span>
                    <input type="text" id="inputfaqs_request" name="faqs_request" value="<?php echo $faq->faqs_request;?>" class="form-control" placeholder="Question">
            </div>
            <div class="form-group col-md-12">
                <label for="inputfaqs_answer" class="label">Réponse <span class="red">*</span></label>
                    <span id="inputfaqs_answer_error" class="error_form"></span>
                    <input type="text" id="inputfaqs_answer" name="faqs_answer" value="<?php echo $faq->faqs_answer;?>" class="form-control" placeholder="Réponse">
            </div>
            <div class="form-group col-md-12">
                <label for="inputfaqs_categorie" class="label">Catégorie <span class="red">*</span></label>
                    <span id="inputfaqs_categorie_error" class="error_form"></span>
                    <input type="text" id="inputfaqs_categorie" name="faqs_categorie" value="<?php echo $faq->faqs_categorie;?>" class="form-control" placeholder="Catégorie">
            </div>
            <?php if(empty($faq->faqs_id)){?>
            <div class="col-md-6">
		<input type="submit" id="btn_add_faq" class="btn btn-default col-md-4 col-md-offset-3" value="Ajouter">
            </div>
            <?php }else{?>
                <div class="form-group col-md-12">
			<div class="col-md-4">
				<input type="submit" class="btn btn-default col-md-4 col-md-offset-3" value="Modifier">
			</div>
			<div class="col-md-4">
				<a href="<?php echo Router::url('faqs/index'); ?>" class="btn btn-default col-md-4 col-md-offset-3"> Annuler</a>
			</div>
		</div>
            <?php } ?>
        </form>
		
</div>
<br/><br/>