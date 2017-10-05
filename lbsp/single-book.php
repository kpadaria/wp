<?php
/* show all single post of book

*/

?>
<?php 
get_header();
$id =get_the_ID();
$image =get_the_post_thumbnail( $id, 'full' );   
?>

<div class="row">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div class="col-md-6">
<?php if($image!=''){

 echo $image;
}
else{?>
	<img src="<?php echo plugin_dir_url( __FILE__ ) .'image/book.png'?>" /> 
<?php }
 ?>
</div>
<div class="col-md-6">
<h1><strong><?php echo get_the_title($id); ?></strong></h1>
<?php 
$author= wp_get_post_terms( $id,'author',array("fields" => "names")); 
$author_implod = implode(" , ",$author);
?>
<h3>Author : <span class="author"><?php echo $author_implod;?></h3>
<?php $publisher =wp_get_post_terms($id,'publisher',array("fields" => "names"));
			$publisher_implod = implode(",",$publisher);
			?>
<h3>Publisher : <span class="publisher"><?php echo 	$publisher_implod;?></span>
<?php $price = get_post_meta($id,'price',true);?>
<h3>Price : <span class="price"><?php echo $price; ?>
<?php $rating = get_post_meta($id,'star_rating',true);?>
<h3>Rating : <span class="rating">Rating of this book is : <?php echo $rating;?> </span></h3>	
			
</div>	
<?php endwhile; ?>
<?php endif; ?>		
</div>

<?php get_footer();?>
