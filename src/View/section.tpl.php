<section <?php if ($d->id !== null) : ?>id='<?=$d->id?>'<?php endif; ?> class='<?=$d->type?>' <?php if ($d->color !== null) : ?>style='<?php if ($d->color->font !== null) : ?>color: <?=$d->color->font?>; <?php endif; ?><?php if ($d->color->background !== null) : ?>background-color: <?=$d->color->background?>;<?php endif; ?>'<?php endif; ?>>
    <div class='content'>
        <div class='text'>
<?php if ($d->text !== null) : ?>
            <?=$d->text?> 
<?php endif; ?>
<?php if ($d->link !== null) : ?>
            <a class='button' href='<?=$d->link->url?>'><?=$d->link->text?></a>
<?php endif; ?>
        </div>
        <div class='img'>
<?php if ($d->image !== null) : ?>
            <image src='<?=$d->image->file?>'<?php if ($d->image->altText !== null) : ?> alt='<?=$d->image->altText?>'<?php endif; ?> />
<?php endif; ?>
        </div>
    </div>
</section>
