<?php

namespace Tests\Feature\Admin;

use App\Model\Admin\AdminUser;
use App\Model\Admin\EntityField;
use App\Repository\Admin\EntityRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class EntityFieldControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $entity;
    protected $user;
    protected $filedName = 'title';

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();

        $data = ['name' => '测试', 'table_name' => 'tests'];
        $this->entity = EntityRepository::add($data);
        $this->user = factory(AdminUser::class)->create();
    }

    public function testEntityFieldCanBeCreated()
    {
        $response = $this->createEntityField();
        $response->assertJson(['code' => 0]);
        $this->assertDatabaseHas(
            'entity_fields',
            [
                'entity_id' => $this->entity->id,
                'name' => 'title',
                'is_show' => EntityField::SHOW_DISABLE,
                'is_edit' => EntityField::EDIT_DISABLE,
                'is_required' => EntityField::REQUIRED_DISABLE,
                'is_show_inline' => EntityField::SHOW_NOT_INLINE,
            ]
        );
        $this->assertTrue(Schema::hasColumn($this->entity->table_name, $this->filedName));
    }

    public function testEntityContentCanBeCreatedAndEdited()
    {
        $this->createEntityField();
        $data = [
            'title' => '测试标题'
        ];
        $response = $this->actingAs($this->user, 'admin')
            ->post('/admin/entity/' . $this->entity->id . '/contents', $data);
        $response->assertJson(['code' => 0]);

        $data = [
            'title' => '测试修改标题'
        ];

        $response = $this->actingAs($this->user, 'admin')
            ->put('/admin/entity/' . $this->entity->id . '/contents/1', $data);
        $response->assertJson(['code' => 0]);
    }

    protected function createEntityField()
    {
        $data = [
            'entity_id' => $this->entity->id,
            'name' => $this->filedName,
            'type' => 'string',
            'form_name' => '标题',
            'form_type' => 'input',
            'order' => 77,
            'field_length' => '',
            'field_total' => '',
            'field_scale' => '',
            'comment' => '',
            'default_value' => ''
        ];
        return $this->actingAs($this->user, 'admin')
            ->post('/admin/entityFields', $data);
    }
}
