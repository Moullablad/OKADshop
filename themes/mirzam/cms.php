<?php
/**
 * The template for displaying cms page.
 *
 * @link https://okdashop.com
 *
 * @package OKADshop
 *
 *
 * 
 *
 */

 
?>

 


<div class="maincontainer">
    <section class="cms-content">
        <div class="container">
            <div class="title-section text-center">
                <h2 class="title"><?= $cms->title; ?></h2>
            </div>
 
            <p>
                <?= $cms->content; ?>
            </p>
        </div>
    </section>
</div>