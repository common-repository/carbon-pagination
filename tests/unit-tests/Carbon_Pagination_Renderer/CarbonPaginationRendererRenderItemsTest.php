<?php
/**
 * @group renderer
 */
class CarbonPaginationRendererRenderItemsTest extends WP_UnitTestCase {

	public function setUp() {
		$paginationStub = $this->getMockForAbstractClass( 'Carbon_Pagination_HTML' );
		$this->pagination = $paginationStub;

		$params = array($this->pagination);
		$collectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->collection = $collectionStub;

		$params = array($this->pagination, false);
		$subitemsCollectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->subitems_collection1 = $subitemsCollectionStub;

		$subitemsCollectionStub = $this->getMock('Carbon_Pagination_Collection', null, $params);
		$this->subitems_collection2 = $subitemsCollectionStub;

		$params = array($this->collection);
		$rendererStub = $this->getMock('Carbon_Pagination_Renderer', null, $params);
		$this->renderer = $rendererStub;

		$itemParams = array($this->collection);
		$itemStub = $this->getMockForAbstractClass( 'Carbon_Pagination_Item', $itemParams, '', TRUE, TRUE, TRUE, array('render', 'get_subitems_collection') );
		$this->item1 = $itemStub;
		$this->item1->expects( $this->any() )
			->method('render')
			->will( $this->returnValue( '123' ) );

		$itemStub = $this->getMockForAbstractClass( 'Carbon_Pagination_Item', $itemParams, '', TRUE, TRUE, TRUE, array('render', 'get_subitems_collection') );
		$this->item2 = $itemStub;
		$this->item2->expects( $this->any() )
			->method('render')
			->will( $this->returnValue( '456' ) );

		$itemStub = $this->getMockForAbstractClass( 'Carbon_Pagination_Item', $itemParams, '', TRUE, TRUE, TRUE, array('render', 'get_subitems_collection') );
		$this->item3 = $itemStub;
		$this->item3->expects( $this->any() )
			->method('render')
			->will( $this->returnValue( '789' ) );
	}

	public function tearDown() {
		unset($this->pagination);
		unset($this->collection);
		unset($this->subitems_collection1);
		unset($this->subitems_collection2);
		unset($this->renderer);
		unset($this->item1);
		unset($this->item2);
		unset($this->item3);
	}

	/**
	 * @covers Carbon_Pagination_Renderer::render_items
	 */
	public function testFlatItems() {
		$items = array( $this->item1, $this->item2, $this->item3 );

		$expected = '123456789';
		$actual = $this->renderer->render_items( $items );
		$this->assertSame( $expected, $actual );
	}

	/**
	 * @covers Carbon_Pagination_Renderer::render_items
	 */
	public function testOneLevelHierarchy() {
		$items = array( $this->item1 );
		$this->subitems_collection1->set_items( array( $this->item2 ) );

		$this->item1->expects( $this->any() )
			->method('get_subitems_collection')
			->will( $this->returnValue( $this->subitems_collection1 ) );		

		$expected = '456';
		$actual = $this->renderer->render_items( $items );
		$this->assertSame( $expected, $actual );
	}

	/**
	 * @covers Carbon_Pagination_Renderer::render_items
	 */
	public function testOneLevelHierarchyMixed() {
		$items = array( $this->item3, $this->item1 );
		$this->subitems_collection1->set_items( array( $this->item2 ) );

		$this->item1->expects( $this->any() )
			->method('get_subitems_collection')
			->will( $this->returnValue( $this->subitems_collection1 ) );		

		$expected = '789456';
		$actual = $this->renderer->render_items( $items );
		$this->assertSame( $expected, $actual );
	}

	/**
	 * @covers Carbon_Pagination_Renderer::render_items
	 */
	public function testTwoLevelHierarchy() {
		$items = array( $this->item1 );
		$this->subitems_collection1->set_items( array( $this->item2 ) );
		$this->subitems_collection2->set_items( array( $this->item3 ) );

		$this->item1->expects( $this->once() )
			->method('get_subitems_collection')
			->will( $this->returnValue( $this->subitems_collection1 ) );

		$this->item2->expects( $this->once() )
			->method('get_subitems_collection')
			->will( $this->returnValue( $this->subitems_collection2 ) );

		$expected = '789';
		$actual = $this->renderer->render_items( $items );
		$this->assertSame( $expected, $actual );
	}

}