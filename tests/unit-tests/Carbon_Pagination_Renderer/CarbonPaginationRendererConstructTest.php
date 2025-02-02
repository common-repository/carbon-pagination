<?php
/**
 * @group renderer
 * @group constructors
 */
class CarbonPaginationRendererConstructTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination_HTML' );
		$this->pagination = $paginationStub;

		$params = array($this->pagination);
		$collectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->collection = $collectionStub;
	}

	public function tearDown() {
		unset($this->pagination);
		unset($this->collection);
	}

	/**
	 * @covers Carbon_Pagination_Renderer::__construct
	 */
	public function testIfCollectionProperlySet() {
		$params = array($this->collection);
		$renderer = $this->getMock('Carbon_Pagination_Renderer', null, $params);
		$this->assertSame( $this->collection, $renderer->get_collection() );
	}

}