<div>
    <div class="col-12 mb-2">
        @if (session()->has('success'))
            <div class="alert alert-success" role="alert">
                {{ session()->get('success') }}
            </div>
        @endif

        @if(session()->has('error'))
            <div class="alert alert-danger" role="alert">
                {{ session()->get('error') }}
            </div>
        @endif

        @if($addPost)
            @include('livewire.create')
        @endif

        @if ($updatePost)
            @include('livewire.update')
        @endif
    </div>

    <div class="col-12">
        <div class="card">
            @if(!$addPost)
                <div class="m-2 d-flex justify-content-between">
                    <input type="text" class="form-control w-25" wire:model.live="search" placeholder="Search Here...">
                    <button wire:click="addNewPost()" class="btn btn-primary btn-sm float-end">Add New Post</button>
                </div>
            @endif
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($posts) > 0)
                                @foreach ($posts as $post)
                                    <tr>
                                        <td>
                                            {{$post->title}}
                                        </td>
                                        <td width="60%">
                                            {{$post->description}}
                                        </td>
                                        <td>
                                            <button wire:click="editPost({{$post->id}})" class="btn btn-primary btn-sm">Edit</button>
                                            <button onclick="deletePost({{$post->id}})" class="btn btn-danger btn-sm">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" align="center">
                                        No Posts Found.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>  
  
    <script>
        function deletePost(id){
            if(confirm("Are you sure to delete this record?"))
                Livewire.dispatch('deletePostListner', {'id': id});
        }
    </script>
</div>
