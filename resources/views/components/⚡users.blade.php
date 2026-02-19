<?php

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\WithFileUploads;
new class extends Component
{
     use WithFileUploads;
    public $users;
    public $name;
    public $email;
    public $password;
    public $image;
    public $isCreating = false;
    public $isEditing = false;
    public $user_id;

      protected function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->user_id,
            'password' => $this->isEditing ? 'nullable|min:6|max:255' : 'required|min:6|max:255',
             'image' => $this->isCreating || $this->isEditing ? 'nullable|image|max:2048' : '',
        ];
    }
    public function resetInput()
    {
        $this->name = null;
        $this->email = null;
        $this->password = null;
        $this->image = null;
    }
    public function mount()
    {
        $this->users = User::latest()->get();
    }
    public function openCreate()
    {
        $this->resetInput();
        $this->isCreating = true;
    }
    public function closeCreate()
    {
        $this->resetInput();
        $this->isCreating = false;
        $this->isEditing = false;
    }
    public function render()
    {
        $this->users = User::latest()->get();
        return view('components.⚡users');
    }
    public function store()
    {
        $this->validate();

         $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);
        if ($this->image) {
            $user->addMedia($this->image->getRealPath())
                ->usingName($this->image->getClientOriginalName())
                ->toMediaCollection('users');
        }

        session()->flash('success', 'User created successfully');
        $this->resetInput();
        $this->closeCreate();
    }
    public function delete(User $user)
    {
        $user->delete();
        session()->flash('success', 'User deleted successfully');
    }

    public function edit(User $user)
    {
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->isEditing = true;
    }
    public function update()
    {
        $this->validate();
        $user = User::find($this->user_id);
        $user->name = $this->name;
        $user->email = $this->email;
        if ($this->password) {
        $user->password = Hash::make($this->password);
    }
        $user->save();
        if ($this->image) {
        $user->clearMediaCollection('users');
        $user->addMedia($this->image->getRealPath())
             ->toMediaCollection('users');
    }

        session()->flash('success', 'User updated successfully');
        $this->resetInput();
        $this->image = null;
        $this->isEditing = false;
    }
};
?>
<div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card-body">
        @if($isCreating || $isEditing)
                <h4>{{ $isEditing ? 'Edit User' : 'Create User' }}</h4>
                <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}">
                    
                    <div class="mb-3">
                        <input type="text" wire:model="name" class="form-control" placeholder="Name">
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <input type="email" wire:model="email" class="form-control" placeholder="Email">
                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                @if($isCreating)
                    <div class="mb-3">
                        <input type="password" wire:model="password" class="form-control" placeholder="Password">
                        @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                @endif

                <div class="mb-3">
                    <input type="file" wire:model="image" class="form-control">
                    @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <!-- Upload Progress -->
                <div wire:loading wire:target="image" class="text-primary">
                    Uploading...
                </div>

                <!-- Preview -->
                @if ($image)
                    <img src="{{ $image->temporaryUrl() }}" class="mt-2" width="100">
                @endif

                    <button class="btn btn-primary">
                        {{ $isEditing ? 'Update' : 'Create' }}
                    </button>

                </form>
                <button wire:click="closeCreate()" class="btn btn-secondary mt-2">
                    {{ 'Cancel' }}
                </button>
        @endif

                <h2 class="card-title mb-4">Users</h2>
                <button wire:click="openCreate()" class="btn btn-success mb-3">Create User</button>

                <table class="table table-striped table-bordered">
                    <thead  class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Avatar</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->getFirstMediaUrl('users'))
                                    <img src="{{ $user->getFirstMediaUrl('users') }}" 
                                        width="50" height="50" 
                                        style="object-fit:cover;border-radius:50%;">
                                @else
                                    <span>No Image</span>
                                @endif
                            </td>
                            <td>
                                <button wire:click="edit({{ $user }})" class="btn btn-warning btn-sm">
                                    Edit
                                </button>

                                <button 
                                    wire:click="delete({{ $user }})"
                                    onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                    class="btn btn-danger btn-sm">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
    </div>
</div>
