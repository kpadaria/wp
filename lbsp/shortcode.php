<?php
// create short code for form

	function book_search_shortcode() {
		
		$search_structure.="<div class='row'>";
		$search_structure.="<h1 class='search_title'>Book Search</h1>";
		$search_structure.="<div class='col-md-12'>";
		$search_structure.="<div class='col-md-6'>";
		$search_structure.="<label for='star_rating'>". esc_html__('Book Name', 'text-domain') ."</label>";
		$search_structure.="<input type='text' placeholder='Book Name' name='book' class='book form-control' id='book_name'/>";
		$search_structure.="</div>";
		$search_structure.="<div class='col-md-6'>";
		$search_structure.="<label for='star_rating'>". esc_html__('Author Name', 'text-domain') ."</label>";
		$search_structure.="<input type='text' placeholder='Author' name='auther' class='author form-control' id='author_id'/>";
		$search_structure.="</div>";
		
		$search_structure.="<div class='col-md-6'>";
		$search_structure.="<label for='star_rating'>". esc_html__('Select Rating', 'text-domain') ."</label>";
		$search_structure.="<select name='rating_name' class='rating form-control' id='rating_id'>
	              <option value=''>Select Rating</option>
				  <option value='1'>1</option>
				  <option value='2'>2</option>
				  <option value='3'>3</option>
				  <option value='4'>4</option>
				  <option value='5'>5</option>
				</select>"; 
		$search_structure.="</div>";
		$search_structure.="<div class='col-md-6'>";
		$search_structure.="<label for='star_rating'>". esc_html__('Select Publisher', 'text-domain') ."</label>";
		$taxonomies=get_terms(['taxonomy'=>'publisher',
		'hide_empty'=>false,
		]); 
		
		$search_structure.="<select name='publisher_name' class='publisher form-control' id='publisher_id'>
			  <option value=''>Select Publisher</option>";
				  foreach($taxonomies as $term){
					  $id = $term->term_id;
					  $name= $term->name;
		$search_structure.= "<option value=".$id.">".$name."</option>";
				  }
		$search_structure.=	"</select>";
		$search_structure.="</div>";
		
		$search_structure.="<div class='col-md-6'>";
		$search_structure.="<label for='star_rating'>". esc_html__('Price', 'text-domain') ."</label>";
		$search_structure.="<input type='text' id='amount' readonly style='border:0; color:#f6931f; font-weight:bold;'>";
		$search_structure.="<div id='slider-range'></div>";
		$search_structure.="<div id='min_price' style='display:none;'></div>";
		$search_structure.="<div id='max_price' style='display:none;'></div>";
		$search_structure.="</div>";
		
		$search_structure.="<div class='col-md-6'>";
		$search_structure.="<label for='star_rating'>". esc_html__('', 'text-domain') ."</label>";
		$search_structure.="<button name='search' id='search_id' class='search_book'>Search</button>";
		$search_structure.="</div>";
		
		$search_structure.="</div>";
		$search_structure.="</div>";
		$search_structure.="<br><br><br><div id='result'></div>";
		
		return $search_structure;
	}
	add_shortcode( 'search_book', 'book_search_shortcode' );