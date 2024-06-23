<?php

namespace Tests\Feature\Tasks;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteTaskTest extends TestCase
{
   use RefreshDatabase;

   public function test_status_204_no_content()
   {
       $user = $this->authUser();
       $task = $this->task()->create(['user_id' => $user->id]);

       $this->deleteJson(route('tasks.destroy', $task->id), [$task])
           ->assertNoContent();
   }

   public function test_delete_task_from_database()
   {
       $user = $this->authUser();
       $task = $this->task()->create(['user_id' => $user->id]);

       $this->deleteJson(route('tasks.destroy', $task->id), [$task]);
       
       $this->assertDatabaseMissing('tasks', [
               'id' => $task->id,
               'title' => $task->title,
               'description' => $task->description,
               'status' => $task->status,
               'created_at' => $task->created_at,
               'updated_at' => $task->updated_at,
           ]);
   }

   public function test_invalid_id_for_delete_a_single_task()
   {
       $user = $this->authUser();
       $task = $this->task()->create(['user_id' => $user->id])->toArray();

       $incorrectId = 9999;

       $this->deleteJson(route('tasks.destroy', $incorrectId), $task)
           ->assertNotFound();
   }
}