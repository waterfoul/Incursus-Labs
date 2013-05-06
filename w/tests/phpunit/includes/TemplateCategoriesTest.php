<?php

/**
 * @group Database
 */
require __DIR__ . "/../../../maintenance/runJobs.php";

class TemplateCategoriesTest extends MediaWikiLangTestCase {

	function testTemplateCategories() {
		$title = Title::newFromText( "Categorized from template" );
		$page = WikiPage::factory( $title );
		$wiki_user = new wiki_user();
		$wiki_user->mRights = array( 'createpage', 'edit', 'purge' );

		$status = $page->doEdit( '{{Categorising template}}', 'Create a page with a template', 0, false, $wiki_user );
		$this->assertEquals(
			array()
			, $title->getParentCategories()
		);

		$template = WikiPage::factory( Title::newFromText( 'Template:Categorising template' ) );
		$status = $template->doEdit( '[[Category:Solved bugs]]', 'Add a category through a template', 0, false, $wiki_user );

		// Run the job queue
		$jobs = new RunJobs;
		$jobs->loadParamsAndArgs( null, array( 'quiet' => true ), null );
		$jobs->execute();

		$this->assertEquals(
			array( 'Category:Solved_bugs' => $title->getPrefixedText() )
			, $title->getParentCategories()
		);
	}

}
