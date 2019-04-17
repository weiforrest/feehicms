<?php
use common\widgets\JsBlock;
use frontend\assets\ImageAsset;

ImageAsset::register($this);

?>
<div class="container gallery-container">
    <h1><?=$tips?></h1>

		    <div class="tz-gallery">
		        <div class="row">
                    <?php
                    foreach($images as $image){
                        ?>
		            <div class="col-sm-6 col-md-4">
		                <div class="thumbnail">
		                    <a class="lightbox" href="<?=$image['img']?>">
		                        <img src="<?=$image['img']?>" alt="Rails">
		                    </a>
		                    <div class="caption">
		                        <h3><?=$image['desc']?></h3>
		                    </div>
		                </div>
                    </div>
                    <?php
                    }
                    ?>
		        </div>
		    </div>
</div>

        <?php
        JsBlock::begin();
        echo '<script type="text/javascript"> baguetteBox.run(".tz-gallery");</script>'; 
       JsBlock::end();
       ?>