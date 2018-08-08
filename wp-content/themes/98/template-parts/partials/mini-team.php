<?php $agent = (isset($agent) ? $agent : null); ?>
<div class="col-sm-6 col-lg-4" >
    <div class="agent-container">
        <div class="agent-thumb text-xs-center">
            <a href="<?= $agent['link']; ?>">
                <img src="<?= $agent['images']['thumbnail'][0]; ?>" >
            </a>
        </div>
        <div class="agent-info text-xs-center">
            <h3 class="agent-name"><?php echo $agent['name']; ?></h3>
            <p class="title"><?php echo $agent['title']; ?></p>
            <div class="line"></div>
            <?php if($agent['email']!=''){ ?><p class="email"><a href="mailto:<?php echo $agent['email']; ?>" ><?php echo $agent['email']; ?></a></p><?php } ?>
            <?php if($agent['cell_phone']!=''){ ?>
                <p class="phone clicktocall"><a href="tel:<?php echo $agent['cell_phone']; ?>" ><?php echo $agent['cell_phone']; ?></a></p>
            <?php }elseif($agent['office_phone']){ ?>
                <p class="phone clicktocall"><a href="tel:<?php echo $agent['office_phone']; ?>" ><?php echo $agent['office_phone']; ?></a></p>
            <?php } ?>
            <a href="<?php echo $agent['link']; ?>" class="btn btn-primary agent-button" >more info</a>
        </div>
    </div>
</div>