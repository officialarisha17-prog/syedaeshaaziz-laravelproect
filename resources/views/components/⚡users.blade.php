<?php

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
new class extends Component
{
    public $users;
    public function render()
    {
        $this ->users= User::all();
        return view('components.⚡users');
    }
};
?>

<div class="card-body">
            <h2 class="card-title mb-4">Users</h2>

            <table class="table table-striped table-bordered">
                <thead  class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <!-- <td>
                            <button wire:click="edit({{ $user->id }})" class="btn btn-warning btn-sm">
                                Edit
                            </button>

                            <button 
                                wire:click="delete({{ $user->id }})"
                                onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                class="btn btn-danger btn-sm">
                                Delete
                            </button>
                        </td> -->
                    </tr>
                    @endforeach
                </tbody>

            </table>
</div>
