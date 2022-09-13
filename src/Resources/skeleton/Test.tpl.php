<?= "<?php\n" ?>

namespace <?= $namespace; ?>;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class <?= $class_name ?> extends WebTestCase
{
    use \Baldeweg\Bundle\ApiBundle\ApiTestTrait;

    public function testScenario()
    {
        // list
        $request = $this->request('/api/<?= $name_lowercase; ?>/', 'GET');

        $this->assertTrue(isset($request));

        // new
        $request = $this->request('/api/<?= $name_lowercase; ?>/new', 'POST', [], [
            // params
        ]);

        $this->assertTrue(isset($request));
        // add asserts

        $id = $request->id;

        // edit
        $request = $this->request('/api/<?= $name_lowercase; ?>/' . $id, 'PUT', [], [
            // params
        ]);

        $this->assertTrue(isset($request));
        // add asserts

        // show
        $request = $this->request('/api/<?= $name_lowercase; ?>/' . $id, 'GET');

        $this->assertTrue(isset($request));
        // add asserts

        // delete
        $request = $this->request('/api/<?= $name_lowercase; ?>/' . $id, 'DELETE');

        $this->assertEquals('DELETED', $request->msg);
    }
}
