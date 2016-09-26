<?php

namespace CodePress\CodeTag\Tests\Models;

use CodePress\CodePost\Models\Post;
use CodePress\CodeTag\Models\Tag;
use CodePress\CodeTag\Tests\AbstractTestCase;
use Illuminate\Validation\Validator;
use Mockery as m;

class TagTest extends AbstractTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->migrate();
    }

    public function test_inject_validator_in_tag_model()
    {
        $tag = new Tag();

        $validator = m::mock(Validator::class);

        $tag->setValidator($validator);

        $this->assertEquals($tag->getValidator(), $validator);
    }

    public function test_should_check_if_it_is_valid_when_it_is()
    {
        $tag = new Tag();
        $tag->name = 'Tag Test';

        $validator = m::mock(Validator::class);

        $validator->shouldReceive('setRules')->with([
            'name' => 'required|max:255'
        ]);

        $validator->shouldReceive('setData')->with([
            'name' => 'Tag Test'
        ]);

        $validator->shouldReceive('fails')->andReturn(false);

        $tag->setValidator($validator);

        $this->assertTrue($tag->isValid());
    }

    public function test_should_check_if_it_is_invalid_when_it_is()
    {
        $tag = new Tag();
        $tag->name = 'Tag Test';

        $validator = m::mock(Validator::class);
        $messageBag = m::mock('Illuminate\Support\MessageBag');

        $validator->shouldReceive('setRules')->with([
            'name' => 'required|max:255'
        ]);

        $validator->shouldReceive('setData')->with([
            'name' => 'Tag Test'
        ]);

        $validator->shouldReceive('fails')->andReturn(true);

        $validator->shouldReceive('errors')->andReturn($messageBag);

        $tag->setValidator($validator);

        $this->assertFalse($tag->isValid());
        $this->assertEquals($messageBag, $tag->errors);
    }

    public function test_check_if_a_category_can_be_persisted()
    {
        $tag = Tag::create([
            'name' => 'Tag Test',
        ]);

        $this->assertEquals('Tag Test', $tag->name);
    }


}