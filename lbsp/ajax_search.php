<?php
add_action( 'wp_ajax_search_result_fun', 'search_result' );
add_action( 'wp_ajax_nopriv_search_result_fun', 'search_result' );

function search_result(){
	
	$query = array('posts_per_page' => -1,'post_type'=>'book','meta_query'=>array('relation'=>'AND'),'tax_query' => array('relation' => 'AND'));
	 

		$book = $_POST['book'];
		$rating = $_POST['rating'];
		$publisher = $_POST['publisher'];
		$author = $_POST['author'];
		$min_price = $_POST['min_price'];
		$max_price = $_POST['max_price'];
		
	   // build dynamic wp query...

		if(!empty($book))
        {
            $query['title'] = $book;
        }
		 if(!empty($rating))
        {
            $query['meta_query'][] = array('key' => 'star_rating', 'value' => $rating, 'compare' => '=');
        }
        if(!empty($max_price))
        {
            $query['meta_query'][] = array('key' => 'price', 'value' => array($min_price,$max_price), 'compare' => 'BETWEEN','type'    => 'numeric');
        }
        if(!empty($author))
        {
            $query['tax_query'][] = array('taxonomy' => 'author', 'field' =>'name', 'terms' => $author);
        }
        if(!empty($publisher))
        {
            $query['tax_query'][] = array('taxonomy' => 'publisher', 'field' =>'id', 'terms' => $publisher);
        }

        if(count($query['meta_query'])<2)
        {
        
            unset($query['meta_query']);
        }
        if(count($query['tax_query'])<2)
        {
        
            unset($query['tax_query']);
        }
        
        $books = new WP_Query($query);

        if(count($books->posts)){

?>
       <div class="row">
		<div class="table-responsive">
			<table class="table">
				<tr>
					<td><b>Title</b></td>
					<td><b>Author</b></td>
					<td><b>Publisher</b></td>
					<td><b>Price</b></td>
					<td><b>Rating</b></td>
				</tr>
				<?php 
					foreach ($books->posts as $book) {
						$id =  $book->ID;

						$author = array();
						$terms = get_the_terms( $id, 'author' );
						foreach ($terms as $term) {
							$author[] = $term->name;
						}
							
						$author = join(',',$author);


						$publisher = array();
						$terms = get_the_terms( $id, 'publisher' );
						foreach ($terms as $term) {
							$publisher[] = $term->name;
						}
						$publisher = join(',',$publisher);

						$price = get_post_meta($id,'price',true);
						$ratings = get_post_meta($id,'star_rating',true);
						$rating = '';
						for($i=0;$i<$ratings;$i++)
						{
							$rating .= '<span class="dashicons dashicons-star-filled"></span>';
						}


						
						
				?>
					<tr>
						<td><a href="<?php echo esc_url( get_permalink($id) ); ?>"><?php echo $book->post_title; ?></a></td>
						<td><?php echo $author; ?></td>
						<td><?php echo $publisher; ?></td>
						<td>$<?php echo $price; ?></td>
						<td><?php echo $rating; ?></td>
					</tr>		
				<?php	
				}
				 ?>

		</table>
		</div>
		</div>

<?php


        }
        else{
        	echo 'no book found.';
        }
        
        


	exit;
}
