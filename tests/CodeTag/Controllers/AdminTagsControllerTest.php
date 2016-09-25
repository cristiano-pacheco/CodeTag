<?php

namespace CodePress\CodeCategory\Tests\Controllers;

use CodePress\CodeTag\Controllers\AdminTagsController;
use CodePress\CodeTag\Controllers\Controller;
use CodePress\CodeTag\Repository\TagRepositoryInterface;
use CodePress\CodeTag\Tests\AbstractTestCase;

use Illuminate\Contracts\Routing\ResponseFactory;
use Mockery as m;

class AdminTagsControllerTest extends AbstractTestCase
{
    public function test_should_extend_from_controller()
    {
        $repository = m::mock(TagRepositoryInterface::class);
        $responseFactory = m::mock(ResponseFactory::class);
        $controller = new AdminTagsController($responseFactory, $repository);

        $this->assertInstanceOf(Controller::class, $controller);
    }

    public function test_controller_should_run_index_method_and_return_correct_arguments()
    {
        $repository = m::mock(TagRepositoryInterface::class);
        $responseFactory = m::mock(ResponseFactory::class);
        $html = m::mock();

        $controller = new AdminTagsController($responseFactory, $repository);

        $tagsResult = ['tag1', 'tag2'];
        $repository->shouldReceive('all')->andReturn($tagsResult);

        $responseFactory->shouldReceive('view')
            ->with('codetag::index', ['tags' => $tagsResult])
            ->andReturn($html);


        $this->assertEquals($controller->index(), $html);

    }
}