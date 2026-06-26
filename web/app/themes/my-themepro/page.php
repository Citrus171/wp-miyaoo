<?php get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

<div class="pt-36 pb-32 max-w-3xl mx-auto px-6">

    <div class="fade-up mb-12 pb-8 border-b border-[#e4e4e7]">
        <h1 class="text-4xl font-bold tracking-tight text-[#09090b]">
            <?php the_title(); ?>
        </h1>
    </div>

    <div class="fade-up prose">
        <?php the_content(); ?>
    </div>

</div>

<?php endwhile; ?>

<?php get_footer(); ?>
