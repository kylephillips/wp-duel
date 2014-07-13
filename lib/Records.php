<?php namespace WPDuel;
use \WP_Query;
/**
* Duel Records
*/
class Records {

	/**
	* Records
	* @var array
	*/
	private $records;

	/**
	* Max Pages
	*/
	private $total_pages;

	/**
	* Records per Page
	*/
	private $per_page;

	/**
	* Pagination
	*/
	private $pagination;


	public function __construct($per_page)
	{
		$this->setPerPage($per_page);
		$this->getRecords();
		$this->displayRecords();
	}


	/**
	* Get the Records from the DB
	*/
	private function getRecords()
	{
		global $paged;
		$record_query = new WP_Query([
			'post_type' => get_option('wpduel_post_type'),
			'posts_per_page' => $this->per_page,
			'meta_key' => 'wpduel_win_ratio',
			'orderby' => 'meta_value_num',
			'paged' => $paged
		]);
		if ( $record_query->have_posts() ) : $i = 0; 
			$this->total_pages = $record_query->max_num_pages;
			$this->setPagination();
			while ( $record_query->have_posts() ) : $record_query->the_post();
				$this->records[$i]['title'] = get_the_title();
				$this->records[$i]['win_ratio'] = get_post_meta(get_the_ID(), 'wpduel_win_ratio', true);
				$i++;
			endwhile;
		else :
			$this->records[] = 'No Records at this time.';
		endif; wp_reset_postdata();
	}


	/**
	* Set per page
	*/
	private function setPerPage($per_page)
	{
		$this->per_page = ( isset($per_page) ) ? $per_page : -1;
	}


	/**
	* Display the Records
	*/
	private function displayRecords()
	{
		include( dirname( dirname(__FILE__) ) . '/views/wpduel-records.php');
	}


	/**
	* Set the Pagination Links
	*/
	private function setPagination()
	{
		$big = 99999999;
		$links = paginate_links(array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'current' => max( 1, get_query_var('paged') ),
			'total' => $this->total_pages
		));
		$this->pagination = $links;
	}

}