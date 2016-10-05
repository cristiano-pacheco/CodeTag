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

    public function test_can_soft_delete()
    {
        $tag = $this->createTag();
        $tag->delete();

        $this->assertTrue($tag->trashed());
        $this->assertCount(0, Tag::all());
    }

    public function test_can_get_rows_deleted()
    {
        $tag = $this->createTag();
        $tag->delete();

        $this->createTag();

        $tags = Tag::onlyTrashed()->get();
        $this->assertEquals(1, $tags[0]->id);
        $this->assertEquals('Tag Test', $tags[0]->name);
    }

    public function test_can_get_rows_deleted_and_activated()
    {
        $tag = $this->createTag();
        $tag->delete();

        $this->createTag();

        $tags = Tag::withTrashed()->get();
        $this->assertEquals(1, $tags[0]->id);
        $this->assertEquals('Tag Test', $tags[0]->name);
        $this->assertCount(2, $tags);
    }


    public function test_can_force_delete()
    {
        $tag = $this->createTag();
        $tag->forceDelete();

        $this->assertCount(0, Tag::all());
    }

    public function test_can_restore_rows_from_deleted()
    {
        $tag = $this->createTag();
        $tag->delete();
        $tag->restore();

        $tags = Tag::all();
        $this->assertEquals(1, $tags[0]->id);
        $this->assertEquals('Tag Test', $tags[0]->name);
    }

    public function createTag()
    {
        return Tag::create(['name' => 'Tag Test']);
    }
}