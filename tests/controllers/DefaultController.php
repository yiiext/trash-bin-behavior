<?php
/**
 * DefaultController class file.
 *
 * @author Veaceslav Medvedev <slavcopost@gmail.com>
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

/**
 * Class DefaultController
 *
 * @author Veaceslav Medvedev <slavcopost@gmail.com>
 * @version 0.1
 */
class DefaultController extends CDbTestCase
{
	public $fixtures = array(
		'posts' => 'TestPost',
		'users' => 'TestUser',
	);

	public function testSave()
	{
		$user = new TestUser();
		$user->id = 1;
		$user->name = 'webmaster';

		$post = new TestPost();
		$post->id = 1;
		$post->title = 'Lorem ipsum';
		$post->user_id = $user->id;

		$this->assertTrue($post->save());
		$this->assertFalse((bool) $post->removed);
		$this->assertFalse($post->isRemoved);

		$post->remove();
		$this->assertTrue($post->save());
		$this->assertTrue((bool) $post->removed);
		$this->assertTrue($post->isRemoved);

		$post->restore();
		$this->assertTrue($post->save());
		$this->assertFalse((bool) $post->removed);
		$this->assertFalse($post->isRemoved);
	}

	public function testFind()
	{
		$user = new TestUser();
		$user->id = 1;
		$user->name = 'webmaster';

		for ($i = 0; $i < 5; $i++) {
			$post = new TestPost();
			$post->id = $i + 1;
			$post->title = 'First post';
			$post->user_id = $user->id;
			$post->save();
		}

		$this->assertCount(5, TestPost::model()->findAll());

		TestPost::model()->findByPk(1)->remove()->save();
		TestPost::model()->findByPk(5)->remove()->save();

		$this->assertCount(3, TestPost::model()->findAll());
		$this->assertCount(5, TestPost::model()->withRemoved()->findAll());
	}
}